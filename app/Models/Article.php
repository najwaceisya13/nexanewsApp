<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * Model untuk Berita/Artikel
 * Menyimpan data berita dengan relasi ke kategori, user, komentar, dan like
 */
class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',      // User (admin) yang membuat berita
        'category_id',  // Kategori berita
        'title',        // Judul berita
        'slug',         // Slug untuk URL yang SEO friendly
        'content',      // Isi berita
        'image',        // Path gambar berita
        'penulis',      // Nama penulis dari redaksi
        'editor',       // Nama editor dari redaksi
        'status',       // Status: draft atau published
        'published_at', // Tanggal publikasi
        'views',        // Jumlah views
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function getRouteKeyName()
{
    return 'slug';
}
    /**
     * Event: Generate slug otomatis saat create dari title
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
        if (!$article->slug) {
            $article->slug = Str::slug($article->title);
        }
        });
    }

    /**
     * Relasi Many-to-One
     * Banyak artikel milik satu kategori
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi Many-to-One
     * Banyak artikel ditulis oleh satu user (admin)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi One-to-Many
     * Satu artikel memiliki banyak komentar
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Relasi One-to-Many
     * Satu artikel dapat dilike banyak kali
     */
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Hitung jumlah like artikel
     */
    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }

    /**
     * Hitung jumlah komentar yang di-approve
     */
    public function getApprovedCommentsCountAttribute()
    {
        return $this->comments()->where('status', 'approved')->count();
    }

    /**
     * Scope untuk menampilkan hanya artikel yang dipublish
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')->whereNotNull('published_at');
    }

    /**
     * Scope untuk menampilkan artikel terbaru
     */
    public function scopeLatest($query)
    {
        return $query->published()->orderBy('published_at', 'desc');
    }

    /**
     * Scope untuk search artikel berdasarkan title atau content
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('title', 'like', "%{$search}%")
                     ->orWhere('content', 'like', "%{$search}%");
    }
}
