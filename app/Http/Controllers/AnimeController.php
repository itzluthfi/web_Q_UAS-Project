<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Anime; // Ganti jika AnimeModel kamu pakai nama lain
use App\Models\Comment;
use Illuminate\Support\Facades\Cache;

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
    $animeTop = Cache::remember('top_anime', 60, function () {
        return $this->animeModel->getTopAnimeForHome(10);
    });

    $animeUpcomings = Cache::remember('upcoming_anime', 60, function () {
        return $this->animeModel->getUpcomingAnime(5);
    });

    $animePopular = Cache::remember('popular_anime', 60, function () {
        return $this->animeModel->getPopularAnimeForHome();
    });

    $animeCurrentSeasonal = Cache::remember('current_season_anime', 60, function () {
        return $this->animeModel->getCurrentSeasonAnimeForHome();
    });

    $animeTopRated = Cache::remember('top_rated_anime', 60, function () {
        return $this->animeModel->getTopRatedAnime(10);
    });
    // dd($animeTopRated);

    $lastestNews = Cache::remember('latest_news', 60, function () {
        return $this->animeModel->getPopularAnimeNews(3);
    });

    $genres = Cache::remember('all_genres', 60, function () {
        return $this->animeModel->getAllGenres(10);
    });

    // $llGenres = Cache::remember('all_genres_unlimited', 60, function () {
    //     return $this->animeModel->getAllGenresUnlimited();
    // });

    return view('user.anime.beranda', compact(
        'animeTop', 
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

        return view('user.anime.berandaTemp' );
    }

    public function showByStudio($studioId){
        $animeList = $this->animeModel->getAnimeByStudio($studioId, 10);
        // dd($animeList);
    }

   

    public function viewAllByLabel($label)
    {
        $page = request()->query('page', 1); // default ke 1 jika tidak ada
        $method = 'get' . ucfirst($label) . 'Anime';

        if (!method_exists($this->animeModel, $method)) {
            return abort(404, "Label '$label' tidak valid.");
        }

        $result = $this->animeModel->$method(10, $page); // ← UBAH: tambah parameter $page
        $animeList = $result['data'] ?? [];              // ← UBAH: ambil dari $result
        $pagination = $result['pagination'] ?? [];       // ← UBAH: ambil dari $result
    
        return view('user.anime.viewAllByLabel', compact('animeList', 'label', 'pagination'));
    }


    public function showByGenre($genreId)
    {
        $page = request()->query('page', 1); // default ke 1 jika tidak ada
        $limit = 10;
    
        $response = $this->animeModel->getAnimeByGenre($genreId, $limit, $page);
        $animeList = $response['data'] ?? [];
        $pagination = $response['pagination'] ?? [];
    
        $label = $this->animeModel->getGenreNameById($genreId);
    
        return view('user.anime.viewAllByLabel', compact('animeList', 'pagination', 'label', 'genreId'));
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
        return view('user.anime.show', compact('anime', 'relatedAnimes','comments'));
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
    $genres = $this->animeModel->getAllGenres(77);
    // dd($genres);

    return view('user.anime.viewAllGenre', compact('genres'));
    }
} 