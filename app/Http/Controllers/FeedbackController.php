<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

/**
 * Controller untuk mengelola Umpan Balik (Feedback) Pengunjung
 */
class FeedbackController extends Controller
{
    /**
     * Store feedback from visitors
     * POST /feedback
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|min:5|max:1000',
            'email' => 'nullable|email',
        ], [
            'message.required' => 'Pesan umpan balik harus diisi',
            'message.min' => 'Pesan umpan balik minimal 5 karakter',
            'message.max' => 'Pesan umpan balik maksimal 1000 karakter',
            'email.email' => 'Format email tidak valid',
        ]);

        Feedback::create([
            'message' => $validated['message'],
            'email' => $validated['email'] ?? null,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Terima kasih atas umpan balik Anda! Masukan Anda sangat berarti bagi kami.');
    }

    /**
     * Display list of feedbacks for admin
     * GET /admin/feedback
     */
    public function index()
    {
        // Admin authorization check is already handled by route middleware, 
        // but double check here as best practice
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403);
        }

        $feedbacks = Feedback::latest()->paginate(15);

        return view('admin.feedback', compact('feedbacks'));
    }

    /**
     * Delete feedback (admin only)
     * DELETE /admin/feedback/{feedback}
     */
    public function destroy(Feedback $feedback)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403);
        }

        $feedback->delete();

        return redirect()
            ->back()
            ->with('success', 'Umpan balik berhasil dihapus');
    }
}
