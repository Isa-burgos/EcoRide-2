<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Repositories\UserRepository;
use App\Services\AuthService;
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
            header('location: ' . ROUTE_LOGIN);
            exit();
        }

        $userRepo = new UserRepository($this->getDB());
        $user = $userRepo->findByEmail($_POST['email']);



        if($user && password_verify($_POST['password'], $user->getPassword())){
            (new AuthService())->login($user);

            $redirectTo = $_SESSION['redirect_after_login']?? ROUTE_DASHBOARD;
            unset($_SESSION['redirect_after_login']);

            header('location: ' . $redirectTo);
            exit();
        } else {
            $_SESSION['error'] = 'Identifiant ou mot de passe incorrect';
            header('location: ' . ROUTE_LOGIN);
            exit();
        }
    }

    public function logout(): void
    {
        $auth = new AuthService();
        $auth->logout();

        header('location: ' . ROUTE_HOME);
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

        // Vérifie que les deux mots de passe correspondent
        if($_POST['password'] !== $_POST['passwordValidate']){
            $errors['passwordValidate'] = 'Les mots de passe ne correspondent pas';
        }

        // Vérifie que l'e-mail n'existe pas déjà
        $userRepo = new UserRepository($this->getDb());
        if($userRepo->emailExists($_POST['email'])){
            $errors['email'] = "Cet e-mail est déjà utilisé";
        }

        // Redirige si erreurs
        if(!empty($errors)){
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            header('location: ' . ROUTE_REGISTER);
            exit();
        }

        
        // Création du UserModel
        $user = new UserModel();
        $user->setName($_POST['name']);
        $user->setFirstname($_POST['firstname']);
        $user->setPseudo($_POST['pseudo'] ?? '');
        $user->setEmail($_POST['email']);
        $user->setPassword($_POST['password']);
        $user->setPhone($_POST['phone'] ?? '');
        $user->setAdress($_POST['adress'] ?? '');
        $user->setBirthDate($_POST['birth_date']);
        $user->setPhoto('/public/assets/img/default-profile.svg');
        $user->setGender($_POST['gender']);
        $user->setRole($_POST['role'] ?? 'user');
        $user->setCreditBalance(20);
        
        // Enregistrement
        $userRepo->createUser($user);

        //Récupération de l'utilisateur enregistré
        $createdUser = $userRepo->findByEmail($user->getEmail());

        // Connexion automatique
        (new AuthService())->login($createdUser);

        // Message d'information
        $_SESSION['info'] = "Veuillez compléter votre profil";

        // Redirection
        header('location: ' . ROUTE_ACCOUNT);
        exit();
    }
}