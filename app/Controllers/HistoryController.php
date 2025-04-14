<?php

namespace App\Controllers;

use App\middleware\AuthMiddleware;
use App\Repositories\CarshareRepository;
use App\Services\AuthService;

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

        $myTrips = $carshareRepo->getByDriver($userId);
        $joinedTrips = $carshareRepo->getByPassenger($userId);

        return $this->view('history.index', [
            'myTrips' => $myTrips,
            'joinedTrips' => $joinedTrips
        ]);
    }

}