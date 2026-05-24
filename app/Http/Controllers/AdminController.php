<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Controller untuk Dashboard Admin
 * Tampilkan statistik dan kelola konten
 */
class AdminController extends Controller
{

    /**
     * Tampilkan dashboard admin
     * GET /admin/dashboard
     */
    public function dashboard()
    {
        // Statistik
        $stats = [
            'total_articles' => Article::count(),
            'published_articles' => Article::published()->count(),
            'draft_articles' => Article::where('status', 'draft')->count(),
            'total_comments' => Comment::count(),
            'pending_comments' => Comment::pending()->count(),
            'total_categories' => Category::count(),
            'total_users' => User::count(),
        ];

        // Notifikasi belum dibaca untuk admin yang login
        $unreadNotifications = auth()->user()->notifications()
            ->unread()
            ->with('comment.article', 'comment.user')
            ->latest()
            ->limit(5)
            ->get();

        // Artikel terbaru
        $latestArticles = Article::with('category', 'user')
            ->latest()
            ->limit(5)
            ->get();

        // Komentar pending
        $pendingComments = Comment::pending()
            ->with('article', 'user')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'unreadNotifications', 'latestArticles', 'pendingComments'));
    }

    /**
     * Tampilkan halaman moderasi komentar
     * GET /admin/comments
     */
    public function comments(Request $request)
    {
        $status = $request->input('status', 'pending');

        $comments = Comment::where('status', $status)
            ->with('article', 'user')
            ->latest()
            ->paginate(15);

        return view('admin.comments', compact('comments', 'status'));
    }

    /**
     * Tampilkan halaman kelola user
     * GET /admin/users
     */
    public function users()
    {
        $users = User::paginate(15);

        return view('admin.users', compact('users'));
    }

    /**
     * Update role user
     * PATCH /admin/users/{id}/role
     */
    public function updateRole(Request $request, User $user)
    {
        // Prevent mengubah diri sendiri
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Tidak bisa mengubah role diri sendiri');
        }

        $validated = $request->validate([
            'role' => 'required|in:admin,user',
            'status' => 'required|in:active,inactive',
        ]);

        $user->update($validated);

        return back()->with('success', 'Role user berhasil diupdate');
    }

    /**
     * Mark notifikasi sebagai sudah dibaca
     * PATCH /admin/notifications/{id}/read
     */
    public function readNotification(Notification $notification)
    {
        // Ensure admin hanya bisa baca notifikasi mereka sendiri
        if ($notification->user_id !== auth()->id()) {
            abort(403);
        }

        $notification->markAsRead();

        return back();
    }

    /**
     * Mark semua notifikasi sebagai dibaca
     * PATCH /admin/notifications/read-all
     */
    public function readAllNotifications()
    {
        auth()->user()->notifications()
            ->unread()
            ->update(['read' => true]);

        return back()->with('success', 'Semua notifikasi ditandai sudah dibaca');
    }
}
