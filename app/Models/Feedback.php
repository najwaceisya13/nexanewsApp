<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model untuk Umpan Balik / Feedback Pengunjung
 */
class Feedback extends Model
{
    use HasFactory;

    // Explicitly define table name
    protected $table = 'feedback';

    protected $fillable = [
        'message',
        'email',
    ];
}
