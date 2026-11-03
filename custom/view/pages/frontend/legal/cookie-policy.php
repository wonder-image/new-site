<?php

    use Wonder\Elements\Components\LegalDocument;

    $SEO->title = __t('legal.cookie_policy.seo.title');
    $SEO->description = __t('legal.cookie_policy.seo.description');
    $SEO->url = __u('legal/cookie-policy');
    $SEO->breadcrumb = [];

    // Il testo viene dal documento legale attivo (backend → Documenti legali).
    \Wonder\View\View::layout('frontend.main');
?>

<section class="intro">
    <div class="content">
        <?= LegalDocument::make('cookie_policy')->render() ?>
    </div>
</section>

<?php \Wonder\View\View::end(); ?>
