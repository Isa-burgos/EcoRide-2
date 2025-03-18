<?php

namespace App\Models;

use App\Models\Model;

class User extends Model{

    protected $table = 'user';

    public $id;
    public $email;
    public $password;
    public $pseudo;
    public $photo;

    public function getByEmail(string $email): User
    {
        $user = $this->query("SELECT * FROM {$this->table} WHERE email = :email", [":email" => $email], true);

        var_dump($user); // 🔍 Vérifie ce que la requête retourne
    exit();

        return $user;
    }

}