<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Anime; // Ganti jika AnimeModel kamu pakai nama lain
use App\Models\Comment;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\LengthAwarePaginator; // Untuk pagination manual
use App\Models\Genre;

class AnimeController extends Controller
{
    protected $animeModel;

    /**
     * Konstruktor controller ini, menginisialisasi model Anime
     *
     * @return void
     */
    public function __construct()
    {
        $this->animeModel = new Anime(); // Ganti Anime dengan AnimeModel jika nama file-nya begitu
    }

    public function beranda()
    {
        // $animeUpcomings = Cache::remember('upcoming_anime', 60, function () {
        //     return $this->animeModel->getUpcomingAnime(5)['data'] ?? [];
        // });

        $animeUpcomings = Cache::remember('upcoming_anime', 60, function () {
            return $this->animeModel->getUpcomingAnimeDB(5) ?? [];
        });

        // dd($animeUpcomings);

        $animeTopRated = Cache::remember('top_rated_anime', 60, function () {
            return $this->animeModel->getTopRatedAnimeDB(6) ?? [];
        });
        // dd($animeTopRated);

        $lastestNews = Cache::remember('latest_news', 60, function () {
            return $this->animeModel->getPopularNewsAnime(3);
        });

        // $genres = Cache::remember('all_genres', 60, function () {
        //     return $this->animeModel->getAllGenres(10)['data'] ?? [];
        // });

        $animeCurrentSeasonal = Cache::remember('current_seasonal_anime', 60, function () {
            return $this->animeModel->getCurrentSeasonAnimeDB(4) ?? [];
        });


        $animePopular = Cache::remember('popular_anime', 60, function () {
            return $this->animeModel->getPopularAnimeDB(6) ?? [];
        });

        // dd($animeCurrentSeasonal);
        // $animeUpcomings = [];
        $genres = [];
        // $lastestNews = [];

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
        // $animeTop = $this->animeModel->getTopAnime(10);
        // $animeUpcomings = $this->animeModel->getUpcomingAnime(5);
        // $animePopular = $this->animeModel->getPopularAnime();
        // $animeCurrentSeasonal = $this->animeModel->getCurrentSeasonAnime();
        // $categories = $this->animeModel->getAllGenres();

        return view('user.anime.berandaTemp');
    }

    public function showByStudio($studioId)
    {
        $animeList = $this->animeModel->getAnimeByStudio($studioId, 10);
        // dd($animeList);
    }



    // public function viewAllByLabel($label)
    // {
    //     $page = request()->query('page', 1); // default ke 1 jika tidak ada
    //     $method = 'get' . ucfirst($label) . 'Anime';

    //     if (!method_exists($this->animeModel, $method)) {
    //         return abort(404, "Label '$label' tidak valid.");
    //     }

    //     $result = $this->animeModel->$method(12, $page); // ← UBAH: tambah parameter $page
    //     $animeList = $result['data'] ?? [];              // ← UBAH: ambil dari $result
    //     $pagination = $result['pagination'] ?? [];       // ← UBAH: ambil dari $result

    //     return view('user.anime.viewAllByLabel', compact('animeList', 'label', 'pagination'));
    // }

    public function viewAllByLabel($label)
    {
        $page = request()->query('page', 1);
        $perPage = 12;
        $method = 'get' . ucfirst($label) . 'Anime';

        if (!method_exists($this->animeModel, $method)) {
            return abort(404, "Label '$label' tidak valid.");
        }

        // Ambil SEMUA data dari model (pastikan return Collection)
        $allData = collect($this->animeModel->$method());

        // Slice sesuai halaman
        $items = $allData->slice(($page - 1) * $perPage, $perPage)->values();

        // Buat paginator manual
        $paginator = new LengthAwarePaginator(
            $items,
            $allData->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        // Data untuk looping anime
        $animeList = $paginator->items();

        // Data untuk pagination component (format array sesuai kebutuhan blade)
        $pagination = [
            'current_page'        => $paginator->currentPage(),
            'last_visible_page'   => $paginator->lastPage(),
        ];

        // Kirim ke view
        return view('user.anime.viewAllByLabel', compact('animeList', 'label', 'pagination'));
    }



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

    public function showByGenre($genreId)
    {
        $page = request()->query('page', 1);
        $perPage = 12;

        // Ambil anime berdasarkan genre (Eloquent Paginator)
        $paginated = $this->animeModel->getAnimeByGenre($genreId, $perPage, $page);

        // Ambil nama genre
        $label = $this->animeModel->getGenreNameById($genreId);

        // Format untuk viewAllByLabel
        $animeList = $paginated->items();
        $pagination = [
            'current_page' => $paginated->currentPage(),
            'last_visible_page' => $paginated->lastPage()
        ];

        return view('user.anime.viewAllByLabel', compact('animeList', 'label', 'pagination', 'genreId'));
    }

    public function show($id)
    {
        // Ambil detail anime dari API
        $anime = Anime::getAnimeById($id);

        // dd($anime);
        if (!$anime) {
            return abort(404, 'Anime detail tidak ditemukan.');
        }

        // Akses genre dengan array syntax
        $genre = is_array($anime['genres'])
            ? implode(',', array_column($anime['genres'], 'name')) // atau 'mal_id' jika ingin ID genre
            : $anime['genres'];

        // Ambil anime terkait berdasarkan genre ID pertama (jika ada)
        $firstGenreId = $anime['genres'][0]['mal_id'] ?? null;
        $relatedAnimes = [];

        if ($firstGenreId) {
            $response = Anime::getAnimeByGenre($firstGenreId, 4);
            $relatedAnimes = $response['data'] ?? [];
        }

        $comments = Comment::with('user')
            ->where('anime_id', $id)
            ->whereNull('parent_id')
            ->get();
        // dd($comments);

        // Kirim ke view
        return view('user.anime.show', compact('anime', 'relatedAnimes', 'comments'));
    }

    public function search(Request $request)
    {
        $query = $request->query('q');
        $page = $request->query('page', 1);

        if (!$query) {
            return redirect()->route('home')->with('error', 'Masukkan kata kunci pencarian.');
        }

        $result = $this->animeModel->searchAnime($query, 10, $page); // pastikan $page dikirim
        $animeList = $result['results'];
        $jmlResult = $result['total'];
        $pagination = [
            'current_page' => $result['pagination']['current_page'] ?? 1,
            'last_visible_page' => $result['pagination']['last_visible_page'] ?? 1,
        ];

        return view('user.anime.viewAllByLabel', compact('animeList', 'jmlResult', 'query', 'pagination'));
    }



    public function viewAllGenre(Request $request)
    {
        $genres = Genre::getAllGenres(); // Mengambil data + count

        return view('user.anime.viewAllGenre', compact('genres'));
    }

    public function viewAllNews(Request $request)
    {
        $news = $this->animeModel->getPopularNewsAnime(5);
        // dd($news);
        return view('user.anime.viewAllNews', compact('news'));
    }
}
