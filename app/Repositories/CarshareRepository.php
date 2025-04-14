<?php

namespace App\Repositories;

use App\Models\CarshareModel;
use Config\DbConnect;

class CarshareRepository extends Repository{

    private string $table = 'carshare';

    public function __construct(DbConnect $db)
    {
        parent::__construct($db);
    }

    public function getCarshare(int $carshareId): ?CarshareModel
    {
        $sql = "SELECT * FROM {$this->table} WHERE carshare_id = :carshare_id";
        $data = $this->fetch($sql, ['carshare_id' => $carshareId]);

        if(!$data){
            return null;
        }

        $carshare = new CarshareModel();
        return $carshare->hydrate($data);
    }

    public function createCarshare(array $data): int|false
    {
        $sql = "INSERT INTO {$this->table}
                (price_person, depart_adress, arrival_adress, depart_date, depart_time, arrival_time, statut, used_vehicle)
                VALUES
                (:price_person, :depart_adress, :arrival_adress, :depart_date, :depart_time, :arrival_time, :statut, :used_vehicle)
                ";
        $this->execute($sql, [
            ':price_person' => (int) $data['price_person'],
            ':depart_adress' => $data['depart_adress'],
            ':arrival_adress' => $data['arrival_adress'],
            ':depart_date' => $data['depart_date'],
            ':depart_time' => $data['depart_time'],
            ':arrival_time' => $data['arrival_time'],
            ':statut' => $data['statut'],
            ':used_vehicle' => $data['used_vehicle']
        ]);
        return $this->pdo->lastInsertId();
    }


}