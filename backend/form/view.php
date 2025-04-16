<?php

    $BACKEND = true;
    $PRIVATE = true;
    $PERMIT = [];

    $ROOT = $_SERVER['DOCUMENT_ROOT'];
    require_once $ROOT."/vendor/wonder-image/app/wonder-image.php";

    require_once "set-up.php";

    if (!empty($PAGE->redirect)) {
        $REDIRECT = $PAGE->redirect;
    } else {
        $REDIRECT = "$PATH->backend/$NAME->folder/list.php";
    }

    $FORM = info('form', 'id', $_GET['id']);
    $FORM->prettyCreation = date('d/m/Y', strtotime($FORM->creation)).' alle '.date('H:i', strtotime($FORM->creation));
    
?>
<!DOCTYPE html>
<html lang="it">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contatto di <?=$FORM->name.' '.$FORM->surname?></title>

    <?php include $ROOT_APP."/utility/backend/head.php"; ?>

</head>
<body>
    
    <?php include $ROOT_APP."/utility/backend/body-start.php"; ?>
    <?php include $ROOT_APP."/utility/backend/header.php" ?>

    <div class="row g-3">

        <wi-card class="col-12">
            <h3><a href="<?=$REDIRECT?>" type="button" class="text-dark"><i class="bi bi-arrow-left-short"></i></a> Contatto di <?=$FORM->name.' '.$FORM->surname?></h3>
            <h6>Effettuata il <?=$FORM->prettyCreation?></h6>
        </wi-card>

        <div class="col-9">
            <div class="row g-3">

                <wi-card class="col-12">
                    <div class="col-6">
                        <h6>DATI</h6>
                        <div class="w-100 mt-2">
                            Nome: <b><?=$FORM->name?> <?=$FORM->surname?></b> <br>
                            Cellulare: <b><?=empty($FORM->phone) ? '--' : prettyPhone($FORM->phone)?></b> <br>
                            Email: <b><?=empty($FORM->email) ? '--' : $FORM->email?></b>
                        </div>
                    </div>
                    <div class="col-6">
                        <h6>RICHIESTA</h6>
                        <div class="w-100 mt-2">
                            <?=$FORM->request?>
                        </div>
                    </div>
                </wi-card>

            </div>
        </div>

        <div class="col-3">
            <div class="row g-3">

                <wi-card class="col-12">
                    <div class="col-12">
                        <h6>DETTAGLI</h6>
                        <div class="w-100 mt-2">
                            Creazione: <b><?=$FORM->prettyCreation?></b> <br>
                            Privacy: <b><?=json_decode($FORM->privacy, true)[0]?></b> <br>
                            URL Richiesta: <br> <a href="<?=$FORM->request_url?>"><?=$FORM->request_url?></a>
                        </div>
                    </div>
                </wi-card>

            </div>
        </div>
    
    </div>

    <?php include $ROOT_APP."/utility/backend/footer.php" ?>
    <?php include $ROOT_APP."/utility/backend/body-end.php"; ?>

</body>
</html>