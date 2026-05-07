<?php

    /**
     * Pagina /legal/cookie-policy/ — versione route-based.
     */

    require_once $_SERVER['DOCUMENT_ROOT'].'/custom/lib/page.php';

    renderPage([
        'key'      => 'cookie_policy',
        'url_path' => 'legal/cookie-policy',
        'breadcrumb' => [], // niente breadcrumb sulle pagine legali
        'render' => function () {
            $key = 'cookie_policy';
            ?>
            <section class="intro">
                <div class="content">

                    <div class="title"><?=__t("legal.{$key}.content.title")?></div>

                    <?php
                        foreach (__t("legal.{$key}.content.paragraphs") as $paragraph) {
                            echo '<div class="subtitle mt-10">'.$paragraph['title'].'</div>';
                            echo '<div class="text mt-4">'.$paragraph['text'].'</div>';
                        }
                    ?>

                </div>
            </section>
            <?php
        },
    ]);
