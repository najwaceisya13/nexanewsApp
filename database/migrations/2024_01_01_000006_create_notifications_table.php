<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Table untuk notifikasi admin tentang komentar baru
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Admin yang menerima notifikasi
            $table->foreignId('comment_id')->constrained('comments')->onDelete('cascade'); // Komentar yang baru
            $table->string('type'); // Tipe notifikasi (comment, etc)
            $table->text('message'); // Pesan notifikasi
            $table->boolean('read')->default(false); // Sudah dibaca atau belum
            $table->timestamps();

            // Index untuk query yang lebih cepat
            $table->index('user_id');
            $table->index('read');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
