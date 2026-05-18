<?php

    $SEO->title = __t('pages.home.seo.title');
    $SEO->description = __t('pages.home.seo.description');
    $SEO->url = __r('home');
    $SEO->breadcrumb = [];

    \Wonder\View\View::layout('frontend.main');
    
?>

<section class="intro">
    <div class="content">
        <h1 class="title-big"><?=__t('pages.home.content.hero.title')?></h1>
        <p class="text mt-5"><?=__t('pages.home.content.hero.subtitle')?></p>
    </div>
</section>

<?=\Wonder\View\View::component('frontend.sections.contact-form')?>

<?php \Wonder\View\View::end(); ?>
