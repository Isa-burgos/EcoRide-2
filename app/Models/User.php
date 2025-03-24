<?php

namespace App\Models;

use PDO;
use App\Models\Model;

class User extends Model{

    protected $table = 'user';

    public $user_id;
    public $name;
    public $firstname;
    public $birth_date;
    public $adress;
    public $phone;
    public $role;
    public $email;
    public $password;
    public $pseudo;
    public $photo;
    public $gender;

    public function getByEmail(string $email): ?User
    {
        return $this->query("SELECT * FROM {$this->table} WHERE email = :email", [":email" => $email], true);

    }

    public function getById(int $user_id): ?User
    {

        return $this->query("SELECT * FROM {$this->table} WHERE user_id = :user_id", [":user_id" => $user_id], true);

    }

    public function emailExists(string $email): bool{
        $stmt = $this->getPDO()->prepare("SELECT user_id FROM {$this->table} WHERE email = :email");
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        return (bool) $stmt->fetch();
    }

    public function createUser(array $data): bool{
        $stmt = $this->getPDO()->prepare("INSERT INTO user
                                            (name, firstname, pseudo, email, password, phone, adress, birth_date, photo, gender, role)
                                            VALUES
                                            (:name, :firstname, :pseudo, :email, :password, :phone, :adress, :birth_date, :photo, :gender, :role)");

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
            'role' => $data['role'] ?? 'user'
        ]);
    }

    public function updateUser(int $userId, array $data): bool
    {
        $stmt = $this->getPDO()->prepare("
            UPDATE {$this->table}
            SET name = :name,
                firstname = :firstname,
                pseudo = :pseudo,
                birth_date = :birth_date,
                email = :email,
                phone = :phone,
                gender = :gender
            WHERE user_id = :user_id
        ");

        return $stmt->execute([
            'name' => $data['name'],
            'firstname' => $data['firstname'],
            'pseudo' => $data['pseudo'],
            'birth_date' => $data['birth_date'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'gender' => $data['gender'],
            'user_id' => $userId
        ]);
    }

    public function getStatuts(int $userId): array{
        $stmt = $this->getPDO()->prepare("
            SELECT s.name
            FROM statut s
            JOIN user_statut us ON us.statut_id = s.statut_id
            WHERE us.user_id = :user_id
        ");
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_COLUMN);

        return array_map('strtolower', $result);
    }

}