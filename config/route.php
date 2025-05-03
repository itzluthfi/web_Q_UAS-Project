<?php

class RouteItem {
    private string $uri;           // URI yang mengidentifikasi route
    private string $method;        // Metode HTTP (GET, POST, dll)
    private string $controller;    // Nama controller yang menangani route ini
    private string $function;      // Nama fungsi dalam controller yang menangani route ini
    private array $middleware;     // Middleware yang diterapkan pada route ini

    // Konstruktor untuk mendefinisikan route baru
    public function __construct(string $method, string $uri, string $controller, string $function, array $middleware)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->controller = $controller;
        $this->function = $function;
        $this->middleware = $middleware;
    }

    // Menambahkan nama untuk route ini
    public function name(string $name): void
    {
        Route::registerNamedRoute($name, $this->uri);
    }
}

class Route
{
    private static array $routes = [];             // Menyimpan semua rute yang telah didefinisikan
    private static array $groupMiddleware = [];    // Menyimpan middleware yang diterapkan untuk grup rute tertentu
    private static array $namedRoutes = [];        // Menyimpan rute yang sudah diberi nama

    // Mendukung route GET
    public static function get(string $uri, $controller, $function = null): RouteItem
    {
        if (is_array($controller)) {
            // Mendukung pemanggilan controller dengan array (misalnya [Controller::class, 'method'])
            [$controllerClass, $method] = $controller;
            return self::addRoute('GET', $uri, $controllerClass, $method);
        }

        return self::addRoute('GET', $uri, $controller, $function);
    }

    // Mendukung route POST
    public static function post(string $uri, $controller, $function = null): RouteItem
    {
        if (is_array($controller)) {
            // Mendukung pemanggilan controller dengan array (misalnya [Controller::class, 'method'])
            [$controllerClass, $method] = $controller;
            return self::addRoute('POST', $uri, $controllerClass, $method);
        }

        return self::addRoute('POST', $uri, $controller, $function);
    }

    // Mendefinisikan grup middleware
    public static function middleware(array $middleware)
    {
        self::$groupMiddleware = $middleware;

        // Mengembalikan objek anonim untuk membungkus grup route
        return new class {
            public function group(callable $callback)
            {
                // Menjalankan callback untuk mendefinisikan grup route
                $callback();
                // Reset middleware setelah grup selesai
                Route::clearGroupMiddleware();
            }
        };
    }

    // Menambahkan route ke dalam daftar
    private static function addRoute(string $method, string $uri, string $controller, string $function): RouteItem
    {
        // Menambahkan route baru ke dalam array $routes
        $route = [
            'method' => $method,
            'controller' => $controller,
            'function' => $function,
            'middleware' => self::$groupMiddleware,
            'uri' => $uri
        ];

        // Menyimpan route dengan URI sebagai key
        self::$routes[$uri] = $route;

        // Mengembalikan objek RouteItem untuk route ini
        return new RouteItem($method, $uri, $controller, $function, self::$groupMiddleware);
    }

    // Mendaftarkan nama route
    public static function registerNamedRoute(string $name, string $uri)
    {
        self::$namedRoutes[$name] = $uri;
    }

    // Mengambil URI dari nama route
    public static function getUriByName(string $name): ?string
    {
        return self::$namedRoutes[$name] ?? null;
    }

    // Menghapus middleware grup setelah selesai
    public static function clearGroupMiddleware()
    {
        self::$groupMiddleware = [];
    }

    // Mengambil semua routes yang terdaftar
    public static function all(): array
    {
        return self::$routes;
    }
}