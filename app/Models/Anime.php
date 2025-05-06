<?php
// app/Models/Anime.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http; // Untuk melakukan HTTP request

class Anime extends Model
{
    // Ambil Anime Terpopuler
    public static function getTopAnime($limit = 10)
    {
        $response = Http::get("https://api.jikan.moe/v4/top/anime?limit=$limit");
        return $response->json('data', []);
    }

    // Ambil Detail Anime Berdasarkan ID
    public static function getAnimeById($id)
    {
        $response = Http::get("https://api.jikan.moe/v4/anime/$id");
        return $response->json('data', []);
    }

    // Ambil Anime Secara Acak
    public static function getRandomAnimes($count = 5)
    {
        $randomAnimes = [];

        for ($i = 0; $i < $count; $i++) {
            $response = Http::get("https://api.jikan.moe/v4/random/anime");
            $randomAnimes[] = $response->json('data', []);
        }

        return $randomAnimes;
    }

    // Cari Anime Berdasarkan Judul
    public static function searchAnime($query, $limit = 10)
    {
        $response = Http::get("https://api.jikan.moe/v4/anime?q=" . urlencode($query) . "&limit=$limit");
        $data = $response->json();
        return [
            'results' => $data['data'] ?? [],
            'total' => $data['pagination']['items']['total'] ?? 0
        ];
    }

    // Ambil Anime yang Tayang di Musim Saat Ini (Current Season)
public static function getCurrentSeasonAnime($limit = 12)
{
    $response = Http::get("https://api.jikan.moe/v4/seasons/now?limit=$limit");
    return $response->json('data', []);
}

    // Ambil Rekomendasi Anime Berdasarkan Anime ID
    public static function getRecommendations($animeId)
    {
        $response = Http::get("https://api.jikan.moe/v4/anime/$animeId/recommendations");
        return $response->json('data', []);
    }

    // Ambil Anime Populer (Trending)
    public static function getPopularAnime($limit = 10)
    {
        $response = Http::get("https://api.jikan.moe/v4/top/anime?filter=bypopularity&limit=$limit");
        return $response->json('data', []);
    }

    // Ambil Anime yang Sedang Tayang (Airing)
    public static function getAiringAnime($limit = 10)
    {
        $response = Http::get("https://api.jikan.moe/v4/top/anime?filter=airing&limit=$limit");
        return $response->json('data', []);
    }

    // Ambil Anime Berdasarkan Genre
    public static function getAnimeByGenre($genreId, $limit = 10)
    {
        $response = Http::get("https://api.jikan.moe/v4/anime?genres=$genreId&limit=$limit");
        return $response->json('data', []);
    }

    // Ambil Anime yang Akan Datang (Upcoming)
    public static function getUpcomingAnime($limit = 10)
    {
        $response = Http::get("https://api.jikan.moe/v4/top/anime?filter=upcoming&limit=$limit");
        return $response->json('data', []);
    }

    // Ambil Karakter dalam Anime
    public static function getAnimeCharacters($animeId)
    {
        $response = Http::get("https://api.jikan.moe/v4/anime/$animeId/characters");
        return $response->json('data', []);
    }

    // Ambil Staf (Staff) Anime
    public static function getAnimeStaff($animeId)
    {
        $response = Http::get("https://api.jikan.moe/v4/anime/$animeId/staff");
        return $response->json('data', []);
    }

    // Ambil Video Trailer dan PV Anime
    public static function getAnimeVideos($animeId)
    {
        $response = Http::get("https://api.jikan.moe/v4/anime/$animeId/videos");
        return $response->json('data', []);
    }

    // Ambil Berita Terkait Anime
    public static function getAnimeNews($animeId)
    {
        $response = Http::get("https://api.jikan.moe/v4/anime/$animeId/news");
        return $response->json('data', []);
    }

    // Ambil Hubungan Anime (Sequel, Prequel, dll)
    public static function getAnimeRelations($animeId)
    {
        $response = Http::get("https://api.jikan.moe/v4/anime/$animeId/relations");
        return $response->json('data', []);
    }

    // Ambil Ulasan (Review) dari Pengguna
    public static function getAnimeReviews($animeId, $page = 1)
    {
        $response = Http::get("https://api.jikan.moe/v4/anime/$animeId/reviews?page=$page");
        return $response->json('data', []);
    }

    // Ambil Musik Tema Anime (OP & ED)
    public static function getAnimeThemes($animeId)
    {
        $response = Http::get("https://api.jikan.moe/v4/anime/$animeId/themes");
        return $response->json('data', []);
    }

    // Ambil Semua Genre dari Jikan API
    public static function getAllGenres()
    {
        $response = Http::get("https://api.jikan.moe/v4/genres/anime");
        return $response->json('data', []);
    }
}
?>