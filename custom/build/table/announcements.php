<?php

    # Annunci
        $TABLE->ANNOUNCEMENTS = [
            "position" => [
                "sql" => [
                    "type" => 'INT'
                ]
            ],
            "slug" => [
                "input" => [
                    "format" => [
                        "sanitize" => false,
                        "link_unique" => true,
                        "lower" => true
                    ]
                ]
            ],
            "name" => [],
            "text" => [],
            "visible" => []
        ];
