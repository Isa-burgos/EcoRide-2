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

    public function getAllUsers(): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE role = 'user'";
        $users = $this->fetch($sql, [], false, UserModel::class);

        return $users;
    }

    public function emailExists(string $email): bool
    {
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

    public function getStatuts(int $userId): array
    {
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

    /**
     * Update user statuts
     */

    public function updateUserStatuts(int $userId, array $statuts): void
    {
        // Supprime tous les anciens statuts pour éviter les doublons
        $stmt = $this->getPDO()->prepare("DELETE FROM user_statut WHERE user_id = :user_id");
        $stmt->execute([':user_id' => $userId]);

        if(!empty($_POST['statuts'])){
            foreach($statuts as $statutName){
                $stmt = $this->getPDO()->prepare("
                    INSERT INTO user_statut (user_id, statut_id)
                    SELECT :user_id, statut_id FROM statut WHERE name = :name
                ");
                $stmt->execute([
                    'user_id' => $userId,
                    'name' => $statutName
                ]);
            }
        }
    }

    public function debitCredits($userId, $amount): void
    {
        $sql = "UPDATE {$this->table} SET credit_balance = credit_balance - :amount WHERE user_id = :user_id";
        $this->execute($sql, [
            'user_id' => $userId,
            'amount' => $amount
        ]);
    }

    public function creditCredits($userId, $amount): void
    {
        $sql = "UPDATE {$this->table} SET credit_balance = credit_balance + :amount WHERE user_id = :user_id";
        $this->execute($sql, [
            'user_id' => $userId,
            'amount' => $amount
        ]);
    }

    public function getAdminId(): ?int
    {
        $sql = "SELECT user_id FROM {$this->table} WHERE role = 'admin' LIMIT 1";
        $admin = $this->fetch($sql, [], true);

        return $admin ? $admin['user_id'] : null;
    }

    public function suspendUser(int $userId): bool
    {
        $sql = "UPDATE {$this->table} SET is_active = 0 WHERE user_id = :user_id";
        return $this->execute($sql, ['user_id' => $userId]);
    }

    public function reactivateUser(int $userId): bool
    {
        $sql = "UPDATE {$this->table} SET is_active = 1 WHERE user_id = :user_id";
        return $this->execute($sql, ['user_id' => $userId]);
    }

    public function deleteUser(int $userId){
        $sql1 = "DELETE FROM user_statut WHERE user_id = :user_id";
        return $this->execute($sql1, ['user_id' => $userId]);

        $sql2 = "DELETE FROM {$this->table} WHERE user_id = :user_id";
        return $this->execute($sql2, ['user_id' => $userId]);
    }
    
}