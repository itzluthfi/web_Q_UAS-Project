<?php

require_once 'app/models/CommentModel.php';

class CommentController {
    private $commentModel;

    public function __construct() {
        session_start();
        $this->commentModel = new CommentModel();
    }

    public function index() {
        try {
            $comments = $this->commentModel->getAllComments();
            return view('user/comment/index', compact('comments'));
        } catch (Exception $e) {
            $_SESSION['error'] = 'Gagal mengambil semua komentar: ' . $e->getMessage();
            return view('user/comment/index', ['comments' => []]);
        }
    }

    public function showByAnime($animeId) {
        try {
            $comments = $this->commentModel->getAllCommentsByAnimeId($animeId);
            return view('user/comment/by_anime', compact('comments', 'animeId'));
        } catch (Exception $e) {
            $_SESSION['error'] = 'Gagal mengambil komentar berdasarkan anime: ' . $e->getMessage();
            return view('user/comment/by_anime', ['comments' => [], 'animeId' => $animeId]);
        }
    }

    public function showByUser($userId) {
        try {
            $comments = $this->commentModel->getAllCommentsByUserId($userId);
            return view('user/comment/by_user', compact('comments', 'userId'));
        } catch (Exception $e) {
            $_SESSION['error'] = 'Gagal mengambil komentar berdasarkan user: ' . $e->getMessage();
            return view('user/comment/by_user', ['comments' => [], 'userId' => $userId]);
        }
    }

    public function show($id) {
        try {
            $comment = $this->commentModel->getCommentById($id);
            if (!$comment) {
                $_SESSION['error'] = 'Komentar tidak ditemukan.';
            }
            return view('user/comment/show', compact('comment'));
        } catch (Exception $e) {
            $_SESSION['error'] = 'Gagal mengambil komentar: ' . $e->getMessage();
            return view('user/comment/show', ['comment' => null]);
        }
    }

    public function create($animeId, $content, $userId, $parentId = null) {
        try {
            $success = $this->commentModel->addComment($animeId, $content, $userId, $parentId);
            if (!$success) {
                $_SESSION['error'] = 'Gagal menambahkan komentar.';
            }
            header("Location: /anime/$animeId"); // Redirect ke detail anime
            exit;
        } catch (Exception $e) {
            $_SESSION['error'] = 'Gagal menambahkan komentar: ' . $e->getMessage();
            header("Location: /anime/$animeId");
            exit;
        }
    }

    public function update($id, $content) {
        try {
            $success = $this->commentModel->updateComment($id, $content);
            if (!$success) {
                $_SESSION['error'] = 'Gagal memperbarui komentar.';
            }
            header("Location: /comment/$id");
            exit;
        } catch (Exception $e) {
            $_SESSION['error'] = 'Gagal memperbarui komentar: ' . $e->getMessage();
            header("Location: /comment/$id");
            exit;
        }
    }

    public function delete($id, $redirectTo = '/') {
        try {
            $success = $this->commentModel->deleteComment($id);
            if (!$success) {
                $_SESSION['error'] = 'Gagal menghapus komentar.';
            }
            header("Location: $redirectTo");
            exit;
        } catch (Exception $e) {
            $_SESSION['error'] = 'Gagal menghapus komentar: ' . $e->getMessage();
            header("Location: $redirectTo");
            exit;
        }
    }

    public function replies($parentId) {
        try {
            $replies = $this->commentModel->getReplies($parentId);
            return view('user/comment/replies', compact('replies', 'parentId'));
        } catch (Exception $e) {
            $_SESSION['error'] = 'Gagal mengambil balasan komentar: ' . $e->getMessage();
            return view('user/comment/replies', ['replies' => [], 'parentId' => $parentId]);
        }
    }
}