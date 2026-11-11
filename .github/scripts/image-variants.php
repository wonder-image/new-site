<?php
/**
 * Genera per le immagini statiche di assets/{ASSETS_VERSION}/images le stesse
 * varianti che il framework crea per gli upload (ResponsiveImage):
 * {nome}.webp e {nome}-{misura}.{ext|webp} per ogni RESPONSIVE_IMAGE_SIZES.
 * Il renderer di __ri() le usa solo se esistono su disco, altrimenti resta
 * l'originale: senza questo step le immagini statiche non hanno srcset.
 *
 * Uso: php .github/scripts/image-variants.php assets/0.0/images [altre cartelle]
 * Misure: env RESPONSIVE_IMAGE_SIZES="240,480,..." (default del framework).
 * Un'immagine che ha già varianti nel repo viene lasciata com'è.
 */

declare(strict_types=1);

$root = dirname(__DIR__, 2);
require $root.'/vendor/autoload.php';

use Wonder\Plugin\Custom\Image\ResponsiveImage;

$sizesEnv = trim((string) getenv('RESPONSIVE_IMAGE_SIZES'));
define('RESPONSIVE_IMAGE_SIZES', $sizesEnv !== ''
    ? array_map('intval', array_filter(array_map('trim', explode(',', $sizesEnv))))
    : [240, 480, 620, 960, 1200, 1440, 1920, 2400]);
define('RESPONSIVE_IMAGE_WEBP', true);

if (!function_exists('imagewebp') || empty(gd_info()['WebP Support'])) {
    fwrite(STDERR, "GD senza supporto WebP: impossibile generare le varianti.\n");
    exit(1);
}

$dirs = array_slice($argv, 1);
if ($dirs === []) {
    fwrite(STDERR, "Uso: php image-variants.php <cartella> [...]\n");
    exit(1);
}

$sizesPattern = implode('|', RESPONSIVE_IMAGE_SIZES);
$generated = 0;
$skipped = 0;
$failed = 0;

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        echo "Cartella assente, salto: $dir\n";
        continue;
    }

    $files = [];
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS));
    foreach ($iterator as $file) {
        if ($file->isFile()) {
            $files[] = $file->getPathname();
        }
    }
    sort($files);
    $present = array_flip($files);

    foreach ($files as $path) {
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'], true)) {
            continue;
        }

        $base = substr($path, 0, -strlen($ext) - 1);

        // È una variante ({nome}-{misura}.ext) di un originale presente: non è una sorgente.
        if (preg_match('/^(.*)-('.$sizesPattern.')$/', $base, $m) && hasOriginal($m[1], $present)) {
            continue;
        }

        // {nome}.webp generato da un {nome}.jpg/png: non è una sorgente.
        if ($ext === 'webp' && hasOriginal($base, $present, ['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG'])) {
            continue;
        }

        // Varianti già nel repo (fatte a mano): non le sovrascrivo.
        if (glob(globEscape($base).'-{'.implode(',', RESPONSIVE_IMAGE_SIZES).'}.*', GLOB_BRACE)) {
            $skipped++;
            continue;
        }

        try {
            ResponsiveImage::path($path)->generate();
            $generated++;
            echo "✓ $path\n";
        } catch (Throwable $e) {
            $failed++;
            echo "::warning::Varianti non generate per $path: {$e->getMessage()}\n";
        }
    }
}

echo "Immagini elaborate: $generated, già con varianti: $skipped, errori: $failed\n";

function hasOriginal(string $base, array $present, array $exts = ['jpg', 'jpeg', 'png', 'webp', 'JPG', 'JPEG', 'PNG', 'WEBP']): bool
{
    foreach ($exts as $ext) {
        if (isset($present["$base.$ext"])) {
            return true;
        }
    }
    return false;
}

function globEscape(string $path): string
{
    return preg_replace('/[\\\\*?\[\]{}]/', '\\\\$0', $path);
}
