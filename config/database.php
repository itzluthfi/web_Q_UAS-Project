<?php


function getDB() {
    $dbConnection = null;
    try {
        // Membuat koneksi ke database
        $dbConnection = new mysqli("localhost", "root", "", "db_anime_list");

        // Cek koneksi
        if ($dbConnection->connect_error) {
            throw new Exception("Koneksi gagal: " . $dbConnection->connect_error);
        } else {
             echo "Koneksi berhasil";     
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
    return $dbConnection;
}