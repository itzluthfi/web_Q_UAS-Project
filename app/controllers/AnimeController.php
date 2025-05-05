<?php

require_once 'app/models/AnimeModel.php';

class AnimeController {
    public function beranda() {
        $animeModel = new AnimeModel();
        $animeTop = $animeModel->getTopAnime(10); // Ambil 10 anime
        $animeRandoms = $animeModel->getRandomAnimes(3); // Ambil 3 anime
        $animePopular = $animeModel->getPopularAnime();
        $animeCurrentSeasonal = $animeModel->getCurrentSeasonAnime();
        $categories = $animeModel->getAllGenres();
        //   if (!$animeTop) {
        //     echo "Anime List tidak ditemukan.";
        //     return;
        // }

        // require 'app/views/user/anime/index.php';
        return view('user/anime/beranda',compact('animeTop','animePopular','animeCurrentSeasonal','animeRandoms'));
    }
    
    public function viewAllByLabel($label) {
        $animeModel = new AnimeModel();
    
        // Susun nama method dinamis, misal: 'get' . 'Top' . 'Anime'
        $method = 'get' . ucfirst($label) . 'Anime';
    
        // Cek apakah method tersebut ada di AnimeModel
        if (method_exists($animeModel, $method)) {
            $animeList = $animeModel->$method(10);
        } else {
            echo "Label '$label' tidak valid.";
            return;
        }
    
        if (!$animeList) {
            echo "Anime List tidak ditemukan.";
            return;
        }
    
        return view('user/anime/viewAllByLabel', compact('animeList','label'));
    }
    


    public function show($id) {
        $animeModel = new AnimeModel();
        $anime = $animeModel->getAnimeById($id);

        if (!$anime) {
            echo "Anime detail tidak ditemukan.";
            return;
        }

        // require 'app/views/user/anime/show.php';
        return view('user/anime/show',compact('anime'));

    }

    public function recommendations($id) {
        $animeModel = new AnimeModel();
        $recommendations = $animeModel->getRecommendations($id);

        if (!$recommendations) {
            echo "Rekomendasi anime tidak ditemukan.";
            return;
        }
    
        require 'app/views/user/anime/recommendations.php';

    }

    public function search() {
        if (!isset($_GET['q'])) {
            $_SESSION['error_message'] = "Masukkan kata kunci pencarian.";
            header('Location: /anime-list-uas/');
            exit;
        }
    
        $query = $_GET['q'];
        $animeModel = new AnimeModel();
        $result = $animeModel->searchAnime($query);
    
        $animeList = $result['results'];
        $jmlResult = $result['total'];
    
        require 'app/views/user/anime/viewAllByLabel.php';
    }
    

    
}