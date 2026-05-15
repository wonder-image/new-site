<?php

    /**
     * Voci di navigazione del sito.
     *
     * Sorgente unica: stesso array è iterato dal nav desktop e dal nav
     * mobile (vedi custom/utility/frontend/header.php). I `key` sono usati
     * per leggere le label da lang/{locale}/components.json sotto
     * `components.navigation.{key}`.
     *
     * Convenzioni per ogni voce:
     * - `key`      : identificatore stabile, usato come chiave i18n.
     *                Esempi: 'home', 'contact', 'services', 'service_a'.
     * - `url`      : opzionale. Path risolto via `__u()`; '' = homepage.
     * - `route`    : opzionale. Nome route risolto via `__r()`. Se presente,
     *                ha precedenza su `url`.
     * - `external` : opzionale. Se true, l'href è usato as-is (no __u())
     *                e l'<a> riceve target="_blank" rel="noopener…".
     * - `children` : opzionale. Array di altre voci con la stessa
     *                struttura (subnav statica). Ricorsivo: ogni figlio
     *                può a sua volta avere `children`. Vedi
     *                custom/view/components/ui/nav-item.php.
     * - `visible`  : opzionale, riservato per uso futuro
     *                ('private' = solo loggati; 'public' = solo
     *                non-loggati; assenza = sempre visibile).
     */

    return [

        [
            'key' => 'home',
            'url' => '',
        ],

        // Esempio di voce con subnav (commentata: la `lang/{locale}/components.json`
        // del progetto deve avere le label sotto components.navigation.{key}):
        //
        // [
        //     'key'      => 'services',
        //     'route'    => 'services',
        //     'children' => [
        //         [ 'key' => 'service_a', 'route' => 'services.a' ],
        //         [ 'key' => 'service_b', 'route' => 'services.b' ],
        //     ],
        // ],

        [
            'key' => 'contact',
            'url' => 'contact',
            'route' => 'contact',
        ],

    ];
