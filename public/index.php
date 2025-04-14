<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/helper.php';


use Dotenv\Dotenv;
use Router\Router;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

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

$router->get('/carshare/create', 'App\Controllers\CarshareController@create', 'proposer un trajet');
$router->post('carshare/create', 'App\Controllers\CarshareController@store', 'proposer un trajet');
$router->get('/history', 'App\Controllers\HistoryController@index', 'historique');


$router->get('/posts/:id', 'App\Controllers\AppController@show');



$router->run();


