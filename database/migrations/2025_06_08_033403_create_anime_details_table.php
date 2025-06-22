<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('anime_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anime_id')->constrained('animes')->onDelete('cascade');
            $table->string('source')->nullable(); // Manga, Light Novel, Original
            $table->string('rating')->nullable(); // PG-13, R, etc
            $table->string('trailer_url')->nullable();
            $table->string('trailer_embed_url')->nullable();
            $table->string('url')->nullable();
            $table->integer('scored_by')->nullable(); // jumlah reviewer
            $table->integer('popularity')->nullable();
            $table->integer('members')->nullable();
            $table->integer('favorites')->nullable();
            $table->text('background')->nullable(); // kadang panjang banget
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anime_details');
    }
};
