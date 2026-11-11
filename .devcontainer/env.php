<?php
// Uso: php .devcontainer/env.php get KEY | set KEY VALUE
// Legge/scrive una chiave nel .env del progetto senza toccare il resto del file.
[$script, $action, $key] = array_pad($argv, 3, '');
$value = $argv[3] ?? '';
$path = dirname(__DIR__).'/.env';

if (!in_array($action, ['get', 'set'], true) || !preg_match('/^[A-Z0-9_]+$/', $key)) {
    fwrite(STDERR, "Uso: php .devcontainer/env.php get|set KEY [VALUE]\n");
    exit(2);
}

$lines = is_file($path) ? preg_split('/\R/', rtrim((string) file_get_contents($path), "\r\n")) : [];
$pattern = '/^\s*'.preg_quote($key, '/').'\s*=/';

if ($action === 'get') {
    foreach ($lines as $line) {
        if (preg_match($pattern, $line)) {
            echo trim(trim(substr($line, strpos($line, '=') + 1)), "\"'");
            exit(0);
        }
    }
    exit(0);
}

$found = false;
foreach ($lines as $i => $line) {
    if (preg_match($pattern, $line)) {
        $lines[$i] = $key.'='.$value;
        $found = true;
    }
}
if (!$found) {
    $lines[] = $key.'='.$value;
}

file_put_contents($path, implode("\n", $lines)."\n");
