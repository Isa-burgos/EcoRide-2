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

    public function getByEmail(string $email): ?User
    {
        return $this->query("SELECT * FROM {$this->table} WHERE email = :email", [":email" => $email], true);

    }

}