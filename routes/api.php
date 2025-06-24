<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AnimeApi;

Route::get('/anime', [AnimeApi::class, 'index']);
Route::get('/anime/{id}', [AnimeApi::class, 'show']);
