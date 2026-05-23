<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model untuk Like/Reaksi pada Berita
 * Pengunjung bisa like tanpa login (menggunakan session_id)
 * atau dengan login (menggunakan user_id)
 */
class Like extends Model
{
    use HasFactory;

    public $timestamps = false; // Tidak perlu timestamps yang kompleks

    protected $fillable = [
        'article_id',  // Berita yang dilike
        'session_id',  // Session ID pengunjung tanpa login
        'user_id',     // User ID jika sudah login
    ];

    /**
     * Relasi Many-to-One
     * Banyak like pada satu artikel
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Relasi Many-to-One
     * Like milik satu user (jika sudah login)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
