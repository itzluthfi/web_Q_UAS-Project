<?php

// database/migrations/2025_06_08_000001_create_categories_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // misal: top, popular, upcoming
            $table->timestamps();
        });

        Schema::create('anime_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anime_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['anime_id', 'category_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('anime_category');
        Schema::dropIfExists('categories');
    }
}
