<?php

namespace App\Controllers;

use PDO;

class AppController extends Controller{

    public function home()
    {
        return $this->view('app.home');
    }

    public function login(string $email, string $password)
    {
        $stmt = $this->db->getPDO()->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->bindValue(":email", $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user && password_verify($password, $user['password'])){
            $_SESSION['user'] = $user;
        } else {
            return $this->view('auth.login',[
                'error' => 'Identifiant ou mot de passe incorrect'
            ]);
        }
        return $this->view('app.login');
    }

    public function dashboard()
    {
        return $this->view('app.dashboard');
    }

    public function index()
    {
        return $this->view('app.index');
    }

    public function show(int $userId)
    {
        return $this->view('app.show', compact('id'));
    }

    public function contact()
    {
        return $this->view('app.contact');
    }

    public function mentionsLegales()
    {
        return $this->view('app.mentions-legales');
    }

}