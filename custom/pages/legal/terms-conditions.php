<?php

    /**
     * Pagina /legal/terms-conditions/ — versione route-based.
     */

    require_once $_SERVER['DOCUMENT_ROOT'].'/custom/lib/page.php';

    renderPage([
        'key'      => 'terms_conditions',
        'url_path' => 'legal/terms-conditions',
        'breadcrumb' => [],
        'render' => function () {
            $key = 'terms_conditions';
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
