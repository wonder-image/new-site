<?php

    $BACKEND = true;
    $PRIVATE = true;
    $PERMIT = [];

    $ROOT = $_SERVER['DOCUMENT_ROOT'];
    require_once $ROOT."/vendor/wonder-image/app/wonder-image.php";

    require_once "set-up.php";

    if (isset($_POST['upload-add']) || isset($_POST['upload'])) {
        $_POST['slug'] = $_POST['name']; 
    }

    require_once $ROOT_APP."/html/backend/index.php";
    
?>
<!DOCTYPE html>
<html lang="it">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$TITLE?></title>

    <?php include $ROOT_APP."/utility/backend/head.php"; ?>

</head>
<body>
    
    <?php include $ROOT_APP."/utility/backend/body-start.php"; ?>
    <?php include $ROOT_APP."/utility/backend/header.php"; ?>

    <form action="" method="post" enctype="multipart/form-data" onsubmit="loadingSpinner()">

        <div class="row g-3">

            <wi-card class="col-12">
                <h3><a href="<?=$REDIRECT?>" type="button" class="text-dark"><i class="bi bi-arrow-left-short"></i></a> <?=$TITLE?></h3>
            </wi-card>

            <div class="col-9">
                <div class="row g-3">

                    <wi-card class="col-12">
                        <div class="col-4">
                            <?=inputFileDragDrop('', 'images'); ?>
                        </div>
                        <div class="col-8">
                            <div class="row g-3">

                                <div class="col-4">
                                    <?=text('Nome', 'name', 'required'); ?>
                                </div>

                                <div class="col-8">
                                    <?=text('Titolo', 'title', 'required'); ?>
                                </div>

                                <h6 class="col-12">
                                    Bottone
                                </h6>
                                <div class="col-4">
                                    <?=text('Testo', 'url_label')?>
                                </div>
                                <div class="col-8">
                                    <?=url('Url', 'url')?>
                                </div>
                                
                            </div>
                        </div>
                    </wi-card>

                </div>
            </div>

            <wi-card class="col-3">
                <div class="col-12">
                    <?=check('Pagine', 'pages', $SITE_PAGES, 'required')?>
                </div>
                <div class="col-12">
                    <?=select('Visualizzazioni', 'view', [ '1' => '1 Volta', '2' => '2 Volte', '' => "Sempre" ], 'old')?>
                </div>
                <div class="col-12">
                    <?=select('Stato', 'visible', [ 'true' => "Visibile", 'false' => "Nascosto" ], 'old', 'required')?>
                </div>
                <div class="col-12">
                    <?=submitAdd()?>
                </div>
            </wi-card>
        
        </div>
    </form>

    <?php include $ROOT_APP."/utility/backend/footer.php"; ?>
    <?php include $ROOT_APP."/utility/backend/body-end.php"; ?>

</body>
</html>