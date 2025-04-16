<?php

    $TABLE->FORM = [
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
        "privacy" => []
    ];