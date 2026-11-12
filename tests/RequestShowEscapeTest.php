<?php
/**
 * php tests/RequestShowEscapeTest.php — i mattoni usati da
 * custom/view/pages/backend/request/show.php (la vista intera richiede
 * View::layout e il DB, quindi si verifica a mano).
 */
declare(strict_types=1);

require __DIR__.'/bootstrap.php';

use App\Support\SafeUrl;

check('email e telefono: <script> e virgolette escapati', function () {
    return e('<script>alert(1)</script>"x"') === '&lt;script&gt;alert(1)&lt;/script&gt;&quot;x&quot;';
});

check('messaggio: HTML escapato, a capo diventano <br>', function () {
    $out = e_br("ciao <img src=x onerror=alert(1)>\nriga 2");
    return !str_contains($out, '<img') && str_contains($out, '&lt;img') && str_contains($out, '<br');
});

check('request_url http e https restano invariati', function () {
    return SafeUrl::http('https://example.com/p?a=1&b=2') === 'https://example.com/p?a=1&b=2'
        && SafeUrl::http(' HTTP://example.com ') === 'HTTP://example.com';
});

check('request_url con schema non http diventa #', function () {
    foreach (['javascript:alert(1)', 'JaVaScRiPt:alert(1)', 'data:text/html,x', '//evil.test/x', 'mailto:a@b.c', '/relativo', '', 'http:///x'] as $url) {
        if (SafeUrl::http($url) !== '#') {
            throw new RuntimeException("non filtrato: {$url}");
        }
    }
    return SafeUrl::http(null) === '#' && SafeUrl::http(['x']) === '#';
});

check('request_url con credenziali nell\'host diventa #', function () {
    foreach (['https://banca.it@evil.test/', 'https://user:pass@evil.test/', 'http://:pass@evil.test', 'https://@evil.test/'] as $url) {
        if (SafeUrl::http($url) !== '#') {
            throw new RuntimeException("non filtrato: {$url}");
        }
    }
    return SafeUrl::http('https://example.com/a@b') === 'https://example.com/a@b';
});

check('show.php usa e(), e_br(), SafeUrl e la precedenza corretta su backend_url', function () {
    $src = (string) file_get_contents(dirname(__DIR__).'/custom/view/pages/backend/request/show.php');
    return str_contains($src, "e(\$REQUEST['email'])")
        && str_contains($src, "e(\$REQUEST['phone'])")
        && str_contains($src, "e_br(\$REQUEST['request']")
        && str_contains($src, "SafeUrl::http(\$REQUEST['request_url']")
        && str_contains($src, "isset(\$CONSENT['backend_url']) ? ")
        && !str_contains($src, "uriBase64 ?? '#'");
});

check('titolo raw verso il layout (che fa già l\'escape), e() solo nel RichText', function () {
    $src = (string) file_get_contents(dirname(__DIR__).'/custom/view/pages/backend/request/show.php');
    $layout = (string) file_get_contents(dirname(__DIR__).'/vendor/wonder-image/app/app/view/layout/backend/show.php');
    return str_contains($src, "'TITLE' => \$fullNameRaw,")
        && str_contains($src, '$fullName = e($fullNameRaw);')
        && str_contains($src, '<b>$fullName</b>')
        && str_contains($layout, "htmlspecialchars((string) (\$TITLE ?? ''), ENT_QUOTES, 'UTF-8')");
});

summary();
