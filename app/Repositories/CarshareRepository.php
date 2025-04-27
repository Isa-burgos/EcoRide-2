<?php

namespace App\Repositories;

use Config\DbConnect;
use App\Models\UserModel;
use App\Models\VehicleModel;
use App\Models\CarshareModel;
use App\Services\PreferenceService;

class CarshareRepository extends Repository{

    private string $table = 'carshare';

    public function __construct(DbConnect $db)
    {
        parent::__construct($db);
    }

    public function getCarshare(int $carshareId): ?CarshareModel
    {
        $sql = "SELECT *, (SELECT belong FROM vehicle WHERE vehicle_id = cs.used_vehicle) AS conducteur_id
                FROM {$this->table} cs
                WHERE carshare_id = :carshare_id";
        return $this->fetch($sql, ['carshare_id' => $carshareId], true, CarshareModel::class);
    }

    public function getAllCarshares(): array
    {
        $sql = "SELECT * FROM {$this->table}";
        return $this->fetch($sql, [], false, CarshareModel::class);


    }

    public function createCarshare(array $data): CarshareModel|false
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

        $lastId = $this->pdo->lastInsertId();
        return $this->getCarshare((int) $lastId);
    }

    public function getByDriver( int $userId): array
    {
        $sql = "SELECT cs.*, v.nb_place, v.energy_icon, v.brand
                FROM {$this->table} cs
                INNER JOIN user_carshare uc ON cs.carshare_id = uc.carshare_id
                INNER JOIN vehicle v ON cs.used_vehicle = v.vehicle_id
                WHERE uc.user_id = :user_id
                AND uc.role = 'conducteur'
                ORDER BY cs.depart_date DESC, cs.depart_time DESC
                ";

        return $this->fetch($sql,[
            'user_id' => $userId
            ],
            false,
            CarshareModel::class
        );
    }

    public function getByPassenger($userId): array
    {
        $sql = "SELECT cs.*, v.nb_place, v.energy_icon, v.brand
                FROM {$this->table} cs
                INNER JOIN user_carshare uc ON cs.carshare_id = uc.carshare_id
                INNER JOIN vehicle v ON cs.used_vehicle = v.vehicle_id
                WHERE uc.user_id = :user_id
                AND uc.role = 'passager'
                ORDER BY cs.depart_date DESC, cs.depart_time DESC
        ";

        return $this->fetch($sql, [
            'user_id' => $userId
            ],
            false,
            CarshareModel::class
        );
    }

    public function getCarshareDetails(int $carshareId): ?CarshareModel
    {
        $sql = "SELECT cs.*, v.brand, v.model, v.color, v.nb_place, v.energy, v.energy_icon, v.belong as user_id
                FROM carshare cs
                JOIN vehicle v ON cs.used_vehicle = v.vehicle_id
                WHERE cs.carshare_id = :carshare_id
        ";

        $trip = $this->fetch($sql, [
            'carshare_id' => $carshareId
            ],
            true,
            CarshareModel::class
        );

        if ($trip) {
            $vehicle = new VehicleModel();
            $vehicle->setBrand($trip->getBrand())
                    ->setModel($trip->getModel())
                    ->setColor($trip->getColor())
                    ->setNbPlace($trip->getNbPlace())
                    ->setEnergy($trip->getEnergy())
                    ->setEnergyIcon($trip->getEnergyIcon());
        
            $trip->setVehicle($vehicle);
        }
        
        return $trip;

    }

    public function updateStatut(int $carshareId, string $newStatut): bool
    {
        $sql = "UPDATE carshare SET statut = :statut WHERE carshare_id = :carshare_id";
        return $this->execute($sql, [
            ':carshare_id' => $carshareId,
            ':statut' => $newStatut
        ]);
    }

    public function getPassengers(int $carshareId): array
    {
        $sql = "SELECT u.*
                FROM user_carshare uc
                INNER JOIN user u ON uc.user_id = u.user_id
                WHERE uc.carshare_id = :carshare_id
                AND uc.role = 'passager'
        ";

        return $this->fetch($sql, [
            'carshare_id' => $carshareId
            ],
            false,
            UserModel::class
        );
    }

    public function updateCarshare(int $carshareId, array $data): bool
    {
        $sql = "UPDATE {$this->table}
                SET price_person = :price_person,
                    depart_adress = :depart_adress,
                    arrival_adress = :arrival_adress,
                    depart_time = :depart_time,
                    arrival_time = :arrival_time,
                    used_vehicle = :used_vehicle
                WHERE carshare_id = :carshare_id
                ";

                return $this->execute($sql, [
                    ':price_person' => $data['price_person'],
                    ':depart_adress' => $data['depart_adress'],
                    ':arrival_adress' => $data['arrival_adress'],
                    ':depart_time' => $data['depart_time'],
                    ':arrival_time' => $data['arrival_time'],
                    ':used_vehicle' => $data['used_vehicle'],
                    ':carshare_id' => $carshareId
                ]);
    }

    public function deleteCarshare(int $carshareId, int $userId): bool
    {
        $sql1 = "DELETE FROM user_carshare WHERE carshare_id = :carshare_id";
        $this->execute($sql1, [':carshare_id' => $carshareId]);

        $sql2 = "DELETE FROM {$this->table}
                WHERE carshare_id = :carshare_id AND used_vehicle IN (
                SELECT vehicle_id FROM vehicle WHERE belong = :user_id)" ;

        return $this->execute($sql2, [
            ':carshare_id' => $carshareId,
            ':user_id' => $userId
        ]);
    }

    public function searchCarshares(string $depart, string $arrival, string $date, int $passenger): array
    {
        $sql = "SELECT cs.*,
                        v.nb_place, v.brand, v.model, v.color, v.energy, v.vehicle_id, v.belong AS driver_id
                FROM {$this->table} cs
                JOIN vehicle v ON cs.used_vehicle = v.vehicle_id
                WHERE cs.depart_adress LIKE CONCAT('%',:depart, '%')
                AND cs.arrival_adress LIKE CONCAT('%',:arrival, '%')
                AND cs.depart_date = :date
                AND cs.statut = 'créé'
                AND v.nb_place >= :passenger
                ";

        $data = $this->fetch($sql, [
            ':depart' => '%' . $depart . '%',
            ':arrival' => '%' . $arrival . '%',
            ':date' => $date,
            ':passenger' => $passenger
        ]);

        $carshares = [];

        $userRepo = new UserRepository($this->db);

        foreach ($data as $row) {
            $carshare = new \App\Models\CarshareModel();
            $carshare->hydrate($row);


            if (isset($row['driver_id'])) {
                $driver = $userRepo->getById($row['driver_id']);
                if ($driver) {
                    $carshare->setDriver($driver);
                }
            }

            $carshares[] = $carshare;
        }

        return $carshares;
    }
}