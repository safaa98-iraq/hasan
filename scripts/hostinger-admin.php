<?php

// Local CLI only. Do not place this script in the web root.
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}
if ($argc !== 2 || ! str_starts_with($argv[1], '/') || file_exists($argv[1])) {
    fwrite(STDERR, "Usage: php scripts/hostinger-admin.php /absolute/private/path/admin.sql (new file)\n");
    exit(1);
}
$name = readline('Admin name: ');
$email = readline('Admin email: ');
if (! $name || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit("Invalid name or email.\n");
}
$terminal = trim((string) shell_exec('stty -g'));
if ($terminal === '') {
    exit("Run interactively in your Mac terminal.\n");
}
try {
    system('stty -echo');
    $password = readline('Password (12+ characters; hidden): ');
    echo PHP_EOL;
    $confirmation = readline('Confirm password: ');
    echo PHP_EOL;
} finally {
    system('stty '.escapeshellarg($terminal));
}
if (strlen($password) < 12 || $password !== $confirmation) {
    exit("Passwords must match and contain at least 12 characters.\n");
}
$hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
$hex = static fn ($value) => "CONVERT(X'".bin2hex($value)."' USING utf8mb4)";
$sql = "-- Private first-account import. Never place in public_html.\nINSERT INTO users (name,email,password,email_verified_at,created_at,updated_at) VALUES (".$hex($name).','.$hex($email).','.$hex($hash).",NOW(),NOW(),NOW());\n";
umask(0077);
$file = fopen($argv[1], 'x');
if (! $file || fwrite($file, $sql) !== strlen($sql)) {
    exit("Could not write admin SQL.\n");
}
fclose($file);
echo "Private account SQL created. Import once in phpMyAdmin.\n";
