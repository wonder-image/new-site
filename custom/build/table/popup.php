<?php

    # Popup
        $TABLE->POPUP = [
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
            "title" => [],
            "url" => [],
            "url_label" => [],
            "pages" => [
                "sql" => [
                    "type" => 'JSON'
                ]
            ],
            "view" => [],
            "images" => [
                "sql" => [
                    "type" => 'JSON'
                ],
                "input" => [
                    "format" => [
                        "sanitize" => false,
                        "file" => true,
                        "reset" => true,
                        "extensions" => [ 'png', 'jpg', 'jpeg' ],
                        "max_size" => 2,
                        "max_file" => 1,
                        "dir" => '/images/',
                        "resize" => [
                            [
                                "width" => 120,
                                "height" => 120
                            ],
                            [
                                "width" => 480,
                                "height" => 480
                            ],
                            [
                                "width" => 620,
                                "height" => 620
                            ],
                            [
                                "width" => 960,
                                "height" => 960
                            ],
                            [
                                "width" => 1080,
                                "height" => 1080
                            ],
                            [
                                "width" => 1440,
                                "height" => 1440
                            ],
                            [
                                "width" => 1920,
                                "height" => 1920
                            ]
                        ]
                    ]
                ]
            ],
            "visible" => []
        ];
