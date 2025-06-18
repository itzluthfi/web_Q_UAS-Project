<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnimeSyncLog extends Model
{
    use HasFactory;

    protected $table = 'anime_sync_logs';

    // Kolom yang bisa diisi secara massal (mass assignable)
    protected $fillable = [
        'category',
        'limit_data',
        'pages_fetched',
        'anime_synced',
        'status',
        'keterangan',
        'synced_at',
    ];

    // Jika ingin otomatis casting ke instance Carbon
    protected $casts = [
        'synced_at' => 'datetime',
    ];
}
