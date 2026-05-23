<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Table untuk komentar berita (pengunjung bisa komentar tanpa login)
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained('articles')->onDelete('cascade'); // Berita yang dikomentar
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade'); // User (opsional, bisa anonymous)
            $table->string('name')->nullable(); // Nama pengunjung (untuk komentar tanpa login)
            $table->string('email')->nullable(); // Email pengunjung
            $table->text('content'); // Isi komentar
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // Status moderasi
            $table->timestamps();

            // Index untuk query yang lebih cepat
            $table->index('article_id');
            $table->index('user_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
