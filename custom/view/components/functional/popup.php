<?php

    /**
     * Renderer del popup associato a una pagina.
     *
     * Estrae la logica popup oggi in custom/utility/frontend/body-start.php in una
     * funzione dedicata, riusabile e testabile.
     *
     * Funzionamento:
     * 1. Cerca in tabella `popup` un record visibile, non eliminato, associato alla pagina.
     * 2. Limita le visualizzazioni in base a $_SESSION (nessuno se view==0 o vuoto).
     * 3. Renderizza un wi-modal con immagine + titolo + eventuale CTA.
     *
     * STATUS: 2a — additivo. Non ancora invocato da body-start.php.
     *
     * @param string|null $pageKey Chiave pagina (es. 'home'). Se null, non fa nulla.
     */
    function renderPopup(?string $pageKey): void
    {
        if ($pageKey === null) {
            return;
        }

        $query = sqlSelect(
            'popup',
            "pages LIKE '%\"$pageKey\"%' AND visible = 'true' AND deleted = 'false'",
            1,
            'position',
            'ASC',
            'id, view'
        );

        if (!$query->exists) {
            return;
        }

        $sessionKey = "popup_$query->id";
        $_SESSION[$sessionKey] = $_SESSION[$sessionKey] ?? 0;

        $maxView = $query->row['view'];
        if ($maxView !== '' && $_SESSION[$sessionKey] >= (int) $maxView) {
            return;
        }

        $_SESSION[$sessionKey]++;

        $popup = info('popup', 'id', $query->id);

        $images    = json_decode($popup->images, true) ?: [];
        $imageHtml = empty($images)
            ? ''
            : "<img src=\"{$images[0]}\" alt=\"$popup->title\" class=\"p-r f-start w-100\">";

        $urlLabel = empty($popup->url_label) ? 'Scopri di più' : $popup->url_label;
        $urlHtml  = empty($popup->url) ? '' : "
            <div class=\"wi-modal-footer b-0\">
                <div class=\"btn-group j-content-end\">
                    <a class=\"btn btn-primary btn-arrow wi-close-modal\" href=\"$popup->url\">
                        $urlLabel <i class=\"bi bi-chevron-right\"></i>
                    </a>
                </div>
            </div>";

        echo "<section id=\"popup\" class=\"wi-modal no-interaction\">

            <div class=\"bg wi-close-modal\"></div>

            <div class=\"content wi-modal-content\">
                <div class=\"wi-modal-header b-0\">
                    <div class=\"wi-modal-title subtitle\"> $popup->title </div>
                    <div class=\"wi-modal-close wi-close-modal\"> <i class=\"bi bi-x-lg\"></i> </div>
                </div>
                <div class=\"wi-modal-body no-scrollbar\">
                    $imageHtml
                </div>
                $urlHtml
            </div>

        </section>
        <script> window.addEventListener('load', (event) => { modal('#popup'); }) </script>";
    }
