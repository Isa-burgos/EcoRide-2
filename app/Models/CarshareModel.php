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
}