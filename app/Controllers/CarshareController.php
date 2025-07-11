<?php

namespace App\Controllers;

use App\middleware\AuthMiddleware;
use App\Repositories\CarshareRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\ReservationRepository;
use App\Repositories\UserRepository;
use App\Repositories\VehicleRepository;
use App\Services\AuthService;
use App\Services\PreferenceService;

class CarshareController extends Controller{

    public function create()
    {
        AuthMiddleware::requireAuth();
        
        $auth = new AuthService($this->db);
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
        $auth = new AuthService($this->db);
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
            empty($_POST['used_vehicle'])
        ){
            $_SESSION['error'] = "Veuillez remplir tous les champs";
            header('location: ' . ROUTE_CARSHARE);
            exit();
        }

        if($_POST['depart_date'] && $_POST['depart_date'] < date('Y-m-d')){
            $_SESSION['errors'] = "Vous ne pouvez pas choisir une date antérieure à la date du jour";
            header('location: ' . ROUTE_CARSHARE_SEARCH);
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

        $carshare = $carshareRepo->createCarshare($carshareData);

        if (!$carshare) {
            $_SESSION['error'] = "Erreur lors de l'enregistrement du trajet";
            header('location: ' . ROUTE_CARSHARE);
            exit();
        }

        $sql = "INSERT INTO user_carshare (user_id, carshare_id, role) VALUES (:user_id, :carshare_id, :role)";
        $stmt = $this->getDB()->getPDO()->prepare($sql);
        $stmt->execute([
            ':user_id' => $userId,
            ':carshare_id' => $carshare->getCarshareId(),
            ':role' => 'conducteur'
        ]);

        $_SESSION['success'] = "Trajet créé avec succès";
        header('location:' . ROUTE_HISTORY);
        exit();
    }

    public function show(int $carshareId)
    {
        AuthMiddleware::requireAuth();
        $auth = new AuthService($this->db);
        $userId = $auth->getCurrentUserId();

        $carshareRepo = new CarshareRepository($this->getDB());
        $trip = $carshareRepo->getCarshareDetails($carshareId);

        if(!$trip || $trip->getUserId() !== $userId){
            $_SESSION['error'] = "Trajet introuvable ou accès non autorisé";
            header('location: ' . ROUTE_HISTORY);
            exit();
        }

        $passengers = $carshareRepo->getPassengers($carshareId);

        return $this->view('carshare.show', [
            'trip' => $trip,
            'passengers' => $passengers
        ]);
    }

    public function start(int $carshareId)
    {
        $carshareRepo = new CarshareRepository($this->getDB());
        $carshareRepo->updateStatut($carshareId, 'en cours');

        $_SESSION['success'] = "Le trajet a bien été lancé";
        header('location: /carshare/' . $carshareId);
        exit();
    }

    public function end(int $carshareId)
    {
        $carshareRepo = new CarshareRepository($this->getDb());
        $reservationRepo = new ReservationRepository($this->getDB());
        $userRepo = new UserRepository($this->getDB());
        $paymentRepo = new PaymentRepository($this->getDB());

        $carshare = $carshareRepo->getCarshare($carshareId);

        if(!$carshare){
            $_SESSION['errors'] = "Trajet introuvable";
            header('location: /carshare/' . $carshareId);
            exit();
        }

        $pricePerPerson = $carshare->getPricePerson();
        $driverId = $carshare->getConducteurId();

        $reservations = $reservationRepo->getReservationsByCarshare($carshareId);
        $totalCreditsForDriver = 0;

        foreach($reservations as $reservation){
            $passengerId = $reservation->getUserId();
            $reservedPlaces = $reservation->getReservedPlaces();
            $amountToPay = $reservedPlaces * $pricePerPerson;

            $userRepo->debitCredits($passengerId, $amountToPay);
            $paymentRepo->log($passengerId, $carshareId, $amountToPay, 'payment');

            $totalCreditsForDriver += $amountToPay;
        }

        $userRepo->creditCredits($driverId, $totalCreditsForDriver - 2);
        $paymentRepo->log($driverId, $carshareId, $totalCreditsForDriver - 2, 'revenue');

        $adminId = $userRepo->getAdminId();

        if($adminId){
            $userRepo->creditCredits($adminId, 2);
            $paymentRepo->log($adminId, $carshareId, 2, 'commission');
        }

        $carshareRepo->updateStatut($carshareId, 'terminé');

        $_SESSION['success'] = "Le trajet est terminé";
        header('location: /carshare/' . $carshareId);
        exit();
    }

    public function cancel(int $carshareId)
    {
        $carshareRepo = new CarshareRepository($this->getDb());
        $carshareRepo->updateStatut($carshareId, 'annulé');

        $_SESSION['success'] = "Le trajet a bien été annulé";
        header('location: /carshare/' . $carshareId);
        exit();
    }

    public function edit(int $carshareId)
    {
        AuthMiddleware::requireAuth();

        $auth = new AuthService($this->db);
        $userId = $auth->getCurrentUserId();
        
        $carshareRepo = new CarshareRepository($this->getDB());
        $carshare = $carshareRepo->getCarshare($carshareId);

        if (!$carshare || $carshare->getConducteurId() !== $userId) {
            $_SESSION['error'] = "Ce trajet n'existe pas.";
            header('Location: ' . ROUTE_HISTORY);
            exit();
        }

        $vehicleRepo = new VehicleRepository($this->getDB());
        $userVehicles = $vehicleRepo->getAllByUser($userId);

        $prefService = new PreferenceService();
        $vehiclePreferences = [];

        foreach($userVehicles as $v){
            $vehiclePreferences[$v->getVehicleId()] = $prefService->getPreferencesByVehicle($v->getVehicleId());
        }

        $redirect = $_GET['redirect'] ?? null;

        return $this->view('carshare.edit', [
            'carshare' => $carshare,
            'redirect' => $redirect,
            'userVehicles' => $userVehicles,
            'vehiclePreferences' => $vehiclePreferences
        ]);
    }

