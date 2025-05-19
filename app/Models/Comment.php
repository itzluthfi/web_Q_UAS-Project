<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'anime_id', 
        'content', 
        'user_id', 
        'parent_id'
    ];

    /**
     * Relationship with Anime.
     */
    public function anime()
    {
        return $this->belongsTo(Anime::class);
    }

    /**
     * Relationship with User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Replies relationship (recursive).
     */
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->with('user', 'replies');
    }

    /**
     * Scope for Comments by Anime ID.
     */
    public function scopeByAnime($query, $animeId)
    {
        return $query->where('anime_id', $animeId)->whereNull('parent_id');
    }

    /**
     * Accessor to Check if a Comment has Replies.  
     */
    public function getHasRepliesAttribute()
    {
        return $this->replies()->exists();
    }
}