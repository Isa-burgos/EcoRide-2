<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/config.php';

use Router\Router;

$router = new Router($_SERVER['REQUEST_URI'] ?? '');

$router->get('/', 'App\Controllers\AppController@home');
$router->get('/dashboard', 'App\Controllers\AppController@dashboard', 'tableau de bord');

$router->get('/login', 'App\Controllers\UserController@login', 'connexion');
$router->post('/login', 'App\Controllers\UserController@loginPost', 'connexion');
$router->get('/logout', 'App\Controllers\UserController@logout', 'déconnexion');
$router->get('/register', 'App\Controllers\UserController@register', 'créer un compte');
$router->post('/register', 'App\Controllers\UserController@registerPost', 'créer un compte');

$router->get('/posts/:id', 'App\Controllers\AppController@show');

$router->run();