<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

file_put_contents('/tmp/last_url.txt', print_r($_SERVER, true), FILE_APPEND);


require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/helper.php';

use Router\Router;

file_put_contents('/tmp/before_run.txt', "avant run\n", FILE_APPEND);

$uri = explode('?', $_SERVER['REQUEST_URI'])[0];
$uri = rtrim($uri, '/'); // supprime slash final s’il existe
$router = new Router($uri);

$router->get('/', 'App\Controllers\AppController@home');
$router->get('/dashboard', 'App\Controllers\AppController@dashboard', 'tableau de bord');

$router->get('/login', 'App\Controllers\UserController@login', 'connexion');
$router->post('/login', 'App\Controllers\UserController@loginPost', 'connexion');
$router->get('/logout', 'App\Controllers\UserController@logout', 'déconnexion');
$router->get('/register', 'App\Controllers\UserController@register', 'créer un compte');
$router->post('/register', 'App\Controllers\UserController@registerPost', 'créer un compte');
$router->get('/account', 'App\Controllers\AccountController@show', 'mon compte');
$router->post('/update-account', 'App\Controllers\AccountController@update', 'mon compte');

$router->post('/vehicle/create', 'App\Controllers\VehicleController@store');

$router->get('/vehicle/:id/edit', 'App\Controllers\VehicleController@edit');
$router->post('/vehicle/:id/update', 'App\Controllers\VehicleController@update');

$router->post('/vehicle/:id/delete', 'App\Controllers\VehicleController@delete');

$router->get('/posts/:id', 'App\Controllers\AppController@show');

$router->post('/test-update', 'App\Controllers\AccountController@testUpdate');


$router->run();
file_put_contents('/tmp/after_run.txt', "après run\n", FILE_APPEND);


