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

        Schema::create('animes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mal_id')->unique();
            $table->string('title');
            $table->string('title_english')->nullable();
            $table->text('synopsis')->nullable();
            $table->string('type')->nullable(); // TV, Movie, OVA, etc
            $table->integer('episodes')->nullable();
            $table->string('duration')->nullable(); // "24 min per ep"
            $table->float('score')->nullable();
            $table->integer('rank')->nullable();
            $table->string('status')->nullable(); // Airing, Finished, etc
            $table->string('season')->nullable(); // spring, fall, etc
            $table->integer('year')->nullable();
            $table->string('category')->nullable();
            $table->string('image_url')->nullable();
            $table->timestamp('aired_from')->nullable();
            $table->timestamp('aired_to')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animes');
    }
};
