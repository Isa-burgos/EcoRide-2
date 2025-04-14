<?php

namespace App\Controllers;

use App\middleware\AuthMiddleware;
use App\Repositories\CarshareRepository;
use App\Repositories\VehicleRepository;
use App\Services\AuthService;
use App\Services\PreferenceService;

class CarshareController extends Controller{

    public function create()
    {
        AuthMiddleware::requireAuth();
        
        $auth = new AuthService();
        $userId = $auth->getCurrentUserId();
        
        if(!$userId){
            $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
            header('location: ' . ROUTE_LOGIN);
            exit();
        }
        
        $vehicleRepo = new VehicleRepository($this->getDB());
        $userVehicles = $vehicleRepo->getAllByUser($userId);

        $prefService = new PreferenceService();
        $vehiclePreferences = [];

        foreach($userVehicles as $v){
            $vehiclePreferences[$v->getVehicleId()] = $prefService->getPreferencesByVehicle($v->getVehicleId());
        }

        return $this->view('carshare.create', [
            'userVehicles' => $userVehicles,
            'vehiclePreferences' => $vehiclePreferences
        ]);
    }

    public function store()
    {
        $auth = new AuthService();
        $userId = $auth->getCurrentUserId();

        if(!$userId){
            $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
            header('location: ' . ROUTE_LOGIN);
            exit();
        }

        if(
            empty($_POST['depart_adress']) ||
            empty($_POST['arrival_adress']) ||
            empty($_POST['depart_date']) ||
            empty($_POST['hour']) ||
            empty($_POST['minute']) ||
            empty($_POST['arrival_time']) ||
            empty($_POST['statut']) ||
            empty($_POST['used_vehicle'])
        ){
            $_SESSION['error'] = "Veuillez remplir tous les champs";
            header('location: ' . ROUTE_CARSHARE);
            exit();
        }

        $departTime = sprintf(
            '%02d:%02d:00',
            intval($_POST['hour']),
            intval($_POST['minute'])
        );

        $carshareRepo = new CarshareRepository($this->getDB());
    
        $carshareData = [
            'price_person' => $_POST['price_person'],
            'depart_adress' => $_POST['depart_adress'],
            'arrival_adress' => $_POST['arrival_adress'],
            'depart_date' => $_POST['depart_date'],
            'depart_time' => $departTime,
            'arrival_time' => $_POST['arrival_time'],
            'statut' => 'créé',
            'used_vehicle' => $_POST['used_vehicle'],
        ];

        $result = $carshareRepo->createCarshare($carshareData);

        if (!$result) {
            $_SESSION['error'] = "Erreur lors de l'enregistrement du trajet";
        } else {
            $_SESSION['success'] = "Trajet ajouté avec succès";
        }
        header('location:' . ROUTE_HISTORY);
        exit();
    }

}
