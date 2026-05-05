<?php
    /**
     * Footer del sito (orchestratore).
     *
     * Delega a tre componenti puri introdotti in fase 2a:
     * - components/sections/contact-form.php   (form contatti, opzionale)
     * - components/layout/site-footer.php       (logo, indirizzo, contatti, legal-bar)
     *
     * Variabili in scope (set dalla pagina, tutte opzionali):
     * - $FOOTER_CONTACT          : bool. Default true. Mostra/nasconde la sezione form.
     * - $FOOTER_CONTACT_MAP      : bool. Default true. Mostra/nasconde Google Maps a sinistra del form.
     * - $FOOTER_CONTACT_TITLE    : string. Override titolo del form (default: i18n).
     * - $FOOTER_CONTACT_SUBTITLE : string. Override sottotitolo del form (default: i18n).
     */

    $showContactForm = $FOOTER_CONTACT ?? true;

    if ($showContactForm) {
        $args = [
            'showMap'  => $FOOTER_CONTACT_MAP      ?? true,
            'title'    => $FOOTER_CONTACT_TITLE    ?? null,
            'subtitle' => $FOOTER_CONTACT_SUBTITLE ?? null,
        ];
        include __DIR__.'/../../components/sections/contact-form.php';
    }

    include __DIR__.'/../../components/layout/site-footer.php';
