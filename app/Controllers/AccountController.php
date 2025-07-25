<?php

namespace App\Controllers;

use App\middleware\AuthMiddleware;
use Config\DbConnect;
use App\Services\AuthService;
use App\Repositories\UserRepository;
use App\Repositories\VehicleRepository;

class AccountController extends Controller{

    public function __construct(DbConnect $db)
{
    parent::__construct($db);
    AuthMiddleware::requireAuth();
}


    public function show()
    {
        AuthMiddleware::requireAuth();

        $auth = new AuthService($this->db);
        $userId = $auth->getCurrentUserId();

        $userRepo = new UserRepository($this->getDB());
        $user = $userRepo->getById($userId);
        $statuts = $userRepo->getStatuts($userId);

        $vehicleRepo = new VehicleRepository($this->getDB());
        $vehicles = $vehicleRepo->getAllByUser($userId);

        return $this->view('app.account', [
            'user' => $user,
            'vehicles' => $vehicles,
            'statuts' => $statuts
        ]);
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = "Méthode non autorisée.";
            header('Location: ' . ROUTE_ACCOUNT . '#alerts');
            exit();
        }

        if (empty($_POST)) {
            $_SESSION['error'] = "Aucune donnée reçue.";
            header('Location: ' . ROUTE_ACCOUNT . '#alerts');
            exit();
        }

        AuthMiddleware::requireAuth();

        $userRepo = new UserRepository($this->getDB());
        $vehicleRepo = new VehicleRepository($this->getDB());

        $auth = new AuthService($this->db);
        $userId = $auth->getCurrentUserId();

        if (!$userId) {
            $_SESSION['error'] = "Session expirée, veuillez vous reconnecter.";
            header('location: ' . ROUTE_LOGIN);
            exit;
        }

        $user = $userRepo->getById($userId);

        if (!$user) {
            $_SESSION['error'] = "Utilisateur introuvable.";
            header('location: ' . ROUTE_LOGIN);
            exit;
        }

        $user->setName($_POST['name']);
        $user->setFirstname($_POST['firstname']);
        $user->setPseudo($_POST['pseudo'] ?? '');
        $user->setBirthDate($_POST['birth_date']);
        $user->setEmail($_POST['email']);
        $user->setPhone($_POST['phone'] ?? '');
        $user->setGender($_POST['gender']);

        $uploadDir = "upload/profile_pictures/";
        $photoPath = $_SESSION['user']['photo'] ?? 'assets/img/default-profile.jpg';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0775, true);
        }

        if(isset($_FILES['photo']) && !empty($_FILES['photo']['name'])){
            $photoTmpPath = $_FILES['photo']['tmp_name'];
            $photoName = basename($_FILES['photo']['name']);
            $photoSize = $_FILES['photo']['size'];
            $photoError = $_FILES['photo']['error'];
            $photoExt = strtolower(pathinfo($photoName, PATHINFO_EXTENSION));
        
            $allowedExts = ["jpg", "jpeg", "png"];
        
            if($photoError === 0 && in_array($photoExt, $allowedExts) && $photoSize <= 2 * 1024 * 1024){
                $newFileName = "profile_" . $userId . "." . $photoExt;
                $photoPath = $uploadDir . $newFileName;
        
                if(!move_uploaded_file($photoTmpPath, $photoPath)){
                    $_SESSION['errors'] = "Le téléchargement de la photo a échoué";
                    header("Location: " . ROUTE_ACCOUNT);
                    exit();
                }
                
                $user->setPhoto($photoPath);
                
            } else {
                $_SESSION['errors'] = "Photo invalide";
                header('location: ' . ROUTE_ACCOUNT);
                exit();
            }
        }

        $userRepo->updateUser($user);
        
        $userRepo->updateUserStatuts($userId, $_POST['statuts'] ?? []);

        $isDriver = in_array('Conducteur', $_POST['statuts'] ?? []);
        $hasVehicle = count($vehicleRepo->getAllByUser($userId)) > 0;
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
                        
                        $success = $vehicleRepo->createVehicle($vehicleData);
                        
                        if(!$success){
                            $_SESSION['error'] = "Erreur lors de l'enregistrement du véhicule";
                            header('location:' . ROUTE_ACCOUNT);
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