<?php

require_once 'config/database.php';

class UserModel {
    private $db;

    public function __construct() {
        $this->db = getDB();
    }

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