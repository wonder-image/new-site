<?php

    $TEXT = (object) [];
    $TEXT->titleS = "annuncio";
    $TEXT->titleP = "annunci";
    $TEXT->last = 'ultimi'; // $TEXT->last 50 $TEXT->titleP
    $TEXT->all = 'tutti'; // Lista $TEXT->all $TEXT->article $titlePageP
    $TEXT->article = 'gli'; // Lista $TEXT->all $TEXT->article $titlePageP
    $TEXT->full = 'usato'; // $TEXT->titleS $TEXT->full
    $TEXT->empty = 'non usato'; // $TEXT->titleS $TEXT->empty
    $TEXT->this = 'questa'; // Sei sicuro di voler eliminare $TEXT->this $TEXT->titleS

    $NAME = (object) [];
    $NAME->table = "announcements";
    $NAME->folder = "announcements";

    $PAGE_TABLE = $TABLE->ANNOUNCEMENTS;

    $QUERY_CUSTOM = "";

    $FILTER_TYPE = 'limit';

    $BUTTON_ADD = true;

    $FILTER_CUSTOM = [
        "visible" => [
            'database' => false,
            'column' => 'visible',
            'name' => 'Stato',
            'search' => false,
            'type' => 'radio'
        ]
    ];

    $TABLE_ACTION = [
        'modify' => true,
        'visible' => true,
        'delete' => true
    ];

    $TABLE_FIELD = [
        "name" => [
            "label" => "Annuncio",
            "href" => "modify"
        ],
        "visible" => [
            "function" => [
                "name" => "visible",
                "return" => "automaticResize"
            ]
        ]
    ];

    $FILTER_SEARCH = [ 'name', 'text'];