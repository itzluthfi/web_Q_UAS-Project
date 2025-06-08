<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    public function animes()
    {
        return $this->belongsToMany(Anime::class, 'anime_category', 'category_id', 'anime_id')
            ->withTimestamps();
    }
}
