<?php

function route(string $name, array $params = []): string
{
    require_once 'config/Route.php'; // pastikan Route dimuat

    // Cek apakah route memiliki nama
    $uri = Route::getUriByName($name);

    if (!$uri) {
        // Jika tidak ada nama route, anggap $name adalah URI langsung
        $uri = $name;
    }

    // Replace parameter seperti /anime/{id}
    foreach ($params as $key => $value) {
        $uri = preg_replace('/\{' . $key . '\}/', $value, $uri);
    }

    // Menambahkan base folder ke URI jika belum ada
    $base = '/anime-list-uas';
    if (strpos($uri, $base) !== 0) { // Cek apakah base sudah ada di URI
        $uri = $base . $uri;
    }

    return $uri;
}