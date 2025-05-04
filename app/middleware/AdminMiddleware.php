<?php
class AdminMiddleware {
    public static function handle() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            // echo "Akses ditolak: Anda bukan admin.";
            // $_SESSION['error_message'] = "Akses ditolak: Anda bukan admin.";
            require 'app/views/errors/403.php';

            // echo "<script>alert(Akses ditolak: Anda bukan admin.);</script>";
            exit;
        }
        
    }
}