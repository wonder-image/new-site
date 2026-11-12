<?php
/**
 * php tests/RequestMailEscapeTest.php — segnaposto delle mail del form
 * contatti (RequestResource::mailValues). L'invio vero si prova in locale.
 */
declare(strict_types=1);

require __DIR__.'/bootstrap.php';
// Mappa usata da sanitize(): simula i valori già preparati per il DB.
require dirname(__DIR__).'/vendor/wonder-image/app/app/config/array/characters.php';
$GLOBALS['CHARACTERS'] = $CHARACTERS;

use App\Resources\Site\RequestResource;

$prepared = [
    'name' => sanitize('<script>alert(1)</script>'),
    'surname' => sanitize("O'Brien & \"figli\""),
    'email' => sanitize('a@b.c'),
    'phone' => sanitize('+39 333'),
    'request' => sanitize('<img src=x onerror=alert(1)>'),
    'request_url' => sanitize('https://example.com/p?a=1&b=2'),
    'files' => null,
    'extra' => ['non', 'scalare'],
];
$mail = RequestResource::mailValues($prepared);

check('name e request: niente tag HTML vivi', function () use ($mail) {
    return $mail['name'] === '&lt;script&gt;alert(1)&lt;/script&gt;'
        && !str_contains($mail['request'], '<img');
});

check('messaggio multi-riga: a capo diventano <br>, HTML escapato', function () {
    $out = RequestResource::mailValues(['request' => sanitize("riga 1\n<b>riga 2</b>")])['request'];
    return str_contains($out, 'riga 1<br')
        && str_contains($out, '&lt;b&gt;riga 2&lt;/b&gt;')
        && !str_contains($out, '<b>');
});

check('solo il messaggio usa e_br: gli altri campi restano su e()', function () {
    $out = RequestResource::mailValues(['name' => sanitize("Mario\nRossi")])['name'];
    return !str_contains($out, '<br');
});

check('niente doppio escape né slash di addslashes', function () use ($mail) {
    return $mail['surname'] === 'O&#039;Brien &amp; &quot;figli&quot;';
});

check('request_url https: valido nell\'href, & escapato una volta', function () use ($mail) {
    return $mail['request_url'] === 'https://example.com/p?a=1&amp;b=2';
});

check('request_url javascript:, con apice o con credenziali nell\'host diventa vuoto', function () {
    foreach (['javascript:alert(1)', "x' onmouseover='alert(1)", '//evil.test', 'https://banca.it@evil.test/'] as $url) {
        if (RequestResource::mailValues(['request_url' => sanitize($url)])['request_url'] !== '') {
            throw new RuntimeException("non filtrato: {$url}");
        }
    }
    return true;
});

check('valori non scalari esclusi dai segnaposto, null diventa stringa vuota', function () use ($mail) {
    return !array_key_exists('extra', $mail) && $mail['files'] === '';
});

check('i valori originali non cambiano', function () use ($prepared) {
    $copy = $prepared;
    RequestResource::mailValues($copy);
    return $copy === $prepared;
});

check('afterStore usa i segnaposto escapati in tutti i __t della mail', function () {
    $src = (string) file_get_contents(dirname(__DIR__).'/app/Resources/Site/RequestResource.php');
    return substr_count($src, "__t('emails.contact_request_customer.subject', \$mailValues)") === 1
        && substr_count($src, "__t('emails.contact_request_customer.text', \$mailValues)") === 1
        && substr_count($src, "__t('emails.contact_request_admin.subject', \$mailValues)") === 1
        && str_contains($src, "(\$mailValues[\$field] ?? '')")
        && str_contains($src, "'request_url' => \$mailValues['request_url']")
        && str_contains($src, "\$values['email'] ?? ''"); // destinatario invariato
});

summary();
