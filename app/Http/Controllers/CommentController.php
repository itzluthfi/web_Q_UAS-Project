<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
 * Store a new comment.
 */
public function store(Request $request)
{
    // Cek apakah user sudah login
    if (!Auth::check()) {
        return redirect()->route('login')->withErrors(['msg' => 'Anda harus login untuk memberikan komentar.']);
    }

    $request->validate([
        'anime_id' => 'required|integer',
        'content' => 'required|string|max:500',
    ]);

    $userId = Auth::id();

    // Jika user ID tetap null, berikan error message
    if (!$userId) {
        return back()->withErrors(['msg' => 'Gagal mendapatkan user ID. Silakan coba lagi.']);
    }

    // Jika user ID ditemukan, simpan komentar
    Comment::create([
        'anime_id' => $request->anime_id,
        'content' => $request->content,
        'user_id' => $userId,
    ]);

    return back()->with('success', 'Komentar berhasil ditambahkan.');
}


    /**
     * Reply to a comment.
     */
   public function reply(Request $request, Comment $comment)
{
    $request->validate([
        'content' => 'required|string|max:500',
    ]);

    Comment::create([
        'anime_id' => $comment->anime_id,
        'content' => $request->content,
        'user_id' => Auth::id(),
        'parent_id' => $comment->id,
    ]);

    return back()->with('success', 'Balasan berhasil ditambahkan.');
}

}