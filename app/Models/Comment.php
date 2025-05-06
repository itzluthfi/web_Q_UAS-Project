<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dari nama model (opsional)
    // protected $table = 'comments';

    // Tentukan kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'anime_id', 
        'content', 
        'user_id', 
        'parent_id'
    ];

    // Tentukan kolom yang perlu disembunyikan (opsional)
    // protected $hidden = ['created_at', 'updated_at'];

    // Menentukan hubungan dengan model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Menentukan hubungan dengan model Anime
    // public function anime()
    // {
    //     return $this->belongsTo(Anime::class);
    // }

    // Menentukan hubungan dengan komentar balasan (self-referencing)
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    // Scope untuk mendapatkan komentar berdasarkan anime_id
    public function scopeByAnime($query, $animeId)
    {
        return $query->where('anime_id', $animeId);
    }

    // Scope untuk mendapatkan komentar berdasarkan user_id
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
