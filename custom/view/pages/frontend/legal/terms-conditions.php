<?php

    use Wonder\Elements\Components\LegalDocument;

    $SEO->title = __t('legal.terms_conditions.seo.title');
    $SEO->description = __t('legal.terms_conditions.seo.description');
    $SEO->url = __u('legal/terms-conditions');
    $SEO->breadcrumb = [];

    // Il testo viene dal documento legale attivo (backend → Documenti legali).
    \Wonder\View\View::layout('frontend.main');
?>

<section class="intro">
    <div class="content">
        <?= LegalDocument::make('terms_conditions')->render() ?>
    </div>
</section>

<?php \Wonder\View\View::end(); ?>
