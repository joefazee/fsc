<?php

/**
 * @Author Joseph Abah
 * Entry point of the program
 *
 *
 */
require_once '../constants.php';


require_once '../vendor/autoload.php';


$router = \App\Router::getInstance();

$app = \App\Application::getInstance($router, \App\Http\Request::getInstance(), new \App\Http\Response());

require_once '../routes/web.php'; // processing goes here

try {
    $app->mount();
} catch (\Exception $e) {
    die($e->getMessage()); // Here we can catch 404, 500 etc..
}

