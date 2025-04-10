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
    private int $nbPlace = 1;
    private string $energy;
    private string $energy_icon;
    private int $belong;



    /**
     * Get the value of vehicle_id
     */ 
    public function getVehicleId()
    {
        return $this->vehicle_id;
    }

    /**
     * Set the value of vehicle_id
     *
     * @return  self
     */ 
    public function setVehicleId($vehicle_id)
    {
        $this->vehicle_id = $vehicle_id;

        return $this;
    }

    /**
     * Get the value of registration
     */ 
    public function getRegistration()
    {
        return $this->registration;
    }

    /**
     * Set the value of registration
     *
     * @return  self
     */ 
    public function setRegistration($registration)
    {
        $this->registration = $registration;

        return $this;
    }

    /**
     * Get the value of first_registration_date
     */ 
    public function getFirstRegistrationDate()
    {
        return $this->first_registration_date;
    }

    /**
     * Set the value of first_registration_date
     *
     * @return  self
     */ 
    public function setFirstRegistrationDate($first_registration_date)
    {
        $this->first_registration_date = $first_registration_date;

        return $this;
    }

    /**
     * Get the value of brand
     */ 
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set the value of brand
     *
     * @return  self
     */ 
    public function setBrand($brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get the value of model
     */ 
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set the value of model
     *
     * @return  self
     */ 
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get the value of color
     */ 
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set the value of color
     *
     * @return  self
     */ 
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get the value of nbPlace
     */ 
    public function getNbPlace(): int
    {
        return $this->nbPlace;
    }

    /**
     * Set the value of nbPlace
     *
     * @return  self
     */ 
    public function setNbPlace($nbPlace)
    {
        $this->nbPlace = $nbPlace;

        return $this;
    }

    /**
     * Get the value of energy
     */ 
    public function getEnergy()
    {
        return $this->energy;
    }

    /**
     * Set the value of energy
     *
     * @return  self
     */ 
    public function setEnergy($energy)
    {
        $this->energy = $energy;

        return $this;
    }

    /**
     * Get the value of energy_icon
     */ 
    public function getEnergyIcon()
    {
        return $this->energy_icon;
    }

    /**
     * Set the value of energy_icon
     *
     * @return  self
     */ 
    public function setEnergyIcon($energy_icon)
    {
        $this->energy_icon = $energy_icon;

        return $this;
    }

    /**
     * Get the value of belong
     */ 
    public function getBelong()
    {
        return $this->belong;
    }

    /**
     * Set the value of belong
     *
     * @return  self
     */ 
    public function setBelong($belong)
    {
        $this->belong = $belong;

        return $this;
    }
}