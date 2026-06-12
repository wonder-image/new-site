<?php

use App\Models\Site\Request;
use App\Resources\Site\RequestResource;
use Wonder\App\Models\Consent\ConsentEvent;
use Wonder\Elements\Components\{ Container, Card, SectionTitle, RichText, Link };

$REQUEST = Request::safeFindById($ITEM['id'] ?? 0);

$fullName = e($REQUEST['name'].' '.$REQUEST['surname']);

$event = consentsForRecord('requests', $REQUEST['id'])[0] ?? null;
$CONSENT = ConsentEvent::safeFindById($event['id'] ?? 0);

\Wonder\View\View::layout('backend.show', [
    'TITLE' => $fullName,
    'SUBTITLE' => 'Richiesta '.$REQUEST['code'].' del '.prettyDate($REQUEST['creation'], true)
]);

echo (new Container)->components([
    
    (new Card)->components([
        
        (new SectionTitle)->text('Richiesta '.$REQUEST['code'])->columnSpan(2),

        (new Container)->components([

            (new RichText(
                RequestResource::getLabel('full_name').": <b>$fullName</b><br>".
                      RequestResource::getLabel('email').": <b>".$REQUEST['email']."</b><br>".
                      RequestResource::getLabel('phone').": <b>".$REQUEST['phone']."</b>"
                ))

        ])->columnSpan(1),

        (new Container)->components([

            (new RichText("Messaggio:<br>".$REQUEST['request']))

        ])->columnSpan(1),

        (new RichText(
            RequestResource::getLabel('request_url').": ".
                    (new Link($REQUEST['request_url'] ?? '#'))
                            ->label($REQUEST['request_url'] ?? 'N/D')
                            ->blank())
            )->columnSpan(2)

    ])->columnSpan(2)
    ->columns(2),

    (new Card)->components([

        (new SectionTitle)->text('Consenso')->columnSpan(2),
        
        (new RichText(
              RequestResource::getLabel('privacy_policy').": <b>".$REQUEST['pretty_accept_privacy_policy']."</b><br>".
                    RequestResource::getLabel('url_consent_privacy_policy').": ".
                    (new Link($CONSENT['backend_url'].'?redirect='.$PAGE->uriBase64 ?? '#'))
                            ->label($CONSENT['backend_url'] ?? 'N/D')
                            ->blank()
            ))
            
    ])->columnSpan(1),

])->columns(3);

\Wonder\View\View::end(); 