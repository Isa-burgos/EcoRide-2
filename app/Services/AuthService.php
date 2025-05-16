<?php

namespace App\Services;

use App\Models\UserModel;
use App\Repositories\UserRepository;
use Config\DbConnect;

class AuthService{

    private $db;

    public function __construct(DbConnect $db)
    {
        $this->db = $db;
    }

    /**
     * Store user info in session
     */

    public function login(UserModel $user): void
    {
        if ($user->getIsActive() === 0) {
            $_SESSION['errors'] = "Votre compte est suspendu. Veuillez contacter un administrateur.";
            header('Location: ' . ROUTE_LOGIN);
            exit();
        }
        
        $_SESSION['user'] = [
            'user_id' => $user->getUserId(),
            'email' => $user->getEmail(),
            'pseudo' => $user->getPseudo(),
            'photo' => $user->getPhoto() ?? '/public/assets/img/default-ptofilr.png',
            'credit_balance' => $user->getCreditBalance(),
            'role' => $user->getRole()
        ];

        session_write_close();
        
    }

    /**
     * Destroy the session
     */

    public function logout(): void
    {
        session_destroy();
    }

    /**
     * Get the logged-in user ID
     */

    public function getCurrentUserId(): ?int
    {
        return $_SESSION['user']['user_id'] ?? null;
    }

    public function getCurrentUser(): ?UserModel
    {
        if (!isset($_SESSION['user']['user_id'])) {
            return null;
        }

        if (isset($_SESSION['current_user']) && $_SESSION['current_user'] instanceof UserModel) {
            return $_SESSION['current_user'];
        }

        $userRepo = new UserRepository($this->db);
        $user = $userRepo->getById($_SESSION['user']['user_id']);

        $_SESSION['current_user'] = $user;

        return $user;
    }

    /**
     * Check if a user is logged in
     */

    public function isLoggedIn(): bool
    {
        return isset($_SESSION['user']);
    }

}