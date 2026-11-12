<?php
/**
 * Hook PostToolUse di Claude Code: dopo ogni modifica a un file .php esegue
 * `php -l`. Con errori di sintassi esce con 2 e Claude riceve il messaggio,
 * così corregge subito invece di accorgersene in CI.
 */
declare(strict_types=1);

$input = json_decode((string) stream_get_contents(STDIN), true);
$file = (string) ($input['tool_input']['file_path'] ?? '');

if ($file === '' || !str_ends_with(strtolower($file), '.php') || !is_file($file)) {
    exit(0);
}

$output = [];
exec('php -l -d display_errors=stderr '.escapeshellarg($file).' 2>&1', $output, $code);

if ($code !== 0) {
    fwrite(STDERR, "php -l fallito su {$file}:\n".implode("\n", $output)."\n");
    exit(2);
}
exit(0);
