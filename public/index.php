<?php
/**
 * This file contains all the routes defined by the application and launche pages.
 * @authors Mélodie Ohan, Samoutphonh Souphakone
 */

use Router\Router;

require_once $_SERVER["DOCUMENT_ROOT"] . '/../config/.env.php'; // Require const file
require_once PROJECT_ROOT . '/vendor/autoload.php';

$router = new Router($_SERVER['REQUEST_URI']);

// -------------------------- Home -------------------------- //
$router->get('/', 'App\Controllers\HomeController@index');
$router->post('/', 'App\Controllers\HomeController@index');

// -------------------------- Exercises -------------------------- //
$router->get('/exercise/take', 'App\Controllers\exerciseController@take');
$router->get('/exercise/new', 'App\Controllers\exerciseController@index');
$router->get('/exercise/fulfillments/:id', 'App\Controllers\exerciseController@fulfillments');
$router->get('/exercise/manage', 'App\Controllers\exerciseController@manage');
$router->post('/exercise/create', 'App\Controllers\exerciseController@create');
$router->post('/exercise/delete/', 'App\Controllers\exerciseController@delete');
$router->post('/exercise/update/', 'App\Controllers\exerciseController@update');

// -------------------------- Questions -------------------------- //
$router->get('/question/fields/:id', 'App\Controllers\questionController@fields');
$router->get('/question/edit/:id', 'App\Controllers\questionController@edit');
$router->post('/question/edit/:id', 'App\Controllers\questionController@edit');
$router->post('/question/create', 'App\Controllers\questionController@create');
$router->post('/question/delete/', 'App\Controllers\questionController@delete');
$router->post('/question/update/:id', 'App\Controllers\questionController@update');

// -------------------------- Answers -------------------------- //
$router->get('/answer/question/:id', 'App\Controllers\answerController@question');
$router->get('/answer/user/:userId/exercise/:exerciseId', 'App\Controllers\answerController@user');
$router->get('/answer/exercise/:id', 'App\Controllers\answerController@exercise');
$router->get('/answer/exercise/:exerciseId/edit/:userId', 'App\Controllers\answerController@edit');
$router->post('/answer/fulfillments/:exerciseId/', 'App\Controllers\answerController@new');
$router->post('/answer/exercise/:exerciseId/update/:userId', 'App\Controllers\answerController@update');

// -------------------------- Errors page (404 and 500)  -------------------------- //
$router->get('/page/error/:code', 'App\Controllers\HomeController@error');

// Execution
try {
    $router->run();
} catch (Exception $e) {
    header('Location: /page/error/500');
}
