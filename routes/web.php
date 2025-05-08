<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnimeController;


// Guest routes
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login/submit', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register/submit', [AuthController::class, 'register'])->name('register.submit');
});

// Admin-only routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users');
    Route::get('/admin/profile', [AdminController::class, 'profile'])->name('admin.profile');
});

// Authenticated users
Route::middleware(['auth'])->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Public routes
Route::get('/anime/search', [AnimeController::class, 'search'])->name('anime.search');
Route::get('/anime/show/{id}', [AnimeController::class, 'show'])->name('anime.show');  
Route::get('/', [AnimeController::class, 'beranda'])->name('home');
Route::get('/anime/viewAllBy/{label}', [AnimeController::class, 'viewAllByLabel'])->name('anime.viewAllByLabel');