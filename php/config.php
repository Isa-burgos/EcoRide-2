<?php

$dbHost = 'DB_HOST';
$dbName = 'DB_DATABASE';
$dbUser = 'DB_USER';
$dbPassword = 'DB_PASSWORD';

$dsn = "mysql:host={$dbHost};port=3306;dbname={$dbName}";
try {
    $pdo = new PDO($dsn, $dbUser, $dbPassword);
    echo "connecté";
} catch (PDOException $e) {
    echo "Connexion échouée : " . $e->getMessage();
}
