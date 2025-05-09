<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;


use Illuminate\Http\Request;
use App\Models\Anime; // Ganti jika AnimeModel kamu pakai nama lain
use App\Models\Comment;

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
        $animeTop = $this->animeModel->getTopAnime(10);
        $animeUpcomings = $this->animeModel->getUpcomingAnime(5);
        $animePopular = $this->animeModel->getPopularAnime();
        $animeCurrentSeasonal = $this->animeModel->getCurrentSeasonAnime();
        $categories = $this->animeModel->getAllGenres();

        return view('user.anime.beranda', compact(
            'animeTop', 
            'animePopular', 
            'animeCurrentSeasonal', 
            'animeUpcomings',
            'categories'
        ));
    }
    public function berandaTemp()
    {
        $animeTop = $this->animeModel->getTopAnime(10);
        $animeUpcomings = $this->animeModel->getUpcomingAnime(5);
        $animePopular = $this->animeModel->getPopularAnime();
        $animeCurrentSeasonal = $this->animeModel->getCurrentSeasonAnime();
        $categories = $this->animeModel->getAllGenres();

        return view('user.anime.berandaTemp', compact(
            'animeTop', 
            'animePopular', 
            'animeCurrentSeasonal', 
            'animeUpcomings',
            'categories'
        ));
    }

    public function viewAllByLabel($label)
    {
        $method = 'get' . ucfirst($label) . 'Anime';

        if (!method_exists($this->animeModel, $method)) {
            return abort(404, "Label '$label' tidak valid.");
        }

        $animeList = $this->animeModel->$method(10);

        return view('user.anime.viewAllByLabel', compact('animeList', 'label'));
    }


    public function show($id)
    {
        // Ambil detail anime dari API
        $anime = Anime::getAnimeById($id);
    
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
            $relatedAnimes = Anime::getAnimeByGenre($firstGenreId, 4);
        }

        $comments = Comment::with('user')->where('anime_id', $id)->get();
        // dd($comments);
    
        // Kirim ke view
        return view('user.anime.show', compact('anime', 'relatedAnimes','comments'));
    }


    public function recommendations($id)
    {
        $recommendations = $this->animeModel->getRecommendations($id);

        if (!$recommendations) {
            return abort(404, 'Rekomendasi anime tidak ditemukan.');
        }

        return view('user.anime.recommendations', compact('recommendations'));
    }

    public function search(Request $request)
    {
        $query = $request->query('q');

        if (!$query) {
            return redirect()->route('home')->with('error', 'Masukkan kata kunci pencarian.');
        }

        $result = $this->animeModel->searchAnime($query);
        $animeList = $result['results'];
        $jmlResult = $result['total'];

        return view('user.anime.viewAllByLabel', compact('animeList', 'jmlResult', 'query'));
    }
} 