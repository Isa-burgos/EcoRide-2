<?php

namespace App\Controllers;

use App\Repositories\VehicleRepository;
use App\Services\AuthService;

class VehicleController extends Controller{

    public function create()
    {
        return $this->view('vehicle.create');
    }

    public function store()
    {
        $auth = new AuthService();
        $userId = $auth->getCurrentUserId();

        $vehicleRepo = new VehicleRepository($this->getDb());

        $vehicleData = [
            'registration' => $_POST['registration'],
            'first_registration_date' => $_POST['first_registration_date'],
            'brand' => $_POST['brand'],
            'model' => $_POST['model'],
            'color' => $_POST['color'],
            'energy' => (int) $_POST['energy'],
            'user_id' => $userId
        ];

        $vehicleRepo->createVehicle($vehicleData);

        header('location:' . ROUTE_ACCOUNT);
        exit();
    }

    public function edit(int $vehicleId)
    {
        $vehicleRepo = new VehicleRepository($this->getDB());
        $vehicle = $vehicleRepo->getVehicle($vehicleId);

        return $this->view('vehicle.edit', [
            'vehicle' => $vehicle
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
            $_SESSION['error'] = ["Tous les champs sont requis."];
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
            'energy' => (int) $_POST['energy']
        ]);

        $_SESSION['success'] = ["Véhicule mis à jour avec succès"];
        header('Location: ' . ROUTE_ACCOUNT);
        exit();
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
            $_SESSION['error'] = ["Erreur lors de la suppression du véhicule."];
        }

        header('location: ' . ROUTE_ACCOUNT);
        exit();
    }


}