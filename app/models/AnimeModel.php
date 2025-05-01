<?php

class AnimeModel {
    public function getTopAnime($limit = 10) {
        $url = "https://api.jikan.moe/v4/top/anime?limit=$limit";
        $response = file_get_contents($url);
        if ($response !== false) {
            $data = json_decode($response, true);
            return $data['data'] ?? [];
        }
        return [];
    }
}