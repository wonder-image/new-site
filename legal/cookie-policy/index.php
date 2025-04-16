<?php
    
    $FRONTEND = true;
    $PRIVATE = false;
    $PERMIT = [];

    $ROOT = $_SERVER['DOCUMENT_ROOT'];
    require_once $ROOT."/vendor/wonder-image/app/wonder-image.php";

    require_once "../info.php";

    $SEO->title = "Cookie Policy";
    $SEO->description = "Cookie Policy di ".$LEGAL->domain;
    $SEO->url = "$PATH->site/legal/cookie-policy/";

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
                COOKIE POLICY
            </div>

            <div class="subtitle mt-10">
                1. Introduzione
            </div>
            <div class="text mt-4">
                Il sito <?=$LEGAL->domain?>, di seguito denominato il "Sito", utilizza i cookie per migliorare l'esperienza dell'utente e per raccogliere informazioni sulle modalità di utilizzo del Sito. La presente Cookie Policy descrive i tipi di cookie utilizzati dal Sito e le modalità di gestione dei cookie. Si prega di leggere attentamente la presente Cookie Policy prima di utilizzare il Sito.
            </div>

            <div class="subtitle mt-10">
                2. Cosa sono i cookie?
            </div>
            <div class="text mt-4">
                I cookie sono piccoli file di testo che vengono memorizzati sul dispositivo dell'utente quando si visita un sito web. I cookie vengono utilizzati per raccogliere informazioni sull'utilizzo del sito web da parte dell'utente, ad esempio le pagine visitate e il tempo trascorso sul sito.
            </div>

            <div class="subtitle mt-10">
                3. Cookie utilizzati sul Sito
            </div>
            <div class="text mt-4">
                Il Sito utilizza i seguenti tipi di cookie:
                <ul>
                    <li>Cookie tecnici: questi cookie sono necessari per il corretto funzionamento del Sito. Questi cookie non richiedono il consenso dell’utente.</li>
                    <li>Cookie di <b>Google Tag Manager</b>: I cookie di Google Tag Manager sono utilizzati per consentire l'integrazione di diversi strumenti di tracciamento, come Google Analytics o Facebook Pixel, all'interno di un sito web. I cookie di Google Tag Manager non raccolgono informazioni personali dell'utente, ma vengono utilizzati per migliorare l'esperienza dell'utente sul sito e per fornire informazioni sulle prestazioni del sito. In particolare, i cookie di Google Tag Manager sono utilizzati per gestire la configurazione dei tag di tracciamento, ovvero dei codici di programmazione che permettono di raccogliere informazioni sull'utilizzo del sito. I tag di tracciamento sono associati a diversi eventi, come la visualizzazione di una pagina web o un'interazione con un elemento del sito, e permettono di monitorare l'attività dell'utente sul sito. I cookie di Google Tag Manager sono di tipo persistenti e possono essere utilizzati da Google o da terze parti per raccogliere informazioni anonime sull'utilizzo del sito. questi cookie vengono utilizzati per gestire i tag sul Sito.</li>
                    <li>Cookie di <b>Google Analytics</b>: Google Analytics è un servizio di analisi web fornito da Google LLC (“Google”). Google utilizza i Dati Personali raccolti allo scopo di tracciare ed esaminare l’utilizzo di questa Applicazione, compilare report e condividerli con gli altri servizi sviluppati da Google. Google potrebbe utilizzare i Dati Personali per contestualizzare e personalizzare gli annunci del proprio network pubblicitario. Questa integrazione di Google Analytics rende anonimo il tuo indirizzo IP. L'anonimizzazione funziona abbreviando entro i confini degli stati membri dell'Unione Europea o in altri Paesi aderenti all'accordo sullo Spazio Economico Europeo l'indirizzo IP degli Utenti. Solo in casi eccezionali, l'indirizzo IP sarà inviato ai server di Google ed abbreviato all'interno degli Stati Uniti. Questi cookie vengono utilizzati per analizzare l'utilizzo del Sito da parte dell'utente. Questi cookie raccolgono informazioni sull'utilizzo del sito web, ad esempio le pagine visitate e il tempo trascorso sul sito. Le informazioni raccolte da questi cookie vengono utilizzate per migliorare il Sito e per fornire all'utente contenuti personalizzati.</li>
                    <li>Cookie di <b>Google Search Console</b>: I cookie di Google Search Console vengono utilizzati per monitorare l'indicizzazione del sito web da parte dei motori di ricerca, in particolare di Google. Questi cookie consentono al proprietario del sito di raccogliere informazioni sull'utilizzo del sito da parte dei motori di ricerca, come ad esempio le parole chiave utilizzate per raggiungere il sito, le pagine del sito indicizzate e la posizione del sito nei risultati di ricerca. I cookie di Google Search Console sono di tipo persistenti e possono essere utilizzati da Google o da terze parti per raccogliere informazioni anonime sull'utilizzo del sito. Tuttavia, i cookie di Google Search Console non raccolgono informazioni personali dell'utente e non sono utilizzati per fini pubblicitari.</li>
                    <li>Cookie di <b>Pixel Facebook</b>: Il monitoraggio conversioni di Facebook Ads (pixel di Facebook) è un servizio di statistiche fornito da Meta Platforms, Inc. che collega i dati provenienti dal network di annunci Meta con le azioni compiute all'interno di questa Applicazione. Il pixel di Facebook monitora le conversioni che possono essere attribuite alle inserzioni di Facebook, Instagram e Audience Network. Questi cookie vengono utilizzati per raccogliere informazioni sull'utilizzo del Sito da parte dell'utente per finalità di marketing. Questi cookie raccolgono informazioni sull'utilizzo del sito web, ad esempio le pagine visitate e il tempo trascorso sul sito. Le informazioni raccolte da questi cookie vengono utilizzate per fornire all'utente pubblicità personalizzata su Facebook.</li>
                    <li>Cookie di <b>Google ADS</b>: I cookie di Google Ads vengono utilizzati per monitorare l'efficacia delle campagne pubblicitarie sul sito web. Questi cookie consentono di raccogliere informazioni sull'interazione dell'utente con gli annunci pubblicitari, come ad esempio il numero di clic sui singoli annunci, le conversioni generati dagli annunci e il comportamento dell'utente dopo il clic sull’annuncio. I cookie di Google Ads sono di tipo persistenti e possono essere utilizzati da Google o da terze parti per raccogliere informazioni anonime sull'utilizzo del sito. Tuttavia, i cookie di Google Ads non raccolgono informazioni personali dell'utente e non sono utilizzati per fini diversi dalla pubblicità.</li>
                </ul>
            </div>

            <div class="subtitle mt-10">
                4. Utilizzo dei Cookie
            </div>
            <div class="text mt-4">
                Il Sito utilizza i cookie per diversi scopi, tra cui:
                <ul>
                    <li>analisi dell'utilizzo del Sito tramite Google Analytics e Google Tag Manager, che consentono di raccogliere informazioni anonime sulle visite al Sito e sulle interazioni dell'utente con il Sito;</li>
                    <li>ottimizzazione del Sito tramite Google Search Console, che consente di monitorare l'indicizzazione del Sito da parte dei motori di ricerca;</li>
                    <li>pubblicità mirata tramite Pixel Facebook, che consente di tracciare le azioni dell'utente sul Sito e di mostrare annunci pubblicitari personalizzati su Facebook.</li>
                </ul>
            </div>

            <div class="subtitle mt-10">
                5. Tipi di Cookie
            </div>
            <div class="text mt-4">
                I cookie utilizzati si dividono in:
                <ul>
                    <li>cookie di sessione, che vengono cancellati automaticamente quando l'utente chiude il browser;</li>
                    <li>cookie persistenti, che rimangono sul dispositivo dell'utente anche dopo la chiusura del browser e vengono utilizzati per memorizzare le preferenze dell’utente;</li>
                    <li>cookie di terze parti, che vengono utilizzati da terze parti per analizzare l'utilizzo del Sito o per mostrare annunci pubblicitari personalizzati.</li>
                </ul>
            </div>

            <div class="subtitle mt-10">
                6. Link a siti di terze parti
            </div>
            <div class="text mt-4">
                Il Sito potrebbe contenere link a siti web di terze parti, che potrebbero utilizzare cookie e altre tecnologie di tracciamento per raccogliere informazioni sull'utente. La presente Cookie Policy non si applica a tali siti web di terze parti e il proprietario del Sito non è responsabile per le politiche sulla privacy o le pratiche di tali siti web.
            </div>

            <div class="subtitle mt-10">
                7. Modifiche alla Cookie Policy
            </div>
            <div class="text mt-4">
                Il proprietario del Sito si riserva il diritto di modificare la presente Cookie Policy in qualsiasi momento e senza preavviso. È responsabilità dell'utente verificare periodicamente la presente Cookie Policy per eventuali aggiornamenti.
            </div>

            <div class="subtitle mt-10">
                8. Gestione dei cookie
            </div>
            <div class="text mt-4">
                L'utente può gestire i cookie utilizzati dal Sito attraverso le impostazioni del proprio browser. L'utente può scegliere di bloccare tutti i cookie o solo alcuni cookie. Tuttavia, in caso di blocco di alcuni cookie, alcune funzionalità del Sito potrebbero non essere disponibili.
            </div>

            <div class="subtitle mt-10">
                9. Ulteriori informazioni
            </div>
            <div class="text mt-4">
                Per ulteriori informazioni sulla raccolta e l'utilizzo dei dati personali dell'utente, si prega di consultare la <a href="<?=$PATH->site?>/legal/privacy-policy/">Privacy Policy</a> del Sito.
            </div>

            <div class="subtitle mt-10">
                10. Accettazione dei cookie
            </div>
            <div class="text mt-4">
                L'utilizzo del Sito implica l'accettazione della presente Cookie Policy. In caso di mancata accettazione della presente Cookie Policy, l'utente dovrà interrompere immediatamente l'utilizzo del Sito.
            </div>

        </div>
    </section>

    <?php include $ROOT.'/custom/utility/frontend/footer.php' ?>
    <?php include $ROOT_APP.'/utility/frontend/body-end.php' ?>

</body>
</html>