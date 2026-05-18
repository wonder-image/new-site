<?php \Wonder\View\View::layout('frontend.base'); ?>
    
    <?= \Wonder\View\View::component('frontend.layout.minimal.header') ?>

    <?=$PAGE_CONTENT?>

    <?= \Wonder\View\View::component('frontend.layout.minimal.footer') ?>

<?php \Wonder\View\View::end(); ?>
