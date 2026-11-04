<?php
namespace App\Core;
use PDO;

class Router {
    protected $routes = [];
    protected $pdo;

    // Menerima koneksi database
    public function __construct(PDO $pdo)
    { $this->pdo = $pdo; }

    // Mendaftarkan route GET atau POST
    public function add($method, $route, $controller, $action)
    {   $method = strtoupper($method);
        $route = trim($route, '/');

        $this->routes[$method][$route] = [
            'controller' => $controller,
            'action' => $action
        ];
    }

    // Mencocokkan URL dengan route
    public function dispatch($url, $method)
    {   $url = trim(parse_url($url, PHP_URL_PATH), '/');
        $method = strtoupper($method);

        $route = $this->routes[$method][$url] ?? null;

        if (!$route) {
            http_response_code(404);
            echo "404 - Halaman tidak ditemukan.";
            return;  }

        $controllerName = $route['controller'];
        $actionName = $route['action'];

        if (!class_exists($controllerName)) {
            http_response_code(500);
            echo "Controller tidak ditemukan.";
            return;   }

        // Mengirim koneksi PDO ke Controller
        $controller = new $controllerName($this->pdo);

        if (!method_exists($controller, $actionName)) {
            http_response_code(500);
            echo "Method tidak ditemukan.";
            return;   }

        return $controller->$actionName();
    }
}