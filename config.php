<?php

$dbHost = getenv('DB_HOST');
$dbName = getenv('DB_DATABASE');
$dbUser = getenv('DB_USER');
$dbPassword = getenv('DB_PASSWORD');

$dsn = "mysql:host={$dbHost};port=3306;dbname={$dbName}";
try {
    $pdo = new PDO($dsn, $dbUser, $dbPassword, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    echo "connecté";
} catch (PDOException $e) {
    echo "Connexion échouée : " . $e->getMessage();
}
