<?php
    // Group middleware
return [
    // Guest only
    [
        'middleware' => ['GuestMiddleware'],
        'routes' => [
            '/login' => [
                'controller' => 'AuthController',
                'function' => 'loginForm',
                'method' => 'GET',
            ],
            '/login/submit' => [
                'controller' => 'AuthController',
                'function' => 'login',
                'method' => 'POST',
            ],
            '/register' => [
                'controller' => 'AuthController',
                'function' => 'registerForm',
                'method' => 'GET',
            ],
            '/register/submit' => [
                'controller' => 'AuthController',
                'function' => 'register',
                'method' => 'POST',
            ],
        ]
    ],

    // Admin only
    [
        'middleware' => ['AuthMiddleware', 'AdminMiddleware'],
        'routes' => [
            '/admin/users' => [
                'controller' => 'AdminController',
                'function' => 'manageUsers',
                'method' => 'GET',
            ],
            '/anime/show/{id}' => [
                'controller' => 'AnimeController',
                'function' => 'show',
                'method' => 'GET',
            ],
        ]
    ],

    // Authenticated users
    [
        'middleware' => ['AuthMiddleware'],
        'routes' => [
            '/logout' => [
                'controller' => 'AuthController',
                'function' => 'logout',
                'method' => 'POST',
            ],
        ]
    ],

    // Public (no middleware)
    [
        'middleware' => [],
        'routes' => [
            '/' => [
                'controller' => 'AnimeController',
                'function' => 'index',
                'method' => 'GET',
            ],
            '/anime/search' => [
                'controller' => 'AnimeController',
                'function' => 'search',
                'method' => 'GET', // for search query
            ],
        ]
    ]
];