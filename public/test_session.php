<?php
require_once __DIR__ . '/../config/session.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

$_SESSION['user'] = ['email' => 'test@test.fr', 'id' => 1];
var_dump($_SESSION);

exit();
?>
