<?php

    # Form
        $TABLE->FORM = [
            "code" => [],
            "name" => [
                "input" => [
                    "format" => [
                        "sanitize" => false,
                        "sanitizeFirst" => true
                    ]
                ]
            ],
            "surname" => [
                "input" => [
                    "format" => [
                        "sanitize" => false,
                        "sanitizeFirst" => true
                    ]
                ]
            ],
            "phone" => [],
            "email" => [
                "input" => [
                    "format" => [
                        "lower" => true
                    ]
                ]
            ],
            "request" => [
                "sql" => [ 
                    "length" => 10000 
                ]
            ],
            "request_url" => [
                "sql" => [ 
                    "length" => 10000 
                ]
            ],
            "file" => [
                "input" => [ 
                    "format" => [
                        "file" => true,
                        "dir" => "/form/files/",
                        "max_file" => null,
                        "max_size" => null,
                        "extensions" => null
                    ]
                ]
            ],
            "privacy" => []
        ];

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
