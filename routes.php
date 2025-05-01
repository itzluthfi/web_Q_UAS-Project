<?php
return [
    '/' => ['controller' => 'AnimeController', 'method' => 'index'],
    
    '/anime/show' => ['controller' => 'AnimeController', 'method' => 'show'],
    
    '/register' => ['controller' => 'AuthController', 'method' => 'registerForm'],  // Halaman Form Register
    '/register/submit' => ['controller' => 'AuthController', 'method' => 'register'], // Proses Register
    
    '/login' => ['controller' => 'AuthController', 'method' => 'loginForm'],  // Halaman Form Login
    '/login/submit' => ['controller' => 'AuthController', 'method' => 'login'],  // Proses Login
    
    '/logout' => ['controller' => 'AuthController', 'method' => 'logout'],
];