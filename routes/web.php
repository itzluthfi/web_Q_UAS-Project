<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnimeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SocialAuthController;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Mail;


// Guest routes
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login/submit', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register/submit', [AuthController::class, 'register'])->name('register.submit');
});

// Admin-only routes
Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/comment', [AdminController::class, 'comment'])->name('admin.comment');
});

// Authenticated users
Route::middleware(['auth'])->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/auth/profile', [AdminController::class, 'profile'])->name('auth.profile');
    Route::get('/auth/setting', [AdminController::class, 'setting'])->name('auth.setting');
    Route::get('/auth/dashboard', [AdminController::class, 'dashboard'])->name('auth.dashboard');
    Route::get('/notifikasi-email', [AuthController::class, 'kirimNotifikasi']);
    Route::post('auth/profile/upload-image', [AuthController::class, 'uploadProfileImage'])->name('auth.profile.uploadImage');
    Route::get('/anime/favorites', [AuthController::class, 'favoriteList'])->name('anime.favorites');
    Route::get('/anime/favorites/dashboard', [AuthController::class, 'favoriteListDashboard'])->name('anime.favorites.dashboard');
    Route::post('/anime/{mal_id}/favorite', [AnimeController::class, 'toggleFavorite'])->name('anime.favorite');
    Route::post('/user/add', [AuthController::class, 'addUser'])->name('user.add');
    Route::put('/user/{id}', [AuthController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [AuthController::class, 'destroy'])->name('user.delete');
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
Route::get('/anime/genre/{id}', [AnimeController::class, 'showByGenre'])->name('anime.showByGenre');
Route::get('/anime/Allgenre', [AnimeController::class, 'viewAllGenre'])->name('anime.viewAllGenre');
Route::get('/anime/Allnews', [AnimeController::class, 'viewAllNews'])->name('anime.viewAllNews');
// routes/web.php
Route::get('/admin/sync-anime', [AdminController::class, 'syncAnimePage'])->name('admin.syncAnimePage');
Route::post('/admin/sync-anime', [AdminController::class, 'syncAnime'])->name('admin.syncAnime');
Route::get('/auth/{provider}', [SocialAuthController::class, 'redirect']);
Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback']);





// Route::get('/tes-kirim-email', function () {
//     Mail::raw('Tes kirim email langsung dari Laravel SMTP Gmail.', function ($message) {
//         $message->to('luthfishidqi28@gmail.com') // ganti jika perlu
//             ->subject('Test Email Manual laravel');
//     });

//     return 'Email langsung berhasil dikirim!';
// });