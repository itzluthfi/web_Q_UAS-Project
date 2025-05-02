<?php
//Group middleware 😏
return [
    // Guest only
    [
        'middleware' => ['GuestMiddleware'],
        'routes' => [
            '/login' => ['controller' => 'AuthController', 'method' => 'loginForm'],
            '/login/submit' => ['controller' => 'AuthController', 'method' => 'login'],
            '/register' => ['controller' => 'AuthController', 'method' => 'registerForm'],
            '/register/submit' => ['controller' => 'AuthController', 'method' => 'register'],
        ]
    ],

    // Admin only
    [
        'middleware' => ['AuthMiddleware', 'AdminMiddleware'],
        'routes' => [
            '/admin/users' => ['controller' => 'AdminController', 'method' => 'manageUsers'],
            '/anime/show/{id}' => ['controller' => 'AnimeController', 'method' => 'show'],

        ]
    ],

    // Authenticated users 
    [
        'middleware' => ['AuthMiddleware'],
        'routes' => [
            '/logout' => ['controller' => 'AuthController', 'method' => 'logout'],
        ]
    ],

    // Public (no middleware)
    [
        'middleware' => [],
        'routes' => [
            '/' => ['controller' => 'AnimeController', 'method' => 'index'],
        ]
    ]
];