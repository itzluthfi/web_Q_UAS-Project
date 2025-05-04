<?php

require_once 'app/models/AnimeModel.php';

class AnimeController {
    public function index() {
        $animeModel = new AnimeModel();
        $animeList = $animeModel->getTopAnime(10); // Ambil 10 anime
          if (!$animeList) {
            echo "Anime List tidak ditemukan.";
            return;
        }
        require 'app/views/user/anime/index.php';
    }


    public function show($id) {
        $animeModel = new AnimeModel();
        $anime = $animeModel->getAnimeById($id);

        if (!$anime) {
            echo "Anime detail tidak ditemukan.";
            return;
        }

        require 'app/views/user/anime/show.php';
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
    $animeList = $animeModel->searchAnime($query);

    require 'app/views/user/anime/index.php'; // tampilkan view yang sama
}

    
}