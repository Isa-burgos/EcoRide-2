<?php

namespace App\Controllers;

use App\Models\User;

class UserController extends Controller{

    public function login()
    {
        return $this->view('auth.login');
    }

    public function loginPost()
    {
        $user = (new User($this->getDB()))->getByEmail($_POST['email']);

        if($user && password_verify($_POST['password'], $user->password)){
            $_SESSION['user'] = [
                'id' => $user->id,
                'email' => $user->email,
                'pseudo' => $user->pseudo,
                'photo' => $user->photo ?? '/public/assets/img/default-profile.png'
            ];

            session_write_close();

            header('location: /dashboard');
            exit();
        } else {
            return $this->view('auth.login',[
                'error' => 'Identifiant ou mot de passe incorrect'
            ]);
        }
    }

    public function logout()
    {
        session_destroy();
    }
}