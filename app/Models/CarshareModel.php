<?php

namespace App\Models;

class CarshareModel extends Model{

    private int $carshareId;
    private int $pricePerson = 2;
    private string $departAdress;
    private string $arrivalAdress;
    private string $departDate;
    private string $departTime;
    private string $arrivalTime;
    private string $statut;
    private int $usedVehicle;
    protected int $conducteurId;
    private int $nbPlace;
    protected ?UserModel $driver = null;

    protected ?VehicleModel $vehicle = null;

    private int $userId;

    private ?string $brand = null;
    private ?string $model = null;
    private ?string $color = null;
    private ?int $nb_place = null;
    private ?int $energy = null;
    private ?string $energyIcon = null;



    public string $smoking_icon;
    public string $pets_icon;
    public string $custom_preferences;




    /**
     * Get the value of carshareId
     */ 
    public function getCarshareId()
    {
        return $this->carshareId;
    }

    /**
     * Set the value of carshareId
     *
     * @return  self
     */ 
    public function setCarshareId($carshareId)
    {
        $this->carshareId = $carshareId;

        return $this;
    }

    /**
     * Get the value of pricePerson
     */ 
    public function getPricePerson()
    {
        return $this->pricePerson;
    }

    /**
     * Set the value of pricePerson
     *
     * @return  self
     */ 
    public function setPricePerson($pricePerson)
    {
        $this->pricePerson = $pricePerson;

        return $this;
    }

    /**
     * Get the value of departAdress
     */ 
    public function getDepartAdress()
    {
        return $this->departAdress;
    }

    /**
     * Set the value of departAdress
     *
     * @return  self
     */ 
    public function setDepartAdress($departAdress)
    {
        $this->departAdress = $departAdress;

        return $this;
    }

    /**
     * Get the value of arrivalAdress
     */ 
    public function getArrivalAdress()
    {
        return $this->arrivalAdress;
    }

    /**
     * Set the value of arrivalAdress
     *
     * @return  self
     */ 
    public function setArrivalAdress($arrivalAdress)
    {
        $this->arrivalAdress = $arrivalAdress;

        return $this;
    }

    /**
     * Get the value of departDate
     */ 
    public function getDepartDate()
    {
        return $this->departDate;
    }

    /**
     * Set the value of departDate
     *
     * @return  self
     */ 
    public function setDepartDate($departDate)
    {
        $this->departDate = $departDate;

        return $this;
    }

    /**
     * Get the value of departTime
     */ 
    public function getDepartTime()
    {
        return $this->departTime;
    }

    /**
     * Set the value of departTime
     *
     * @return  self
     */ 
    public function setDepartTime($departTime)
    {
        $this->departTime = $departTime;

        return $this;
    }

    /**
     * Get the value of arrivalTime
     */ 
    public function getArrivalTime()
    {
        return $this->arrivalTime;
    }

    /**
     * Set the value of arrivalTime
     *
     * @return  self
     */ 
    public function setArrivalTime($arrivalTime)
    {
        $this->arrivalTime = $arrivalTime;

        return $this;
    }

    /**
     * Get the value of statut
     */ 
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Set the value of statut
     *
     * @return  self
     */ 
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get the value of usedVehicle
     */ 
    public function getUsedVehicle()
    {
        return $this->usedVehicle;
    }

    /**
     * Set the value of usedVehicle
     *
     * @return  self
     */ 
    public function setUsedVehicle($usedVehicle)
    {
        $this->usedVehicle = $usedVehicle;

        return $this;
    }

    /**
     * Get the value of conducteur_id
     */ 
    public function getConducteurId()
    {
        return $this->conducteurId;
    }

    /**
     * Set the value of conducteur_id
     *
     * @return  self
     */ 
    public function setConducteurId($conducteurId)
    {
        $this->conducteurId = $conducteurId;

        return $this;
    }


    /**
     * Get the value of nbPlace
     */ 
    public function getNbPlace()
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
     * Get the value of driver
     */ 
    public function getDriver(): ?UserModel
    {
        return $this->driver;
    }

    /**
     * Set the value of driver
     *
     * @return  self
     */ 
    public function setDriver(UserModel $driver): self
    {
        $this->driver = $driver;

        return $this;
    }

    /**
     * Get the value of vehicle
     */ 
    public function getVehicle()
    {
        return $this->vehicle;
    }

    /**
     * Set the value of vehicle
     *
     * @return  self
     */ 
    public function setVehicle($vehicle)
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    /**
     * Get the value of userId
     */ 
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set the value of userId
     *
     * @return  self
     */ 
    public function setUserId($userId)
    {
        $this->userId = $userId;

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
     * Get the value of nb_place
     */ 
    public function getNb_place()
    {
        return $this->nb_place;
    }

    /**
     * Set the value of nb_place
     *
     * @return  self
     */ 
    public function setNb_place($nb_place)
    {
        $this->nb_place = $nb_place;

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
        return $this->energyIcon;
    }

    /**
     * Set the value of energy_icon
     *
     * @return  self
     */ 
    public function setEnergyIcon($energy_icon)
    {
        $this->energyIcon = $energy_icon;

        return $this;
    }
}