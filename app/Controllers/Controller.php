<?php

namespace App\Controllers;

use Database\DbConnect;

abstract class Controller{

    protected $db;

    public function __construct(DbConnect $db)
    {
        $this->db = $db;
    }

    protected function view(string $path, ?array $params = null)
    {
        ob_start();
        if($params){
            extract($params);
        }
        $path = str_replace('.', DIRECTORY_SEPARATOR, $path);
        require_once VIEWS . $path . '.php';
        $pageContent = ob_get_clean();
        require VIEWS . 'layout.php';
    }

    protected function getDB()
    {
        return $this->db;
    }

    protected function isUserConnected(): bool{
        
        return isset($_SESSION['user']);
    }
}