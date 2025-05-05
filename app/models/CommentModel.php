<?php

require_once 'config/database.php';

class CommentModel {
    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    // Ambil semua komentar tanpa filter
    public function getAllComments() {
        $result = $this->db->query("SELECT * FROM comments ORDER BY created_at DESC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Ambil komentar berdasarkan anime_id
    public function getAllCommentsByAnimeId($animeId) {
        $stmt = $this->db->prepare("SELECT * FROM comments WHERE anime_id = ? ORDER BY created_at DESC");
        $stmt->bind_param("i", $animeId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Ambil komentar berdasarkan user_id
    public function getAllCommentsByUserId($userId) {
        $stmt = $this->db->prepare("SELECT * FROM comments WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Ambil komentar berdasarkan ID
    public function getCommentById($id) {
        $stmt = $this->db->prepare("SELECT * FROM comments WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Tambahkan komentar baru
    public function addComment($animeId, $content, $userId, $parentId = null) {
        $stmt = $this->db->prepare("INSERT INTO comments (anime_id, content, created_at, user_id, parent_id) VALUES (?, ?, NOW(), ?, ?)");
        $stmt->bind_param("isii", $animeId, $content, $userId, $parentId);
        return $stmt->execute();
    }

    // Perbarui komentar
    public function updateComment($id, $content) {
        $stmt = $this->db->prepare("UPDATE comments SET content = ? WHERE id = ?");
        $stmt->bind_param("si", $content, $id);
        return $stmt->execute();
    }

    // Hapus komentar
    public function deleteComment($id) {
        $stmt = $this->db->prepare("DELETE FROM comments WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Ambil balasan dari komentar tertentu
    public function getReplies($parentId) {
        $stmt = $this->db->prepare("SELECT * FROM comments WHERE parent_id = ? ORDER BY created_at ASC");
        $stmt->bind_param("i", $parentId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}