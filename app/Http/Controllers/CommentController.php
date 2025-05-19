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
        'parent_id' => 'nullable|integer|exists:comments,id', // Validasi parent_id
    ]);

    $userId = Auth::id();

    // Jika user ID tetap null, berikan error message
    if (!$userId) {
        return back()->withErrors(['msg' => 'Gagal mendapatkan user ID. Silakan coba lagi.']);
    }

    // Jika user ID ditemukan, simpan komentar
    $comment = Comment::create([
        'anime_id' => $request->anime_id,
        'content' => $request->content,
        'user_id' => $userId,
        'parent_id' => $request->parent_id, // Menyimpan parent_id jika ada
    ]);

    return redirect()->back()
    ->with('success', 'Komentar berhasil ditambahkan.')
    ->with('new_comment_id', $comment->id); // Kirim ID ke session;
}




}