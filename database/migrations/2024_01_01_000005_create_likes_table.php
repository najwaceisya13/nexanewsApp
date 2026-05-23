<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Table untuk like/reaksi pada berita
     */
    public function up(): void
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained('articles')->onDelete('cascade'); // Berita yang dilike
            $table->string('session_id')->nullable(); // Session ID untuk visitor tanpa login
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade'); // User ID jika sudah login
            $table->timestamps();

            // Prevent duplicate likes dari user/session yang sama
            $table->unique(['article_id', 'session_id', 'user_id']);

            // Index untuk query yang lebih cepat
            $table->index('article_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
