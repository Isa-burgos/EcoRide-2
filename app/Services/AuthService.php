<?php

namespace App\Services;

use App\Models\UserModel;

class AuthService{

    /**
     * Store user info in session
     */

    public function login(UserModel $user): void
    {
        $_SESSION['user'] = [
            'user_id' => $user->getUserId(),
            'email' => $user->getEmail(),
            'pseudo' => $user->getPseudo(),
            'photo' => $user->getPhoto() ?? '/public/assets/img/default-ptofilr.png',
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

    /**
     * Check if a user is logged in
     */

    public function isLoggedIn(): bool
    {
        return isset($_SESSION['user']);
    }

}