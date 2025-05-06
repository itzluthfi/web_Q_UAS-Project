<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat 2 user default
        User::create([
            'username' => 'luthfi',
            'email' => 'luthfi@example.com', // Sesuaikan dengan email yang diinginkan
            'password' => Hash::make('admin'), // Password 'admin' dienkripsi
            'role' => 'admin', // Misal set role 'admin' untuk Luthfi
        ]);

        User::create([
            'username' => 'brillian',
            'email' => 'brillian@example.com', // Sesuaikan dengan email yang diinginkan
            'password' => Hash::make('user'), // Password 'user' dienkripsi
            'role' => 'user', // Misal set role 'user' untuk Brillian
        ]);

        // Menggunakan factory untuk menambahkan 10 user lainnya
        User::factory(10)->create();

        // Menambahkan 15 komentar
        Comment::factory(15)->create();
    }
}