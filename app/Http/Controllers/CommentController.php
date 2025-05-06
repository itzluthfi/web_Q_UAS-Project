<!-- <?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment; // Ganti jika model kamu belum rename ke Eloquent
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class CommentController extends Controller
{
    protected $commentModel;

    public function __construct()
    {
        $this->commentModel = new Comment(); // Asumsinya ini adalah model Eloquent
    }

    public function index()
    {
        try {
            $comments = $this->commentModel->getAllComments();
            return view('user.comment.index', compact('comments'));
        } catch (\Exception $e) {
            return view('user.comment.index', ['comments' => []])
                   ->with('error', 'Gagal mengambil semua komentar: ' . $e->getMessage());
        }
    }

    public function showByAnime($animeId)
    {
        try {
            $comments = $this->commentModel->getAllCommentsByAnimeId($animeId);
            return view('user.comment.by_anime', compact('comments', 'animeId'));
        } catch (\Exception $e) {
            return view('user.comment.by_anime', ['comments' => [], 'animeId' => $animeId])
                   ->with('error', 'Gagal mengambil komentar berdasarkan anime: ' . $e->getMessage());
        }
    }

    public function showByUser($userId)
    {
        try {
            $comments = $this->commentModel->getAllCommentsByUserId($userId);
            return view('user.comment.by_user', compact('comments', 'userId'));
        } catch (\Exception $e) {
            return view('user.comment.by_user', ['comments' => [], 'userId' => $userId])
                   ->with('error', 'Gagal mengambil komentar berdasarkan user: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $comment = $this->commentModel->getCommentById($id);
            if (!$comment) {
                return back()->with('error', 'Komentar tidak ditemukan.');
            }
            return view('user.comment.show', compact('comment'));
        } catch (\Exception $e) {
            return view('user.comment.show', ['comment' => null])
                   ->with('error', 'Gagal mengambil komentar: ' . $e->getMessage());
        }
    }

    public function create(Request $request)
    {
        $request->validate([
            'anime_id' => 'required|integer',
            'content' => 'required|string',
            'user_id' => 'required|integer',
            'parent_id' => 'nullable|integer'
        ]);

        try {
            $success = $this->commentModel->addComment(
                $request->anime_id,
                $request->content,
                $request->user_id,
                $request->parent_id
            );

            if (!$success) {
                return redirect()->route('anime.show', $request->anime_id)->with('error', 'Gagal menambahkan komentar.');
            }

            return redirect()->route('anime.show', $request->anime_id)->with('success', 'Komentar berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->route('anime.show', $request->anime_id)
                             ->with('error', 'Gagal menambahkan komentar: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        try {
            $success = $this->commentModel->updateComment($id, $request->content);

            if (!$success) {
                return back()->with('error', 'Gagal memperbarui komentar.');
            }

            return redirect()->route('comment.show', $id)->with('success', 'Komentar berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui komentar: ' . $e->getMessage());
        }
    }

    public function delete(Request $request, $id)
    {
        $redirectTo = $request->input('redirectTo', '/');

        try {
            $success = $this->commentModel->deleteComment($id);

            if (!$success) {
                return redirect($redirectTo)->with('error', 'Gagal menghapus komentar.');
            }

            return redirect($redirectTo)->with('success', 'Komentar berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect($redirectTo)->with('error', 'Gagal menghapus komentar: ' . $e->getMessage());
        }
    }

    public function replies($parentId)
    {
        try {
            $replies = $this->commentModel->getReplies($parentId);
            return view('user.comment.replies', compact('replies', 'parentId'));
        } catch (\Exception $e) {
            return view('user.comment.replies', ['replies' => [], 'parentId' => $parentId])
                   ->with('error', 'Gagal mengambil balasan komentar: ' . $e->getMessage());
        }
    }
} 
