<?php

namespace Router;

class Router{

    public $url;
    public $routes = [];

    public function __construct($url)
    {
        $this->url = trim($url, "/");
        $this->routes['GET'] = [];
        $this->routes['POST'] = [];
    }

    public function get(string $path, string $action)
    {
        $this->routes['GET'][] = new Route($path, $action);
    }

    public function post(string $path, string $action)
{
    $this->routes['POST'][] = new Route($path, $action);
}


    public function run()
    {
        $method = $_SERVER['REQUEST_METHOD'];

        if(!isset($this->routes[$method])){
        http_response_code(404);
        echo "404 not found";
        return;
        }

        foreach ($this->routes[$method] as $route) {
            if ($route->matches($this->url)) {
                file_put_contents('/tmp/route_matched.txt', "Route matchée : " . $this->url . "\n", FILE_APPEND);
                $route->execute();
                return;
            }
        }
        file_put_contents('/tmp/route_matched.txt', "Aucune route matchée pour : " . $this->url . "\n", FILE_APPEND);
        
    }

}