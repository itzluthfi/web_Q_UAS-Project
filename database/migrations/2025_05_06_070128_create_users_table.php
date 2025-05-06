<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Kolom 'id' sebagai primary key (integer, auto-increment)
            $table->string('username'); // Kolom 'username' tipe string
            $table->string('email')->unique(); // Kolom 'email' tipe string dengan unique constraint
            $table->string('password'); // Kolom 'password' tipe string (untuk menyimpan password hash)
            $table->string('role'); // Kolom 'role' tipe string
            $table->timestamps(); // Kolom 'created_at' dan 'updated_at' otomatis
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users'); // Hapus tabel jika migrasi dibatalkan
    }
};