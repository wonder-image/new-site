<?php
// Router per `php -S` nel devcontainer: stessa logica del router temporaneo di
// `php forge start`, che qui non si usa perché resta in foreground e riscrive APP_URL.
$docroot = dirname(__DIR__);
$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$legacyUri = preg_replace('#/index\.php$#', '/', $uri);

if (is_string($legacyUri) && $legacyUri !== '' && $legacyUri !== $uri) {
    $query = isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] !== ''
        ? '?'.$_SERVER['QUERY_STRING']
        : '';
    $uri = $legacyUri;
    $_SERVER['REQUEST_URI'] = $uri.$query;
    $_SERVER['PHP_SELF'] = $uri;
}

// Mai servire file o cartelle nascosti (.env, .git, .devcontainer…),
// tranne /.well-known: il server ascolta su 0.0.0.0.
if (preg_match('#/\.(?!well-known(/|$))#', $uri)) {
    http_response_code(404);
    return true;
}

$requestPath = $docroot.$uri;

if ($uri !== '/' && is_file($requestPath)) {
    return false;
}

if ($uri !== '/' && is_dir($requestPath) && file_exists($requestPath.'/index.php')) {
    require $requestPath.'/index.php';
    return true;
}

if ($uri !== '/' && file_exists($requestPath.'.php')) {
    require $requestPath.'.php';
    return true;
}

$handlerIndex = $docroot.'/handler/index.php';

if (file_exists($handlerIndex)) {
    require $handlerIndex;
    return true;
}

require $docroot.'/index.php';
return true;
