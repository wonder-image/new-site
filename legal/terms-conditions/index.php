<?php
    
    $FRONTEND = true;
    $PRIVATE = false;
    $PERMIT = [];

    $ROOT = $_SERVER['DOCUMENT_ROOT'];
    require_once $ROOT."/vendor/wonder-image/app/wonder-image.php";

    require_once "../info.php";

    $SEO->title = "Termini e Condizioni";
    $SEO->description = "Termini e Condizioni di ".$LEGAL->domain;
    $SEO->url = "$PATH->site/legal/terms-conditions/";

?>
<!DOCTYPE html>
<html lang="it">
<head>

    <?php include $ROOT_APP.'/utility/frontend/head.php'; ?>

</head>
<body>

    <?php include $ROOT_APP.'/utility/frontend/body-start.php' ?>
    <?php include $ROOT.'/custom/utility/frontend/header.php' ?>
    
    <section class="intro">
        <div class="content">

            <div class="title">
                TERMINI E CONDIZIONI
            </div>

            <div class="subtitle mt-10">
                1. Accettazione dei termini
            </div>
            <div class="text mt-4">
                Benvenuti sul sito di <?=$LEGAL->domain?> di seguito "il Sito". Prima di utilizzare il Sito, si prega di leggere attentamente i seguenti Termini e Condizioni di Utilizzo ("Termini e Condizioni") che regolano l'accesso e l'utilizzo del Sito. <br>
                Accedendo e utilizzando il Sito, l'utente accetta automaticamente i seguenti Termini e Condizioni e si impegna a rispettarli. Se non si accettano questi Termini e Condizioni, si prega di non utilizzare il Sito.
            </div>

            <div class="subtitle mt-10">
                2. Utilizzo del sito
            </div>
            <div class="text mt-4">
                Il sito è destinato esclusivamente all'uso personale e non commerciale. Non è consentito utilizzare il sito per attività illegali o che violino i diritti di terzi. Inoltre, non è consentito utilizzare il sito per inviare spam o messaggi non richiesti.
            </div>

            <div class="subtitle mt-10">
                3. Proprietà intellettuale
            </div>
            <div class="text mt-4">
                Tutti i contenuti del sito web, compresi i testi, le immagini, i video, i loghi, i marchi, le grafiche, il codice HTML e altri materiali sono di proprietà di <?=$LEGAL->name?> o dei loro rispettivi proprietari e sono protetti dalle leggi sulla proprietà intellettuale. Non è consentito copiare, modificare, distribuire o utilizzare tali contenuti per scopi commerciali senza il permesso esplicito del proprietario del sito web.
            </div>

            <div class="subtitle mt-10">
                4. Responsabilità
            </div>
            <div class="text mt-4">
                Il proprietario del sito web non è responsabile per eventuali danni derivanti dall'utilizzo del sito web, incluse le perdite di dati o perdita di profitti. Inoltre, il proprietario del sito web non è responsabile per eventuali errori, inesattezze o omissioni nei contenuti del sito web.
            </div>

            <div class="subtitle mt-10">
                5. Link esterni
            </div>
            <div class="text mt-4">
                Il Sito potrebbe contenere collegamenti ad altri siti web che non sono di proprietà o controllati dal proprietario del Sito. Il proprietario del Sito non ha alcun controllo sul contenuto, sulle politiche o sulle pratiche di tali siti web e non è responsabile per eventuali perdite, danni o lesioni derivanti dall'utilizzo o dall'incapacità di utilizzare tali siti web. L'inclusione di collegamenti ad altri siti web non implica necessariamente l'approvazione o la raccomandazione di tali siti web da parte del proprietario del Sito.
            </div>

            <div class="subtitle mt-10">
                6. Privacy
            </div>
            <div class="text mt-4">
                La privacy degli utenti del Sito è importante per il proprietario del Sito. Si prega di leggere la <a href="<?=$PATH->site?>/legal/privacy-policy/">Privacy Policy</a> del Sito per maggiori informazioni sulla raccolta, l'uso e la protezione dei dati personali.
            </div>

            <div class="subtitle mt-10">
                7. Modifiche ai termini e alle condizioni
            </div>
            <div class="text mt-4">
                Il proprietario del Sito si riserva il diritto di modificare, in qualsiasi momento e senza preavviso, i presenti Termini e Condizioni. Si prega di controllare periodicamente i Termini e Condizioni per verificare eventuali aggiornamenti o modifiche. L'utilizzo continuato del Sito dopo eventuali modifiche ai Termini e Condizioni costituirà accettazione di tali modifiche.
            </div>

            <div class="subtitle mt-10">
                8. Legge applicabile
            </div>
            <div class="text mt-4">
                I presenti termini e condizioni sono disciplinati dalle leggi dello Stato italiano. In caso di controversie, le parti saranno soggette alla giurisdizione esclusiva dei tribunali italiani.
            </div>
            
            <div class="subtitle mt-10">
                9. Contatto
            </div>
            <div class="text mt-4">
                In caso di domande o commenti sui presenti termini e condizioni, si prega di contattare il proprietario del sito web all’indirizzo <?=$SOCIETY->email?>.
            </div>

        </div>
    </section>

    <?php include $ROOT.'/custom/utility/frontend/footer.php' ?>
    <?php include $ROOT_APP.'/utility/frontend/body-end.php' ?>

</body>
</html>