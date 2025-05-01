<?php

require_once 'app/models/UserModel.php';

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    // Fungsi untuk tampilkan form registrasi
    public function registerForm() {
        require 'app/views/auth/register.php';
    }

    // Fungsi untuk proses registrasi
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $role = $_POST['role'] ?? 'user';

            if ($this->userModel->register($username, $email, $password, $role)) {
                header('Location: /login'); // Redirect ke halaman login setelah registrasi
                exit;
            } else {
                echo "Registrasi gagal!";
            }
        }
    }

    // Fungsi untuk tampilkan form login
    public function loginForm() {
        require 'app/views/auth/login.php';
    }

    // Fungsi untuk proses login
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $this->userModel->login($username, $password);

            if ($user) {
                session_start();
                $_SESSION['user'] = $user; // Simpan data user ke session
                header('Location: /'); // Redirect ke halaman utama setelah login sukses
                exit;
            } else {
                echo "Login gagal!";
            }
        }
    }

    // Fungsi untuk logout
    public function logout() {
        session_start();
        session_destroy();
        header('Location: /login'); // Redirect ke halaman login setelah logout
        exit;
    }
}