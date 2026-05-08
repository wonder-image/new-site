<?php

/**
 * Route API del progetto new-site.
 *
 * - Endpoint pubblici/frontend (auth: api_internal_user) sotto /api/frontend/*
 * - Endpoint privati/backend, se servono in futuro, andranno sotto /api/backend/*
 *
 * NB: il framework registra già le route resource-driven (CRUD) per ogni
 * Resource via `ResourceRouteRegistrar::registerApi(...)` in
 * vendor/wonder-image/app/app/config/routes/route.api.php. Quelle URL
 * sono auto-generate e non vanno duplicate qui.
 *
 * Variabili in scope: $ROOT, $ROOT_APP (iniettate da RouteDispatcher).
 */

use Wonder\Http\Route;

Route::area('api')
    ->prefix('/api')
    ->response('json')
    ->name('api.')
    ->group(function () use ($ROOT) {

        Route::name('frontend.')
            ->prefix('/frontend')
            ->group(function () use ($ROOT) {

                Route::post('/form/', $ROOT.'/custom/pages/api/frontend/form.php')
                    ->name('form');

            });

    });
