<?php

namespace App\Models\Form;

use Wonder\App\Model;
use Wonder\Data\UploadSchema as Field;
use Wonder\Sql\TableSchema as Column;

/**
 * Tabella `form` — registro generico delle submission dei form pubblici
 * del sito (contatto, richiesta info, ecc.).
 *
 * Il campo `code` discrimina il tipo di form: ad ogni `code` corrisponde
 * una Resource backend dedicata che filtra per quel valore (vedi
 * `App\Resources\Form\FormContactResource` con condition `code = 'contact'`).
 *
 * Aggiungere un nuovo tipo di form = nuova Resource con condition diversa,
 * niente nuove tabelle.
 */
final class Form extends Model
{
    public static string $table = 'form';
    public static string $folder = 'forms';
    public static string $icon = 'bi bi-envelope-paper';

    public static function tableSchema(): array
    {
        return [
            ...static::sqlColumnsFromDataSchema([
                'code',
                'name',
                'surname',
                'phone',
                'email',
                'privacy',
                'file',
            ]),
            // request/request_url possono essere lunghi (pagina sorgente con
            // querystring, messaggio libero), serve un VARCHAR maggiorato.
            Column::key('request')->varchar()->length(10000),
            Column::key('request_url')->varchar()->length(10000),
        ];
    }

    public static function dataSchema(): array
    {
        return [
            Field::key('code')->text()->sanitize(false)->lower(),
            Field::key('name')->text()->sanitizeFirst(),
            Field::key('surname')->text()->sanitizeFirst(),
            Field::key('phone')->text(),
            Field::key('email')->text()->lower(),
            Field::key('request')->text(),
            Field::key('request_url')->text(),
            Field::key('file')->file()->dir('/form/files/'),
            Field::key('privacy')->text(),
        ];
    }
}
