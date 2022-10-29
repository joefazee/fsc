<?php

$router->get('/', function ($req, $res) {

    $variables = ['errors' => [], 'name' => '', 'address' => ''];
    $res->render('index', $variables);
});


$router->post('/', function ($req, $res) {

    $name = $req->input('name');
    $address = $req->input('address');

    $errors = [];
    if (!$name || strlen($name) > 255) {
        $errors['name'] = 'company name must not be blank and must not greater than 255';
    }

    if (!$address || strlen($address) > 255) {
        $errors['address'] = 'company address must not be blank and must not greater than 255';
    }

    if ($errors) {
        $variables = ['errors' => $errors, 'name' => $name, 'address' => $address];
        $res->render('index', $variables);
    }

    // store data
});