    public function update(int $carshareId)
    {
        if (
            empty($_POST['price_person']) ||
            empty($_POST['depart_adress']) ||
            empty($_POST['arrival_adress']) ||
            empty($_POST['depart_time']) ||
            empty($_POST['arrival_time']) ||
            empty($_POST['used_vehicle'])

        ) {
            $_SESSION['error'] = ["Tous les champs sont requis."];
            header('Location: /carshare/' . $carshareId . '/edit');
            exit();
        }

        $carshareRepo = new CarshareRepository($this->getDb());
        $carshareRepo->updateCarshare($carshareId, [
            'price_person' => $_POST['price_person'],
            'depart_adress' => $_POST['depart_adress'],
            'arrival_adress' => $_POST['arrival_adress'],
            'depart_time' => $_POST['depart_time'],
            'arrival_time' => $_POST['arrival_time'],
            'used_vehicle' => $_POST['used_vehicle']
        ]);

        $_SESSION['success'] = "Le trajet a été mis à jour avec succès";
        header('Location: ' . ROUTE_HISTORY);
        exit();
    }

    public function delete(int $carshareId)
    {
        $auth = new AuthService($this->db);
        $userId = $auth->getCurrentUserId();

        $carshareRepo = new CarshareRepository($this->getDB());

        $deleted = $carshareRepo->deleteCarshare($carshareId, $userId);

        if($deleted){
            $_SESSION['success'] = "Trajet supprimé avec succès";
        } else {
            $_SESSION['error'] = "Erreur lors de la suppression du trajet";
        }

        header('location: ' . ROUTE_HISTORY);
        exit();
    }

    public function search()
    {
        $depart = $_GET['depart_adress'] ?? null;
        $arrival = $_GET['arrival_adress'] ?? null;
        $date = $_GET['depart_date'] ?? null;
        $passenger = (int) ($_GET['nb_place'] ?? 1);

        if($depart && $arrival && $date){
            $query = http_build_query([
                'depart_adress' => $depart,
                'arrival_adress' => $arrival,
                'depart_date' => $date,
                'nb_place' => $passenger
            ]) ;
            header('location: ' . ROUTE_CARSHARE_RESULTS . '?' . $query);
            exit();
        }

        if($date && $date < date('Y-m-d')){
            $_SESSION['errors'] = "Vous ne pouvez pas choisir une date antérieure à la date du jour";
            header('location: ' . ROUTE_CARSHARE_SEARCH);
            exit();
        }

        return $this->view('carshare.search',[
            'depart_adress' => $depart,
            'arrival_adress' => $arrival,
            'depart_date' => $date,
            'nb_place' => $passenger
        ]);
    }

    public function results()
    {
        $depart = $_GET['depart_adress'] ?? null;
        $arrival = $_GET['arrival_adress'] ?? null;
        $date = $_GET['depart_date'] ?? null;
        $passenger = (int)($_GET['nb_place'] ?? 1);
        $sort = $_GET['sort'] ?? null;
        $time = $_GET['time'] ?? [];
        $services = $_GET['services'] ?? [];
        
        if(!$depart || !$arrival || !$date){
            return $this->view('carshare.results', [
                'results' => [],
                'depart_adress' => '',
                'arrival_adress' => '',
                'depart_date' => '',
                'nb_place' => 1,
                'error' => "Veuillez remplir tous les champs obligatoires."
            ]);
        }
        
        $carshareRepo = new CarshareRepository($this->getDB());
        $results = $carshareRepo->searchCarshares($depart, $arrival, $date, $passenger, $time, $services, $sort);

        $reservationRepo = new ReservationRepository($this->getDB());
        $vehicleRepo = new VehicleRepository($this->getDB());
        $prefService = new PreferenceService();

        foreach($results as $carshare){
            if(is_object($carshare)){
                $reserved = $reservationRepo->countReservedSeats($carshare->getCarshareId());
                $carshare->setNbPlace($carshare->getNbPlace() - $reserved);
                $vehicle = $vehicleRepo->getVehicle($carshare->getUsedVehicle());
                if($vehicle){
                    $preferences = $prefService->getPreferencesByVehicle($vehicle->getVehicleId());
                }

                $smoking = $preferences['smoking'] ?? false;
                $pets = $preferences['pets'] ?? false;

                $carshare->smoking_icon = $smoking
                    ? '/assets/icons/smoke.svg'
                    : '/assets/icons/no-smoking.svg';
    
                $carshare->pets_icon = $pets
                    ? '/assets/icons/pets.svg'
                    : '/assets/icons/no-pets.svg';

            }
        }

        return $this->view('carshare.results', [
            'results' => $results,
            'depart_adress' => $depart,
            'arrival_adress' => $arrival,
            'depart_date' => $date,
            'nb_place' => $passenger
        ]);
    }

    public function details(string|int $carshareId)
    {
        $carshareId = (int) $carshareId;

        $carshareRepo = new CarshareRepository($this->getDB());

        $trip = $carshareRepo->getCarshareDetails($carshareId);

        if(!$trip){
            $_SESSION['error'] = "Ce trajet n'existe pas.";
            header('location: ' . ROUTE_CARSHARE_SEARCH);
            exit();
        }

        return $this->view('carshare.details', [
            'trip' => $trip
        ]);
    }

}
