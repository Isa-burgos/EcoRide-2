<?php

namespace App\Controllers;

use App\Services\AuthService;
use App\middleware\AuthMiddleware;
use App\Models\CarshareModel;
use App\Services\PreferenceService;
use App\Repositories\CarshareRepository;
use App\Repositories\ReservationRepository;
use App\Repositories\UserRepository;
use App\Repositories\VehicleRepository;

class HistoryController extends Controller{

    public function index()
    {
        $auth = new AuthService($this->db);
        $userId = $auth->getCurrentUserId();

        if(!$userId){
            $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
            header('location: ' . ROUTE_HISTORY);
            exit();
        }

        $carshareRepo = new CarshareRepository($this->getDB());
        $vehicleRepo = new VehicleRepository($this->getDb());
        $userRepo = new UserRepository($this->getDB());

        $myTrips = $carshareRepo->getByDriver($userId);
        $joinedTrips = $carshareRepo->getByPassenger($userId);

        $prefService = new PreferenceService();
        $reservationRepo = new ReservationRepository($this->getDB());

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

        $currentUserId = $_SESSION['user']['user_id'];

        foreach($joinedTrips as &$trip){
            if (is_object($trip)){
                $vehicle = $vehicleRepo->getVehicle($trip->getUsedVehicle());
                $trip->setVehicle($vehicle);
                $trip->setReservedPlaces($reservationRepo->getReservedPlacesByUser($currentUserId, $trip->getCarshareId()));

                $trip->setConducteurId($trip->getUserId());
                $driver = $userRepo->getById($trip->getConducteurId());
                if($driver){
                    $trip->setDriver($driver);
                }

                $reservationId = $reservationRepo->getReservationByUserAndCarshare($currentUserId, $trip->getCarshareId());
                $trip->setReservationId($reservationId);

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