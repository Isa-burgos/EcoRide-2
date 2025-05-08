<?php

namespace App\Models;

class PaymentModel extends Model{

    private int $paymentId;
    private float $amount;
    private string $type;
    private string $createdAt;
    private int $userId;
    private int $carshareId;

    /**
     * Get the value of paymentId
     */ 
    public function getPaymentId()
    {
        return $this->paymentId;
    }

    /**
     * Set the value of paymentId
     *
     * @return  self
     */ 
    public function setPaymentId($paymentId)
    {
        $this->paymentId = $paymentId;

        return $this;
    }

    /**
     * Get the value of amount
     */ 
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set the value of amount
     *
     * @return  self
     */ 
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get the value of type
     */ 
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @return  self
     */ 
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of createdAt
     */ 
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @return  self
     */ 
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

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
}