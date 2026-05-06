<?php
    /**
     * Home (demo).
     *
     * Pilota di fase 2b/4: usa la factory renderPage() definita in
     * custom/lib/page.php al posto del boilerplate manuale (require di
     * wonder-image.php, set di $FRONTEND/$PRIVATE/$PERMIT, scaffold HTML,
     * include head/body-start/header/footer/body-end).
     *
     * La factory legge SEO defaults da lang/{locale}/pages.json (chiave
     * pages.home.seo.*) e label nav da lang/{locale}/components.json
     * (components.navigation.home).
     *
     * Override possibili (vedi custom/lib/page.php):
     * - 'frontend' / 'private' / 'permit'    : equivalenti legacy
     * - 'seo' => ['title','description','url']: override SEO inline
     * - 'breadcrumb'                          : override breadcrumb
     * - 'url_path'                            : path da passare a __u()
     */

    require_once $_SERVER['DOCUMENT_ROOT'].'/custom/lib/page.php';

    renderPage([
        'key'    => 'home',
        'render' => function () {
            // Contenuto della home — vuoto, come la demo originale.
            // Aggiungere qui sezioni con include diretto, es:
            //   include $_SERVER['DOCUMENT_ROOT'].'/custom/components/sections/hero.php';
        },
    ]);