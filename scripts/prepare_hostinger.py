#!/usr/bin/env python3
"""Build in an isolated directory. Never bootstrap the working checkout."""
import argparse
import hashlib
import json
import os
from pathlib import Path
import shutil
import subprocess
import sys
import tempfile
import time
import zipfile

ROOT = Path(__file__).resolve().parent.parent


def run(args, cwd, env, **kwargs):
    print('+ ' + ' '.join(map(str, args)), flush=True)
    return subprocess.run(list(map(str, args)), cwd=cwd, env=env, check=True, **kwargs)


def copy_tree(source, target):
    # No symlinks, dotfiles, backups, environment files or executable local artifacts.
    def ignored(directory, names):
        return [n for n in names if n.startswith('.') or n.endswith(('~', '.bak', '.log', '.sqlite', '.sql', '.pem', '.key'))
                or (Path(directory) / n).is_symlink()]
    shutil.copytree(source, target, ignore=ignored)


def database_sql(app, output, work, env):
    base = Path('/Applications/XAMPP/xamppfiles')
    required = [base / 'bin/mysql_install_db', base / 'sbin/mysqld', base / 'bin/mysql', base / 'bin/mysqldump']
    if not all(p.is_file() for p in required):
        raise RuntimeError('SQL generation needs the existing XAMPP MariaDB binaries. Use --without-sql only if you accept no database installer; see HOSTINGER_DEPLOY.md.')
    data = work / 'mariadb'
    socket = work / 'db.sock'
    # --no-defaults and --skip-networking prevent touching any installed server.
    log = work / 'mariadb.log'
    with log.open('w') as stream:
        run([required[0], '--no-defaults', f'--basedir={base}', f'--datadir={data}', '--auth-root-authentication-method=normal'], work, env, stdout=stream, stderr=stream)
        server = subprocess.Popen([str(required[1]), '--no-defaults', f'--basedir={base}', f'--datadir={data}', f'--socket={socket}', f'--pid-file={work / "db.pid"}', '--skip-networking', '--innodb-buffer-pool-size=64M'], env=env, stdout=stream, stderr=stream)
        client = [required[2], '--no-defaults', '--protocol=SOCKET', f'--socket={socket}', '-uroot']
        try:
            for _ in range(100):
                if server.poll() is not None:
                    raise RuntimeError('Isolated MariaDB exited: ' + log.read_text()[-3000:])
                if socket.exists() and subprocess.run(list(map(str, client)) + ['-e', 'SELECT 1'], env=env, stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL).returncode == 0:
                    break
                time.sleep(.1)
            else:
                raise RuntimeError('Isolated MariaDB did not start: ' + log.read_text()[-3000:])
            run(client + ['-e', 'CREATE DATABASE meso_build CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci; CREATE DATABASE meso_verify CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;'], work, env)
            db_env = dict(env, DB_CONNECTION='mysql', DB_HOST='localhost', DB_SOCKET=str(socket), DB_DATABASE='meso_build', DB_USERNAME='root', DB_PASSWORD='')
            run(['php', 'artisan', 'migrate', '--force', '--no-interaction'], app, db_env)
            dump = [required[3], '--no-defaults', '--protocol=SOCKET', f'--socket={socket}', '-uroot', '--skip-comments', '--skip-add-drop-table', '--skip-add-locks', '--skip-disable-keys']
            sql = output / 'database-first-install.sql'
            with sql.open('wb') as f:
                f.write(b'-- FIRST INSTALL ONLY: empty database. Schema and migration history; no users or content.\n')
                run(dump + ['--no-data', 'meso_build'], work, env, stdout=f)
                run(dump + ['--no-create-info', 'meso_build', 'migrations'], work, env, stdout=f)
            with sql.open('rb') as f:
                run(client + ['meso_verify'], work, env, stdin=f)
            verify_env = dict(db_env, DB_DATABASE='meso_verify')
            run(['php', 'artisan', 'migrate:status', '--no-interaction'], app, verify_env)
            # Fail if any table other than migration history has rows.
            check = "require 'vendor/autoload.php'; $a=require 'bootstrap/app.php'; $a->make(Illuminate\\Contracts\\Console\\Kernel::class)->bootstrap(); foreach(Illuminate\\Support\\Facades\\DB::select('SHOW TABLES') as $r){$t=array_values((array)$r)[0]; if($t!=='migrations' && Illuminate\\Support\\Facades\\DB::table($t)->count())exit(1);}"
            run(['php', '-r', check], app, verify_env)
            (output / 'DATABASE-VERIFIED.txt').write_text('Generated from migrations on isolated MariaDB 10.4; re-imported into a second empty database. No seeders or user data.\n')
        finally:
            server.terminate()
            try:
                server.wait(timeout=20)
            except subprocess.TimeoutExpired:
                server.kill()
                server.wait()


