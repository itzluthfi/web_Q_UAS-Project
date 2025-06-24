<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Anime;

class AnimeApi extends Controller
{
    public function index()
    {
        return response()->json(Anime::paginate(10));
    }

    public function show($id)
    {
        $anime = Anime::findOrFail($id);
        return response()->json($anime);
    }
}
