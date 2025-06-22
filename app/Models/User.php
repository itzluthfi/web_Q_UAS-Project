<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'profile_image_url',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function favoriteAnimes()
    {
        // user_id = kolom di favorite_anime, anime_mal_id = kolom di favorite_anime, id = users, mal_id = animes
        return $this->belongsToMany(Anime::class, 'favorite_anime', 'user_id', 'anime_mal_id', 'id', 'mal_id')
            ->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
