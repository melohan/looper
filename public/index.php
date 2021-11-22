<?php

use Router\Router;

define('FOLDERROOT', '../');

require(realpath(FOLDERROOT . '/vendor/autoload.php'));

//Chemin views
define('VIEWS', FOLDERROOT . DIRECTORY_SEPARATOR . 'resources/views' . DIRECTORY_SEPARATOR);

//Chemin css/js
define('SCRIPTS', dirname($_SERVER['SCRIPT_NAME']) . DIRECTORY_SEPARATOR);

$router = new Router($_SERVER['REQUEST_URI']);

//Home
$router->get('/', 'App\Controllers\HomeController@index');

$router->post('/', 'App\Controllers\HomeController@index');

//Exercise
$router->get('/exercise/take', 'App\Controllers\exerciseController@take');
$router->get('/exercise/new', 'App\Controllers\exerciseController@index');
$router->get('/exercise/fulfillments/:id', 'App\Controllers\exerciseController@fulfillments');
$router->get('/exercise/manage', 'App\Controllers\exerciseController@manage');

$router->post('/exercise/create', 'App\Controllers\exerciseController@create');
$router->post('/exercise/fulfillments', 'App\Controllers\exerciseController@fulfillments');
$router->post('/exercise/update', 'App\Controllers\exerciseController@update');

//Questions
$router->get('/question/fields/:id', 'App\Controllers\questionController@fields');
$router->get('/question/edit/:id', 'App\Controllers\questionController@edit');

$router->post('/question/edit/:id', 'App\Controllers\questionController@edit');
$router->post('/question/create', 'App\Controllers\questionController@create');
$router->post('/question/delete/', 'App\Controllers\questionController@delete');
$router->post('/question/update', 'App\Controllers\questionController@update');


//error 404 manage server error
$router->get('/question/fields/', 'App\Controllers\questionController@fields');

// Answers
$router->get('/answer/answer', 'App\Controllers\answerController@answer');
$router->get('/answer/answerUser', 'App\Controllers\answerController@answerUser');
$router->get('/answer/result', 'App\Controllers\answerController@result');


//Etc
try {
    //
    $router->run();
} catch (Exception $e) {
    $router->get('/', 'App\Controllers\HomeController@index');
}
