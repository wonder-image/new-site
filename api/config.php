<?php

    error_reporting(0);
    ini_set('display_errors', 0);

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    header("Content-Type: application/json; charset=utf-8");

    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        
        http_response_code(200);
        exit(0);
        
    }

    $ROOT = str_replace('/api', "", __DIR__);
    require_once $ROOT."/vendor/wonder-image/app/wonder-image.php";