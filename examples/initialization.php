<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/../vendor/autoload.php";

$clientRequestResource = new \AssurConnect\Api\Resources\Request\Auth\ClientResource(
    '6fa3aac2-faee-4d3f-8ab2-0c696ce4838e',
    'sand_c23217a3-9825-4d21-94e8-a4b5962267c8',
    'TEST',
    'e4612cef-362e-4e52-951a-ae3d2c17939c',
);

$api = new \AssurConnect\Api\AssurConnectApi();
$api->useSandbox();

$token = $api->authToken->call($clientRequestResource);
$api->setToken($token);
