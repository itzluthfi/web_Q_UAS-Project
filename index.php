<?php
session_start();
require_once 'config/database.php';
require_once 'config/route.php'; // File class Route
require_once 'config/helper.php'; // File class Helper 
require_once 'routes.php';       // File definisi route

// Autoload controller, model, middleware
spl_autoload_register(function ($class) {
    foreach (['app/controllers/', 'app/models/', 'app/middleware/'] as $dir) {
        $file = $dir . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

$base = '/anime-list-uas'; // Ganti sesuai subfolder kamu
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = str_replace($base, '', $uri);
$uri = rtrim($uri, '/') ?: '/';

$httpMethod = $_SERVER['REQUEST_METHOD'];
$routes = Route::all();

$found = false;

foreach ($routes as $route => $info) {
    // Ubah {param} ke regex (contoh: /anime/show/{id} -> /anime/show/([\w-]+))
    $pattern = preg_replace('#\{[\w]+\}#', '([\w-]+)', $route);

    // Jangan rtrim '/' untuk root
    if ($route !== '/') {
        $pattern = rtrim($pattern, '/');
    }

    $pattern = '#^' . $pattern . '$#';

    if (preg_match($pattern, $uri, $matches)) {
        // Cek method HTTP
        if (isset($info['method']) && strtoupper($info['method']) !== $httpMethod) {
            continue;
        }

        array_shift($matches); // hapus full match dari array

        // Jalankan semua middleware
        if (isset($info['middleware'])) {
            $middlewares = is_array($info['middleware']) ? $info['middleware'] : [$info['middleware']];
            foreach ($middlewares as $middlewareClass) {
                if (class_exists($middlewareClass) && method_exists($middlewareClass, 'handle')) {
                    $middlewareClass::handle();
                } else {
                    echo "Middleware $middlewareClass tidak valid.<br>";
                    exit;
                }
            }
        }

        $controllerName = $info['controller'];
        $function = $info['function'];

        $controller = new $controllerName();

        if (method_exists($controller, $function)) {
            call_user_func_array([$controller, $function], $matches);
            $found = true;
            break;
        } else {
            echo "Function $function tidak ditemukan di $controllerName.";
            exit;
        }
    }
}

if (!$found) {
    http_response_code(404);
    require 'app/views/errors/404.php';
    exit;
}