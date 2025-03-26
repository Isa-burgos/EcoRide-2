<?php

namespace App\Models;

use PDO;
use App\Models\Model;

class VehicleModel extends Model{

    protected $table = 'vehicle';

    private int $vehicle_id;
    private string $registration;
    private string $first_registration_date;
    private string $brand;
    private string $model;
    private string $color;
    private string $energy;
    private string $energy_icon;
    private int $belong;

    public function getVehicleId(): int
    {
        return $this->vehicle_id;
    }

    public function getRegistration(): string
    {
        return $this->registration;
    }

    public function getFirstRegistrationDate(): string
    {
        return $this->first_registration_date;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function getEnergy(): string
    {
        return $this->energy;
    }

    public function getEnergyIcon(): string
    {
        return $this->energy_icon;
    }
    
    public function getUserId(): int
    {
        return $this->belong;
    }

    public function setVehicleId(int $vehicleId): void
    {
        $this->vehicle_id = $vehicleId;
    }

    public function setRegistration(string $registration): void
    {
        $this->registration = $registration;
    }

    public function setFirstRegistrationDate(string $firstRegistrationDate): void
    {
        $this->first_registration_date = $firstRegistrationDate;
    }

    public function setBrand(string $brand): void
    {
        $this->brand = $brand;
    }

    public function setModel(string $model): void
    {
        $this->model = $model;
    }

    public function setColor(string $color): void
    {
        $this->color = $color;
    }

    public function setEnergy(string $energy): void
    {
        $this->energy = $energy;
    }

    public function setEnergyIcon(string $energyIcon): void
    {
        $this->energy_icon = $energyIcon;
    }

    public function setUserId(int $userId): void
    {
        $this->belong = $userId;
    }
}