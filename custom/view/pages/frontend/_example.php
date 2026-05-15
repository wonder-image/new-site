<?php

    /**
     * ESEMPIO — non è una pagina caricata da nessuna route.
     *
     * Pattern corretto per le view frontend route-based:
     * - imposta SEO / variabili pagina
     * - apri il layout `frontend.main`
     * - stampa solo il contenuto della pagina
     * - chiudi con `View::end()`
     */

    $SEO->title = __t('pages.home.seo.title');
    $SEO->description = __t('pages.home.seo.description');
    $SEO->url = __u('');

    \Wonder\View\View::layout('frontend.main');
?>

<section class="intro">
    <div class="content">
        <h1 class="title-big"><?=__t('pages.home.content.hero.title')?></h1>
        <p class="text mt-5"><?=__t('pages.home.content.hero.subtitle')?></p>
    </div>
</section>

<?php \Wonder\View\View::end(); ?>
