<?php

namespace App\Repositories;

use PDO;
use Config\DbConnect;

abstract class Repository{

    protected PDO $pdo;

    protected function __construct(DbConnect $db)
    {
        $this->pdo = $db->getPDO();
    }

    protected function getPDO(): PDO
    {
        return $this->pdo;
    }

    protected function execute(string $sql, array $params = []): bool
    {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    protected function fetch(string $sql, array $params = [], bool $fetchOne = false): array|null
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $fetchOne ? $stmt->fetch(PDO::FETCH_ASSOC) : $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}