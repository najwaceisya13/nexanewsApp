<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

/**
 * Controller untuk mengelola Like pada Berita
 */
class LikeController extends Controller
{
    /**
     * Toggle like pada artikel
     * POST /articles/{id}/like
     */
    public function toggle(Article $article)
    {
        $sessionId = Session::getId();
        $userId = auth()->id();

        // Cari like yang sudah ada
        $like = Like::where('article_id', $article->id)
            ->where(function ($query) use ($sessionId, $userId) {
                $query->where('session_id', $sessionId)
                      ->orWhere('user_id', $userId);
            })
            ->first();

        if ($like) {
            // Jika sudah like, hapus
            $like->delete();
            $message = 'Like dihapus';
        } else {
            // Jika belum like, tambah
            Like::create([
                'article_id' => $article->id,
                'session_id' => $userId ? null : $sessionId,
                'user_id' => $userId,
            ]);
            $message = 'Like ditambahkan';
        }

        // Return JSON response untuk AJAX
        return response()->json([
            'success' => true,
            'message' => $message,
            'likes_count' => $article->likes()->count(),
        ]);
    }

    /**
     * Get likes count untuk artikel
     * GET /articles/{id}/likes-count
     */
    public function getCount(Article $article)
    {
        $sessionId = Session::getId();
        $userId = auth()->id();

        $isLiked = $article->likes()
            ->where(function ($query) use ($sessionId, $userId) {
                $query->where('session_id', $sessionId)
                      ->orWhere('user_id', $userId);
            })
            ->exists();

        return response()->json([
            'likes_count' => $article->likes()->count(),
            'is_liked' => $isLiked,
        ]);
    }
}
