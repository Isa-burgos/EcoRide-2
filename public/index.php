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

date_default_timezone_set('Europe/Paris');

if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
}

$uri = explode('?', $_SERVER['REQUEST_URI'])[0];
$uri = rtrim($uri, '/'); // supprime slash final s’il existe
$router = new Router($uri);

$router->get('/', 'App\Controllers\AppController@home');
$router->get('/dashboard', 'App\Controllers\AppController@dashboard', 'tableau de bord');
$router->get('/contact', 'App\Controllers\AppController@contact', 'page contact');
$router->get('/mentions-legales', 'App\Controllers\AppController@mentionsLegales', 'page mentions légales');

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
$router->post('/carshare/create', 'App\Controllers\CarshareController@store', 'proposer un trajet');
$router->get('/carshare/search', 'App\Controllers\CarshareController@search', 'chercher un covoiturage');
$router->get('/carshare/results', 'App\Controllers\CarshareController@results', 'afficher les trajets');
$router->get('/carshare/:id', 'App\Controllers\CarshareController@show', 'voir le trajet');
$router->post('/carshare/:id/start', 'App\Controllers\CarshareController@start', 'démarrer un trajet');
$router->post('/carshare/:id/end', 'App\Controllers\CarshareController@end', 'terminer un trajet');
$router->post('/carshare/:id/cancel', 'App\Controllers\CarshareController@cancel', 'annuler un trajet');
$router->get('/carshare/:id/edit', 'App\Controllers\CarshareController@edit', 'éditer un trajet');
$router->post('/carshare/:id/update', 'App\Controllers\CarshareController@update', 'mettre à jour un trajet');
$router->post('/carshare/:id/delete', 'App\Controllers\CarshareController@delete', 'supprimer un trajet');
$router->get('/carshare/:id/details', 'App\Controllers\CarshareController@details', 'détails d\'un trajet');


$router->get('/history', 'App\Controllers\HistoryController@index', 'historique');

$router->post('/carshare/:id/reserve', 'App\Controllers\ReservationController@reserve', 'réservation d\'un trajet');

$router->get('/admin/dashboard', 'App\Controllers\AdminController@dashboard', 'tableau de bord admin');
$router->get('/admin/employes', 'App\Controllers\AdminController@indexEmployes', 'gestion des employés');
$router->get('/admin/employes/:id/edit', 'App\Controllers\AdminController@edit', 'modifier des employés');
$router->post('/admin/employes', 'App\Controllers\AdminController@store', 'création des employés');
$router->post('/admin/employes/:id/update', 'App\Controllers\AdminController@update', 'Mise à jour des informations des employés');
$router->post('/admin/employes/:id/suspend', 'App\Controllers\AdminController@suspend', 'suspension d\'un employé');
$router->post('/admin/employes/:id/reactivate', 'App\Controllers\AdminController@reactivate', 'réactivation d\'un employé');
$router->post('/admin/employes/:id/delete', 'App\Controllers\AdminController@deleteEmploye', 'supprimer des employés');
$router->get('/admin/users', 'App\Controllers\AdminController@indexUsers', 'gestion des utilisateurs');
$router->post('/admin/users/:id/suspend', 'App\Controllers\AdminController@suspend', 'suspendre un utilisateur');
$router->post('/admin/users/:id/reactivate', 'App\Controllers\AdminController@reactivate', 'réactiver un utilisateur');
$router->post('/admin/users/:id/delete', 'App\Controllers\AdminController@deleteUser', 'supprimer un utilisateur');


$router->run();


