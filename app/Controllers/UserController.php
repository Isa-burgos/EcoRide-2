<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Vehicle;
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
            exit;
        }

        $user = (new User($this->getDB()))->getByEmail($_POST['email']);

        if($user && password_verify($_POST['password'], $user->password)){
            $_SESSION['user'] = [
                'id' => $user->user_id ?? 0,
                'email' => $user->email,
                'pseudo' => $user->pseudo,
                'photo' => $user->photo ?? '/public/assets/img/default-profile.png'
            ];

            
            session_write_close();

            header('location: ' . ROUTE_DASHBOARD);
            exit();
        } else {
            $_SESSION['error'] = 'Identifiant ou mot de passe incorrect';
            header('location: ' . ROUTE_LOGIN);
            exit();
        }
    }

    public function logout()
    {
        session_destroy();

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
            header('location: ' . ROUTE_REGISTER);
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
            'role' => 'user'
        ]);

        header('location: ' . ROUTE_LOGIN, true, 303);
        exit();

    }

    public function account()
    {
        $userId = $_SESSION['user']['id'];

        $vehicleModel = new Vehicle($this->getDB());
        $vehicles = $vehicleModel->getAllByUser($userId);

        $userModel = new User($this->getDB());
        $user = $userModel->getById($userId);

        $statuts = $userModel->getStatuts($user->user_id);

        return $this->view('app.account', [
            'user' => $user,
            'vehicles' => $vehicles,
            'statuts' => $statuts
        ]);
    }

    public function updateAccount()
    {
        $userModel = new User($this->getDB());
        $vehicleModel = new Vehicle($this->getDB());

        $userId = $_SESSION['user']['id'];

        $userModel->updateUser($userId, [
            'name' => $_POST['name'],
            'firstname' => $_POST['firstname'],
            'pseudo' => $_POST['pseudo'],
            'birth_date' => $_POST['birth_date'],
            'email' => $_POST['email'],
            'phone' => $_POST['phone'],
            'gender' => $_POST['gender']
        ]);

        if(isset($_POST['statuts'])){
            $stmt = $this->getDB()->getPDO()->prepare("DELETE FROM user_statut WHERE user_id = :user_id");
            $stmt->bindValue(':user_id', $userId);
            $stmt->execute();
        }

        foreach($_POST['statuts'] as $statutName){
            $stmt = $this->getDB()->getPDO()->prepare("
                INSERT INTO user_statut (user_id, statut_id)
                SELECT :user_id, statut_id FROM statut WHERE name = :name
            ");
            $stmt->execute([
                'user_id' => $userId,
                'name' => $statutName
            ]);
        }

        $isDriver = in_array('Conducteur', $_POST['statuts'] ?? []);
        $hasVehicle = count($vehicleModel->getAllByUser($userId)) > 0;
        $wantsToAddVehicle = !empty($_POST['registration']);

        if($isDriver){
            if(!$hasVehicle && !$wantsToAddVehicle){
                $_SESSION['error'] = "Vous devez enregistrer un véhicule si vous êtes conducteur";
                header('location:' . ROUTE_ACCOUNT);
                exit();
            }


            if($wantsToAddVehicle){
                if(
                    !empty($_POST['registration']) &&
                    !empty($_POST['first_registration_date']) &&
                    !empty($_POST['brand']) &&
                    !empty($_POST['model']) &&
                    !empty($_POST['color']) &&
                    isset($_POST['energy'])
                    ){
                        $vehicleData = [
                            'registration' => $_POST['registration'],
                            'first_registration_date' => $_POST['first_registration_date'],
                            'brand' => $_POST['brand'],
                            'model' => $_POST['model'],
                            'color' => $_POST['color'],
                            'energy' => (int)$_POST['energy'],
                            'belong' => $userId
                        ];
                        
                        $success = $vehicleModel->createVehicle($vehicleData);
                        
                        if(!$success){
                            $_SESSION['error'] = "Erreur lors de l'enregistrement du véhicule";
                            header(('location:' . ROUTE_ACCOUNT));
                            exit();
                        }

                    } else{
                        $_SESSION['error'] = "Veuillez remplir tous les champs du véhicule pour l'enregistrer";
                        header('location: ' . ROUTE_ACCOUNT);
                        exit();
                    }
                }

            }
        $_SESSION['success'] = "Votre compte a bien été mis à jour.";
        header('location:' . ROUTE_ACCOUNT);
        exit();
    }
}