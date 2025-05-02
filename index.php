<?php
session_start();
require_once 'config/database.php';
$routes = require __DIR__ . '/routes.php';

// Autoload
spl_autoload_register(function ($class) {
    foreach (['app/controllers/', 'app/models/', 'app/middleware/'] as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

$base = '/anime-list-uas'; // Ubah sesuai folder kamu
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = str_replace($base, '', $uri);
$uri = rtrim($uri, '/') ?: '/';

// HTTP Method (GET, POST, etc)
$httpMethod = $_SERVER['REQUEST_METHOD'];

// Flatten group routes
$flattenedRoutes = [];

foreach ($routes as $key => $value) {
    if (isset($value['routes']) && isset($value['middleware'])) {
        foreach ($value['routes'] as $path => $info) {
            $infoMiddleware = isset($info['middleware']) ? $info['middleware'] : [];
            $mergedMiddleware = array_merge($value['middleware'], (array) $infoMiddleware);
            $info['middleware'] = $mergedMiddleware;
            $flattenedRoutes[$path] = $info;
        }
    } else {
        $flattenedRoutes[$key] = $value;
    }
}

// Routing
$found = false;

foreach ($flattenedRoutes as $route => $info) {
    $pattern = preg_replace('#\{[\w]+\}#', '([\w-]+)', $route);

    // Jika route adalah '/', jangan rtrim '/'
    if ($route !== '/') {
        $pattern = rtrim($pattern, '/');
    }

    $pattern = '#^' . $pattern . '$#';

    if (preg_match($pattern, $uri, $matches)) {
        // Check if HTTP method matches
        if (isset($info['method']) && strtoupper($info['method']) !== $httpMethod) {
            // Skip if method doesn't match
            continue;
        }

        array_shift($matches);

        // Jalankan middleware
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
        $function = $info['function']; // Menggunakan 'function' sekarang
        $controller = new $controllerName();

        if (method_exists($controller, $function)) {
            call_user_func_array([$controller, $function], $matches);
            $found = true;
            break;
        } else {
            echo "Function $function tidak ditemukan di $controllerName.";
        }
    }
}

if (!$found) {
    echo "404 - Halaman tidak ditemukan.";
}