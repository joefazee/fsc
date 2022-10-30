<?php

$router->get('/', function ($req, $res, $resolver) {

    $company = $resolver['company'];
    $variables = ['errors' => [], 'name' => '', 'address' => '', 'companies' => $company->getAll()];
    $res->render('index', $variables);
});


/**
 * /GET Employees endpoint
 */
$router->get('/employees/{companyId}', function ($req, $res, $resolver) {

    $company = $resolver['company'];

    $companyInfo = $company->find($req->companyId);
    if (!$companyInfo) {
        $res->redirect('/?notfound=true');
    }

    $employees = $company->employees($companyInfo['id']);

    $variables = [
        'companyInfo' => $companyInfo,
        'employees' => $employees,
        'errors' => [],
        'phone' => '',
        'email' => '',
        'name' => ''
    ];

    $res->render('employees', $variables);
});


$router->post('/employees/{companyId}', function ($req, $res, $resolver) {

    $company = $resolver['company'];
    $companyInfo = $company->find($req->companyId); // We want to make sure user does not change the ID to an invalid ID
    if (!$companyInfo) {
        $res->redirect('/?notfound=true');
    }
    $employees = $company->employees($companyInfo['id']);

    $errors = [];

    $name = $req->input('name');
    $email = $req->input('email');
    $phone = $req->input('phone');

    if (!$name || strlen($name) > 255) {
        $errors['name'] = 'name is not valid! must not be blank and not greater than 255';
    }

    if ($phone === '' || !is_numeric($phone)) {
        $errors['phone'] = 'only numeric values are allowed for phone';
    }

    if ($email === '' || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $errors['email'] = 'please enter a valid email address';
    }

    if ($errors) {

        $variables = [
            'companyInfo' => $companyInfo,
            'employees' => $employees,
            'errors' => $errors,
            'phone' => $phone,
            'email' => $email,
            'name' => $name
        ];

        $res->render('employees', $variables);
        return;
    }

    $company->addEmployee($name, $phone, $email, $companyInfo['id']);

    $res->redirect('/employees/' . $companyInfo['id']);

});


/**
 *  /POST - Handle posting of a company
 */
$router->post('/', function ($req, $res, $resolver) {

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

        $variables = ['errors' => $errors, 'name' => $name, 'address' => $address, 'companies' => $resolver['company']->getAll()];
        $res->render('index', $variables);
        return;
    }

    $resolver['company']->insert($name, $address);


    $res->redirect('/');
});
