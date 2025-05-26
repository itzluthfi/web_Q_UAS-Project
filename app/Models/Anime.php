<?php
// app/Models/Anime.php

namespace App\Models;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Anime extends Model
{
    // === Top, Populer, Airing, Upcoming ===
    
    // Ambil Anime Terpopuler
    public static function getTopAnime($limit = 10)
    {
        $response = Http::get("https://api.jikan.moe/v4/top/anime?limit=$limit");
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

    // Ambil Anime yang Akan Datang (Upcoming)
    public static function getUpcomingAnime($limit = 10)
    {
        $response = Http::get("https://api.jikan.moe/v4/top/anime?filter=upcoming&limit=$limit");
        return $response->json('data', []);
    }

    // === Season, Genre, Random, Search === 
    public function getAnimeByStudio($studioId, $limit = 10)
    {
        $url = "https://api.jikan.moe/v4/producers/{$studioId}/anime";
        $response = Http::get($url, [
            'limit' => $limit,
        ]);

        return $response->json()['data'] ?? [];
    }

    // Ambil Anime yang Tayang di Musim Saat Ini
    public static function getCurrentSeasonAnime($limit = 12)
    {
        $response = Http::get("https://api.jikan.moe/v4/seasons/now?limit=$limit");
        return $response->json('data', []);
    }

    // Ambil Anime Berdasarkan Genre
    public static function getAnimeByGenre($genreId, $limit = 10)
    {
        $response = Http::get("https://api.jikan.moe/v4/anime?genres=$genreId&limit=$limit");
        return $response->json('data', []);
    }

    // Ambil Semua Genre
    public static function getAllGenres($limit = 10)
    {
       $response = Http::get("https://api.jikan.moe/v4/genres/anime?limit=$limit");
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

    // === Detail Anime Berdasarkan ID ===
    //gen genre by id
    public function getGenreNameById($genreId)
{
    $response = Http::get("https://api.jikan.moe/v4/genres/anime");

    if ($response->successful()) {
        $genres = $response->json('data');

        foreach ($genres as $genre) {
            if ($genre['mal_id'] == $genreId) {
                return $genre['name'];
            }
        }
    }

    return 'Unknown Genre';
}
    // Ambil Detail Anime
    public static function getAnimeById($id)
    {
        $response = Http::get("https://api.jikan.moe/v4/anime/$id");
        return $response->json('data', []);
    }

    // Ambil Rekomendasi Anime
    public static function getRecommendations($animeId)
    {
        $response = Http::get("https://api.jikan.moe/v4/anime/$animeId/recommendations");
        return $response->json('data', []);
    }

    // Ambil Hubungan Anime (Sequel, Prequel, dll)
    public static function getAnimeRelations($animeId)
    {
        $response = Http::get("https://api.jikan.moe/v4/anime/$animeId/relations");
        return $response->json('data', []);
    }

    // Ambil Ulasan Pengguna
    public static function getAnimeReviews($animeId, $page = 1)
    {
        $response = Http::get("https://api.jikan.moe/v4/anime/$animeId/reviews?page=$page");
        return $response->json('data', []);
    }

    // === Karakter, Staff, Tema, Video ===

    // Ambil Karakter dalam Anime
    public static function getAnimeCharacters($animeId)
    {
        $response = Http::get("https://api.jikan.moe/v4/anime/$animeId/characters");
        return $response->json('data', []);
    }

    // Ambil Staf dalam Anime
    public static function getAnimeStaff($animeId)
    {
        $response = Http::get("https://api.jikan.moe/v4/anime/$animeId/staff");
        return $response->json('data', []);
    }

    // Ambil Musik Tema (OP & ED)
    public static function getAnimeThemes($animeId)
    {
        $response = Http::get("https://api.jikan.moe/v4/anime/$animeId/themes");
        return $response->json('data', []);
    }

    // Ambil Video Trailer & PV
    public static function getAnimeVideos($animeId)
    {
        $response = Http::get("https://api.jikan.moe/v4/anime/$animeId/videos");
        return $response->json('data', []);
    }

    // === Berita Anime ===

    // Ambil Berita Terkait Anime
    public static function getAnimeNews($animeId)
    {
        $response = Http::get("https://api.jikan.moe/v4/anime/$animeId/news");
        return $response->json('data', []);
    }

    // === Komposit: Data dari Banyak Anime ===

    // Ambil Karakter dari Beberapa Anime Populer
    public static function getPopularAnimeCharacters($limit = 5)
    {
        $topAnime = self::getTopAnime($limit);
        $charactersData = [];

        foreach ($topAnime as $anime) {
            $animeId = $anime['mal_id'];
            $charactersData[] = [
                'anime_title' => $anime['title'],
                'anime_id' => $animeId,
                'characters' => self::getAnimeCharacters($animeId)
            ];
        }

        return $charactersData;
    }

  // Ambil Tema Anime Populer + Gambar
public static function getPopularAnimeThemes($limit = 5)
{
    $topAnime = self::getTopAnime($limit);
    $themesData = [];

    foreach ($topAnime as $anime) {
        $animeId = $anime['mal_id'] ?? null;

        if ($animeId) {
            // Ambil themes (OP & ED)
            $themes = self::getAnimeThemes($animeId);

            $themesData[] = [
                'title' => $anime['title'] ?? 'Untitled',
                'image' => $anime['images']['jpg']['image_url'] ?? null,
                'themes' => $themes
            ];
        }
    }

    return $themesData;
}

    // Ambil Berita dari Beberapa Anime Populer
    public static function getPopularAnimeNews($limit = 3)
    {
        $topAnime = self::getTopAnime($limit);
        $newsData = [];

        foreach ($topAnime as $anime) {
            $animeId = $anime['mal_id'];
            $animeTitle = $anime['title'];
            $newsItems = self::getAnimeNews($animeId);

            foreach ($newsItems as $item) {
                $newsData[] = [
                    'title' => $item['title'],
                    'date' => $item['date'],
                    'excerpt' => $item['excerpt'],
                    'url' => $item['url'],
                    'images' => $item['images'], // sudah sesuai format Jikan
                    'anime' => [
                        'id' => $animeId,
                        'title' => $animeTitle
                    ]
                ];
            }
        }

        // Urutkan berdasarkan tanggal terbaru (optional)
        usort($newsData, function ($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });

        // Batasi total jumlah berita yang di-return
        return array_slice($newsData, 0, $limit);
    }

    public static function getTopRatedAnime($limit = 10)
    {
        $response = Http::get("https://api.jikan.moe/v4/top/anime?filter=all&limit=$limit");
        return $response->json('data', []);
    }


}