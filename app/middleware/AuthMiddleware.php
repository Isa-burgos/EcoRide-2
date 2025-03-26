<?php

namespace App\middleware;

class AuthMiddleware{

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


}