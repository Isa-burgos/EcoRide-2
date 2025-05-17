<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Validation\Validator;
use App\middleware\AuthMiddleware;
use App\Repositories\AdminRepository;
use App\Repositories\CarshareRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\UserRepository;

class AdminController extends Controller
{
    public function dashboard()
    {
        AuthMiddleware::requireAdmin();
        
        $carshareRepo = new CarshareRepository($this->getDB());
        $paymentRepo = new PaymentRepository($this->getDB());
        
        $ridesPerDay = $carshareRepo->getRidesPerDay();
        $creditsPerDay= $paymentRepo->getCreditsPerDay();
        
        return $this->view('admin.dashboard', [
            'ridesPerDay' => $ridesPerDay,
            'creditsPerDay' => $creditsPerDay
        ], 'layout/admin');
    }

    public function createEmploye()
    {
        AuthMiddleware::requireAdmin();
        return $this->view('admin.employes', [], 'layout/admin');
    }

    public function store()
    {
        AuthMiddleware::requireAdmin();

        $validator = new Validator($_POST);
        $validator->validate([
            'name' => ['required', 'min:3'],
            'firstname' => ['required', 'min:3'],
            'adress' => ['required'],
            'phone' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'password'],
        ]);

        if(
            empty($_POST['name']) ||
            empty($_POST['firstname']) ||
            empty($_POST['adress']) ||
            empty($_POST['phone']) ||
            empty($_POST['email']) ||
            empty($_POST['password'])
        ){
            $_SESSION['errors'] = "Tous les champs sont requis";
            header('location: '. ROUTE_DASHBOARD_EMPLOYES);
            exit();
        }

        $userRepo = new UserRepository($this->getDB());

        $user = new UserModel();
        $user->setName($_POST['name']);
        $user->setFirstname($_POST['firstname']);
        $user->setEmail($_POST['email']);
        $user->setPassword($_POST['password']);
        $user->setPhone($_POST['phone'] ?? '');
        $user->setAdress($_POST['adress'] ?? '');
        $user->setRole($_POST['role'] ?? 'employe');

        $userId = $userRepo->createUser($user);

        if(!$userId){
            $_SESSION['errors'] = "Erreur lors de l'ajout de l'employé";
            header('location: ' . ROUTE_DASHBOARD_EMPLOYES);
            exit();
        }

        $_SESSION['success'] = "Employé ajouté avec succès";
        header('location: ' . ROUTE_DASHBOARD_EMPLOYES);
        exit();
    }

    public function indexEmployes()
    {
        AuthMiddleware::requireAdmin();

        $adminRepo = new AdminRepository($this->getDB());
        $employes = $adminRepo->getAllEmployes();

        return $this->view('admin.employes', ['employes' => $employes], 'layout/admin');
    }

    public function indexUsers()
    {
        AuthMiddleware::requireAdmin();

        $userRepo = new UserRepository($this->getDB());
        $users = $userRepo->getAllUsers();

        return $this->view('admin.users', ['users' => $users], 'layout/admin');


    }

    public function edit(int $userId)
    {
        AuthMiddleware::requireAdmin();

        $adminRepo = new AdminRepository($this->getDB());
        $employe = $adminRepo->getEmployeById($userId);

        if(!$employe){
            $_SESSION['errors'] = "Cet employé n'existe pas";
            header('location: ' . ROUTE_DASHBOARD_EMPLOYES);
            exit();
        }

        return $this->view('admin.edit', [
            'employe' => $employe,
        ],
        'layout/admin');
    }

    public function update(int $userId)
    {
        if(
            empty($_POST['name']) ||
            empty($_POST['firstname']) ||
            empty($_POST['adress']) ||
            empty($_POST['phone']) ||
            empty($_POST['email'])
        ){
            $_SESSION['errors'] = "Tous les champs sont requis";
            header('location: /admin/edit/' . $userId);
            exit();
        }

        $adminRepo = new AdminRepository($this->getDB());
        $adminRepo->updateEmploye($userId, [
            'name' => $_POST['name'],
            'firstname' => $_POST['firstname'],
            'adress' => $_POST['adress'],
            'phone' => $_POST['phone'],
            'email' => $_POST['email'],
        ]);

        $_SESSION['success'] = "Employé mis à jour avec succès";
        header('location: ' . ROUTE_DASHBOARD_EMPLOYES);
        exit();
    }

    public function suspend(int $userId)
    {
        AuthMiddleware::requireAdmin();

        $userRepo = new UserRepository($this->getDB());
        $userRepo->suspendUser($userId);

        $referer = $_SERVER['HTTP_REFERER'] ?? '/admin/dashboard';

        $_SESSION['success'] = "Utilisateur suspendu avec succès";
        header('Location: ' . $referer);
        exit();

    }

    public function reactivate(int $userId)
    {
        AuthMiddleware::requireAdmin();

        $userRepo = new UserRepository($this->getDB());
        $userRepo->reactivateUser($userId);

        $referer = $_SERVER['HTTP_REFERER'] ?? '/admin/dashboard';

        $_SESSION['success'] = "Utilisateur réactivé avec succès";
        header('Location: ' . $referer);
        exit();
    }

    public function deleteEmploye(int $userId)
    {
        AuthMiddleware::requireAdmin();

        $adminRepo = new AdminRepository($this->getDB());
        $deleted = $adminRepo->deleteEmploye($userId);

        if($deleted){
            $_SESSION['success'] = "Employé supprimé avec succès";
        } else {
            $_SESSION['error'] = "Un problème est survenu lors de la suppression de cet employé";
        }

        header('location: '. ROUTE_DASHBOARD_EMPLOYES);
        exit();
    }

    public function deleteUser(int $userId)
    {
        AuthMiddleware::requireAdmin();

        $userRepo = new UserRepository($this->getDB());
        $deleted = $userRepo->deleteUser($userId);

        if($deleted){
            $_SESSION['success'] = "Utilisateur supprimé avec succès";
        } else {
            $_SESSION['error'] = "Un problème est survenu lors de la suppression de cet utilisateur";
        }

        header('location: '. ROUTE_DASHBOARD_EMPLOYES);
        exit();
    }
}
