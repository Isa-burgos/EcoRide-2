<?php

namespace App\Models;

use PDO;
use App\Models\Model;

class User extends Model{

    protected $table = 'user';

    public $id;
    public $email;
    public $password;
    public $pseudo;
    public $photo;

    public function getByEmail(string $email): ?User
    {
        return $this->query("SELECT * FROM {$this->table} WHERE email = :email", [":email" => $email], true);

    }

    public function emailExists(string $email): bool{
        $stmt = $this->getPDO()->prepare("SELECT user_id FROM {$this->table} WHERE email = :email");
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        return (bool) $stmt->fetch();
    }

    public function createUser(array $data): bool{
        $stmt = $this->getPDO()->prepare("INSERT INTO user
                                            (name, firstname, pseudo, email, password, phone, adress, birth_date, photo, gender, possess)
                                            VALUES
                                            (:name, :firstname, :pseudo, :email, :password, :phone, :adress, :birth_date, :photo, :gender, :possess)");

        return $stmt->execute([
            'name' => $data['name'],
            'firstname' => $data['firstname'],
            'pseudo' => $data['pseudo'] ?? '',
            'email' => $data['email'],
            'password' => $data['password'],
            'phone' => $data['phone'] ?? 0,
            'adress' => $data['adress'] ?? '',
            'birth_date' => $data['birth_date'] . ' 00:00:00',
            'photo' => $data['photo'] ?? '/public/assets/img/default-profile.png',
            'gender' => $data['gender'],
            'possess' => $data['possess'] ?? 1
        ]);
    }

}