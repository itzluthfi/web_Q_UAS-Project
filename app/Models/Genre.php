<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $fillable = [
        'mal_id',
        'name',
    ];

    // Relasi many-to-many ke Anime
    public function animes()
    {
        return $this->belongsToMany(Anime::class, 'anime_genre', 'genre_id', 'anime_id')
            ->withTimestamps();
    }

    public static function getAllGenres()
    {
        return static::withCount('animes')
            ->orderBy('name')
            ->get()
            ->map(function ($genre) {
                return [
                    'id' => $genre->id,
                    'name' => $genre->name,
                    'count' => $genre->animes_count ?? 0,
                ];
            });
    }
}
