<?php

namespace App\Models;

use PDO;
use App\Models\Model;

class Vehicle extends Model{

    protected $table = 'vehicle';

    public $vehicule_id;
    public $registration;
    public $first_registration_date;
    public $brand;
    public $model;
    public $color;
    public $energy;
    public $energy_icon;
    public $user_id;

    public function getVehicle(int $vehicle_id): ?Vehicle
    {
        return $this->query("SELECT * FROM {$this->table} WHERE vehicle_id = :vehicle_id", [':vehicle_id' => $vehicle_id], true);
    }

    public function getVehiculeByUser(int $user_id): array
    {
        $stmt = $this->getPDO()->prepare("SELECT vehicle_id FROM {$this->table} WHERE user_id = :user_id");
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createVehicle(array $data): bool
    {
        $energyIcon = $data['energy'] == 1 ? '/assets/icons/electric-icon.svg' : '/assts/icons/thermal-icon.svg';

        $stmt = $this->getPDO()->prepare("INSERT INTO vehicle
                                            (registration, first_registration_date, brand, model, color, energy, energy_icon, belong)
                                            VALUES
                                            (:registration, :first_registration_date, :brand, :model, :color, :energy, :energy_icon, :belong)
                                            ");
        return $stmt->execute([
            'registration' => $data['registration'],
            'first_registration_date' => $data['first_registration_date'],
            'brand' => $data['brand'],
            'model' => $data['model'],
            'color' => $data['color'],
            'energy' => $data['energy'],
            'energy_icon' => $energyIcon,
            'belong' => $data['belong'],
        ]);
    }

    public function getAllByUser(int $userId): array
    {
        $stmt = $this->getPDO()->prepare("SELECT * FROM {$this->table} WHERE belong = :belong");
        $stmt->bindValue(':belong', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}