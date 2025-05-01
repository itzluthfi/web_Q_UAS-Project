<?php
session_start();
require_once 'config/database.php';
$routes = require __DIR__ . '/routes.php';


spl_autoload_register(function ($class) {
    if (file_exists("app/controllers/$class.php")) {
        require_once "app/controllers/$class.php";
    } elseif (file_exists("app/models/$class.php")) {
        require_once "app/models/$class.php";
    }
});

// Tangkap URI
$base = '/anime-list-uas';
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = str_replace($base, '', $uri);
$uri = rtrim($uri, '/');
$uri = $uri === '' ? '/' : $uri;


// Routing
if (array_key_exists($uri, $routes)) {
    $controllerName = $routes[$uri]['controller'];
    $method = $routes[$uri]['method'];

    $controller = new $controllerName();
    if (method_exists($controller, $method)) {
        $controller->$method();
    } else {
        echo "Method $method tidak ditemukan di $controllerName.";
    }
} else {
    http_response_code(404);
    echo "404 - Halaman tidak ditemukan";
}