<?php

namespace App\Controllers;

use App\Services\AuthService;
use App\middleware\AuthMiddleware;
use App\Services\PreferenceService;
use App\Repositories\CarshareRepository;
use App\Repositories\VehicleRepository;

class HistoryController extends Controller{

    public function index()
    {
        $auth = new AuthService();
        $userId = $auth->getCurrentUserId();

        if(!$userId){
            $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
            header('location: ' . ROUTE_HISTORY);
            exit();
        }

        $carshareRepo = new CarshareRepository($this->getDB());
        $vehicleRepo = new VehicleRepository($this->getDb());

        $myTrips = $carshareRepo->getByDriver($userId);
        $joinedTrips = $carshareRepo->getByPassenger($userId);

        $prefService = new PreferenceService();

        foreach($myTrips as &$trip){
            if (is_object($trip)){
                $vehicle = $vehicleRepo->getVehicle($trip->getUsedVehicle());
                $trip->setVehicle($vehicle);
                
                $preferences = $prefService->getPreferencesByVehicle($trip->getUsedVehicle());
    
                $smoking = $preferences['smoking'] ?? false;
                $pets = $preferences['pets'] ?? false;
                $custom = $preferences['custom'] ?? '';
    
                $trip->smoking_icon = $smoking
                    ? '/assets/icons/smoke.svg'
                    : '/assets/icons/no-smoking.svg';
    
                $trip->pets_icon = $pets
                    ? '/assets/icons/pets.svg'
                    : '/assets/icons/no-pets.svg';
    
                $trip->custom_preferences = $custom;

            }
        }

        foreach($joinedTrips as &$trip){
            if (is_object($trip)){
                $preferences = $prefService->getPreferencesByVehicle($trip->getUsedVehicle());
    
                $smoking = $preferences['smoking'] ?? false;
                $pets = $preferences['pets'] ?? false;
                $custom = $preferences['custom'] ?? '';
    
                $trip->smoking_icon = $smoking
                    ? '/assets/icons/smoke.svg'
                    : '/assets/icons/no-smoking.svg';
    
                $trip->pets_icon = $pets
                    ? '/assets/icons/pets.svg'
                    : '/assets/icons/no-pets.svg';
    
                $trip->custom_preferences = $custom;

            }
        }

        return $this->view('history.index', [
            'myTrips' => $myTrips,
            'joinedTrips' => $joinedTrips
        ]);
    }

}