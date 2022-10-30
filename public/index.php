<?php

use \App\Router;
use \App\Application;
use \App\Http\Request;
use \App\Http\Response;

/**
 * @Author Joseph Abah
 * Entry point of the program
 *
 *
 */
require_once '../constants.php';


require_once '../vendor/autoload.php';


$router = Router::getInstance();

$app = Application::getInstance(
    $router,
    Request::getInstance(),
    new Response());

require_once '../routes/web.php'; // processing goes here

// inject some dependencies
$app->inject('company', new \App\Models\Company(getDbConnection()));


try {
    $app->mount();
} catch (\Exception $e) {
    die($e->getMessage()); // Here we can catch 404, 500 etc..
}

