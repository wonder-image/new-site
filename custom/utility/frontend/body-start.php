<?php
    /**
     * Body-start del frontend del progetto.
     *
     * Renderizza il popup di pagina (se configurato in tabella `popup`).
     * La logica SQL+HTML inline è stata estratta in
     * custom/components/functional/popup.php in fase 2b.
     *
     * Variabili attese in scope:
     * - $PAGE_KEY : chiave pagina (es. 'home'). Se assente o null, niente popup.
     */

    $PAGE_KEY ??= null;

    require_once $_SERVER['DOCUMENT_ROOT'].'/custom/components/functional/popup.php';
    renderPopup($PAGE_KEY);
