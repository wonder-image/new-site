<?php

    error_reporting(0);
    ini_set('display_errors', 0);

    header("Access-Control-Allow-Origin: *");
    header("Accept: application/json");
    header("Content-Type: application/json; charset=utf-8");

    $ROOT = str_replace('/api', "", __DIR__);
    require_once $ROOT."/vendor/wonder-image/app/wonder-image.php";