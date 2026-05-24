<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom penulis dan editor ke tabel articles
     */
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('penulis')->nullable()->after('image');  // Nama penulis dari redaksi
            $table->string('editor')->nullable()->after('penulis'); // Nama editor dari redaksi
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn(['penulis', 'editor']);
        });
    }
};
