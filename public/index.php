<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/../vendor/autoload.php';

$uri = $_SERVER['REQUEST_URI'];
$router = new AltoRouter();

require_once __DIR__ . '/../config/routes.php';

$match = $router->match();
if(is_array($match)){
    if (is_callable($match['target'])){
        call_user_func_array($match['target'], $match['params']);
    } else{
        $params = $match['params'];
        ob_start();
        require_once __DIR__ . '/../templates/' . $match['target'] . '.php';
        $pageContent = ob_get_clean();
    }
    require_once __DIR__ . '/../elements/layout.php';
} else{
    echo '404';
}