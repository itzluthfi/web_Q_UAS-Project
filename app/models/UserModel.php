<?php

require_once 'config/database.php';

class UserModel {
    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    //ROLE : ADMIN
    // Fungsi untuk mendapatkan semua pengguna
    // Ambil semua user
    public function getAllUsers() {
        $result = $this->db->query("SELECT id, username, email, role FROM users");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Ambil user berdasarkan ID
    public function getUserById($id) {
        $stmt = $this->db->prepare("SELECT id, username, email, role FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Update user
    public function updateUser($id, $username, $email, $role) {
        $stmt = $this->db->prepare("UPDATE users SET username = ?, email = ?, role = ? WHERE id = ?");
        $stmt->bind_param("sssi", $username, $email, $role, $id);
        return $stmt->execute();
    }

    // Hapus user
    public function deleteUser($id) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }


    //ROLE : USER
    // Fungsi untuk registrasi pengguna baru
    public function register($username, $email, $password, $role = 'user') {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT); // Enkripsi password

        $stmt = $this->db->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $passwordHash, $role);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Fungsi untuk login pengguna
    public function login($username, $password) {
        $stmt = $this->db->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            return $user; // Return user data
        }

        return false;
    }
}