<?php

namespace App\Resources\Form;

use Wonder\App\Resource;
use Wonder\App\ResourceSchema\ApiSchema;
use Wonder\App\ResourceSchema\NavigationSchema;
use Wonder\App\ResourceSchema\PageSchema;
use Wonder\App\ResourceSchema\PermissionSchema;
use Wonder\App\ResourceSchema\TableColumn;
use Wonder\App\ResourceSchema\TableLayoutSchema;

/**
 * Backend per le submission del form di contatto (`code = 'contact'`).
 *
 * Solo lettura: le richieste arrivano dal frontend, in admin si visualizzano
 * e si gestiscono (no creazione manuale).
 */
final class FormContactResource extends Resource
{
    public static string $model = \App\Models\Form\Form::class;

    public static array|string $condition = [
        'deleted' => 'false',
        'code' => 'contact',
    ];

    public static string $orderColumn = 'creation';
    public static string $orderDirection = 'DESC';

    public static function path(): string
    {
        return 'forms/contact';
    }

    public static function icon(): string
    {
        return 'bi bi-envelope-paper';
    }

    public static function textSchema(): array
    {
        return [
            'label' => 'richiesta',
            'plural_label' => 'richieste',
            'last' => 'ultime',
            'all' => 'tutte',
            'article' => 'le',
            'full' => 'gestita',
            'empty' => 'non gestita',
            'this' => 'questa',
        ];
    }

    public static function labelSchema(): array
    {
        return [
            'name' => 'Nome',
            'surname' => 'Cognome',
            'email' => 'Email',
            'phone' => 'Telefono',
            'request' => 'Richiesta',
            'request_url' => 'URL pagina',
            'creation' => 'Ricevuta il',
        ];
    }

    public static function tableSchema(): array
    {
        return [
            TableColumn::key('name')->text()->link('view'),
            TableColumn::key('surname')->text()->link('view'),
            TableColumn::key('email')->text(),
            TableColumn::key('phone')->text(),
            TableColumn::key('creation')->datetime()->size('medium'),
        ];
    }

    public static function tableLayoutSchema(): TableLayoutSchema
    {
        return TableLayoutSchema::for(static::class)
            ->title('Lista '.static::pluralLabel())
            ->results()
            ->hideButtonAdd()
            ->filters()
            ->searchFields(['name', 'surname', 'email', 'phone', 'request']);
    }

    public static function pageSchema(): PageSchema
    {
        return PageSchema::for(static::class)
            ->only(['list', 'view']);
    }

    public static function apiSchema(): ApiSchema
    {
        return ApiSchema::for(static::class)
            ->fields('store', ['name', 'surname', 'phone', 'email', 'request', 'request_url', 'privacy']);
    }

    public static function permissionSchema(): PermissionSchema
    {
        return PermissionSchema::for(static::class)
            ->backend(['list', 'view'], ['admin', 'administrator']);
    }

    public static function navigationSchema(): NavigationSchema
    {
        return NavigationSchema::for(static::class)
            ->section('Form', 'forms', 'bi-envelope-paper')
            ->title('Contatti')
            ->order(10)
            ->authority(['admin', 'administrator']);
    }

    public static function mutateRequestValues(
        array $values,
        string $action,
        string $context = 'backend',
        ?array $oldValues = null
    ): array {
        // Discriminator: ogni submission che passa da questa Resource deve
        // sempre essere taggata `code = contact`, indipendentemente
        // dall'input.
        $values['code'] = 'contact';

        return $values;
    }
}
