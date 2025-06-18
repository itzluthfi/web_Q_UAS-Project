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
        'popularity',
        'status',
        'season',
        'year',
        'category',
        'image_url',
        'large_image_url',
        'aired_from',
        'aired_to',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class, 'anime_id', 'mal_id')
            ->whereNull('parent_id') // Hanya ambil komentar utama
            ->with('user', 'replies'); // Eager load user dan replies
    }

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
    // === GET BY DATABASE === //
    // ===================== //
    public static function getTopRatedAnimeDB($limit = null)
    {
        return self::whereNotNull('score')
            ->orderByDesc('score')
            ->take($limit)
            ->get();
    }

    public static function getUpcomingAnimeDB($limit = 10)
    {
        return self::where('status', 'Not yet aired')
            ->orderByDesc('score')
            ->take($limit)
            ->get();
    }

    public static function getCurrentSeasonAnimeDB($limit = null)
    {
        return self::where('category', 'current-season')
            ->orderByRaw("FIELD(season, 'Winter', 'Spring', 'Summer', 'Fall')")
            ->orderByDesc('year')
            ->take($limit)
            ->get();
    }


    public static function getPopularAnimeDB($limit = 10)
    {
        return self::orderByDesc('popularity')
            ->take($limit)
            ->get();
    }
    public static function getLastestNewsDB($limit = 10) {}


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



    public static function getPopularAnime($limit = null)
    {
        $query = self::whereNotNull('popularity')
            ->orderBy('popularity'); // dari yang paling populer

        if ($limit !== null) {
            return $query->take($limit)->get();
        }

        return $query->get();
    }

    // public static function getPopularAnimeForHome($limit = 10)
    // {
    //     $response = Http::get("https://api.jikan.moe/v4/top/anime", [
    //         'filter' => 'bypopularity',
    //         'limit' => $limit,
    //         'page' => 1
    //     ]);
    //     return $response->json('data', []);
    // }

    // public static function getTopRatedAnime($limit = 10)
    // {
    //     $response = Http::get("https://api.jikan.moe/v4/top/anime", [
    //         'limit' => $limit
    //     ]);
    //     // dd($response->json());
    //     return $response->json();
    // }

    public static function getTopRatedAnime($limit = null)
    {
        $query = self::whereNotNull('score')->orderByDesc('score');

        if ($limit !== null) {
            return $query->take($limit)->get(); // return Collection
        }

        $result = $query->get();
        // dd($result); // Debugging line, remove in production
        return $result; // return Collection
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

    public static function getCurrentSeasonAnime($limit = null)
    {
        $query = self::where('category', 'current-season')
            ->orderByRaw("FIELD(season, 'Winter', 'Spring', 'Summer', 'Fall')")
            ->orderByDesc('year');
    
        if ($limit !== null) {
            return $query->take($limit)->get(); // Ambil jumlah tertentu
        }
    
        return $query->get(); // Ambil semua data
    }

    // public static function getCurrentSeasonAnimeForHome($limit = 12)
    // {
    //     $response = Http::get("https://api.jikan.moe/v4/seasons/now", [
    //         'limit' => $limit,
    //         'page' => 1
    //     ]);
    //     return $response->json('data', []);
    // }

    // public static function getAnimeByGenre($genreId, $limit = 10, $page = 1)
    // {
    //     $response = Http::get("https://api.jikan.moe/v4/anime", [
    //         'genres' => $genreId,
    //         'limit' => $limit,
    //         'page' => $page
    //     ]);
    //     return $response->json();
    // }

    public static function getAnimeByGenre($genreId, $perPage = 12, $page = 1)
    {
        // Debug 1: Pastikan genreId diterima dengan benar
        // dd("Debug Genre ID: ", $genreId);

        // Debug 2: Lihat SQL Query dan binding
        $query = self::whereHas('genres', function ($q) use ($genreId) {
            $q->where('genre_id', $genreId);
        })->with('genres');

        // Tampilkan query SQL + binding
        // \Log::info($query->toSql(), $query->getBindings());
        // dd("Query SQL:", $query->toSql(), "Binding:", $query->getBindings());

        // Debug 3: Jalankan query tanpa pagination untuk lihat hasil langsung
        $results = $query->get();
        // dd("Hasil Query Tanpa Pagination: ", $results);

        // Debug 4: Jalankan query dengan pagination
        $paginated = $query->paginate($perPage, ['*'], 'page', $page);
        // dd("Hasil Dengan Pagination: ", $paginated);

        // Return akhir
        return $paginated;
    }

    public static function getAnimeByStudio($studioId, $limit = 10)
    {
        $response = Http::get("https://api.jikan.moe/v4/producers/{$studioId}/anime", [
            'limit' => $limit
        ]);
        return $response->json();
    }

    public static function searchAnime($query, $perPage = 12, $page = 1)
    {
        // Bangun query pencarian
        $dbQuery = self::query()
            ->where('title', 'like', "%$query%");
    
        // Tambahkan eager loading jika perlu
        $dbQuery->with(['genres']);
    
        // Jalankan pagination
        $paginated = $dbQuery->paginate($perPage, ['*'], 'page', $page);
    
        return [
            'results' => $paginated->items(),
            'total' => $paginated->total(),
            'page' => $paginated->currentPage(),
            'pagination' => $paginated
        ];
    }

    // public static function getAllGenres()
    // {
    //     $response = Http::get("https://api.jikan.moe/v4/genres/anime");
    //     return $response->json('data', []);
    // }

    public static function getAllGenres()
    {
        return static::withCount('animes')
            ->orderBy('name')
            ->get()
            ->map(function ($genre) {
                return [
                    'id' => $genre->id,
                    'name' => $genre->name,
                    'count' => $genre->animes_count ?? 0,
                ];
            });
    }

    public static function getGenreNameById($genreId)
    {
        // Ambil nama genre dari database
        return Genre::find($genreId)?->name ?? 'Unknown Genre';
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
        // $response = Http::get("https://api.jikan.moe/v4/anime/$id");
        // return $response->json('data', []);
        return self::with('genres')->where('mal_id', $id)
            ->with(['genres', 'details'])
            ->first();
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

    public static function getAnimeNews($animeId)
    {
        $response = Http::get("https://api.jikan.moe/v4/anime/$animeId/news");
        return $response->json('data', []);
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
