<?php

namespace App\Controllers;

use App\middleware\AuthMiddleware;

class AdminController extends Controller
{
    public function dashboard()
    {
        AuthMiddleware::requireAdmin();
        return $this->view('admin.dashboard', [], 'layout/admin');
    }
}
