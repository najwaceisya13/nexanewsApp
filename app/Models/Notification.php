<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model untuk Notifikasi
 * Mengirim notifikasi kepada admin ketika ada komentar baru
 */
class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',     // Admin yang menerima notifikasi
        'comment_id',  // Komentar yang baru
        'type',        // Tipe notifikasi (comment, etc)
        'message',     // Pesan notifikasi
        'read',        // Status baca notifikasi
    ];

    protected $casts = [
        'read' => 'boolean',
    ];

    /**
     * Relasi Many-to-One
     * Notifikasi diterima oleh satu user (admin)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi Many-to-One
     * Notifikasi tentang satu komentar
     */
    public function comment(): BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }

    /**
     * Scope untuk menampilkan notifikasi yang belum dibaca
     */
    public function scopeUnread($query)
    {
        return $query->where('read', false);
    }

    /**
     * Mark notifikasi sebagai sudah dibaca
     */
    public function markAsRead()
    {
        $this->update(['read' => true]);
    }
}
