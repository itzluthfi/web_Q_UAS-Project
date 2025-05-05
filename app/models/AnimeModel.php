<?php

class AnimeModel {

    // === Top Anime ===
    public function getTopAnime($limit = 10) {
        $url = "https://api.jikan.moe/v4/top/anime?limit=$limit";
        $response = file_get_contents($url);

        if ($response !== false) {
            $data = json_decode($response, true);
            return $data['data'] ?? [];
        }

        return [];
    }

    // === Detail Anime Berdasarkan ID ===
    public function getAnimeById($id) {
        $url = "https://api.jikan.moe/v4/anime/$id";
        $response = @file_get_contents($url);

        if ($response !== false) {
            $data = json_decode($response, true);
            return $data['data'] ?? [];
        }

        return [];
    }

    // === Fungsi untuk mendapatkan beberapa anime acak (default 5) ===
    public function getRandomAnimes($count = 5) {
        $randomAnimes = [];

        for ($i = 0; $i < $count; $i++) {
            $url = "https://api.jikan.moe/v4/random/anime";
            $response = file_get_contents($url);

            if ($response !== false) {
                $data = json_decode($response, true);
                if (isset($data['data'])) {
                    $randomAnimes[] = $data['data'];
                }
            }

            // Delay sedikit agar tidak diblokir (optional tapi disarankan)
            // usleep(500000); // 0.5 detik
        }

        return $randomAnimes;
    }


       // === Cari Anime Berdasarkan Judul ===
    public function searchAnime($query, $limit = 10) {
        $url = "https://api.jikan.moe/v4/anime?q=" . urlencode($query) . "&limit=$limit";
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        return [
            'results' => $data['data'] ?? [],
            'total' => $data['pagination']['items']['total'] ?? 0
        ];
    }


    // === Rekomendasi Anime Berdasarkan Anime ID ===
    public function getRecommendations($animeId) {
        $url = "https://api.jikan.moe/v4/anime/$animeId/recommendations";
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        return $data['data'] ?? [];
    }

    // === Anime Paling Populer (Trending) ===
    public function getPopularAnime($limit = 10) {
        $url = "https://api.jikan.moe/v4/top/anime?filter=bypopularity&limit=$limit";
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        return $data['data'] ?? [];
    }

    // === Anime yang Sedang Tayang (Airing) ===
    public function getAiringAnime($limit = 10) {
        $url = "https://api.jikan.moe/v4/top/anime?filter=airing&limit=$limit";
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        return $data['data'] ?? [];
    }

    // === Anime Musim Tertentu ===
    public function getSeasonalAnime($year, $season = 'spring') {
        $url = "https://api.jikan.moe/v4/seasons/$year/$season";
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        return $data['data'] ?? [];
    }

    // === Anime Musiman Saat Ini ===
    public function getCurrentSeasonAnime() {
        $url = "https://api.jikan.moe/v4/seasons/now";
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        return $data['data'] ?? [];
    }

    // === Anime Berdasarkan Genre ===
    public function getAnimeByGenre($genreId, $limit = 10) {
        $url = "https://api.jikan.moe/v4/anime?genres=$genreId&limit=$limit";
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        return $data['data'] ?? [];
    }

    // === Anime yang Akan Datang (Upcoming) ===
    public function getUpcomingAnime($limit = 10) {
        $url = "https://api.jikan.moe/v4/top/anime?filter=upcoming&limit=$limit";
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        return $data['data'] ?? [];
    }

    // === Karakter dalam Anime ===
    public function getAnimeCharacters($animeId) {
        $url = "https://api.jikan.moe/v4/anime/$animeId/characters";
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        return $data['data'] ?? [];
    }

    // === Staf (Staff) Anime ===
    public function getAnimeStaff($animeId) {
        $url = "https://api.jikan.moe/v4/anime/$animeId/staff";
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        return $data['data'] ?? [];
    }

    // === Video Trailer dan PV Anime ===
    public function getAnimeVideos($animeId) {
        $url = "https://api.jikan.moe/v4/anime/$animeId/videos";
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        return $data['data'] ?? [];
    }

    // === Berita Terkait Anime ===
    public function getAnimeNews($animeId) {
        $url = "https://api.jikan.moe/v4/anime/$animeId/news";
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        return $data['data'] ?? [];
    }

    // === Hubungan Anime (Sequel, Prequel, dll) ===
    public function getAnimeRelations($animeId) {
        $url = "https://api.jikan.moe/v4/anime/$animeId/relations";
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        return $data['data'] ?? [];
    }

    // === Ulasan (Review) dari Pengguna ===
    public function getAnimeReviews($animeId, $page = 1) {
        $url = "https://api.jikan.moe/v4/anime/$animeId/reviews?page=$page";
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        return $data['data'] ?? [];
    }

    // === Musik Tema Anime (OP & ED) ===
    public function getAnimeThemes($animeId) {
        $url = "https://api.jikan.moe/v4/anime/$animeId/themes";
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        return $data['data'] ?? [];
    }


    // === Ambil Semua Genre dari Jikan API ===
    public function getAllGenres()
    {
        $url = "https://api.jikan.moe/v4/genres/anime";
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        return $data['data'] ?? [];
    }

}