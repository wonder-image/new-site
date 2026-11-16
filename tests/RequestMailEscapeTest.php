<?php
/**
 * php tests/RequestMailEscapeTest.php — email del form contatti
 * (RequestResource::afterStore): corpi composti con MailMessage, dati del
 * visitatore escapati una volta sola. L'invio vero si prova in locale.
 */
declare(strict_types=1);

require __DIR__.'/bootstrap.php';
// Mappa usata da sanitize(): simula i valori già preparati per il DB.
require dirname(__DIR__).'/vendor/wonder-image/app/app/config/array/characters.php';
$GLOBALS['CHARACTERS'] = $CHARACTERS;
// La classe di questo checkout, anche quando vendor/ è di un altro checkout.
require_once dirname(__DIR__).'/app/Resources/Site/RequestResource.php';

use App\Resources\Site\RequestResource;
use Wonder\App\Support\Mail\MailMessage;
use Wonder\Localization\{ LanguageContext, TranslationProvider };

LanguageContext::addLangPath(dirname(__DIR__).'/vendor/wonder-image/app/resources/lang/')
    ::addLangPath(dirname(__DIR__).'/lang/')
    ::setLang('it');
TranslationProvider::init();

// Postino finto: tiene le email invece di spedirle.
$GLOBALS['__sent'] = [];
function sendMail($from, $to, $object, $body, $attachments = null): bool
{
    $GLOBALS['__sent'][] = ['to' => $to, 'subject' => $object, 'body' => $body];

    return true;
}

$prepared = [
    'name' => sanitize('<script>alert(1)</script>'),
    'surname' => sanitize("O'Brien & \"figli\""),
    'email' => sanitize('a@b.c'),
    'phone' => sanitize('+39 333'),
    'request' => sanitize("riga 1\n<img src=x onerror=alert(1)>"),
    'request_url' => sanitize('https://example.com/p?a=1&b=2'),
    'files' => null,
    'extra' => ['non', 'scalare'],
];
$mail = RequestResource::mailValues($prepared);

check('mailValues: valori in chiaro, senza escape né slash di addslashes', function () use ($mail) {
    return $mail['name'] === '<script>alert(1)</script>'
        && $mail['surname'] === "O'Brien & \"figli\""
        && $mail['request'] === "riga 1\n<img src=x onerror=alert(1)>";
});

check('request_url https resta in chiaro', function () use ($mail) {
    return $mail['request_url'] === 'https://example.com/p?a=1&b=2';
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

$GLOBALS['PATH'] = (object) ['backend' => 'https://sito.test/backend', 'rUpload' => sys_get_temp_dir()];
$GLOBALS['SOCIETY'] = (object) ['email' => 'negozio@sito.test'];
RequestResource::afterStore((object) ['insert_id' => 7], $prepared);
[$customer, $admin] = $GLOBALS['__sent'] + [null, null];

check('partono due email: al cliente e al negozio', function () use ($customer, $admin) {
    return $customer['to'] === 'a@b.c' && $admin['to'] === 'negozio@sito.test';
});

check('i corpi sono MailMessage', function () use ($customer, $admin) {
    return $customer['body'] instanceof MailMessage && $admin['body'] instanceof MailMessage
        && MailMessage::isBuilt((string) $customer['body']) && MailMessage::isBuilt((string) $admin['body']);
});

check('dati del visitatore escapati una volta, niente tag vivi', function () use ($customer, $admin) {
    foreach ([(string) $customer['body'], (string) $admin['body']] as $html) {
        if (str_contains($html, '<script') || str_contains($html, '<img') || str_contains($html, '&amp;lt;')) {
            return false;
        }
    }
    return str_contains((string) $customer['body'], '&lt;script&gt;alert(1)&lt;/script&gt;')
        && str_contains((string) $admin['body'], 'O&#039;Brien &amp; &quot;figli&quot;');
});

check('il messaggio conserva gli a capo', function () use ($admin) {
    return str_contains((string) $admin['body'], 'riga 1<br>&lt;img');
});

check('pulsante verso la richiesta nel backend e pagina di invio', function () use ($admin) {
    $html = (string) $admin['body'];
    return str_contains($html, 'href="https://sito.test/backend/'.\App\Models\Site\Request::$folder.'/7/"')
        && str_contains($html, 'https://example.com/p?a=1&amp;b=2');
});

check('nessuna chiave di traduzione rimasta nel testo', function () use ($customer, $admin) {
    foreach ([$customer, $admin] as $sent) {
        if (str_contains((string) $sent['body'], 'emails.') || str_contains($sent['subject'], 'emails.')) {
            return false;
        }
    }
    return true;
});

summary();
