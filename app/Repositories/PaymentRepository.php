<?php

namespace App\Repositories;

use App\Models\PaymentModel;

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

    public function getCreditsPerDay(): array
    {
        $sql = "SELECT DATE(created_at) as date, SUM(amount) as total
                FROM {$this->table}
                WHERE type = 'commission'
                GROUP BY DATE(created_at)
                ORDER BY DATE(created_at) ASC"
                ;

        return $this->fetch($sql);
    }

}