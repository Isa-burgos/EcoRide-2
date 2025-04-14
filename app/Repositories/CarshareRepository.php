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

    public function getByDriver( int $userId): array
    {
        $sql = "SELECT cs.*, v.nb_place, v.energy_icon, v.brand
                FROM {$this->table} cs
                JOIN vehicle v ON cs.used_vehicle = v.vehicle_id
                WHERE v.belong = :user_id
                ORDER BY cs.depart_date DESC, cs.depart_time DESC
        ";

        return $this->fetch($sql,[
            'user_id' => $userId
        ]);
    }

    public function getByPassenger($userId): array
    {
        $sql = "SELECT cs.*
                FROM {$this->table} cs
                JOIN user_carshare uc ON uc.carshare_id = cs.carshare_id
                WHERE uc.user_id = :user_id
                ORDER BY cs.depart_date DESC, cs.depart_time DESC
        ";

        return $this->fetch($sql, [
            'user_id' => $userId
        ]);
    }


}