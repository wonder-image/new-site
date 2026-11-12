<?php
/**
 * php .github/scripts/check-lang.php — controllo delle traduzioni del sito.
 *
 * 1. Ogni lang/{locale}/**.json è JSON valido.
 * 2. Ogni chiave letterale usata con __t('...') in custom/ e app/ esiste nella
 *    lingua predefinita (nel sito, nel framework o in un modulo wonder-image).
 * 3. Solo se custom/config/lang.php attiva 2+ lingue con addLanguage(): le
 *    lingue attive hanno le stesse chiavi del sito. Con una sola lingua basta
 *    la lingua predefinita: le altre cartelle in lang/ sono ignorate.
 *
 * Esce con 1 se trova errori. Non legge .env e non tocca il database.
 */
declare(strict_types=1);

$root = dirname(__DIR__, 2);
$errors = [];

$langConfig = (string) @file_get_contents($root.'/custom/config/lang.php');
preg_match_all("/addLanguage\\(\\s*['\"]([a-z]{2}(?:[-_][A-Za-z]{2})?)['\"]/", $langConfig, $m);
$active = array_values(array_unique($m[1]));
$default = null;
foreach (['defaultLang', 'setLang'] as $fn) {
    if ($default === null && preg_match("/{$fn}\\(\\s*['\"]([a-z]{2}(?:[-_][A-Za-z]{2})?)['\"]/", $langConfig, $d)) {
        $default = $d[1];
    }
}
$default ??= $active[0] ?? 'it';
if ($active === []) {
    $active = [$default];
}

/** Chiavi foglia "file.a.b" dei JSON di una cartella lingua, oppure null se la cartella manca. */
function leafKeys(string $dir, array &$errors): ?array
{
    if (!is_dir($dir)) {
        return null;
    }
    $keys = [];
    $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS));
    foreach ($it as $file) {
        if (!$file->isFile() || $file->getExtension() !== 'json') {
            continue;
        }
        $data = json_decode((string) file_get_contents($file->getPathname()), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $errors[] = "JSON non valido: {$file->getPathname()} (".json_last_error_msg().')';
            continue;
        }
        $prefix = str_replace(DIRECTORY_SEPARATOR, '.', substr($file->getPathname(), strlen($dir) + 1, -5));
        $walk = function ($node, string $path) use (&$walk, &$keys): void {
            if (is_array($node) && $node !== [] && array_keys($node) !== range(0, count($node) - 1)) {
                foreach ($node as $k => $v) {
                    $walk($v, $path.'.'.$k);
                }
                return;
            }
            $keys[$path] = true;
        };
        $walk($data, $prefix);
    }
    return $keys;
}

// 1. JSON valido in tutte le cartelle di lang/
foreach (glob($root.'/lang/*', GLOB_ONLYDIR) ?: [] as $dir) {
    leafKeys($dir, $errors);
}

$site = [];
foreach ($active as $locale) {
    $keys = leafKeys($root.'/lang/'.$locale, $errors);
    if ($keys === null) {
        $errors[] = "Lingua attiva senza cartella: lang/{$locale}/";
        $keys = [];
    }
    $site[$locale] = $keys;
}

// 2. Chiavi usate nel codice presenti nella lingua predefinita
$available = $site[$default] ?? [];
$upstreamDirs = glob($root.'/vendor/wonder-image/*/{resources/lang,lang}/'.$default, GLOB_ONLYDIR | GLOB_BRACE) ?: [];
foreach ($upstreamDirs as $dir) {
    $available += leafKeys($dir, $errors) ?? [];
}
$hasVendor = $upstreamDirs !== [];

$isPrefix = static function (string $key, array $keys): bool {
    foreach ($keys as $k => $_) {
        if (str_starts_with($k, $key.'.')) {
            return true;
        }
    }
    return false;
};

$sources = [];
foreach (['custom', 'app'] as $base) {
    if (!is_dir($root.'/'.$base)) {
        continue;
    }
    $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root.'/'.$base, FilesystemIterator::SKIP_DOTS));
    foreach ($it as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $sources[] = $file->getPathname();
        }
    }
}
if (!$hasVendor) {
    // Senza vendor/ non si vedono le chiavi del framework e dei moduli.
    echo "Nota: vendor/ assente, controllo delle chiavi usate nel codice saltato (lancia composer install).\n";
    $sources = [];
}
foreach ($sources as $path) {
    $src = (string) file_get_contents($path);
    // Solo chiavi letterali complete: '__t("pages.home." . $x)' viene saltata.
    preg_match_all("/__t\\(\\s*(['\"])([A-Za-z0-9_.\\-]+)\\1\\s*[,)]/", $src, $calls);
    foreach (array_unique($calls[2]) as $key) {
        if (isset($available[$key]) || $isPrefix($key, $available)) {
            continue;
        }
        $errors[] = "Chiave mancante in lang/{$default}/: '{$key}' (".substr($path, strlen($root) + 1).')';
    }
}

// 3. Stesse chiavi tra le lingue attive (solo siti multilingua)
if (count($active) > 1) {
    foreach ($active as $locale) {
        if ($locale === $default) {
            continue;
        }
        foreach (array_diff_key($site[$default], $site[$locale]) as $k => $_) {
            $errors[] = "Chiave presente in {$default} ma non in {$locale}: '{$k}'";
        }
        foreach (array_diff_key($site[$locale], $site[$default]) as $k => $_) {
            $errors[] = "Chiave presente in {$locale} ma non in {$default}: '{$k}'";
        }
    }
}

echo 'Lingue attive: '.implode(', ', $active)." (predefinita: {$default})\n";
if ($errors !== []) {
    foreach ($errors as $e) {
        echo "::error::{$e}\n";
    }
    exit(1);
}
echo "Traduzioni OK\n";
