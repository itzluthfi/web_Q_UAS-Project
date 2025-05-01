<?php
return [
    '/' => ['controller' => 'AnimeController', 'method' => 'index'],

    '/anime/show/{id}' => ['controller' => 'AnimeController', 'method' => 'show'], // Tambahkan {id}

    '/register' => ['controller' => 'AuthController', 'method' => 'registerForm'],
    '/register/submit' => ['controller' => 'AuthController', 'method' => 'register'],

    '/login' => ['controller' => 'AuthController', 'method' => 'loginForm'],
    '/login/submit' => ['controller' => 'AuthController', 'method' => 'login'],

    '/logout' => ['controller' => 'AuthController', 'method' => 'logout'],
];