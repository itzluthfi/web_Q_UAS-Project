<?php

require_once 'app/models/UserModel.php';

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function registerForm() {
        require 'app/views/auth/register.php';
    }

    public function register()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = $_POST['role'];

        // Coba untuk melakukan registrasi
        $result = $this->userModel->register($username, $email, $password, $role);

        // Jika hasilnya adalah string error (username sudah ada), tampilkan pesan
        if ($result !== true) {
            $_SESSION['error_message'] = $result;
            include 'app/views/auth/register.php';
        } else {
            // Redirect atau tampilkan sukses
            $_SESSION['success_message'] = "Registrasi berhasil! Silakan login.";
            header("Location: /anime-list-uas/login");
            exit;
        }
    } else {
        include 'app/views/auth/register.php';
    }
}

    public function loginForm() {
        require 'app/views/auth/login.php';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $this->userModel->login($username, $password);

            if ($user) {
                session_start();
                $_SESSION['user'] = $user; // Simpan data user ke session
                $_SESSION['success_message'] = "Login berhasil!";
                header('Location: /anime-list-uas/'); // Redirect ke halaman utama setelah login sukses
                exit;
            } else {
                $_SESSION['error_message'] = "Login gagal! Username atau password salah.";
                
            }
        }
    }

    public function logout() {
   
            session_start();
            session_destroy();
            header('Location: /anime-list-uas/');
            exit;
       
    }
    
}