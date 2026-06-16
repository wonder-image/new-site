<?php

namespace App\Resources\Site;

use RuntimeException;
use Wonder\App\LegacyGlobals;
use Wonder\App\Resource;
use Wonder\App\ResourceSchema\ApiSchema;
use Wonder\App\ResourceSchema\FormField;
use Wonder\App\ResourceSchema\NavigationSchema;
use Wonder\App\ResourceSchema\PageSchema;
use Wonder\App\ResourceSchema\PermissionSchema;
use Wonder\App\ResourceSchema\TableColumn;
use Wonder\App\ResourceSchema\TableLayoutSchema;
use Wonder\Plugin\Google\Credentials as GoogleCredentials;
use Wonder\Plugin\Google\Security\reCAPTCHA;

/**
 * Backend per le submission del form di contatto (`code = 'contact'`).
 *
 * Solo lettura: le richieste arrivano dal frontend, in admin si visualizzano
 * e si gestiscono (no creazione manuale).
 */
final class RequestResource extends Resource
{
    public static string $model = \App\Models\Site\Request::class;

    public static array|string $condition = [
        'deleted' => 'false'
    ];

    public static string $orderColumn = 'creation';
    public static string $orderDirection = 'DESC';

    public static function path(): string
    {
        return static::$model::$folder;
    }

