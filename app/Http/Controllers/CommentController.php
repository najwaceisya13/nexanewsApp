<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Notification;
use Illuminate\Http\Request;

/**
 * Controller untuk mengelola Komentar pada Berita
 */
class CommentController extends Controller
{
    /**
     * Store a newly created comment in storage.
     * POST /articles/{id}/comments - Tambah komentar baru
     */
    public function store(Request $request, Article $article)
    {
        $validated = $request->validate([
            'content' => 'required|string|min:5|max:1000',
        ], [
            'content.required' => 'Komentar harus diisi',
            'content.min' => 'Komentar minimal 5 karakter',
            'content.max' => 'Komentar maksimal 1000 karakter',
        ]);

        $comment = new Comment();
        $comment->article_id = $article->id;
        $comment->content = $validated['content'];

        // Jika user sudah login
        if (auth()->check()) {
            $comment->user_id = auth()->id();
        } else {
            // Jika anonymous
            $comment->name = null;
            $comment->email = null;
        }

        // Status default pending (perlu moderasi)
        $comment->status = 'pending';
        $comment->save();

        // Kirim notifikasi ke semua admin
        $this->notifyAdmins($article, $comment);

        return redirect()
            ->route('articles.show', $article->slug)
            ->with('success', 'Komentar berhasil ditambahkan! Menunggu persetujuan admin.');
    }

    /**
     * Approve comment (admin only)
     * PATCH /comments/{id}/approve
     */
    public function approve(Comment $comment)
    {
        $this->authorize('approve', $comment);

        $comment->update(['status' => 'approved']);

        return redirect()
            ->back()
            ->with('success', 'Komentar berhasil disetujui');
    }

    /**
     * Reject comment (admin only)
     * PATCH /comments/{id}/reject
     */
    public function reject(Comment $comment)
    {
        $this->authorize('approve', $comment);

        $comment->update(['status' => 'rejected']);

        return redirect()
            ->back()
            ->with('success', 'Komentar berhasil ditolak');
    }

    /**
     * Delete comment (admin or own comment)
     * DELETE /comments/{id}
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $article = $comment->article;

        $comment->delete();

        return redirect()
            ->back()
            ->with('success', 'Komentar berhasil dihapus');
    }

    /**
     * Notify admins tentang komentar baru
     */
    private function notifyAdmins(Article $article, Comment $comment)
    {
        // Get all admins
        $admins = \App\Models\User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'comment_id' => $comment->id,
                'type' => 'comment',
                'message' => 'Ada komentar baru pada artikel: ' . $article->title,
                'read' => false,
            ]);
        }
    }
}
