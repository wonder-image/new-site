<?php

    $FRONTEND = true;

    require_once "../../config.php";

    use Wonder\Api\{ Endpoint, EndpointException };
    use Wonder\App\Table;
    
    try {

        # Preparo l'endopoint
            $CALL = (new Endpoint("/api/frontend/form/", "POST", "api_internal_user"))
                        ->checkParameters([ "email" ]);

        # Verifico Recaptcha se inviato
            if (isset($CALL->parameters['g-recaptcha-token'])) {

                verifyRecaptcha($CALL->parameters);
                
                if (isset($ALERT) && !empty($ALERT)) { throw new Exception(__t("notifications.{$ALERT}.text"), $ALERT); } 

            }

        # Preparo i valori per l'upload
            $VALUES = Table::key('form')
                        ->prepare($CALL->parameters);

            if (isset($ALERT) && !empty($ALERT)) { throw new Exception(__t("notifications.{$ALERT}.text"), $ALERT); } 

        # Preparo gli allegati
            $attachment = [];

            foreach ($CALL->files as $key => $tmp) {
                foreach (json_decode($VALUES[$key]) as $key => $file) {
                    array_push($attachment, "$PATH->rUpload/form/files/$file");
                }
            }

        # Inserisco la richiesta
            $SQL = sqlInsert('form', $VALUES);
            $REQUEST_ID = $SQL->insert_id;
            
            if (isset($ALERT) && !empty($ALERT)) { throw new Exception(__t("notifications.{$ALERT}.text"), $ALERT); } 

        # Email customer
            $object = __t("emails.contact_request_customer.subject", $VALUES);
            $body = __t("emails.contact_request_customer.text", $VALUES);

        # Invio email al customer
            sendMail(
                $SOCIETY->email, 
                $VALUES['email'], 
                $object, 
                $body, 
                $attachment
            );

        # Email admin
            $object = __t("emails.contact_request_admin.subject", $VALUES);

            $body = "";
            foreach ([ 'name', 'surname', 'phone', 'email', 'request' ] as $field) { $body .= __t("components.forms.fields.{$field}.label").': '.$VALUES[$field].'<br>'; }

            $body = __t("emails.contact_request_admin.text", [
                'body' => $body,
                'request' => "$PATH->backend/form/view.php?id=$REQUEST_ID",
                'request_url' => $VALUES['request_url']
            ]);

        # Invio email all'admin
            sendMail(
                $SOCIETY->email, 
                $SOCIETY->email, 
                $object, 
                $body, 
                $attachment
            );
        
        # Risposta
            $RESPONSE = $CALL->response(__t("notifications.649.text"));

    } catch (EndpointException $e) {

        http_response_code($e->getCode() ?: 400);

        $RESPONSE = $e->getResponse();
        
    } catch (Exception $e) {

        http_response_code($e->getCode(),);

        $RESPONSE = [
            "success"  => false,
            "status"   => $e->getCode() ?: 500,
            "response" => $e->getMessage()
        ];

    }

    echo json_encode($RESPONSE, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit();