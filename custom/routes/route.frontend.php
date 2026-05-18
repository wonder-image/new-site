<?php

/**
 * Route frontend del progetto new-site.
 *
 * Carico ciò che NON sono pagine "speciali" gestite altrove (homepage,
 * eventuali landing). Le pagine custom vivono in
 * `custom/view/pages/frontend/` e usano il sistema view/layout di
 * `wonder-image/app`.
 *
 * Variabili in scope (iniettate da RouteDispatcher):
 * - $ROOT     : root del progetto (es. document root del sito)
 * - $ROOT_APP : root del package framework (vendor/wonder-image/app/app)
 *
 * Convenzione naming:
 * - `contact` → /contact/
 * - `legal.cookie-policy` → /legal/cookie-policy/
 *
 * Le route in area=frontend sono translatable di default: i path verranno
 * espansi in N varianti per lingua quando il consumer ha registrato
 * `urls.json` per i locali (vedi UrlTranslator + TASK A).
 */

use Wonder\Http\Route;

Route::area('frontend')
    ->response('html')
    ->group(function () use ($ROOT, $ROOT_APP) {

        Route::get('/', $ROOT_APP.'/view/pages/frontend/default/under_construction.php');

        Route::get('/demo.php', $ROOT.'/custom/view/pages/frontend/home.php')
            ->name('home');

        Route::get('/contact/', $ROOT.'/custom/view/pages/frontend/contact.php')
            ->name('contact');

        Route::name('legal.')
            ->prefix('/legal')
            ->group(function () use ($ROOT) {

                Route::get('/cookie-policy/', $ROOT.'/custom/view/pages/frontend/legal/cookie-policy.php')
                    ->name('cookie-policy');

                Route::get('/privacy-policy/', $ROOT.'/custom/view/pages/frontend/legal/privacy-policy.php')
                    ->name('privacy-policy');

                Route::get('/terms-conditions/', $ROOT.'/custom/view/pages/frontend/legal/terms-conditions.php')
                    ->name('terms-conditions');

            });

    });
