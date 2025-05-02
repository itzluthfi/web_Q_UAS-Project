<?php
class AdminMiddleware {
    public static function handle() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            // echo "Akses ditolak: Anda bukan admin.";
            $_SESSION['error_message'] = "Akses ditolak: Anda bukan admin.";
            header("Location: /anime-list-uas/");
            // echo "<script>alert(Akses ditolak: Anda bukan admin.);</script>";
            exit;
        }
        
    }
}