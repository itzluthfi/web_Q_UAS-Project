<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anime;
use App\Models\Comment;
use App\Models\Genre;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class AnimeController extends Controller
{
    protected $animeModel;

    /**
     * Konstruktor controller ini, menginisialisasi model Anime
     */
    public function __construct()
    {
        $this->animeModel = new Anime();
    }

    // ==========================
    // ======= BERANDA ==========
    // ==========================
    public function beranda()
    {
        $animeUpcomings = Cache::remember('upcoming_anime', 60, function () {
            return $this->animeModel->getUpcomingAnimeDB(5) ?? [];
        });

        $animeTopRated = Cache::remember('top_rated_anime', 60, function () {
            return $this->animeModel->getTopRatedAnimeDB(6) ?? [];
        });

        $lastestNews = Cache::remember('latest_news', 60, function () {
            return $this->animeModel->getPopularNewsAnime(3);
        });

        $animeCurrentSeasonal = Cache::remember('current_seasonal_anime', 60, function () {
            return $this->animeModel->getCurrentSeasonAnimeDB(4) ?? [];
        });

        $animePopular = Cache::remember('popular_anime', 60, function () {
            return $this->animeModel->getPopularAnimeDB(6) ?? [];
        });

        $genres = [];

        return view('user.anime.beranda', compact(
            'animePopular',
            'animeCurrentSeasonal',
            'animeUpcomings',
            'animeTopRated',
            'lastestNews',
            'genres',
        ));
    }

    public function berandaTemp()
    {
        return view('user.anime.berandaTemp');
    }

    // ==========================
    // ======= STUDIO ===========
    // ==========================
    public function showByStudio($studioId)
    {
        $animeList = $this->animeModel->getAnimeByStudio($studioId, 10);
        // dd($animeList);
    }

    // ==========================
    // ======= LABEL =============
    // ==========================
    public function viewAllByLabel($label)
    {
        $page = request()->query('page', 1);
        $perPage = 12;
        $method = 'get' . ucfirst($label) . 'Anime';

        if (!method_exists($this->animeModel, $method)) {
            return abort(404, "Label '$label' tidak valid.");
        }

        $allData = collect($this->animeModel->$method());
        $items = $allData->slice(($page - 1) * $perPage, $perPage)->values();

        $paginator = new LengthAwarePaginator(
            $items,
            $allData->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $animeList = $paginator->items();
        $pagination = [
            'current_page'      => $paginator->currentPage(),
            'last_visible_page' => $paginator->lastPage(),
        ];

        return view('user.anime.viewAllByLabel', compact('animeList', 'label', 'pagination'));
    }

    // ==========================
    // ======= GENRE ============
    // ==========================
    public function showByGenre($genreId)
    {
        $page = request()->query('page', 1);
        $perPage = 12;

        $paginated = $this->animeModel->getAnimeByGenre($genreId, $perPage, $page);
        $label = $this->animeModel->getGenreNameById($genreId);

        $animeList = $paginated->items();
        $pagination = [
            'current_page'      => $paginated->currentPage(),
            'last_visible_page' => $paginated->lastPage()
        ];

        return view('user.anime.viewAllByLabel', compact('animeList', 'label', 'pagination', 'genreId'));
    }

    public function viewAllGenre(Request $request)
    {
        $genres = Genre::getAllGenres();
        return view('user.anime.viewAllGenre', compact('genres'));
    }

    // ==========================
    // ======= DETAIL ===========
    // ==========================
    public function show($id)
    {
        $anime = Anime::getAnimeById($id);

        if (!$anime) {
            return abort(404, 'Anime detail tidak ditemukan.');
        }

        $genre = $anime->genres->isNotEmpty()
            ? $anime->genres->pluck('name')->implode(',')
            : 'Tidak ada genre';

        $firstGenreId = $anime->genres->first()?->mal_id;
        $relatedAnimes = [];

        if ($firstGenreId) {
            $relatedAnimes = Anime::getAnimeByGenre($firstGenreId, 4);
        }

        $comments = Comment::with('user')
            ->where('anime_id', $id)
            ->whereNull('parent_id')
            ->get();

        return view('user.anime.show', compact('anime', 'relatedAnimes', 'comments'));
    }

    // ==========================
    // ======= SEARCH ===========
    // ==========================
    public function search(Request $request)
    {
        $query = $request->query('q');
        $page = $request->query('page', 1);

        if (!$query) {
            return redirect()->route('home')->with('error', 'Masukkan kata kunci pencarian.');
        }

        $result = $this->animeModel->searchAnime($query, 10, $page);
        $animeList = $result['results'];
        $jmlResult = $result['total'];
        $pagination = [
            'current_page'      => $result['pagination']['current_page'] ?? 1,
            'last_visible_page' => $result['pagination']['last_visible_page'] ?? 1,
        ];

        return view('user.anime.viewAllByLabel', compact('animeList', 'jmlResult', 'query', 'pagination'));
    }

    // ==========================
    // ======= NEWS =============
    // ==========================
    public function viewAllNews(Request $request)
    {
        $news = $this->animeModel->getPopularNewsAnime(5);
        return view('user.anime.viewAllNews', compact('news'));
    }

    // ==========================
    // ===== FAVORITES ==========
    // ==========================
    public function toggleFavorite($mal_id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Unauthenticated.'], 401);
        }

        // Pastikan relasi di model User: favoritesAnimes()
        $anime = Anime::where('mal_id', $mal_id)->firstOrFail();

        // Toggle: jika sudah ada, hapus. Jika belum, tambahkan.
        $isFavorited = $user->favoriteAnimes()->where('mal_id', $anime->mal_id)->exists();

        if ($isFavorited) {
            $user->favoriteAnimes()->detach($anime->mal_id);
            $status = 'removed';
        } else {
            $user->favoriteAnimes()->attach($anime->mal_id);
            $status = 'added';
        }

        return response()->json(['status' => 'success', 'action' => $status]);
    }


    // ==========================
    // ===== KOMENTAR CODE ======
    // ==========================
    // public function viewAllByLabel($label)
    // {
    //     $page = request()->query('page', 1); // default ke 1 jika tidak ada
    //     $method = 'get' . ucfirst($label) . 'Anime';
    //     if (!method_exists($this->animeModel, $method)) {
    //         return abort(404, "Label '$label' tidak valid.");
    //     }
    //     $result = $this->animeModel->$method(12, $page);
    //     $animeList = $result['data'] ?? [];
    //     $pagination = $result['pagination'] ?? [];
    //     return view('user.anime.viewAllByLabel', compact('animeList', 'label', 'pagination'));
    // }

    // public function showByGenre($genreId)
    // {
    //     $page = request()->query('page', 1); // default ke 1 jika tidak ada
    //     $limit = 10;
    //     $response = $this->animeModel->getAnimeByGenre($genreId, $limit, $page);
    //     $animeList = $response['data'] ?? [];
    //     $pagination = $response['pagination'] ?? [];
    //     $label = $this->animeModel->getGenreNameById($genreId);
    //     return view('user.anime.viewAllByLabel', compact('animeList', 'pagination', 'label', 'genreId'));
    // }

    // public function show($id)
    // {
    //     // Ambil detail anime dari API
    //     // $anime = Anime::getAnimeById($id);
    //     // if (!$anime) {
    //     //     return abort(404, 'Anime detail tidak ditemukan.');
    //     // }
    //     // $genre = is_array($anime['genres'])
    //     //     ? implode(',', array_column($anime['genres'], 'name'))
    //     //     : $anime['genres'];
    //     // $firstGenreId = $anime['genres'][0]['mal_id'] ?? null;
    //     // $relatedAnimes = [];
    //     // if ($firstGenreId) {
    //     //     $response = Anime::getAnimeByGenre($firstGenreId, 4);
    //     //     $relatedAnimes = $response['data'] ?? [];
    //     // }
    //     // $comments = Comment::with('user')
    //     //     ->where('anime_id', $id)
    //     //     ->whereNull('parent_id')
    //     //     ->get();
    //     // return view('user.anime.show', compact('anime', 'relatedAnimes', 'comments'));
    // }
}
