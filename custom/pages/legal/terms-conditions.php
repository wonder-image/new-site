<?php

    /**
     * Pagina /legal/terms-conditions/ — versione route-based.
     */

    require_once $_SERVER['DOCUMENT_ROOT'].'/custom/lib/page.php';

    renderPage([
        'key'        => 'terms_conditions',
        'url_path'   => 'legal/terms-conditions',
        'seo'        => [
            'title'       => __t('legal.terms_conditions.seo.title'),
            'description' => __t('legal.terms_conditions.seo.description'),
            'url'         => __u('legal/terms-conditions'),
        ],
        'breadcrumb' => [],
        'render' => function () {
            $key = 'terms_conditions';
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
