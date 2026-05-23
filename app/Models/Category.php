<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model untuk Kategori Berita
 * Menyimpan data kategori seperti Makanan, Teknologi, Pendidikan
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',      // Nama kategori
        'slug',      // Slug untuk URL yang SEO friendly
        'description', // Deskripsi kategori
        'color',     // Warna badge kategori
    ];

    /**
     * Relasi One-to-Many
     * Satu kategori memiliki banyak artikel
     */
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    /**
     * Scope untuk filter kategori aktif (yang memiliki artikel)
     */
    public function scopeActive($query)
    {
        return $query->has('articles');
    }
}
