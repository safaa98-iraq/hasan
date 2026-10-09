#!/usr/bin/env python3
"""Test the actual ZIP in a fresh directory, never the user's database or .env."""
import argparse
import base64
import html
import http.cookiejar
import json
import os
from pathlib import Path
import re
import secrets
import socket
import subprocess
import tempfile
import time
import urllib.error
import urllib.parse
import urllib.request
import zipfile


def verify(archive):
    checks = []
    with tempfile.TemporaryDirectory(prefix='meso-check-', dir='/tmp') as tmp:
        root = Path(tmp)
        with zipfile.ZipFile(archive) as z:
            assert z.testzip() is None, 'Corrupt ZIP'
            names = z.namelist()
            for name in names:
                assert not Path(name).is_absolute() and '..' not in Path(name).parts, 'Unsafe ZIP path'
                assert Path(name).name not in ['.env', 'auth.json', 'hot', 'node_modules', '.git'], 'Forbidden artifact'
                assert not (z.getinfo(name).external_attr >> 16 & 0o170000) == 0o120000, 'ZIP contains a symlink'
            required = ['meso-app/bootstrap/app.php', 'meso-app/bootstrap/providers.php', 'meso-app/vendor/autoload.php', 'meso-app/vendor/composer/autoload_real.php', 'meso-app/app/Http/Controllers/Auth/EmailVerificationPromptController.php', 'meso-app/app/View/Components/AppLayout.php', 'meso-app/resources/views/auth/login.blade.php', 'public_html/index.php', 'public_html/.htaccess', 'public_html/build/manifest.json']
            for name in required:
                assert name in names, 'Missing runtime file: ' + name
            for name in ['bootstrap/cache/', 'storage/app/public/', 'storage/app/private/', 'storage/framework/views/', 'storage/framework/sessions/', 'storage/framework/cache/data/', 'storage/logs/']:
                assert 'meso-app/' + name in names, 'Missing directory: ' + name
            for name in names:
                assert not (name.startswith('meso-app/bootstrap/cache/') and not name.endswith('/')), 'Stale bootstrap cache'
                assert not (name.startswith('meso-app/storage/') and not name.endswith('/')), 'Local storage data included'
            z.extractall(root)
        checks.append('ZIP integrity, runtime files, empty writable directories, no .env or symlinks or local cache')
        app = root / 'meso-app'
        web = root / 'public_html'
        env = {'PATH': os.environ['PATH'], 'HOME': os.environ['HOME'], 'COMPOSER_HOME': str(root / 'composer-home'), 'APP_ENV': 'production', 'APP_DEBUG': 'false', 'APP_KEY': 'base64:' + base64.b64encode(os.urandom(32)).decode(), 'DB_CONNECTION': 'sqlite', 'DB_DATABASE': str(root / 'test.sqlite'), 'SESSION_DRIVER': 'file', 'SESSION_SECURE_COOKIE': 'false', 'SESSION_ENCRYPT': 'true', 'CACHE_STORE': 'file', 'QUEUE_CONNECTION': 'sync', 'PUBLIC_MEDIA_FALLBACK': 'true', 'MAIL_MAILER': 'array', 'BCRYPT_ROUNDS': '4'}
        (root / 'test.sqlite').touch()
        for args in [['php', 'artisan', 'migrate', '--force', '--no-interaction'], ['composer', 'check-platform-reqs', '--no-dev']]:
            subprocess.run(args, cwd=app, env=env, check=True, stdout=subprocess.DEVNULL)
        checks.append('Isolated SQLite migrations and production platform requirements')
        email = 'verify-' + secrets.token_hex(4) + '@example.test'
        password = secrets.token_urlsafe(24)
        setup = "require 'vendor/autoload.php'; $a=require 'bootstrap/app.php'; $a->make(Illuminate\\Contracts\\Console\\Kernel::class)->bootstrap(); App\\Models\\User::create(['name'=>'Verification','email'=>getenv('VERIFY_EMAIL'),'password'=>getenv('VERIFY_PASSWORD')]); $im=imagecreatetruecolor(2,2); imagepng($im,storage_path('app/public/probe.png')); Illuminate\\Support\\Facades\\Storage::disk('public')->put('probe.php','<?php echo 123;'); Illuminate\\Support\\Facades\\Storage::disk('local')->put('private-secret.txt','private-test-only');"
        subprocess.run(['php', '-r', setup], cwd=app, env=dict(env, VERIFY_EMAIL=email, VERIFY_PASSWORD=password), check=True, stdout=subprocess.DEVNULL)
        classmap = "require 'vendor/autoload.php'; $map=require 'vendor/composer/autoload_classmap.php'; foreach($map as $c=>$p)if(str_starts_with($c,'App\\\\')&&!is_file($p))throw new Exception('Missing class: '.$c);"
        subprocess.run(['php', '-r', classmap], cwd=app, env=env, check=True, stdout=subprocess.DEVNULL)
        checks.append('Application classmap paths exist')
        with socket.socket() as listener:
            listener.bind(('127.0.0.1', 0))
            port = listener.getsockname()[1]
        base = f'http://127.0.0.1:{port}'
        env['APP_URL'] = base
        # This CLI router exists only in the test directory; it is never in the ZIP.
        router = root / 'router.php'
        router.write_text("<?php $p=parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH); if($p!=='/' && is_file(__DIR__.'/public_html'.$p))return false; require __DIR__.'/public_html/index.php';")
        log = root / 'server.log'
        with log.open('w') as stream:
            server = subprocess.Popen(['php', '-S', f'127.0.0.1:{port}', '-t', str(web), str(router)], env=env, stdout=stream, stderr=stream)
            jar = http.cookiejar.CookieJar()
            client = urllib.request.build_opener(urllib.request.HTTPCookieProcessor(jar))

            def request(path, data=None, headers=None):
                req = urllib.request.Request(base + path, data=data, headers=headers or {})
                try:
                    with client.open(req, timeout=10) as response:
                        return response.status, response.read(), response.geturl(), response.headers
                except urllib.error.HTTPError as response:
                    return response.code, response.read(), response.geturl(), response.headers

            def csrf(body):
                match = re.search(rb'name="_token"\s+value="([^"]+)"', body)
                assert match, 'CSRF field missing'
                return html.unescape(match.group(1).decode())

            def post(path, fields):
                return request(path, urllib.parse.urlencode(fields).encode(), {'Content-Type': 'application/x-www-form-urlencoded'})

            try:
                for _ in range(100):
                    if server.poll() is not None:
                        raise RuntimeError('PHP server exited')
                    try:
                        result = request('/up')
                        break
                    except urllib.error.URLError:
                        time.sleep(.1)
                else:
                    raise RuntimeError('PHP server did not start')
                for path in ['/', '/ar', '/login', '/up']:
                    status, body, url, _ = request(path)
                    assert status == 200, f'{path}: HTTP {status}'
                assert urllib.parse.urlparse(request('/admin')[2]).path == '/login', 'Guest admin access allowed'
                checks.append('Home, Arabic home, login, health HTTP 200; guest admin redirect')
                manifest = json.loads((web / 'build/manifest.json').read_text())
                assets = {asset for entry in manifest.values() for asset in [entry['file']] + entry.get('css', []) + entry.get('assets', [])}
                for asset in assets:
                    assert request('/build/' + asset)[0] == 200, 'Missing frontend asset'
                checks.append('All manifest assets served over HTTP')
                login = request('/login')[1]
                post('/login', {'_token': csrf(login), 'email': email, 'password': secrets.token_urlsafe(24)})
                assert urllib.parse.urlparse(request('/admin')[2]).path == '/login', 'Invalid password authenticated'
                login = request('/login')[1]
                status, _, url, _ = post('/login', {'_token': csrf(login), 'email': email, 'password': password})
                assert status == 200 and urllib.parse.urlparse(url).path == '/admin', 'Valid login failed'
                admin = request('/admin')
                assert admin[0] == 200 and urllib.parse.urlparse(admin[2]).path == '/admin', 'Authenticated session missing'
                checks.append('Invalid password rejected; real login and file session reach /admin')
                create = request('/admin/places/create')
                token = csrf(create[1])
                boundary = 'meso-' + secrets.token_hex(8)
                fields = {'_token': token, 'name_en': 'Verification place', 'slug': 'verification-place', 'order': '0', 'is_published': '1'}
                body = b''
                for key, value in fields.items():
                    body += f'--{boundary}\r\nContent-Disposition: form-data; name="{key}"\r\n\r\n{value}\r\n'.encode()
                body += f'--{boundary}\r\nContent-Disposition: form-data; name="image_path"; filename="probe.png"\r\nContent-Type: image/png\r\n\r\n'.encode() + (app / 'storage/app/public/probe.png').read_bytes() + f'\r\n--{boundary}--\r\n'.encode()
                status, _, url, _ = request('/admin/places', body, {'Content-Type': f'multipart/form-data; boundary={boundary}'})
                assert status == 200 and urllib.parse.urlparse(url).path == '/admin/places', 'Image upload failed'
                images = list((app / 'storage/app/public/images/places').glob('*.png'))
                assert len(images) == 1, 'Uploaded image not stored'
                image_path = images[0].relative_to(app / 'storage/app/public').as_posix()
                image_response = request('/storage/' + image_path)
                assert image_response[0] == 200 and image_response[3].get_content_type() == 'image/png', 'Uploaded image unavailable'
                assert request('/places/verification-place')[0] == 200, 'Published database content unavailable'
                checks.append('Admin image upload, published DB content and image served without symlink')
                for path in ['/storage/probe.php', '/storage/private-secret.txt', '/private-storage/private-secret.txt', '/.env', '/vendor/autoload.php']:
                    assert request(path)[0] in [403, 404], 'Private or executable file exposed: ' + path
                checks.append('PHP uploads, private files and application files denied')
                admin = request('/admin')
                post('/logout', {'_token': csrf(admin[1])})
                assert urllib.parse.urlparse(request('/admin')[2]).path == '/login', 'Logout failed'
                checks.append('Logout removes authenticated access')
            except Exception as error:
                # Include private diagnostics only in local tooling output, without test credentials.
                print(log.read_text()[-2000:])
                for p in (app / 'storage/logs').glob('*.log'):
                    lines = [line for line in p.read_text().splitlines() if '.ERROR:' in line]
                    for line in lines[-2:]:
                        print(line[:600])
                raise error
            finally:
                server.terminate()
                server.wait(timeout=10)
    return {'status': 'passed', 'checks': checks, 'limits': ['PHP built-in server; Apache/LiteSpeed rewrite and hosting permissions require live verification', 'SQLite HTTP smoke test; MariaDB schema import verification reported separately', 'Hostinger database credentials, existing content, SMTP and HTTPS not tested']}


if __name__ == '__main__':
    parser = argparse.ArgumentParser()
    parser.add_argument('archive', type=Path)
    parser.add_argument('--report', type=Path)
    args = parser.parse_args()
    report = verify(args.archive)
    if args.report:
        args.report.write_text(json.dumps(report, ensure_ascii=False, indent=2) + '\n')
    print('ZIP runtime verification PASSED: ' + str(len(report['checks'])) + ' checks')
