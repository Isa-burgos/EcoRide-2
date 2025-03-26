<?php

namespace App\Repositories;

use Config\DbConnect;
use App\Models\VehicleModel;

class VehicleRepository extends Repository{

    private string $table = 'vehicle';

    public function __construct(DbConnect $db)
    {
        parent::__construct($db);
    }

    public function getVehicle(int $vehicleId): ?VehicleModel
    {
        
        $sql = "SELECT * FROM {$this->table} WHERE vehicle_id = :vehicle_id";
        $data = $this->fetch($sql, [':vehicle_id' => $vehicleId], true);

        if(!$data){
            return null;
        }

        $vehicle = new VehicleModel();
        return $vehicle->hydrate($data);
    }

    public function createVehicle(array $data): bool
    {
        $energyIcon = $data['energy'] == 1 ? '/assets/icons/electric-icon.svg' : '/assts/icons/thermal-icon.svg';

        $sql = "INSERT INTO vehicle
                (registration, first_registration_date, brand, model, color, energy, energy_icon, belong)
                VALUES
                (:registration, :first_registration_date, :brand, :model, :color, :energy, :energy_icon, :belong)
                ";
        return $this->execute($sql, [
            ':registration' => $data['registration'],
            ':first_registration_date' => $data['first_registration_date'],
            ':brand' => $data['brand'],
            ':model' => $data['model'],
            ':color' => $data['color'],
            ':energy' => $data['energy'],
            ':energy_icon' => $energyIcon,
            ':belong' => $data['belong'],
        ]);
    }

    public function getAllByUser(int $userId): array
    {
        $sql ="SELECT * FROM {$this->table} WHERE belong = :belong";
        $vehiclesData = $this->fetch($sql, [':belong' => $userId]);

        $vehicles = [];
        foreach($vehiclesData as $data){
            $vehicle = new VehicleModel();
            $vehicles[] = $vehicle->hydrate($data);
        }

        return $vehicles;
    }

}