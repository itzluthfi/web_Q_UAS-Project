<?php
class AuthMiddleware {
    public static function handle() {
        if (!isset($_SESSION['user'])) {
            header("Location: /anime-list-uas/login");
            exit;
        }
    }
}