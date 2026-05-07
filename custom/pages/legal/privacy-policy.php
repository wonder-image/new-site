<?php

    /**
     * Pagina /legal/privacy-policy/ — versione route-based.
     */

    require_once $_SERVER['DOCUMENT_ROOT'].'/custom/lib/page.php';

    renderPage([
        'key'      => 'privacy_policy',
        'url_path' => 'legal/privacy-policy',
        'breadcrumb' => [],
        'render' => function () {
            $key = 'privacy_policy';
            ?>
            <section class="intro">
                <div class="content">

                    <div class="title"><?=__t("legal.{$key}.content.title")?></div>
                    <div class="text mt-4"><?=__t("legal.{$key}.content.subtitle")?></div>

                    <?php
                        foreach (__t("legal.{$key}.content.paragraphs") as $paragraph) {
                            echo '<div class="subtitle mt-10">'.$paragraph['title'].'</div>';
                            echo '<div class="text mt-4">'.$paragraph['text'].'</div>';
                        }
                    ?>

                    <div class="text mt-10"><?=__t("legal.{$key}.content.payoff")?></div>

                </div>
            </section>
            <?php
        },
    ]);
