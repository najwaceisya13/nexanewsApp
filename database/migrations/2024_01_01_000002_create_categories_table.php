<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Table untuk kategori berita
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Nama kategori (Makanan, Teknologi, Pendidikan)
            $table->string('slug')->unique(); // Slug untuk URL yang SEO friendly
            $table->text('description')->nullable(); // Deskripsi kategori
            $table->string('color')->default('#c1121f'); // Warna badge kategori
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
