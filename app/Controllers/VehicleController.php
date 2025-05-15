<?php

namespace App\Controllers;

use App\Services\AuthService;
use App\Services\PreferenceService;
use App\Repositories\VehicleRepository;

class VehicleController extends Controller{

    public function create()
    {
        return $this->view('vehicle.create');
    }

    public function store()
    {
        $auth = new AuthService();
        $userId = $auth->getCurrentUserId();

        if (!$userId) {
            $_SESSION['errors'] = "Veuillez vous reconnecter";
            header('location: ' . ROUTE_LOGIN);
            exit();
        }

        // Validation des champs
        if (
            empty($_POST['registration']) ||
            empty($_POST['first_registration_date']) ||
            empty($_POST['brand']) ||
            empty($_POST['model']) ||
            empty($_POST['color']) ||
            !isset($_POST['energy'])
        ) {
            $_SESSION['errors'] = "Tous les champs du véhicule sont requis";
            header('location: ' . ROUTE_ACCOUNT);
            exit();
        }

        // Création du véhicule dans MySQL

        $vehicleRepo = new VehicleRepository($this->getDb());

        $vehicleData = [
            'registration' => $_POST['registration'],
            'first_registration_date' => $_POST['first_registration_date'],
            'brand' => $_POST['brand'],
            'model' => $_POST['model'],
            'color' => $_POST['color'],
            'nb_place' => $_POST['nb_place'],
            'energy' => (int) $_POST['energy'],
            'belong' => $userId
        ];

        $vehicleId = $vehicleRepo->createVehicle($vehicleData);

        if (!$vehicleId) {
            $_SESSION['errors'] = "Erreur lors de l'ajout du véhicule";
            header('location:' . ROUTE_ACCOUNT);
            exit();
        }

        // Préférences à stocker dans MongoDB
        $preferences = [
            'smoking' => isset($_POST['smoking']) ? (bool) $_POST['smoking'] : false,
            'pets' => isset($_POST['pets']) ? (bool) $_POST['pets'] : false,
            'custom' => $_POST['custom_preferences'] ?? ''
        ];

        // Insertion dans MongoDB
            $prefService = new PreferenceService();
            $prefService->savePreferences((int)$vehicleId, $preferences);

        // Message de confirmation
        header('location:' . ROUTE_ACCOUNT);
        exit();
    }


    public function edit(int $vehicleId)
    {
        $vehicleRepo = new VehicleRepository($this->getDB());
        $vehicle = $vehicleRepo->getVehicle($vehicleId);

        $redirect = $_GET['redirect'] ?? null;

        return $this->view('vehicle.edit', [
            'vehicle' => $vehicle,
            'redirect' => $redirect
        ]);

        header('location: ' . ROUTE_ACCOUNT);
        exit();
    }


    public function update(int $vehicleId)
    {
        if (
            empty($_POST['registration']) ||
            empty($_POST['first_registration_date']) ||
            empty($_POST['brand']) ||
            empty($_POST['model']) ||
            empty($_POST['color']) ||
            !isset($_POST['energy'])
        ) {
            $_SESSION['errors'] = ["Tous les champs sont requis."];
            header('Location: /vehicle/' . $vehicleId . '/edit');
            exit();
        }

        $vehicleRepo = new VehicleRepository($this->getDB());
        $vehicleRepo->updateVehicle($vehicleId, [
            'registration' => $_POST['registration'],
            'first_registration_date' => $_POST['first_registration_date'],
            'brand' => $_POST['brand'],
            'model' => $_POST['model'],
            'color' => $_POST['color'],
            'nb_place' => $_POST['nb_place'],
            'energy' => (int) $_POST['energy']
        ]);
        
        $preferences = [
            'smoking' => isset($_POST['smoking']) ? (bool) $_POST['smoking'] : false,
            'pets' => isset($_POST['pets']) ? (bool) $_POST['pets'] : false,
            'custom' => $_POST['custom_preferences'] ?? ''
        ];

        $prefService = new PreferenceService();
        $prefService->savePreferences($vehicleId, $preferences);

        $_SESSION['success'] = ["Véhicule mis à jour avec succès"];

        if(!empty($_POST['redirect'])){
            $redirectTo = '/' . trim($_POST['redirect'], '/');
            header('Location: ' . $redirectTo);
            exit();
        } else {
            header('location:' . ROUTE_ACCOUNT);
            exit();
        }
    }

    public function delete(int $vehicleId)
    {
        $auth = new AuthService();
        $userId = $auth->getCurrentUserId();
        
        $vehicleRepo = new VehicleRepository($this->getDB());

        if($vehicleRepo->isUsedInCarshare($vehicleId))
        {
            $_SESSION['errors'] = ["Ce véhicule est utilisé dans un trajet et ne peut être supprimé"];
            header('location: ' . ROUTE_ACCOUNT);
            exit();
        }

        $deleted = $vehicleRepo->deleteVehicle($vehicleId, $userId);

        if ($deleted) {
            $_SESSION['success'] = ["Véhicule supprimé avec succès."];
        } else {
            $_SESSION['errors'] = ["Erreur lors de la suppression du véhicule."];
        }

        header('location: ' . ROUTE_ACCOUNT);
        exit();
    }

}