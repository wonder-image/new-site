<?php

    /**
     * Pagina /contact/ — versione route-based (sostituisce contact/index.php).
     *
     * Boilerplate centralizzato in custom/lib/page.php (renderPage()).
     */

    require_once $_SERVER['DOCUMENT_ROOT'].'/custom/lib/page.php';

    renderPage([
        'key'      => 'contact',
        'url_path' => 'contact',
        'render' => function () {
            // Sezione form contatto (riusabile, da custom/components/sections/).
            include $_SERVER['DOCUMENT_ROOT'].'/custom/components/sections/contact-form.php';
        },
    ]);
