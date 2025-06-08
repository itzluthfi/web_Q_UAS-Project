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
        Schema::create('anime_sync_logs', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->integer('limit_data');
            $table->integer('pages_fetched');
            $table->integer('anime_synced');
            $table->timestamp('synced_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anime_sync_logs');
    }
};
