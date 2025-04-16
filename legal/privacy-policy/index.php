<?php
    
    $FRONTEND = true;
    $PRIVATE = false;
    $PERMIT = [];

    $ROOT = $_SERVER['DOCUMENT_ROOT'];
    require_once $ROOT."/vendor/wonder-image/app/wonder-image.php";

    require_once "../info.php";

    $SEO->title = "Informativa sulla privacy";
    $SEO->description = "Informativa sulla privacy di ".$LEGAL->domain;
    $SEO->url = "$PATH->site/legal/privacy-policy/";

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
                INFORMATIVA SULLA PRIVACY
            </div>
            <div class="text mt-4">
                La privacy dei nostri clienti è importante per noi. La nostra Informativa sul Trattamento dei dati personali illustra le modalità di raccolta, utilizzo, trasferimento e conservazione delle informazioni che La riguardano. L’elaborazione dei dati personali avviene nel rispetto del regolamento generale  sulla protezione dei dati (GDPR, General Data Protection Regulation). La preghiamo di leggere l’intera Informativa sulla privacy.
            </div>

            <div class="subtitle mt-10">
                1. Responsabile del trattamento e informazioni di contatto
            </div>
            <div class="text mt-4">
                Responsabile del trattamento dei dati personali che raccogliamo per le finalità indicate al successivo  articolo è <?=$LEGAL->name?>, C.F. <?=$LEGAL->cf?>, P. IVA <?=$LEGAL->pi?>. <br>
                Per domande o richieste a riguardo, può utilizzare i seguenti riferimenti e contatti: <?=$LEGAL->name?>, <?=$LEGAL->office?>, E-mail <?=$LEGAL->email?>, tel. <?=$LEGAL->phone?>.  
            </div>

            <div class="subtitle mt-10">
                2. Modalità e finalità del trattamento dei dati personali
            </div>
            <div class="text mt-4">
                Con riferimento a quanto previsto dell’art. 6, par. 1, lett. b del GDPR, recante disposizioni a tutela della riservatezza nel trattamento dei dati personali, desideriamo con la presente informarLa che: <br>
                <ul>
                    <li>I dati personali da Lei forniti, ovvero altrimenti acquisiti nell’ambito della nostra attività, possono  formare oggetto di trattamento con o senza l’ausilio di mezzi elettronici, nel rispetto della normativa sopra richiamata, per le finalità istituzionali del nostro Studio, e in particolare per: dare esecuzione ad un servizio o ad una o più operazioni contrattualmente convenute; all’esecuzione di obblighi previsti da leggi o regolamenti; e alla tutela dei diritti del titolare del trattamento <?=$LEGAL->name?> in sede giudiziaria (di seguito “Finalità Contrattuali”);</li>
                    <li>
                        Il conferimento dei Suoi dati ad <?=$LEGAL->name?>, sopra identificato, è strettamente funzionale  all’esecuzione del rapporto contrattuale o, quando specificato, alle attività acconsentite dall’utente, in particolare, i seguenti trattamenti dei Suoi dati personali, diversi dalle Finalità Contrattuali, sono possibili solo previo specifico consenso da Lei espresso:
                        <ol>
                            <li>pubblicare fotografie e/o video che La ritraggono nella sezione „GALLERIA“ del Sito o attraverso altri canali elettronici (ad es. Facebook, LinkedIn, Instagram) o tradizionali per fini  promozionali;</li>
                            <li>esibire e/o inviare fotografie che La ritraggono a terzi per fini promozionali;</li>
                            <li>inviarLe materiale informativo circa i servizi offerti da <?=$LEGAL->name?>, sopra identificato, ed eventuali iniziative anche di carattere commerciale dallo stesso avviate, mediante comunicazioni elettroniche e/o tradizionali.</li>
                        </ol>
                    </li>
                </ul>
                I trattamenti indicati ai punti 1, 2 e 3 sono complessivamente indicati come le “Finalità di  Marketing”. <br>
                <?=$LEGAL->name?> Le chiederà se intende acconsentire espressamente alle Finalità di Marketing nella fase di accettazione dell’incarico o anche successivamente. Il Suo legittimo rifiuto di prestare il consenso per una o più delle Finalità di Marketing non pregiudica i trattamenti dei Suoi dati personali limitatamente alle Finalità Contrattuali.
                <ul>
                    <li>I dati saranno conservati presso la nostra sede legale in <?=$LEGAL->office?>, 3 per il tempo prescritto  dalle norme di legge;</li>
                    <li>Il trattamento dei dati forniti, o altrimenti acquisiti nell’ambito della nostra attività, potrà essere effettuato anche da soggetti a cui sia riconosciuta la facoltà di accedere ai Suoi dati personali da  norme di legge o di normative secondarie e/o comunitarie;</li>
                    <li>Per prevenire accessi non autorizzati, usi illeciti o non corretti e la perdita di dati personali sono adottate specifiche misure di sicurezza;</li>
                    <li>I dati personali da Lei forniti non vengono trasferiti verso Paesi terzi extra UE;</li>
                    <li>In qualsiasi momento si potrà richiedere la modifica o la cancellazione dei suddetti dati.</li>
                </ul>
            </div>

            <div class="subtitle mt-10">
                3. Fondamento giuridico del trattamento
            </div>
            <div class="text mt-4">
                Il fondamento giuridico dei trattamenti svolti per le Finalità Contrattuali è costituito dall’adempimento del contratto e delle obbligazioni precedenti e successive, nonché dall’adempimento degli obblighi giuridici nascenti dal contratto o dalla legge. <br>
                Il fondamento giuridico dei trattamenti svolti per le Finalità di Marketing è costituito dai rispettivi consensi da Lei liberamente prestati.
            </div>

            <div class="subtitle mt-10">
                4. Periodo di conservazione dei dati
            </div>
            <div class="text mt-4">
                I dati raccolti per i trattamenti per le Finalità Contrattuali vengono conservati per un periodo corrispondente a quanto richiesto dalla normativa applicabile ai fini civilistici e fiscali. <br>
                I dati raccolti per i trattamenti per le Finalità di Marketing verranno conservati per il periodo necessario al trattamento per le specifiche finalità e comunque per un periodo non superiore a 5  anni.            
            </div>

            <div class="subtitle mt-10">
                5. Categorie particolari di dati personali
            </div>
            <div class="text mt-4">
                Qualora Lei dovesse conferire ad <?=$LEGAL->name?> dati qualificabili come “categorie particolari di dati personali” e cioè quei dati che rivelano l’origine razziale o etnica, le opinioni politiche, le convinzioni religiose o filosofiche, o l’appartenenza sindacale, nonché dati genetici, dati biometrici intesi a identificare in modo univoco una persona fisica, dati relativi alla salute o alla vita sessuale o all’orientamento sessuale della persona ai sensi degli articoli 9 e 10 del GDPR, tali categorie di dati potranno essere trattate solo previo Suo libero ed esplicito consenso, manifestato in  forma scritta o digitale tramite un form che verrà reso a Lei disponibile. <br>
                Misure di sicurezza specifiche per questa tipologia di dati sono incrementate ulteriormente al fine di garantire il più alto standard di sicurezza dei Suoi dati.
            </div>

            <div class="subtitle mt-10">
                6. Diritti della persona interessata dal trattamento
            </div>
            <div class="text mt-4">
                In ogni momento, Lei può esercitare, ai sensi degli articoli dal 15 al 22 del GDPR, il diritto di:
                <ul>
                    <li>chiedere la conferma dell’esistenza o meno di dati personali che La riguardano (diritto di accesso);</li>
                    <li>ottenere le indicazioni circa le finalità del trattamento, le categorie dei dati personali, i destinatari o le categorie di destinatari a cui i dati personali sono stati o saranno comunicati e, quando possibile, il periodo di conservazione;</li>
                    <li>ottenere la rettifica dei dati personali inesatti e l’integrazione di quelli incompleti;</li>
                    <li>ottenere la limitazione del trattamento nelle ipotesi indicate sub art. 18 GDPR;</li>
                    <li>ottenere la cancellazione dei dati o la trasformazione dei dati in forma anonima, decorsi i termini  di conservazione previsti dalla legge o dalla presente informativa;</li>
                    <li>ottenere la portabilità dei dati, ossia ricevere copia dei dati personali che La riguardano in un formato strutturato, di uso comune e leggibile da dispositivo automatico, per poterli trasmettere a un altro titolare del trattamento;</li>
                    <li>opporsi al trattamento in qualsiasi momento, salvo che sussistano motivi legittimi per la  prosecuzione del trattamento;</li>
                    <li>revocare in qualsiasi momento il consenso per le Finalità di Marketing, senza pregiudicare la liceità dei trattamenti svolti in base al Suo consenso prima della revoca. Tale revoca può essere esercitata anche solo limitatamente a specifiche modalità di trattamento;</li>
                    <li>proporre reclamo al Garante per la Protezione dei Dati Personali o ad un’altra autorità di controllo competente.</li>
                </ul>
                L’Interessato può esercitare i propri diritti contattando il Titolare del trattamento tramite le modalità indicate nella presente Informativa.
            </div>

            <div class="subtitle mt-10">
                7. Modifiche alla politica sulla privacy
            </div>
            <div class="text mt-4">
                Possiamo modificare le informazioni contenute nella presente Politica sulla privacy quando lo riteniamo opportuno. In tal caso, provvederemo ad informarLa tramite procedure diverse attraverso  la Piattaforma (ad esempio, con un banner, un pop-up o una notifica push) oppure mediante l'invio di un avviso al Suo indirizzo e-mail qualora la modifica incida in modo rilevante sulla Sua privacy, affinché Lei possa prendere visione dei cambiamenti, valutarli e, a seconda dei casi, opporsi o disdire eventuali servizi.
            </div>
            <div class="text mt-10">
                E’ possibile consultare online il testo completo della legge: <a href="https://www.garanteprivacy.it/il-testo-del-regolamento" target="_blank" rel="noopener noreferrer">https://www.garanteprivacy.it/il-testo-del-regolamento</a>         
            </div>

        </div>
    </section>

    <?php include $ROOT.'/custom/utility/frontend/footer.php' ?>
    <?php include $ROOT_APP.'/utility/frontend/body-end.php' ?>

</body>
</html>