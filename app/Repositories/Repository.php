<?php

namespace App\Repositories;

use PDO;
use Config\DbConnect;

abstract class Repository{

    protected PDO $pdo;
    protected DbConnect $db;

    protected function __construct(DbConnect $db)
    {
        $this->pdo = $db->getPDO();
        $this->db = $db;
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

    protected function fetch(string $sql, array $params = [], bool $fetchOne = false, ?string $modelClass =null): mixed
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        $data = $fetchOne ? $stmt->fetch(PDO::FETCH_ASSOC) : $stmt->fetchAll(PDO::FETCH_ASSOC);

        if($modelClass && class_exists($modelClass)){
            if($fetchOne){
                if(!$data) return null;
                return (new $modelClass())->hydrate($data);
            }

            $objects = [];
            foreach($data as $item){
                $objects[] = (new $modelClass())->hydrate($item);
            }
            return $objects;
        }
        return $data;
    }

}