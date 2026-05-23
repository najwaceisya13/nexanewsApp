<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Table untuk berita/artikel
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Penulis berita
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); // Kategori berita
            $table->string('title'); // Judul berita
            $table->string('slug')->unique(); // Slug untuk URL SEO friendly
            $table->text('content'); // Isi berita
            $table->string('image')->nullable(); // Path gambar berita
            $table->enum('status', ['draft', 'published'])->default('draft'); // Status publikasi
            $table->dateTime('published_at')->nullable(); // Tanggal publikasi
            $table->integer('views')->default(0); // Jumlah views
            $table->timestamps();

            // Index untuk query yang lebih cepat
            $table->index('category_id');
            $table->index('user_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
