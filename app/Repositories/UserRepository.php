<?php

namespace App\Repositories;

use PDO;
use Config\DbConnect;
use App\Models\UserModel;
use App\Repositories\Repository;

class UserRepository extends Repository{

    private string $table = 'user';

    public function __construct(DbConnect $db)
    {
        parent::__construct($db);
    }

    public function findByEmail(string $email): ?UserModel
    {
        $data = $this->fetch("SELECT * FROM {$this->table} WHERE email = :email", [":email" => $email], true);

        if(!$data){
            return null;
        }

        $user = new UserModel();
        return $user->hydrate($data);
    }

    public function getById(int $user_id): ?UserModel
    {

        $data = $this->fetch("SELECT * FROM {$this->table} WHERE user_id = :user_id", [":user_id" => $user_id], true);

        if(!$data){
            return null;
        }

        $user = new UserModel();
        return $user->hydrate($data);

    }

    public function emailExists(string $email): bool{
        $stmt = $this->getPDO()->prepare("SELECT user_id FROM {$this->table} WHERE email = :email");
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        return (bool) $stmt->fetch();
    }

    /**
     * Create a new user
     */

    public function createUser(UserModel $user): bool
    {
        $sql = "INSERT INTO {$this->table}
                (name, firstname, pseudo, email, password, phone, adress, birth_date, photo, gender, role)
                VALUES
                (:name, :firstname, :pseudo, :email, :password, :phone, :adress, :birth_date, :photo, :gender, :role)";

        return $this->execute($sql,[
            ':name' => $user->getName(),
            ':firstname' => $user->getFirstname(),
            ':pseudo' => $user->getPseudo(),
            ':email' => $user->getEmail(),
            ':password' => $user->getPassword(),
            ':phone' => $user->getPhone(),
            ':adress' => $user->getAdress(),
            ':birth_date' => $user->getBirthDate(),
            ':photo' => $user->getPhoto(),
            ':gender' => $user->getGender(),
            ':role' => $user->getRole(),
        ]);
    }

    /**
     * Update user
     */

    public function updateUser(UserModel $user): bool
    {
        $sql = "UPDATE {$this->table}
                SET
                    name = :name,
                    firstname = :firstname,
                    pseudo = :pseudo,
                    birth_date = :birth_date,
                    email = :email,
                    phone = :phone,
                    gender = :gender
                WHERE user_id = :user_id
        ";

        return $this->execute($sql, [
            ':name' => $user->getName(),
            ':firstname' => $user->getFirstname(),
            ':pseudo' => $user->getPseudo(),
            ':birth_date' => $user->getBirthDate(),
            ':email' => $user->getEmail(),
            ':phone' => $user->getPhone(),
            ':gender' => $user->getGender(),
            ':user_id' => $user->getUserId(),
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

    /**
     * Update password
     */

    public function updatePassword(int $userId, string $newPassword): bool
    {
        $sql = "UPDATE {$this->table} SET password = :password WHERE user_id = :user_id";

        $user = new UserModel();
        $user->setPassword($newPassword);

        return $this->execute($sql, [
            ':password' => $user->getPassword(),
            ':user_id' => $userId
        ]);
    }

    
}