def main():
    parser = argparse.ArgumentParser()
    parser.add_argument('--without-sql', action='store_true', help='Explicitly build files only; no database SQL.')
    args = parser.parse_args()
    for name in ['composer.lock', 'package-lock.json']:
        if not (ROOT / name).is_file():
            raise RuntimeError('Required lock file missing: ' + name)
    before = {p: hashlib.sha256((ROOT / p).read_bytes()).hexdigest() for p in ['composer.lock', 'package-lock.json', '.env'] if (ROOT / p).exists()}
    # A short private temp path also avoids the Unix socket path length limit on macOS.
    with tempfile.TemporaryDirectory(prefix='meso-', dir='/tmp') as tmp:
        work = Path(tmp)
        env = {'PATH': os.environ['PATH'], 'HOME': os.environ['HOME'], 'COMPOSER_HOME': str(work / 'composer-home'), 'COMPOSER_CACHE_DIR': str(Path(os.environ['HOME']) / ('Library/Caches/composer' if sys.platform == 'darwin' else '.cache/composer')), 'npm_config_cache': str(Path(os.environ['HOME']) / '.npm'), 'npm_config_userconfig': str(work / 'npmrc'), 'TMPDIR': str(work), 'LANG': 'en_US.UTF-8', 'APP_ENV': 'production', 'APP_DEBUG': 'false', 'CACHE_STORE': 'file', 'SESSION_DRIVER': 'file', 'QUEUE_CONNECTION': 'sync', 'DB_CONNECTION': 'sqlite', 'DB_DATABASE': ':memory:', 'COMPOSER_NO_INTERACTION': '1'}
        run(['php', '-r', '''if(PHP_VERSION_ID<80401)throw new Exception('PHP 8.4.1+ required by composer.lock'); foreach(['ctype','curl','dom','fileinfo','filter','gd','hash','iconv','json','libxml','mbstring','openssl','pcre','PDO','pdo_mysql','pdo_sqlite','session','tokenizer','xml'] as $e)if(!extension_loaded($e))throw new Exception("Missing extension: $e"); if(!function_exists('imagewebp') || !in_array('argon2id',password_algos()))throw new Exception('GD WebP and Argon2id required');'''], ROOT, env)
        version = subprocess.check_output(['composer', '--version'], env=env, stderr=subprocess.DEVNULL).decode()
        if not version.startswith('Composer version 2.'):
            raise RuntimeError('Composer 2 required')
        run(['node', '-e', "if(Number(process.versions.node.split('.')[0])<22)throw Error('Node 22+ required for this build script')"], ROOT, env)
        bundle = work / 'bundle'
        app = bundle / 'meso-app'
        web = bundle / 'public_html'
        app.mkdir(parents=True)
        web.mkdir()
        for name in ['app', 'config', 'routes', 'lang']:
            if not (ROOT / name).is_dir():
                continue
            copy_tree(ROOT / name, app / name)
        (app / 'bootstrap/cache').mkdir(parents=True)
        for name in ['app.php', 'providers.php']:
            shutil.copy2(ROOT / 'bootstrap' / name, app / 'bootstrap' / name)
        for name in ['views', 'data']:
            if not (ROOT / 'resources' / name).is_dir():
                continue
            copy_tree(ROOT / 'resources' / name, app / 'resources' / name)
        copy_tree(ROOT / 'database/migrations', app / 'database/migrations')
        for name in ['artisan', 'composer.json', 'composer.lock']:
            shutil.copy2(ROOT / name, app / name)
        for name in ['app/public', 'app/private', 'framework/cache/data', 'framework/sessions', 'framework/views', 'logs']:
            (app / 'storage' / name).mkdir(parents=True)
        run(['composer', 'validate', '--no-check-publish'], app, env)
        run(['composer', 'install', '--no-dev', '--prefer-dist', '--optimize-autoloader', '--no-interaction', '--no-progress'], app, env)
        run(['composer', 'check-platform-reqs', '--no-dev'], app, env)
        run(['composer', 'audit', '--locked', '--no-dev'], app, env)
        front = work / 'frontend'
        front.mkdir()
        for name in ['package.json', 'package-lock.json', 'vite.config.js', 'postcss.config.js', 'tailwind.config.js']:
            if (ROOT / name).exists():
                shutil.copy2(ROOT / name, front / name)
        copy_tree(ROOT / 'resources', front / 'resources')
        run(['npm', 'ci', '--include=dev', '--no-audit', '--no-fund'], front, env)
        run(['npm', 'run', 'build'], front, dict(env, VITE_APP_NAME='Meso Travels'))
        for name in ['assets', 'css', 'js', 'data']:
            if not (ROOT / 'public' / name).is_dir():
                continue
            copy_tree(ROOT / 'public' / name, web / name)
        for name in ['favicon.ico', 'robots.txt', '.htaccess']:
            shutil.copy2(ROOT / 'public' / name, web / name)
        copy_tree(front / 'public/build', web / 'build')
        shutil.copy2(ROOT / 'deployment/hostinger/index.php', web / 'index.php')
        with (web / '.htaccess').open('a') as f:
            f.write('\n# Only the front controller may execute PHP. Uploaded files live outside this tree.\n<FilesMatch "(?i)^(?!index\\.php$).*\\.(php[0-9]*|phtml|phar)(\\.|$)">\n    Require all denied\n</FilesMatch>\n<FilesMatch "^\\.">\n    Require all denied\n</FilesMatch>\nOptions -Indexes\n')
        shutil.copy2(ROOT / 'deployment/hostinger/.env.hostinger.example', app / '.env.hostinger.example')
        shutil.copy2(ROOT / 'HOSTINGER_DEPLOY.md', bundle / 'HOSTINGER_DEPLOY.md')
        if args.without_sql:
            (bundle / 'DATABASE-NOT-INCLUDED.txt').write_text('SQL explicitly skipped. An empty database cannot run this application until schema is imported. See HOSTINGER_DEPLOY.md.\n')
        else:
            database_sql(app, bundle, work, env)
        # Remove all generated runtime state, including package discovery manifests.
        for directory in [app / 'bootstrap/cache', app / 'storage']:
            for file in directory.rglob('*'):
                if file.is_file():
                    file.unlink()
        # Composer packages may ship their own tests; they are not runtime dependencies.
        for file in sorted((app / 'vendor').rglob('*'), key=lambda p: len(p.parts), reverse=True):
            if file.is_dir() and file.name in ['tests', 'Tests', 'test', '.git', '.github']:
                shutil.rmtree(file)
        if (front / 'package-lock.json').read_bytes() != (ROOT / 'package-lock.json').read_bytes() or (app / 'composer.lock').read_bytes() != (ROOT / 'composer.lock').read_bytes():
            raise RuntimeError('A build changed a lock file')
        manifest = json.loads((web / 'build/manifest.json').read_text())
        for entry in manifest.values():
            for asset in [entry['file']] + entry.get('css', []) + entry.get('assets', []):
                if not (web / 'build' / asset).is_file():
                    raise RuntimeError('Missing built asset: ' + asset)
        for p, digest in before.items():
            if hashlib.sha256((ROOT / p).read_bytes()).hexdigest() != digest:
                raise RuntimeError('Local file unexpectedly changed: ' + p)
        files = [p for p in bundle.rglob('*') if p.is_file()]
        for p in bundle.rglob('*'):
            if p.is_symlink() or p.name in ['.env', 'auth.json', 'hot', 'node_modules', '.git'] or p.suffix in ['.sqlite', '.log']:
                raise RuntimeError('Forbidden bundle artifact: ' + str(p.relative_to(bundle)))
        # Detect accidental inclusion of actual local secrets without printing their values.
        secrets = []
        if (ROOT / '.env').exists():
            for line in (ROOT / '.env').read_text().splitlines():
                key, _, value = line.partition('=')
                value = value.strip().strip('"\'')
                if any(s in key for s in ['PASSWORD', 'SECRET', 'TOKEN', 'APP_KEY']) and len(value) >= 8:
                    secrets.append(value.encode())
        for p in files:
            content = p.read_bytes()
            if any(secret in content for secret in secrets):
                raise RuntimeError('Local secret detected in: ' + str(p.relative_to(bundle)))
        out = ROOT / 'dist/hostinger' / (time.strftime('%Y%m%d-%H%M%S') + '-' + os.urandom(3).hex())
        out.mkdir(parents=True)
        archive = out / 'meso-hostinger.zip'
        with zipfile.ZipFile(archive, 'x', zipfile.ZIP_DEFLATED) as z:
            for p in sorted(bundle.rglob('*')):
                z.write(p, p.relative_to(bundle))
        with zipfile.ZipFile(archive) as z:
            if z.testzip():
                raise RuntimeError('ZIP integrity check failed')
        for name in ['database-first-install.sql', 'DATABASE-VERIFIED.txt', 'DATABASE-NOT-INCLUDED.txt', 'HOSTINGER_DEPLOY.md']:
            if (bundle / name).exists():
                shutil.copy2(bundle / name, out / name)
        run(['python3', ROOT / 'scripts/verify_hostinger.py', archive, '--report', out / 'VERIFICATION.json'], ROOT, env)
        (out / 'SHA256SUMS').write_text(hashlib.sha256(archive.read_bytes()).hexdigest() + '  meso-hostinger.zip\n')
        print(f'\nSUCCESS: {archive}\nNo local .env, uploads or database were copied. No config/route/view cache included.')


if __name__ == '__main__':
    try:
        main()
    except (Exception, KeyboardInterrupt) as error:
        print(f'ERROR: Hostinger preparation stopped: {error}', file=sys.stderr)
        sys.exit(1)
