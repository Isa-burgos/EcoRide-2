<?php

namespace App\middleware;

class CsrfMiddleware
{
    public static function verify(): void
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $token = $_POST['csrf_token'] ?? null;
            $sessionToken = $_SESSION['csrf_token'] ?? null;

            if(!self::isValid($token)){
                http_response_code(403);
                ob_clean();
                require_once __DIR__ . '/../../views/errors/csrf.php';
                exit();
            }
        }
    }

    public static function generate(): string
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function isValid(?string $token): bool
    {
        $sessionToken = $_SESSION['csrf_token'] ?? null;

        if(!$token || !$sessionToken || !hash_equals($token, $sessionToken)){
            return false;
        }

        unset($_SESSION['csrf_token']);
        return true;
    }

}
