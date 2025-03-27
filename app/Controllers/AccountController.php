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

        $auth = new AuthService();
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

        $auth = new AuthService();
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

        try {
            $user->setName($_POST['name']);
            $user->setFirstname($_POST['firstname']);
            $user->setPseudo($_POST['pseudo'] ?? '');
            $user->setBirthDate($_POST['birth_date']);
            $user->setEmail($_POST['email']);
            $user->setPhone($_POST['phone'] ?? '');
            $user->setGender($_POST['gender']);

            $userRepo->updateUser($user);
            $_SESSION['success'] = "Votre profil a bien été mis à jour.";
            header('Location: ' . ROUTE_ACCOUNT . '#alerts');
            exit();
        } catch (\Throwable $e) {
            $_SESSION['error'] = "Erreur lors de la mise à jour : " . $e->getMessage();
            header('Location: ' . ROUTE_ACCOUNT . '#alerts');
            exit();
        }

        // Supprime tous les anciens statuts pour éviter les doublons
        $stmt = $this->getDB()->getPDO()->prepare("DELETE FROM user_statut WHERE user_id = :user_id");
        $stmt->execute([':user_id' => $userId]);

        if(!empty($_POST['statuts'])){
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
        }

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