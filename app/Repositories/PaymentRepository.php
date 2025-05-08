<?php

namespace App\Repositories;

class PaymentRepository extends Repository{

    private string $table = 'payment';

    public function __construct($db)
    {
        parent::__construct($db);
    }

    public function log(int $userId, int $carshareId, float $amount, string $type): void
    {
        $sql = "INSERT INTO {$this->table}
                (amount, type, created_at, user_id, carshare_id)
                VALUES
                (:amount, :type, NOW(), :user_id, :carshare_id)
                ";
        
        $this->execute($sql,[
            'amount' => $amount,
            'type' => $type,
            'user_id' => $userId,
            'carshare_id' => $carshareId
        ]);
    }

}