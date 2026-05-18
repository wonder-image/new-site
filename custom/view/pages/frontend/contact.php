<?php
    
    $SEO->title = __t('pages.contact.seo.title');
    $SEO->description = __t('pages.contact.seo.description');
    $SEO->url = __r('contact');
    $SEO->breadcrumb = [];

    \Wonder\View\View::layout('frontend.main');

?>

<?=\Wonder\View\View::component('frontend.sections.contact-form')?>

<?php \Wonder\View\View::end(); ?>
