<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnimeDetail extends Model
{
    protected $fillable = [
        'anime_id',
        'source',
        'rating',
        'trailer_url',
        'scored_by',
        'popularity',
        'members',
        'favorites',
        'background',
    ];

    // Relasi ke Anime
    public function anime()
    {
        return $this->belongsTo(Anime::class);
    }
}
