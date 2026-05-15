<?php

namespace App\Resources\Form;

use RuntimeException;
use Wonder\App\LegacyGlobals;
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
            TableColumn::key('name')->text()->columns(['name', 'surname'])->link('view'),
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
            ->only(['store'])
            ->fields('store', ['name', 'surname', 'phone', 'email', 'request', 'request_url', 'privacy', 'file']);
    }

    public static function permissionSchema(): PermissionSchema
    {
        return PermissionSchema::for(static::class)
            ->api('store', ['api_internal_user'])
            ->backend(['list', 'view'], ['admin', 'administrator']);
    }

    public static function navigationSchema(): NavigationSchema
    {
        return NavigationSchema::for(static::class)
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
        if ($context === 'api' && $action === 'store' && isset($_POST['g-recaptcha-token'])) {
            verifyRecaptcha($_POST);

            if (!empty($GLOBALS['ALERT'])) {
                $alert = (string) $GLOBALS['ALERT'];

                throw new RuntimeException(__t("notifications.{$alert}.text"), (int) $alert);
            }
        }

        // Discriminator: ogni submission che passa da questa Resource deve
        // sempre essere taggata `code = contact`, indipendentemente
        // dall'input.
        $values['code'] = 'contact';

        return $values;
    }

    public static function afterStore(object $result, array $values = []): void
    {
        $requestId = (int) ($result->insert_id ?? 0);

        if ($requestId <= 0) {
            return;
        }

        $path = LegacyGlobals::get('PATH');
        $society = LegacyGlobals::get('SOCIETY');

        if (!is_object($path) || !isset($path->backend, $path->rUpload) || !is_object($society) || empty($society->email)) {
            return;
        }

        $attachments = static::attachmentPaths($values['file'] ?? null, (string) $path->rUpload);

        $customerSubject = __t('emails.contact_request_customer.subject', $values);
        $customerBody = __t('emails.contact_request_customer.text', $values);

        sendMail(
            $society->email,
            $values['email'] ?? '',
            $customerSubject,
            $customerBody,
            $attachments
        );

        $adminSubject = __t('emails.contact_request_admin.subject', $values);
        $adminDetails = '';

        foreach (['name', 'surname', 'phone', 'email', 'request'] as $field) {
            $adminDetails .= __t("components.forms.fields.{$field}.label").': '.($values[$field] ?? '').'<br>';
        }

        $adminBody = __t('emails.contact_request_admin.text', [
            'body' => $adminDetails,
            'request' => "{$path->backend}/forms/contact/{$requestId}/",
            'request_url' => $values['request_url'] ?? '',
        ]);

        sendMail(
            $society->email,
            $society->email,
            $adminSubject,
            $adminBody,
            $attachments
        );
    }

    private static function attachmentPaths(mixed $storedFiles, string $uploadRoot): array
    {
        if (!is_string($storedFiles) || trim($storedFiles) === '') {
            return [];
        }

        $files = json_decode($storedFiles, true);

        if (!is_array($files)) {
            return [];
        }

        return array_values(array_map(
            static fn (string $file): string => rtrim($uploadRoot, '/').'/form/files/'.$file,
            array_filter($files, 'is_string')
        ));
    }
}
