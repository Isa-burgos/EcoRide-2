<?php

namespace App\Controllers;

use App\Models\Vehicle;

class VehicleController extends Controller{

    public function create()
    {
        return $this->view('vehicle.create');
    }

    public function addVehicule()
    {
        $vehicleModel = new Vehicle($this->getDB());

        $vehicleModel->createVehicle([
            'registration' => $_POST['registration'],
            'first_registration_date' => $_POST['first_registration_date'],
            'brand' => $_POST['brand'],
            'model' => $_POST['model'],
            'color' => $_POST['color'],
            'energy' => $_POST['energy'],
            'user_id' => $_SESSION['user']['id']
        ]);

        header('location:' . ROUTE_ACCOUNT);
        exit();
    }


}