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

    public function getAnimeById($id) {
        $url = "https://api.jikan.moe/v4/anime/$id";
        $response = @file_get_contents($url);
        
        if ($response !== false) {
            $data = json_decode($response, true);
            return $data['data'] ?? [];
        }
        return [];
    }

    public function searchAnime($query) {
        $url = "https://api.jikan.moe/v4/anime?q=" . urlencode($query) . "&limit=10";
        $response = file_get_contents($url);
        $data = json_decode($response, true);
    
        return $data['data'] ?? [];
    }

    public function getRecommendations($animeId) {
        $url = "https://api.jikan.moe/v4/anime/$animeId/recommendations";
        $response = file_get_contents($url);
        $data = json_decode($response, true);
    
        return $data['data'] ?? [];
    }
    
    
}