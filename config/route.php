<?php

class RouteItem {
    private string $uri;
    private string $method;
    private string $controller;
    private string $function;
    private array $middleware;

    public function __construct(string $method, string $uri, string $controller, string $function, array $middleware)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->controller = $controller;
        $this->function = $function;
        $this->middleware = $middleware;
    }

    public function name(string $name): void
    {
        Route::registerNamedRoute($name, $this->uri);
    }
}

class Route
{
    private static array $routes = [];
    private static array $groupMiddleware = [];
    private static array $namedRoutes = [];

    // Mendukung GET
    public static function get(string $uri, $controller, $function = null): RouteItem
    {
        if (is_array($controller)) {
            [$controllerClass, $method] = $controller;
            return self::addRoute('GET', $uri, $controllerClass, $method);
        }

        return self::addRoute('GET', $uri, $controller, $function);
    }

    // Mendukung POST
    public static function post(string $uri, $controller, $function = null): RouteItem
    {
        if (is_array($controller)) {
            [$controllerClass, $method] = $controller;
            return self::addRoute('POST', $uri, $controllerClass, $method);
        }

        return self::addRoute('POST', $uri, $controller, $function);
    }

    // Grup Middleware
    public static function middleware(array $middleware)
    {
        self::$groupMiddleware = $middleware;

        return new class {
            public function group(callable $callback)
            {
                $callback();
                Route::clearGroupMiddleware();
            }
        };
    }

    // Menambahkan route
    private static function addRoute(string $method, string $uri, string $controller, string $function): RouteItem
    {
        $route = [
            'method' => $method,
            'controller' => $controller,
            'function' => $function,
            'middleware' => self::$groupMiddleware,
            'uri' => $uri
        ];

        self::$routes[$uri] = $route;

        return new RouteItem($method, $uri, $controller, $function, self::$groupMiddleware);
    }

    // Registrasi nama route
    public static function registerNamedRoute(string $name, string $uri)
    {
        self::$namedRoutes[$name] = $uri;
    }

    // Ambil URI dari nama
    public static function getUriByName(string $name): ?string
    {
        return self::$namedRoutes[$name] ?? null;
    }

    // Reset middleware
    public static function clearGroupMiddleware()
    {
        self::$groupMiddleware = [];
    }

    // Ambil semua routes
    public static function all(): array
    {
        return self::$routes;
    }
}