<?php

    $NAV_BACKEND = [
        [
            'title' => 'Contatti',
            'folder' => 'form',
            'file' => 'list.php',
            'icon' => 'bi-postcard',
            'authority' => [],
            'subnavs' => []
        ],
        [
            'title' => 'Avvisi',
            'folder' => 'notices',
            'icon' => 'bi bi-bell',
            'authority' => [ 'admin' ],
            'subnavs' => [
                [
                    'title' => 'Annunci',
                    'folder' => 'notices/announcements',
                    'file' => 'list.php',
                    'authority' => []
                ],
                [
                    'title' => 'Popup',
                    'folder' => 'notices/popup',
                    'file' => 'list.php',
                    'authority' => []
                ]
            ]
        ]
    ];
