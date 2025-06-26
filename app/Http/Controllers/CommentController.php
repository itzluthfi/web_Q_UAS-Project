<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors(['msg' => 'Anda harus login untuk memberikan komentar.']);
        }

        $request->validate([
            'anime_id'  => 'required|integer',
            'content'   => 'required|string|max:500',
            'parent_id' => 'nullable|integer|exists:comments,id',
        ]);

        $userId = Auth::id();

        if (!$userId) {
            return back()->withErrors(['msg' => 'Gagal mendapatkan user ID. Silakan coba lagi.']);
        }

        $comment = Comment::create([
            'anime_id'  => $request->anime_id,
            'content'   => $request->content,
            'user_id'   => $userId,
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->back()
            ->with('success', 'Komentar berhasil ditambahkan.')
            ->with('new_comment_id', $comment->id);
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $comment = Comment::findOrFail($id);
        $currentUser = Auth::user();
// dd($currentUser->role);
        // Izinkan hanya pemilik komentar atau admin
        if ($comment->user_id !== $currentUser->id && $currentUser->role !== 'admin') {
            return back()->withErrors(['msg' => 'Anda tidak memiliki izin untuk mengedit komentar ini.']);
        }

        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $comment->update([
            'content' => $request->content,
        ]);

        // dd($comment);

        return redirect()->back()->with('success', 'Komentar berhasil diperbarui.');
    }

    public function delete($id)
    {
        $comment = Comment::findOrFail($id);
        $currentUser = Auth::user();

        // Izinkan hanya pemilik komentar atau admin
        if ($comment->user_id !== $currentUser->id && $currentUser->role !== 'admin') {
            return back()->withErrors(['msg' => 'Anda tidak memiliki izin untuk menghapus komentar ini.']);
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Komentar berhasil dihapus.');
    }
}
