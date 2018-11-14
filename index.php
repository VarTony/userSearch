<?php

namespace App;

require './vendor/autoload.php';

use function Stringy\create as s;

$users = Generator::generate(100);

$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];

$app = new \Slim\App($configuration);

$container = $app->getContainer();
$container['renderer'] = new \Slim\Views\PhpRenderer(__DIR__ . '/templates');

$app->get('/', function ($request, $response) {
    return $this->renderer->render($response, 'index.phtml');
});

// BEGIN

$app->get('/users', function($req, $res) use($users) {
    
    $term = $req->getQueryParam('term', "");
    $paramse = $req->getQueryParams(); 
    

    $searched = ["id" => "Native", "firstName" => htmlspecialchars($term), "lastName" => "NaN", "email" => "void@mail.org"];
    foreach($users as $user) {
        if(strtolower($user['firstName'])  == strtolower($term)) {
            $searched = $user;
            break;
    }
}

    $params = ['term'  => $term,
               'users' => $users,
               'user'  => $searched,
               'paramse' => $paramse
    ];

    return $this->renderer->render($res, '/users/index.phtml', $params);

});

// END

$app->run();