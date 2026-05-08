<?php

/**
 * Endpoint pubblico per la submission del form di contatto.
 *
 * Migrazione 1:1 di api/frontend/form/index.php (legacy directory-based)
 * verso il nuovo route system. Differenze:
 *
 * - Il bootstrap di wonder-image.php è già stato fatto da `RouteDispatcher`
 *   (`bootApplication()`), niente più require manuale né api/config.php.
 * - I CORS headers sono gestiti dal dispatcher per `area=api`.
 * - L'URL backend nella mail dell'admin punta alla pagina auto-generata
 *   dalla `FormContactResource` (`/backend/forms/contact/{id}/`) invece
 *   che alla vecchia `/backend/form/view.php?id=...`.
 */

use Wonder\Api\Endpoint;
use Wonder\Api\EndpointException;
use Wonder\App\Table;

try {

    $CALL = (new Endpoint('/api/frontend/form/', 'POST', 'api_internal_user'))
        ->checkParameters(['email']);

    if (isset($CALL->parameters['g-recaptcha-token'])) {
        verifyRecaptcha($CALL->parameters);

        if (isset($ALERT) && !empty($ALERT)) {
            throw new Exception(__t("notifications.{$ALERT}.text"), $ALERT);
        }
    }

    $VALUES = Table::key('form')->prepare($CALL->parameters);

    if (isset($ALERT) && !empty($ALERT)) {
        throw new Exception(__t("notifications.{$ALERT}.text"), $ALERT);
    }

    // Discriminator: la submission del form di contatto pubblico
    // è sempre code='contact', leggibile poi da FormContactResource.
    $VALUES['code'] = 'contact';

    // Allegati (se presenti)
    $attachment = [];
    foreach ($CALL->files as $key => $tmp) {
        if (empty($VALUES[$key])) {
            continue;
        }
        $files = json_decode($VALUES[$key]);
        if (!is_array($files)) {
            continue;
        }
        foreach ($files as $file) {
            $attachment[] = "$PATH->rUpload/form/files/$file";
        }
    }

    $SQL = sqlInsert('form', $VALUES);
    $REQUEST_ID = $SQL->insert_id;

    if (isset($ALERT) && !empty($ALERT)) {
        throw new Exception(__t("notifications.{$ALERT}.text"), $ALERT);
    }

    // Email customer
    $object = __t('emails.contact_request_customer.subject', $VALUES);
    $body   = __t('emails.contact_request_customer.text', $VALUES);

    sendMail(
        $SOCIETY->email,
        $VALUES['email'],
        $object,
        $body,
        $attachment
    );

    // Email admin
    $object = __t('emails.contact_request_admin.subject', $VALUES);

    $body = '';
    foreach (['name', 'surname', 'phone', 'email', 'request'] as $field) {
        $body .= __t("components.forms.fields.{$field}.label").': '.$VALUES[$field].'<br>';
    }

    $body = __t('emails.contact_request_admin.text', [
        'body'        => $body,
        // Link alla pagina auto-generata da FormContactResource (path
        // 'forms/contact' + slug 'forms-contact'); URL nominata via
        // RouteRegistrar: backend.resource.forms-contact.view
        'request'     => "$PATH->backend/forms/contact/$REQUEST_ID/",
        'request_url' => $VALUES['request_url'],
    ]);

    sendMail(
        $SOCIETY->email,
        $SOCIETY->email,
        $object,
        $body,
        $attachment
    );

    $RESPONSE = $CALL->response(__t('notifications.649.text'));

} catch (EndpointException $e) {

    http_response_code($e->getCode() ?: 400);
    $RESPONSE = $e->getResponse();

} catch (Exception $e) {

    http_response_code($e->getCode() ?: 500);

    $RESPONSE = [
        'success'  => false,
        'status'   => $e->getCode() ?: 500,
        'response' => $e->getMessage(),
    ];

}

echo json_encode($RESPONSE, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
exit();
