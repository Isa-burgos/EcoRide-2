<?php

namespace App\Repositories;

use App\Models\UserModel;
use Config\DbConnect;

class AdminRepository extends Repository
{
    private string $table = 'user';

    public function __construct(DbConnect $db)
    {
        parent::__construct($db);
    }

    public function getEmployeById(int $employeId): ?UserModel
    {
        $sql = "SELECT user_id, name, firstname, adress, phone, email FROM {$this->table} WHERE user_id = :user_id";
        return $this->fetch($sql, ['user_id' => $employeId], true, UserModel::class);
    }

    public function getAllEmployes(): array
    {
        $sql = "SELECT user_id, name, firstname, adress, phone, email, is_active FROM {$this->table} WHERE role = 'employe'";
        return $this->fetch($sql, [], false, UserModel::class);
    }

    public function updateEmploye(int $userId, array $data): bool
    {
        $sql = "UPDATE {$this->table}
                SET name= :name,
                    firstname = :firstname,
                    adress = :adress,
                    phone = :phone,
                    email = :email
                WHERE user_id = :user_id
                ";

        return $this->execute($sql, [
            'name' => $data['name'],
            'firstname' => $data['firstname'],
            'adress' => $data['adress'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'user_id' => $userId
        ]);
    }
}
