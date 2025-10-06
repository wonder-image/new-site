<?php

    $FRONTEND = true;
    $PRIVATE = false;
    $PERMIT = [];

    $ROOT = $_SERVER['DOCUMENT_ROOT'];
    require_once $ROOT."/vendor/wonder-image/app/wonder-image.php";

    $PAGE_KEY = 'contact';

    $SEO->title = __t("pages.{$PAGE_KEY}.seo.title");
    $SEO->description = __t("pages.{$PAGE_KEY}.seo.description");
    $SEO->url = __u('contact');
    $SEO->breadcrumb = [
        __u() => __t("components.navigation.home"),
        $SEO->url => __t("components.navigation.{$PAGE_KEY}")
    ];
    
?>
<!DOCTYPE html>
<html lang="<?=__l()?>">
<head>

    <?php include $ROOT_APP.'/utility/frontend/head.php'; ?>

</head>
<body>

    <?php include $ROOT_APP.'/utility/frontend/body-start.php' ?>
    <?php include $ROOT.'/custom/utility/frontend/header.php' ?>


    
    <?php include $ROOT.'/custom/utility/frontend/footer.php' ?>
    <?php include $ROOT_APP.'/utility/frontend/body-end.php' ?>

</body>
</html>