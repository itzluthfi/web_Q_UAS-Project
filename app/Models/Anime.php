<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Anime extends Model
{


    protected $fillable = [
        'mal_id',
        'title',
        'title_english',
        'synopsis',
        'type',
        'episodes',
        'duration',
        'score',
        'rank',
        'status',
        'season',
        'year',
        'category',
        'image_url',
        'aired_from',
        'aired_to',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'anime_category', 'anime_id', 'category_id')
            ->withTimestamps();
    }


    // Relasi many-to-many ke Genre
    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'anime_genre', 'anime_id', 'genre_id')
            ->withTimestamps();
    }

    // Relasi one-to-one ke AnimeDetail
    public function details()
    {
        return $this->hasOne(AnimeDetail::class);
    }



    private static function baseUrl($path = '')
    {
        $base = rtrim(config('jikan.base_url'), '/');
        $path = ltrim($path, '/');
        return "{$base}/{$path}";
    }

    // ===================== //
    // === TOP & TRENDING === //
    // ===================== //
    public static function getTopAnime($limit = 10)
    {
        $response = Http::get("https://api.jikan.moe/v4/top/anime", [
            'limit' => $limit
        ]);
        return $response->json();
    }



    public static function getPopularAnime($limit = 10, $page = 1)
    {
        $response = Http::get("https://api.jikan.moe/v4/top/anime", [
            'filter' => 'bypopularity',
            'limit' => $limit,
            'page' => $page
        ]);
        return $response->json();
    }

    public static function getPopularAnimeForHome($limit = 10)
    {
        $response = Http::get("https://api.jikan.moe/v4/top/anime", [
            'filter' => 'bypopularity',
            'limit' => $limit,
            'page' => 1
        ]);
        return $response->json('data', []);
    }

    public static function getTopRatedAnime($limit = 10)
    {
        $response = Http::get("https://api.jikan.moe/v4/top/anime", [
            'filter' => 'all',
            'limit' => $limit
        ]);
        return $response->json();
    }



    public static function getAiringAnime($limit = 10)
    {
        $response = Http::get("https://api.jikan.moe/v4/top/anime", [
            'filter' => 'airing',
            'limit' => $limit
        ]);
        return $response->json();
    }

    public static function getUpcomingAnime($limit = 10)
    {
        $response = Http::get("https://api.jikan.moe/v4/top/anime", [
            'filter' => 'upcoming',
            'limit' => $limit
        ]);
        return $response->json();
    }

    // =================== //
    // === BY CATEGORY === //
    // =================== //

    public static function getCurrentSeasonAnime($limit = 12, $page = 1)
    {
        $response = Http::get("https://api.jikan.moe/v4/seasons/now", [
            'limit' => $limit,
            'page' => $page
        ]);
        return $response->json();
    }

    public static function getCurrentSeasonAnimeForHome($limit = 12)
    {
        $response = Http::get("https://api.jikan.moe/v4/seasons/now", [
            'limit' => $limit,
            'page' => 1
        ]);
        return $response->json('data', []);
    }

    public static function getAnimeByGenre($genreId, $limit = 10, $page = 1)
    {
        $response = Http::get("https://api.jikan.moe/v4/anime", [
            'genres' => $genreId,
            'limit' => $limit,
            'page' => $page
        ]);
        return $response->json();
    }

    public static function getAnimeByStudio($studioId, $limit = 10)
    {
        $response = Http::get("https://api.jikan.moe/v4/producers/{$studioId}/anime", [
            'limit' => $limit
        ]);
        return $response->json();
    }

    public static function searchAnime($query, $limit = 10, $page = 1)
    {
        $response = Http::get("https://api.jikan.moe/v4/anime", [
            'q' => $query,
            'limit' => $limit,
            'page' => $page
        ]);

        $data = $response->json();

        return [
            'results' => $data['data'] ?? [],
            'total' => $data['pagination']['items']['total'] ?? 0,
            'page' => $page,
            'pagination' => $data['pagination'] ?? []
        ];
    }

    public static function getAllGenres()
    {
        $response = Http::get("https://api.jikan.moe/v4/genres/anime");
        return $response->json('data', []);
    }

    public static function getGenreNameById($genreId)
    {
        $response = Http::get("https://api.jikan.moe/v4/genres/anime");

        if ($response->successful()) {
            foreach ($response->json('data') as $genre) {
                if ($genre['mal_id'] == $genreId) {
                    return $genre['name'];
                }
            }
        }

        return 'Unknown Genre';
    }

    public static function getRandomAnimes($count = 5)
    {
        $results = [];

        for ($i = 0; $i < $count; $i++) {
            $response = Http::get("https://api.jikan.moe/v4/random/anime");
            $results[] = $response->json('data', []);
        }

        return $results;
    }

    // ====================== //
    // === ANIME DETAILS ==== //
    // ====================== //

    public static function getAnimeById($id)
    {
        $response = Http::get("https://api.jikan.moe/v4/anime/$id");
        return $response->json('data', []);
    }

    public static function getAnimeRelations($animeId)
    {
        $response = Http::get("https://api.jikan.moe/v4/anime/$animeId/relations");
        return $response->json('data', []);
    }

    public static function getRecommendations($animeId)
    {
        $response = Http::get("https://api.jikan.moe/v4/anime/$animeId/recommendations");
        return $response->json('data', []);
    }

    public static function getAnimeReviews($animeId, $page = 1)
    {
        $response = Http::get("https://api.jikan.moe/v4/anime/$animeId/reviews", [
            'page' => $page
        ]);
        return $response->json('data', []);
    }

    public static function getAnimeCharacters($animeId)
    {
        $response = Http::get("https://api.jikan.moe/v4/anime/$animeId/characters");
        return $response->json('data', []);
    }

    public static function getAnimeStaff($animeId)
    {
        $response = Http::get("https://api.jikan.moe/v4/anime/$animeId/staff");
        return $response->json('data', []);
    }

    public static function getAnimeThemes($animeId)
    {
        $response = Http::get("https://api.jikan.moe/v4/anime/$animeId/themes");
        return $response->json('data', []);
    }

    public static function getAnimeVideos($animeId)
    {
        $response = Http::get("https://api.jikan.moe/v4/anime/$animeId/videos");
        return $response->json('data', []);
    }

    public static function getAnimeNews($animeId)
    {
        $response = Http::get("https://api.jikan.moe/v4/anime/$animeId/news");
        return $response->json('data', []);
    }

    // ======================== //
    // === COMPOSITE FETCH ==== //
    // ======================== //

    public static function getPopularAnimeCharacters($limit = 5)
    {
        $topAnime = self::getTopAnime($limit)['data'] ?? [];
        $result = [];

        foreach ($topAnime as $anime) {
            $result[] = [
                'anime_title' => $anime['title'],
                'anime_id' => $anime['mal_id'],
                'characters' => self::getAnimeCharacters($anime['mal_id'])
            ];
        }

        return $result;
    }

    public static function getPopularAnimeThemes($limit = 5)
    {
        $topAnime = self::getTopAnime($limit)['data'] ?? [];
        $result = [];

        foreach ($topAnime as $anime) {
            $result[] = [
                'title' => $anime['title'] ?? 'Untitled',
                'image' => $anime['images']['jpg']['image_url'] ?? null,
                'themes' => self::getAnimeThemes($anime['mal_id'])
            ];
        }

        return $result;
    }

    public static function getPopularNewsAnime($limit = 20)
    {
        // Kalau limit kurang dari 1, fallback ke 25
        $animeLimit = $limit > 0 ? $limit : 25;

        $result = self::getTopAnime($animeLimit);
        $topAnime = is_array($result) && isset($result['data']) ? $result['data'] : [];

        $newsData = [];
        $newsUrls = []; // untuk melacak URL yang sudah masuk

        foreach ($topAnime as $anime) {
            $animeId = $anime['mal_id'] ?? null;
            if (!$animeId) continue;

            $newsItems = self::getAnimeNews($animeId);

            foreach ($newsItems as $item) {
                // Skip jika URL sudah ada
                if (in_array($item['url'], $newsUrls)) {
                    continue;
                }

                $newsData[] = [
                    'title' => $item['title'],
                    'date' => $item['date'],
                    'excerpt' => $item['excerpt'],
                    'url' => $item['url'],
                    'images' => $item['images'],
                    'anime' => [
                        'id' => $animeId,
                        'title' => $anime['title']
                    ]
                ];

                $newsUrls[] = $item['url']; // tandai URL sudah ditambahkan
            }
        }


        // Urutkan berita dari terbaru ke terlama
        usort($newsData, fn($a, $b) => strtotime($b['date']) - strtotime($a['date']));
        // Batasi jumlah yang dikembalikan sesuai $limit
        return array_slice($newsData, 0, $limit);
    }
}
