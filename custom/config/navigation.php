<?php

    /**
     * Voci di navigazione del sito.
     *
     * Una sola sorgente di verità per nav desktop e nav mobile.
     * I `key` vengono usati per leggere le label da lang/{locale}/components.json
     * (chiave: components.navigation.{key}).
     *
     * STATUS: 2a — additivo. header.php non lo usa ancora.
     *
     * Convenzioni:
     * - `key`     : identificatore stabile, usato come chiave i18n.
     * - `url`     : risolto via __u(); '' = homepage.
     * - `external`: se true, l'href è usato as-is (no __u()) e si aggiunge target="_blank".
     * - `visible` : se 'private' la voce viene mostrata solo a utenti loggati;
     *               'public' solo a non loggati; assenza = sempre visibile.
     */

    return [

        [
            'key'     => 'home',
            'url'     => '',
        ],

        [
            'key'     => 'contact',
            'url'     => 'contact',
        ],

    ];
