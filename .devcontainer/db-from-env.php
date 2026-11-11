<?php
// Stampa l'SQL che crea nel MariaDB del container database e utente già
// scritti nel .env (DB_DATABASE `alias:nome[,alias:nome]`, DB_USERNAME,
// DB_PASSWORD), senza modificare il .env. Uso:
//   php .devcontainer/db-from-env.php | mariadb --socket=... -uroot
$path = dirname(__DIR__).'/.env';
$env = [];
foreach (is_file($path) ? file($path, FILE_IGNORE_NEW_LINES) : [] as $line) {
    if (preg_match('/^\s*([A-Z0-9_]+)\s*=(.*)$/', $line, $m)) {
        $env[$m[1]] = trim(trim($m[2]), "\"'");
    }
}

$user = $env['DB_USERNAME'] ?? '';
$password = $env['DB_PASSWORD'] ?? '';
$charset = preg_match('/^\w+$/', $env['DB_CHARSET'] ?? '') ? $env['DB_CHARSET'] : 'latin1';
$collation = preg_match('/^\w+$/', $env['DB_COLLATION'] ?? '') ? $env['DB_COLLATION'] : 'latin1_swedish_ci';

$databases = [];
foreach (explode(',', $env['DB_DATABASE'] ?? '') as $part) {
    $name = trim(str_contains($part, ':') ? substr($part, strpos($part, ':') + 1) : $part);
    if ($name !== '') {
        $databases[] = $name;
    }
}

if ($user === '' || $databases === []) {
    fwrite(STDERR, "DB_USERNAME o DB_DATABASE mancanti nel .env\n");
    exit(1);
}

$q = static fn (string $v): string => "'".str_replace(['\\', "'"], ['\\\\', "\\'"], $v)."'";
$id = static fn (string $v): string => '`'.str_replace('`', '``', $v).'`';

foreach (['localhost', '127.0.0.1'] as $host) {
    echo 'CREATE USER IF NOT EXISTS '.$q($user).'@'.$q($host).' IDENTIFIED BY '.$q($password).";\n";
    echo 'ALTER USER '.$q($user).'@'.$q($host).' IDENTIFIED BY '.$q($password).";\n";
}
foreach ($databases as $db) {
    echo 'CREATE DATABASE IF NOT EXISTS '.$id($db).' CHARACTER SET '.$charset.' COLLATE '.$collation.";\n";
    foreach (['localhost', '127.0.0.1'] as $host) {
        echo 'GRANT ALL PRIVILEGES ON '.$id($db).'.* TO '.$q($user).'@'.$q($host).";\n";
    }
}
echo "FLUSH PRIVILEGES;\n";
