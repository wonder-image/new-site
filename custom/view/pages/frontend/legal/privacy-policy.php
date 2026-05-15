<?php

    $SEO->title = __t('legal.privacy_policy.seo.title');
    $SEO->description = __t('legal.privacy_policy.seo.description');
    $SEO->url = __u('legal/privacy-policy');
    $SEO->breadcrumb = [];

    $key = 'privacy_policy';
    $paragraphs = __t("legal.{$key}.content.paragraphs");
    $subtitle = __t("legal.{$key}.content.subtitle");
    $payoff = __t("legal.{$key}.content.payoff");

    \Wonder\View\View::layout('frontend.main');
?>

<section class="intro">
    <div class="content">

        <div class="title"><?=__t("legal.{$key}.content.title")?></div>
        <?php if (!empty($subtitle)) : ?>
            <div class="text mt-4"><?=$subtitle?></div>
        <?php endif; ?>

        <?php if (is_array($paragraphs)) : ?>
            <?php foreach ($paragraphs as $paragraph) : ?>
                <div class="subtitle mt-10"><?=$paragraph['title'] ?? ''?></div>
                <div class="text mt-4"><?=$paragraph['text'] ?? ''?></div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (!empty($payoff)) : ?>
            <div class="text mt-10"><?=$payoff?></div>
        <?php endif; ?>

    </div>
</section>

<?php \Wonder\View\View::end(); ?>
