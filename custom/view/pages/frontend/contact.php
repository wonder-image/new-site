<?php

    $SEO->title = __t('pages.contact.seo.title');
    $SEO->description = __t('pages.contact.seo.description');
    $SEO->url = __u('contact');
    $SEO->breadcrumb = [];

    \Wonder\View\View::layout('frontend.main');
?>

<?php include $_SERVER['DOCUMENT_ROOT'].'/custom/view/components/sections/contact-form.php'; ?>

<?php \Wonder\View\View::end(); ?>
