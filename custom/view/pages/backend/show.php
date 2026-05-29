<?php

use App\Models\Request\Request;
use App\Resources\Request\RequestResource;
use Wonder\App\Models\Consent\ConsentEvent;
use Wonder\Elements\Components\{ Container, Card, SectionTitle, Text };

$REQUEST = Request::safeFindById($ITEM['id'] ?? 0);

$fullName = e($REQUEST['name'].' '.$REQUEST['surname']);

$event = consentsForRecord('requests', $REQUEST['id']);
$CONSENT = ConsentEvent::safeFindById($event['id'] ?? 0);

$TITLE = $fullName; # Non viene passato

\Wonder\View\View::layout('backend.show');

echo (new Container)->components([
    
    (new Card)->components([
        
        (new SectionTitle)->text('Richiesta '.$REQUEST['code'])->columnSpan(2),

        (new Container)->components([

            (new Text(
                RequestResource::getLabel('full_name').": <b>$fullName</b><br>".
                      RequestResource::getLabel('email').": <b>".$REQUEST['email']."</b><br>".
                      RequestResource::getLabel('phone').": <b>".$REQUEST['phone']."</b>"
                ))

        ])->columnSpan(1),

        (new Container)->components([

            (new Text("Messaggio:<br>".$REQUEST['request']))

        ])->columnSpan(1),

        (new Text("Link: <a href=\"".$REQUEST['request_url']."\"  target=\"_blank\" rel=\"noopener noreferrer\"'>".$REQUEST['request_url']."</a>"))->columnSpan(2)

    ])->columnSpan(2)
    ->columns(2),

    (new Card)->components([

        (new SectionTitle)->text('Consenso')->columnSpan(2),
        
        (new Text(
            RequestResource::getLabel('privacy_policy').": <b>".$REQUEST['accept_privacy_policy']."</b><br>".
                  RequestResource::getLabel('url_consent_privacy_policy').": <b>".$REQUEST['accept_privacy_policy']."</b>"
            ))
            
    ])->columnSpan(1),

])->columns(3);

?>


<div class="row g-3">
    <wi-card class="col-8">
        <h6 class="col-12">Richiesta</h6>
        <div class="col-12">
            Nome: <b><?=e($fullName)?></b>
        </div>
    </wi-card>

    <wi-card class="col-4">
        <h6 class="col-12">Consenso privacy</h6>
        <div class="col-12">
            <?= wiCard($events ?? '') ?>
        </div>
    </wi-card>

</div>

<?php \Wonder\View\View::end(); ?>
