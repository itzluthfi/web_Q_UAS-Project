<?php

require_once 'config/route.php';

Route::middleware(['GuestMiddleware'])->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');

    Route::post('/login/submit', 'AuthController', 'login')->name('login.submit');
    Route::get('/register', 'AuthController', 'registerForm');
    Route::post('/register/submit', 'AuthController', 'register');
});

Route::middleware(['AuthMiddleware', 'AdminMiddleware'])->group(function () {
    Route::get('/admin/users', 'AdminController', 'manageUsers');
    Route::get('/anime/show/{id}', 'AnimeController', 'show');
});

Route::middleware(['AuthMiddleware'])->group(function () {
    Route::post('/logout', 'AuthController', 'logout')->name('logout');
    Route::get('/anime/show/{id}', 'AnimeController', 'show');
});

Route::get('/', 'AnimeController', 'index');
Route::get('/anime/search', 'AnimeController', 'search');