    public static function icon(): string
    {
        return static::$model::$icon;
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
            'code' => 'Codice',
            'full_name' => 'Nome',
            'name' => 'Nome',
            'surname' => 'Cognome',
            'email' => 'Email',
            'phone' => 'Telefono',
            'request' => 'Richiesta',
            'request_url' => 'URL pagina',
            'files' => 'Files',
            'privacy_policy' => 'Privacy Policy',
            'accept_privacy_policy' => 'Accetta la Privacy Policy',
            'url_consent_privacy_policy' => 'Link consenso',
            'creation' => 'Ricevuta il',
        ];
    }

    /**
     * Definizione dei campi input del form contatto.
     *
     * Sorgente canonica: la view frontend recupera i singoli campi via
     * `static::getInput($name)` e li infila nel container `Form`. I
     * componenti di control (captcha hidden + SubmitRecaptcha) restano
     * nella view perche non sono input "di dato" ma plumbing del flusso.
     */
    public static function formSchema(): array
    {
        return [
            FormField::key('name')->text()->required()
                ->label(__t('components.forms.fields.name.label')),

            FormField::key('surname')->text()->required()
                ->label(__t('components.forms.fields.surname.label')),

            FormField::key('phone')->phone()->required()
                ->label(__t('components.forms.fields.phone.label')),

            FormField::key('email')->email()->required()
                ->attribute('autocomplete="email"')
                ->label(__t('components.forms.fields.email.label')),

            FormField::key('request')->textarea()->required()
                ->label(__t('components.forms.fields.request.label')),

            FormField::key('accept_privacy_policy')->acceptDocument('privacy_policy')->required(),

            FormField::key('request_url')->hidden(),

            FormField::key('recaptcha')->recaptcha('contact'),

            FormField::key('files')->file()->maxFile(1)->maxSize(2)->extensions(['pdf'])

        ];
    }

    public static function tableSchema(): array
    {
        return [
            TableColumn::key('name')->text()->columns(['name', 'surname'])->link('view'),
            TableColumn::key('email')->text()->hiddenDevice('mobile'),
            TableColumn::key('phone')->text()->hiddenDevice('mobile'),
            TableColumn::key('creation')->datetime()->hiddenDevice('mobile'),
            TableColumn::key('actions')->button()->actions(['view'])
        ];
    }

    public static function tableLayoutSchema(): TableLayoutSchema
    {
        return TableLayoutSchema::for(static::class)
            ->title('Lista '.static::pluralLabel())
            ->results()
            ->hideButtonAdd()
            ->filters()
            ->searchFields(['name', 'surname', 'email', 'phone', 'request'])
            ->download(['xlsx', 'csv'])
            ->downloadColumns([
                'code',
                ['label' => 'Nome completo', 'value' => fn($r) => trim(($r['name'] ?? '').' '.($r['surname'] ?? ''))],
                'email',
                'phone',
                'creation'
            ]);
    }

    public static function pageSchema(): PageSchema
    {
        return PageSchema::for(static::class)
            ->only(['list', 'view'])
            ->view('show', static::customShowViewPath())
            ->title('view', 'Dettaglio richiesta');
    }

    private static function customShowViewPath(): ?string
    {

        $root = (string) LegacyGlobals::get('ROOT', '');

        return $root !== ''
            ? $root.'/custom/view/pages/backend/request/show.php'
            : null;

    }

    public static function apiSchema(): ApiSchema
    {
        return ApiSchema::for(static::class)
            ->only(['store'])
            ->fields('store', ['name', 'surname', 'phone', 'email', 'request', 'request_url', 'accept_privacy_policy', 'files']);
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
            ->title('Richieste')
            ->sectionOrder(30)
            ->authority(['admin', 'administrator']);
    }

    public static function mutateRequestValues(
        array $values,
        string $action,
        string $context = 'backend',
        ?array $oldValues = null
    ): array {

        if ($context === 'api' && $action === 'store') {
            static::verifyContactCaptcha();
        }

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

        $attachments = static::attachmentPaths($values['files'] ?? null, (string) $path->rUpload);

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
            'request' => "{$path->backend}/".static::$model::$folder."/{$requestId}/",
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

    /**
     * Verifica reCAPTCHA Enterprise per la submission del form contatto.
     *
     * Usa direttamente `Wonder\Plugin\Google\Security\reCAPTCHA::verify()`
     * invece dell'helper procedurale `verifyRecaptcha()` (che muta
     * `$GLOBALS['ALERT']`, pattern legacy).
     *
     * Token e action sono trasporto HTTP, non dato persistito: vivono
     * fuori dall'`apiSchema()` whitelist e li leggiamo da `$_POST`.
     * Sono popolati dalla view tramite
     * `Wonder\Plugin\Custom\Input\reCAPTCHA` (che emette il widget
     * `.g-recaptcha` + due hidden `g-recaptcha-token` /
     * `g-recaptcha-action`, riempiti runtime dal callback in
     * `lib/src/build/frontend/js/form/recaptcha.js`).
     *
     * Lancia `RuntimeException` con codice i18n 617 (captcha non
     * valido) cosi il middleware API lo restituisce al frontend, che
     * lo mostra via `loadingResponse`.
     */
    private static function verifyContactCaptcha(): void
    {
        $token  = trim((string) ($_POST['g-recaptcha-token']  ?? ''));
        $action = trim((string) ($_POST['g-recaptcha-action'] ?? ''));

        if ($token === '' || $action === '') {
            static::logRecaptchaFailure('missing_token_or_action', [
                'action' => $action,
                'token_length' => strlen($token),
            ]);
            throw new RuntimeException(__t('notifications.617.text'), 617);
        }

        try {
            $result = (new reCAPTCHA())->verify($token, $action);
        } catch (\Throwable $exception) {
            static::logRecaptchaFailure('enterprise_verify_exception', [
                'action' => $action,
                'token_length' => strlen($token),
            ], $exception);

            throw new RuntimeException(__t('notifications.617.text'), 617);
        }

        if (empty($result->valid)) {
            static::logRecaptchaFailure('enterprise_verify_invalid', [
                'action' => $action,
                'token_length' => strlen($token),
                'google_result' => (array) ($result->result ?? []),
            ]);
            throw new RuntimeException(__t('notifications.617.text'), 617);
        }
    }

    private static function logRecaptchaFailure(string $reason, array $context = [], ?\Throwable $exception = null): void
    {
        $credentials = GoogleCredentials::get();

        $baseContext = [
            'reason' => $reason,
            'request_uri' => (string) ($_SERVER['REQUEST_URI'] ?? ''),
            'remote_addr' => (string) ($_SERVER['REMOTE_ADDR'] ?? ''),
            'has_gcp_project_id' => trim((string) ($credentials->gcp_project_id ?? '')) !== '',
            'has_gcp_api_key' => trim((string) ($credentials->gcp_api_key ?? '')) !== '',
            'has_site_key' => trim((string) ($credentials->recaptcha_site_key ?? '')) !== '',
        ];

        \Wonder\App\Logger::log(
            $exception ?? new RuntimeException('reCAPTCHA Enterprise verification failed'),
            'recaptcha',
            'contact_form_verify',
            'ERROR',
            'error/recaptcha',
            array_merge($baseContext, $context),
            false
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
            static fn (string $file): string => rtrim($uploadRoot, '/').'/requests/files/'.$file,
            array_filter($files, 'is_string')
        ));
    }
}
