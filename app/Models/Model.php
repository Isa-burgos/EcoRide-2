<?php

namespace App\Models;

use PDO;
use Database\DbConnect;

abstract class Model{

    protected $db;

    public function __construct(DbConnect $db)
    {
        $this->db = $db;
    }

    public function getPDO(): \PDO
    {
        return $this->db->getPDO();
    }

    protected function hydrate(array $data): self
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
        return $this;
    }

    public function query(string $sql, array $params = []): ?self
    {
        $stmt = $this->getPDO()->prepare($sql);
        foreach($params as $key => $value){
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if($data){
            return $this->hydrate($data);
        }
        return null;
    }

    
}