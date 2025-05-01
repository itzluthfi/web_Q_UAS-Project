<?php

require_once 'app/models/AnimeModel.php';

class AnimeController {
    public function index() {
        $animeModel = new AnimeModel();
        $animeList = $animeModel->getTopAnime(10); // Ambil 10 anime
        require 'app/views/anime/index.php';
    }

  

    public function show($id) {
        $animeModel = new AnimeModel();
        $anime = $animeModel->getAnimeById($id);

        if (!$anime) {
            echo "Anime tidak ditemukan.";
            return;
        }

        require 'app/views/anime/show.php';
    }
}

