<?php

    $TEXT = (object) array();
    $TEXT->titleS = "richiesta";
    $TEXT->titleP = "richieste";
    $TEXT->last = 'ultime'; // $TEXT->last 50 $TEXT->titleP
    $TEXT->all = 'tutte'; // Lista $TEXT->all $TEXT->article $titlePageP
    $TEXT->article = 'le'; // Lista $TEXT->all $TEXT->article $titlePageP
    $TEXT->full = 'usata'; // $TEXT->titleS $TEXT->full
    $TEXT->empty = 'non usata'; // $TEXT->titleS $TEXT->empty
    $TEXT->this = 'questa'; // Sei sicuro di voler eliminare $TEXT->this $TEXT->titleS

    $NAME = (object) array();
    $NAME->table = "form";
    $NAME->folder = "form";

    $BUTTON_ADD = false;

    $BUTTON_CUSTOM = [
        [
            "value" => "<i class='bi bi-filetype-csv'></i> Scarica .csv",
            "action" => "href='$PATH->backend/form/download.php?file=csv'"
        ],
        [
            "value" => "<i class='bi bi-filetype-xls'></i> Scarica .xls",
            "action" => "href='$PATH->backend/form/download.php?file=xls'"
        ]
    ];

    $FILTER_TYPE = 'date';

    $PAGE_TABLE = $TABLE->FORM;

    $TABLE_ACTION = [ 
        'view' => true,
        'delete' => true
    ];

    $TABLE_FIELD = [
        "name" => [
            "label" => "Nome",
            "value" => ['name', 'surname'],
            "href" => "view"
        ],
        "phone" => [
            "label" => "Telefono",
            "href" => "tel",
            "tablet" => false
        ],
        "email" => [
            "label" => "Email",
            "href" => "mailto",
            "tablet" => false
        ]
    ];

    $FILTER_SEARCH = ['name', 'phone', 'email'];

?>