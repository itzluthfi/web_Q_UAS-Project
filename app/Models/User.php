<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class User extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dari nama model (opsional)
    // protected $table = 'users';

    // Tentukan kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'username', 
        'email', 
        'password', 
        'role'
    ];

    // Tentukan kolom yang harus disembunyikan (jika ada)
    protected $hidden = [
        'password',
    ];

    // Fungsi untuk registrasi pengguna baru
    public static function register($username, $email, $password, $role = 'user')
    {
        $passwordHash = Hash::make($password); // Hash password menggunakan Hash facade

        return self::create([
            'username' => $username,
            'email' => $email,
            'password' => $passwordHash,
            'role' => $role,
        ]);
    }

    // Fungsi untuk login pengguna
    public static function login($username, $password)
    {
        $user = self::where('username', $username)->first(); // Ambil user berdasarkan username

        if ($user && Hash::check($password, $user->password)) {
            return $user; // Return user data jika password cocok
        }

        return null; // Return null jika login gagal
    }
}
