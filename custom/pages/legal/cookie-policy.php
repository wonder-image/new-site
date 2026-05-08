<?php

    /**
     * Pagina /legal/cookie-policy/ — versione route-based.
     */

    require_once $_SERVER['DOCUMENT_ROOT'].'/custom/lib/page.php';

    renderPage([
        'key'        => 'cookie_policy',
        'url_path'   => 'legal/cookie-policy',
        'seo'        => [
            'title'       => __t('legal.cookie_policy.seo.title'),
            'description' => __t('legal.cookie_policy.seo.description'),
            'url'         => __u('legal/cookie-policy'),
        ],
        'breadcrumb' => [],
        'render' => function () {
            $key = 'cookie_policy';
            $paragraphs = __t("legal.{$key}.content.paragraphs");
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
            <?php
        },
    ]);
