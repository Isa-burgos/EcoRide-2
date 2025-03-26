<?php

ob_start();

$session_lifetime = 3600;


if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => $session_lifetime,
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Strict'
    ]);
    session_start();
}

if (!headers_sent() && isset($_SESSION['user'])) {
    setcookie(session_name(), session_id(), [
        'expires' => time() + $session_lifetime,
        'path' => "/",
        'httponly' => true,
        'samesite' => 'Strict'
    ]);
}

ob_end_flush();