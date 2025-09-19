<?php

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