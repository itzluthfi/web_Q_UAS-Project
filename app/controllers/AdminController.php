<?php

require_once 'models/UserModel.php';

class AdminController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    // Tampilkan semua user
    public function manageUsers() {
        try {
            $users = $this->userModel->getAllUsers();
            require 'views/admin/users/index.php';
        } catch (Exception $e) {
            $this->handleError("Gagal memuat data pengguna: " . $e->getMessage());
        }
    }

    // Tampilkan form edit user
    public function edit($id) {
        try {
            $user = $this->userModel->getUserById($id);

            if (!$user) {
                throw new Exception("User tidak ditemukan.");
            }

            require 'views/admin/users/edit.php';
        } catch (Exception $e) {
            $this->handleError("Gagal membuka form edit: " . $e->getMessage());
        }
    }

    // Update user
    public function update($id) {
        try {
            if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['role'])) {
                throw new Exception("Semua field harus diisi.");
            }

            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $role = trim($_POST['role']);

            $success = $this->userModel->updateUser($id, $username, $email, $role);

            if (!$success) {
                throw new Exception("Gagal memperbarui data pengguna.");
            }

            header("Location: /admin/users");
            exit;
        } catch (Exception $e) {
            $this->handleError("Gagal update user: " . $e->getMessage());
        }
    }

    // Hapus user
    public function delete($id) {
        try {
            $success = $this->userModel->deleteUser($id);

            if (!$success) {
                throw new Exception("Gagal menghapus pengguna.");
            }

            header("Location: /admin/users");
            exit;
        } catch (Exception $e) {
            $this->handleError("Gagal hapus user: " . $e->getMessage());
        }
    }

    // Penanganan error umum
    private function handleError($message) {
        // Bisa diganti dengan sistem log, redirect, atau flash message
        echo "<h2>Error:</h2><p>$message</p><a href='/admin/users'>Kembali</a>";
        exit;
    }
}