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
}
