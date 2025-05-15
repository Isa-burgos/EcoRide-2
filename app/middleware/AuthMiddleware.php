<?php

namespace App\middleware;

use App\Services\AuthService;
use Config\DbConnect;

class AuthMiddleware{

    private $db;

    public function __construct(DbConnect $db)
    {
        $this->db = $db;
    }

    public static function requireAuth(): void
    {
        if(!isset($_SESSION['user'])){
            $_SESSION['errors'] = "Vous devez être connecté pour accéder à cette page";
            header('location: ' . ROUTE_LOGIN);
            exit();
        }
    }

    public static function requireRole(string $role): void
    {
        if(!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== $role){
            $_SESSION['errors'] = "Accès refusé";
            header('location: ' . ROUTE_LOGIN);
            exit();
        }
    }

    public static function requireAdmin(): void
    {
        self::requireAuth();

        $auth = new AuthService(new DbConnect());
        $user = $auth->getCurrentUser();

        if($user->getRole() !== 'admin'){
            $_SESSION['errors'] = "Accès réservé à l'administrateur";
            header('location: ' . ROUTE_HOME);
            exit();
        }
    }

}