<?php

namespace App\Controllers;

use App\Models\User;
use App\Validation\Validator;

class UserController extends Controller{

    public function login()
    {
        return $this->view('auth.login');
    }

    public function loginPost()
    {
        $validator = new Validator($_POST);
        $errors = $validator->validate([
            'email' => ['required'],
            'password' => ['required']
        ]);

        if($errors){
            $_SESSION['errors'] = $errors;
            header('location: /login');
            exit;
        }

        $user = (new User($this->getDB()))->getByEmail($_POST['email']);

        if($user && password_verify($_POST['password'], $user->password)){
            $_SESSION['user'] = [
                'id' => $user->id ?? 0,
                'email' => $user->email,
                'pseudo' => $user->pseudo,
                'photo' => $user->photo ?? '/public/assets/img/default-profile.png'
            ];

            session_write_close();

            header('location: /dashboard');
            exit();
        } else {
            $_SESSION['error'] = 'Identifiant ou mot de passe incorrect';
            header('location: /login');
            exit();
        }
    }

    public function logout()
    {
        session_destroy();

        header('location: /');
        exit();
    }

    public function register()
    {
        return $this->view('auth.register');
    }

    public function registerPost()
    {
        $validator = new Validator($_POST);
        $errors = $validator->validate([
            'gender' => ['required'],
            'name' => ['required', 'min:3'],
            'firstname' => ['required', 'min:3'],
            'birth_date' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'password'],
            'passwordValidate' => ['required']
        ]);

        if($_POST['password'] !== $_POST['passwordValidate']){
            $errors['passwordValidate'] = 'Les mots de passe ne correspondent pas';
        }

        $userModel = new User($this->getDB());

        if($userModel->emailExists($_POST['email'])){
            $errors['email'] = "Cet e-mail est déjà utilisé";
        }

        if(!empty($errors)){
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            header('location: /register');
            exit();
        }

        $userModel->createUser([
            'name' => $_POST['name'],
            'firstname' => $_POST['firstname'],
            'pseudo' => $_POST['pseudo'] ?? '',
            'email' => $_POST['email'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'phone' => $_POST['phone'] ?? 0,
            'adress' => $_POST['adress'] ?? '',
            'birth_date' => $_POST['birth_date'],
            'photo' => '/public/assets/img/default-profile.png',
            'gender' => $_POST['gender'],
            'possess' => 1
        ]);

        header('location: /login', true, 303);
        exit();

    }
}