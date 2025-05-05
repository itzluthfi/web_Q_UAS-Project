<?php

require_once 'config/route.php';

//guest
Route::middleware(['GuestMiddleware'])->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login/submit', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register/submit', [AuthController::class, 'register'])->name('register.submit');
});

//hanya admin
Route::middleware(['AuthMiddleware', 'AdminMiddleware'])->group(function () {
    // Route::get('/admin/users', [AdminController::class, 'manageUsers'])->name('admin.users');
});

//yg sudah login
Route::middleware(['AuthMiddleware'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/anime/show/{id}', [AnimeController::class, 'show'])->name('anime.show');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users');
    
});

//public
Route::get('/', [AnimeController::class, 'beranda'])->name('home');
Route::get('/anime/viewAllBy/{label}', [AnimeController::class, 'viewAllByLabel'])->name('anime.viewAllByLabel');
Route::get('/anime/search', [AnimeController::class, 'search'])->name('anime.search');