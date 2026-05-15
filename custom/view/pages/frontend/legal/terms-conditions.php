<?php

    $SEO->title = __t('legal.terms_conditions.seo.title');
    $SEO->description = __t('legal.terms_conditions.seo.description');
    $SEO->url = __u('legal/terms-conditions');
    $SEO->breadcrumb = [];

    $key = 'terms_conditions';
    $paragraphs = __t("legal.{$key}.content.paragraphs");

    \Wonder\View\View::layout('frontend.main');
?>

<section class="intro">
    <div class="content">

        <div class="title"><?=__t("legal.{$key}.content.title")?></div>

        <?php if (is_array($paragraphs)) : ?>
            <?php foreach ($paragraphs as $paragraph) : ?>
                <div class="subtitle mt-10"><?=$paragraph['title'] ?? ''?></div>
                <div class="text mt-4"><?=$paragraph['text'] ?? ''?></div>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>
</section>

<?php \Wonder\View\View::end(); ?>
