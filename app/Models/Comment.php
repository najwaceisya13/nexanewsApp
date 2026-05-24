<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model untuk Komentar pada Berita
 * Pengunjung bisa komentar tanpa login (anonymous comment)
 */
class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id',  // Berita yang dikomentar
        'user_id',     // User yang komentar (opsional)
        'name',        // Nama pengunjung (untuk anonymous)
        'email',       // Email pengunjung
        'content',     // Isi komentar
        'status',      // Status: pending, approved, atau rejected
    ];

    /**
     * Relasi Many-to-One
     * Banyak komentar pada satu artikel
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Relasi Many-to-One
     * Komentar milik satu user (jika sudah login)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi One-to-Many
     * Satu komentar memiliki banyak notifikasi
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Scope untuk menampilkan hanya komentar yang di-approve
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope untuk menampilkan komentar yang pending (perlu moderasi)
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Get nama komentar (dari user atau nama pengunjung)
     */
    public function getCommentorNameAttribute()
    {
        return $this->user ? $this->user->name : ($this->name ?: 'Pengunjung');
    }

    /**
     * Get email komentar (dari user atau email pengunjung)
     */
    public function getCommentorEmailAttribute()
    {
        return $this->user ? $this->user->email : ($this->email ?: '-');
    }
}
