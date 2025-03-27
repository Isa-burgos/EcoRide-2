<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/helper.php';

use Router\Router;

$router = new Router($_SERVER['REQUEST_URI'] ?? '');

$router->get('/', 'App\Controllers\AppController@home');
$router->get('/dashboard', 'App\Controllers\AppController@dashboard', 'tableau de bord');

$router->get('/login', 'App\Controllers\UserController@login', 'connexion');
$router->post('/login', 'App\Controllers\UserController@loginPost', 'connexion');
$router->get('/logout', 'App\Controllers\UserController@logout', 'déconnexion');
$router->get('/register', 'App\Controllers\UserController@register', 'créer un compte');
$router->post('/register', 'App\Controllers\UserController@registerPost', 'créer un compte');
$router->get('/account', 'App\Controllers\AccountController@show', 'mon compte');
$router->post('/update-account', 'App\Controllers\AccountController@update', 'mon compte');
$router->post('/debug-form', 'App\Controllers\AccountController@debugForm');


$router->get('/vehicle/:id/edit', 'App\Controllers\VehicleController@edit');
$router->post('/vehicle/:id/update', 'App\Controllers\VehicleController@update');

$router->post('/vehicle/:id/delete', 'App\Controllers\VehicleController@delete');

$router->get('/posts/:id', 'App\Controllers\AppController@show');

$router->post('/test-update', 'App\Controllers\AccountController@testUpdate');


$router->run();

file_put_contents(__DIR__ . '/../debug.log', date('Y-m-d H:i:s') . " - passage dans index\n", FILE_APPEND);
