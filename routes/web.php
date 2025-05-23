<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnimeController;
use App\Http\Controllers\CommentController;
use Illuminate\Container\Attributes\Auth;

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
    Route::get('/admin/setting', [AdminController::class, 'setting'])->name('admin.setting');
    Route::get('/admin/comment', [AdminController::class, 'comment'])->name('admin.comment');
});

// Authenticated users
Route::middleware(['auth'])->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/user/profile', [AdminController::class, 'profile'])->name('user.profile');
    // Pastikan middleware 'auth' digunakan, karena hanya user login yang boleh upload
    Route::post('/profile/upload-image', [AuthController::class, 'uploadProfileImage'])
    ->name('profile.uploadImage');
});

// Public routes
Route::get('/', [AnimeController::class, 'beranda'])->name('home');
Route::get('/anime/search', [AnimeController::class, 'search'])->name('anime.search');
Route::get('/anime/show/{id}', [AnimeController::class, 'show'])->name('anime.show');  
Route::get('/anime/viewAllBy/{label}', [AnimeController::class, 'viewAllByLabel'])->name('anime.viewAllByLabel');
Route::get('/anime/berandaTemp', [AnimeController::class, 'berandaTemp'])->name('berandaTemp');
Route::get('/anime/showByStudio', [AnimeController::class, 'showByStudio'])->name('anime.showByStudio');
Route::post('/anime/comments/store', [CommentController::class, 'store'])->name('comments.store');
Route::get('/anime/berita/{id}', [AnimeController::class, 'beritaShow'])->name('anime.berita.show');
Route::get('/anime/showByGenre/{id}', [AnimeController::class, 'showByGenre'])->name('anime.showByGenre');
Route::get('/anime/genre', [AnimeController::class, 'testView'])->name('anime.genre');