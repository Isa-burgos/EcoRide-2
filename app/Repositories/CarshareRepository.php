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

    public function getRidesPerDay(): array
    {
        $sql = "SELECT depart_date as date, COUNT(*) as count
                FROM {$this->table}
                GROUP BY depart_date
                ORDER BY depart_date ASC
                ";

                return $this->fetch($sql);
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
        $sql = "SELECT cs.*, v.nb_place, v.energy_icon, v.brand, v.belong AS user_id
                FROM {$this->table} cs
                INNER JOIN reservations r ON cs.carshare_id = r.carshare_id
                INNER JOIN vehicle v ON cs.used_vehicle = v.vehicle_id
                WHERE r.user_id = :user_id
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

            $reservationRepo = new ReservationRepository($this->db);
            $reserved = $reservationRepo->countReservedSeats($trip->getCarshareId());
            $available = max(0, $trip->getNbPlace() - $reserved);
            $trip->setAvailablePlaces($available);


            $userRepo = new UserRepository($this->db);
            $driver = $userRepo->getById($trip->getUserId());

            if ($driver){
                $trip->setDriver($driver);
            }

            $prefService = new PreferenceService();
            $preferences = $prefService->getPreferencesByVehicle($trip->getUsedVehicle());

            $trip->smoking_icon = $preferences['smoking_icon'] ?? 'non_fumeur';
            $trip->pets_icon = $preferences['pets_icon'] ?? 'no';
            $trip->custom_preferences = $preferences['custom'] ?? '';
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
                FROM reservations r
                JOIN user u ON u.user_id = r.user_id
                WHERE r.carshare_id = :carshare_id
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

    public function searchCarshares(string $depart, string $arrival, string $date, int $passenger, ?array $time = [], ?array $services = [], ?string $sort = null): array
    {
        $sql = "SELECT cs.*,
                        v.nb_place, v.brand, v.model, v.color, v.energy, v.energy_icon, v.vehicle_id, v.belong AS driver_id
                FROM {$this->table} cs
                JOIN vehicle v ON cs.used_vehicle = v.vehicle_id
                WHERE cs.depart_adress LIKE CONCAT('%',:depart, '%')
                AND cs.arrival_adress LIKE CONCAT('%',:arrival, '%')
                AND cs.depart_date = :date
                AND cs.statut = 'créé'
                AND v.nb_place >= :passenger
                ";

        $params = [
            ':depart' => '%' . $depart . '%',
            ':arrival' => '%' . $arrival . '%',
            ':date' => $date,
            ':passenger' => $passenger
        ];
        
        if(in_array('electric', $services)){
            $sql .= " AND v.energy = 1";
        }

        if(!empty($time)){
            $timeConditions = [];
            
            if(in_array('morning', $time)){
                $timeConditions[] = "(TIME(cs.depart_time) BETWEEN '06:00:00' AND '12:00:00')";
            }

            if(in_array('afternoon', $time)){
                $timeConditions[] = "(TIME(cs.depart_time) BETWEEN '12:01:00' AND '19:00:00')";
            }

            if(!empty($timeConditions)){
                $sql .= ' AND (' . implode(' OR ', $timeConditions) . ')';
            }
        }

        switch ($sort){
            case 'depart_asc':
                $sql .= " ORDER BY cs.depart_date ASC, cs.depart_time ASC";
                break;
            case 'price_asc':
                $sql .= " ORDER BY cs.price_person ASC";
                break;
            default:
                $sql .= " ORDER BY cs.depart_date ASC";
                break;
        }

        $data = $this->fetch($sql, $params);

        $carshares = [];
        $userRepo = new UserRepository($this->db);
        $reservationRepo = new ReservationRepository($this->db);
        $preferenceService = new PreferenceService();

        foreach ($data as $row) {
            $carshare = new CarshareModel();
            $carshare->hydrate($row);

            if (isset($row['driver_id'])) {
                $driver = $userRepo->getById($row['driver_id']);
                if ($driver) {
                    $carshare->setDriver($driver);
                }
            }

            $reserved = $reservationRepo->countReservedSeats($carshare->getCarshareId());
            $remaining = (int) $carshare->getNbPlace() - $reserved;
            $carshare->setAvailablePlaces(max(0, $remaining));

            if($remaining < $passenger) continue;
                
                $prefs = $preferenceService->getPreferencesByVehicle($carshare->getUsedVehicle());
                
                if (in_array('smoking', $services) && empty($prefs['smoking'])) continue;
                if (in_array('pets', $services) && empty($prefs['pets'])) continue;

                $carshares[] = $carshare;
        }

        return $carshares;
    }
}