<?php

namespace App\Models;

use App\Models\Model;
use InvalidArgumentException;

class UserModel extends Model{

    protected $table = 'user';

    private int $user_id;
    private string $name;
    private string $firstname;
    private ?string $birth_date = null;
    private string $adress;
    private string $phone;
    private string $role;
    private string $email;
    private string $password;
    private ?string $pseudo = null;
    private ?string $photo = null;
    private ?string $gender = null;
    private int $creditBalance = 20;
    private int $isActive;

    public function getUserId(): int{
        return $this->user_id;
    }

    public function getName(): string{
        return $this->name;
    }

    public function getFirstname(): string{
        return $this->firstname;
    }

    public function getBirthDate(): ?string{
        return $this->birth_date;
    }

    public function getAdress(): string{
        return $this->adress;
    }

    public function getPhone(): string{
        return $this->phone;
    }

    public function getRole(): string{
        return $this->role;
    }

    public function getEmail(): string{
        return $this->email;
    }

    public function getPassword(): string{
        return $this->password;
    }

    public function getPseudo(): ?string{
        return $this->pseudo;
    }

    public function getPhoto(): ?string{
        return $this->photo;
    }

    public function getGender(): ?string{
        return $this->gender;
    }

    public function setUserId(int $userId): void{
        $this->user_id = $userId;
    }

    public function setName(string $name): void{
        $this->name = $name;
    }

    public function setFirstname(string $firstname): void{
        $this->firstname = $firstname;
    }

    public function setBirthDate(string $birthDate): void{
        $this->birth_date = $birthDate;
    }

    public function setAdress(string $adress): void{
        $this->adress = $adress;
    }

    public function setPhone(string $phone): void{
        $this->phone = $phone;
    }

    public function setRole(string $role): void{
        $this->role = $role;
    }

    public function setEmail(string $email): void{
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            throw new InvalidArgumentException("Adresse e-mail invalide");
        }
        $this->email = $email;
    }
    
    public function setPassword(string $password): void{
        if (str_starts_with($password, '$2y$')) {
            $this->password = $password;
        } else {
            $this->password = password_hash($password, PASSWORD_DEFAULT);
        }
    }

    public function setPseudo(string $pseudo): void{
        $this->pseudo = $pseudo;
    }

    public function setPhoto(?string $photo){
        $this->photo = $photo ?? '/public/assets/img/default-profile.svg';
        return $this;
    }

    public function setGender(string $gender): void{
        $this->gender = $gender;
    }


    /**
     * Get the value of creditBalance
     */ 
    public function getCreditBalance()
    {
        return $this->creditBalance;
    }

    /**
     * Set the value of creditBalance
     *
     * @return  self
     */ 
    public function setCreditBalance($creditBalance)
    {
        $this->creditBalance = $creditBalance;

        return $this;
    }
    /**
     * Get the value of isActive
     */ 
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set the value of isActive
     *
     * @return  self
     */ 
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }
}