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
$uri = rtrim($uri, '/') ?: '/';
// echo "URI: $uri<br>";
// print_r($routes);


// Proses routing dengan dukungan parameter
$found = false;

foreach ($routes as $route => $info) {
    // Tangani root '/' secara eksplisit
    if ($route === $uri) {
        $controllerName = $info['controller'];
        $method = $info['method'];
        $controller = new $controllerName();

        if (method_exists($controller, $method)) {
            $controller->$method();
        } else {
            echo "Method $method tidak ditemukan di $controllerName.";
        }

        $found = true;
        break;
    }

    // Tangani route dinamis seperti /anime/show/{id}
    $pattern = preg_replace('#\{[\w]+\}#', '([\w-]+)', $route);
    $pattern = '#^' . rtrim($pattern, '/') . '$#';

    if (preg_match($pattern, $uri, $matches)) {
        array_shift($matches);

        $controllerName = $info['controller'];
        $method = $info['method'];
        $controller = new $controllerName();

        if (method_exists($controller, $method)) {
            call_user_func_array([$controller, $method], $matches);
        } else {
            echo "Method $method tidak ditemukan di $controllerName.";
        }

        $found = true;
        break;
    }
}

if (!$found) {
    echo "404 - Halaman tidak ditemukan.";
}