<?php

namespace App\Controllers;

use App\Repositories\CarshareRepository;
use App\Repositories\ReservationRepository;
use App\Repositories\VehicleRepository;
use App\Services\AuthService;

class ReservationController extends Controller{

    public function reserve(int $carshareId)
    {
        if (!isset($_SESSION['user']['user_id'])){
            header('location: ' . ROUTE_LOGIN);
            exit();
        }
        $userId = $_SESSION['user']['user_id'];

        $reservationRepo = new ReservationRepository($this->getDB());

        if($reservationRepo->isAlreadyReserved($userId, $carshareId)){
            $_SESSION['errors'] = "Vous avez déjà réservé ce trajet";
            header('Location: /carshare/' . $carshareId . '/details');
            exit();
        }

        $carshareRepo = new CarshareRepository($this->getDB());
        $carshare = $carshareRepo->getCarshare($carshareId);

        if(!$carshare){
            $_SESSION['errors'] = "Trajet introuvable";
            header('Location: ' . ROUTE_CARSHARE_SEARCH);
            exit();
        }

        $vehicleId = $carshare->getUsedVehicle();

        $vehicleRepo = new VehicleRepository($this->getDB());
        $vehicle = $vehicleRepo->getVehicle($vehicleId);

        if(!$vehicle){
            $_SESSION['errors'] = "Véhicule introuvable";
            header('Location: ' . ROUTE_CARSHARE_SEARCH);
            exit();
        }

        $requestedPlaces = isset($_POST['number_of_passengers']) ? (int) $_POST['number_of_passengers'] : 1;

        $availablePlaces = $vehicle->getNbPlace();
        $reservedPlaces = $reservationRepo->countReservedSeats($carshareId);
        $remainingPlaces = $availablePlaces - $reservedPlaces;

        if ($requestedPlaces > $remainingPlaces) {
            $_SESSION['errors'] = "Il ne reste que $remainingPlaces place(s) disponible(s) pour ce trajet.";
            header("Location: /carshare/$carshareId/details");
            exit();
        }

        $reservationCount = $reservationRepo->countReservation($carshareId);

        if($reservationCount >= $availablePlaces){
            $_SESSION['errors'] = "désolé, ce trajet est complet";
            header('Location: /carshare/' . $carshareId . '/details');
            exit();
        }

        if($reservationRepo->reserve($userId, $carshareId, $requestedPlaces)){
            $_SESSION['success'] = "Réservation confirmée";
            header('Location: /carshare/' . $carshareId . '/details');
            exit();
        } else {
            $_SESSION['errors'] = "Erreur lors de la réservation";
            header('Location: /carshare/' . $carshareId . '/details');
            exit();
        }
    }

    public function cancelReservation(int $reservationId)
    {
        $auth = new AuthService($this->getDB());
        $user = $auth->getCurrentUser();
        $userId = $user->getUserId();

        if(!$userId){
            $_SESSION['errors'] = "Vous devez être connecté(e) pour annuler une réservation";
            header('location: ' . ROUTE_LOGIN);
            exit();
        }

        $reservationRepo = new ReservationRepository($this->getDB());
        $success = $reservationRepo->deleteReservation($reservationId, $userId);

        if($success){
            $_SESSION['success'] = "Votre réservation a été annulée";
        } else {
            $_SESSION['errors'] = "Impossible d'annuler la réservation";
        }

        header('location: ' . ROUTE_HISTORY);
        exit();
    }

}