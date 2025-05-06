<?php

namespace App\Models;

class ReservationModel extends Model{

    private int $reservationId;
    private string $reservationDate;
    private int $userId;
    private int $carshareId;
    private int $reservedPlaces = 1;


    /**
     * Get the value of reservationId
     */ 
    public function getReservationId()
    {
        return $this->reservationId;
    }

    /**
     * Set the value of reservationId
     *
     * @return  self
     */ 
    public function setReservationId($reservationId)
    {
        $this->reservationId = $reservationId;

        return $this;
    }

    /**
     * Get the value of reservationDate
     */ 
    public function getReservationDate()
    {
        return $this->reservationDate;
    }

    /**
     * Set the value of reservationDate
     *
     * @return  self
     */ 
    public function setReservationDate($reservationDate)
    {
        $this->reservationDate = $reservationDate;

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
     * Get the value of reservedPlaces
     */ 
    public function getReservedPlaces()
    {
        return $this->reservedPlaces;
    }

    /**
     * Set the value of reservedPlaces
     *
     * @return  self
     */ 
    public function setReservedPlaces($reservedPlaces)
    {
        $this->reservedPlaces = $reservedPlaces;

        return $this;
    }
}