<?php

/**
 * Route frontend del progetto new-site.
 *
 * Carico ciò che NON sono pagine "speciali" gestite altrove (homepage,
 * eventuali landing). Le pagine custom vivono in `custom/pages/`,
 * il boilerplate (require wonder-image.php, SEO, header/footer) è in
 * `custom/lib/page.php` (renderPage()).
 *
 * Variabili in scope (iniettate da RouteDispatcher):
 * - $ROOT     : root del progetto (es. document root del sito)
 * - $ROOT_APP : root del package framework (vendor/wonder-image/app/app)
 *
 * Convenzione naming:
 * - `frontend.contact` → /contact/
 * - `frontend.legal.cookie-policy` → /legal/cookie-policy/
 *
 * Le route in area=frontend sono translatable di default: i path verranno
 * espansi in N varianti per lingua quando il consumer ha registrato
 * `urls.json` per i locali (vedi UrlTranslator + TASK A).
 */

use Wonder\Http\Route;

Route::area('frontend')
    ->response('html')
    ->name('frontend.')
    ->group(function () use ($ROOT) {

        Route::get('/contact/', $ROOT.'/custom/pages/contact.php')
            ->name('contact');

        Route::name('legal.')
            ->prefix('/legal')
            ->group(function () use ($ROOT) {

                Route::get('/cookie-policy/', $ROOT.'/custom/pages/legal/cookie-policy.php')
                    ->name('cookie-policy');

                Route::get('/privacy-policy/', $ROOT.'/custom/pages/legal/privacy-policy.php')
                    ->name('privacy-policy');

                Route::get('/terms-conditions/', $ROOT.'/custom/pages/legal/terms-conditions.php')
                    ->name('terms-conditions');

            });

    });
