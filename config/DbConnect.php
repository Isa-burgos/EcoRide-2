<?php

namespace Config;

use PDO;

class DbConnect{
    
    private ?PDO $pdo = null;

    public function getPDO(): PDO
    {

        if(!isset($this->pdo)){
            $host = $_ENV['DB_HOST'];
            $db = $_ENV['DB_DATABASE'];
            $user = $_ENV['DB_USER'];
            $pass = $_ENV['DB_PASSWORD'];

            $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

            $this->pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
            ]);
        }

        return $this->pdo;
    }
}