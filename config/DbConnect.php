<?php

namespace Config;

use PDO;

class DbConnect{

    private $dbHost;
    private $dbName;
    private $dbUser;
    private $dbPassword;
    private $pdo;

    public function __construct(string $dbHost, string $dbName, string $dbUser, string $dbPassword )
    {
        $this->dbHost = getenv($dbHost) ?: $dbHost;
        $this->dbName = getenv($dbName);
        $this->dbUser = getenv($dbUser);
        $this->dbPassword = getenv($dbPassword);
    }
    
    public function getPDO(): PDO
    {
        return $this->pdo ?? $this->pdo = new PDO("mysql:host={$this->dbHost};dbname={$this->dbName}", $this->dbUser, $this->dbPassword,[
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'UTF8'"
        ]);
    }
}