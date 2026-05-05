<?php

    /**
     * ESEMPIO — non è una pagina caricata da nessuna route.
     *
     * Mostra come una pagina del sito potrà essere scritta in fase 2b
     * usando la factory renderPage() in custom/lib/page.php.
     *
     * Confronta con demo.php / contact/index.php (oggi) per vedere il boilerplate
     * eliminato dalla factory.
     */

    require_once $_SERVER['DOCUMENT_ROOT'].'/custom/lib/page.php';

    renderPage([
        'key'    => 'home',
        'render' => function () {
            ?>

            <section class="intro">
                <div class="content">
                    <h1 class="title-big"><?=__t('pages.home.content.hero.title')?></h1>
                    <p class="text mt-5"><?=__t('pages.home.content.hero.subtitle')?></p>
                </div>
            </section>

            <?php

            // Esempio di sezione riusabile (in 2b sarà già wired-up nel footer):
            // include $_SERVER['DOCUMENT_ROOT'].'/custom/components/sections/contact-form.php';
        },
    ]);
