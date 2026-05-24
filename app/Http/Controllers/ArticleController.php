<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;

/**
 * Controller untuk mengelola Berita/Artikel
 * Fitur: Create, Read, Update, Delete berita dengan upload gambar
 */
class ArticleController extends Controller
{

    /**
     * Display a listing of the resource.
     * GET /articles - Tampilkan daftar semua artikel
     */
    public function index()
    {
        $articles = Article::with('category', 'user')
            ->paginate(15);

        return view('articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     * GET /articles/create - Form buat artikel baru
     */
    public function create()
    {
        $categories = Category::all();

        return view('articles.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     * POST /articles - Simpan artikel baru ke database
     */
    public function store(StoreArticleRequest $request)
    {
        // Validasi sudah dilakukan di Form Request
        $validated = $request->validated();

        // Handle upload gambar
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('articles', 'public');
            $validated['image'] = $imagePath;
        }

        // Set user_id dari admin yang login
        $validated['user_id'] = auth()->id();

        // Jika status publish, set published_at
        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        Article::create($validated);

        return redirect()
            ->route('articles.index')
            ->with('success', 'Artikel berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     * GET /articles/{id} - Tampilkan detail artikel
     */
    public function show(Article $article)
    {
        // Increment views
        $article->increment('views');

        $article->load('category', 'user', 'comments.user');

        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     * GET /articles/{id}/edit - Form edit artikel
     */
    public function edit(Article $article)
    {
        // Check authorization - hanya penulis atau admin yang bisa edit
        if (auth()->id() !== $article->user_id && !auth()->user()->isAdmin()) {
            abort(403, 'Tidak diizinkan mengakses resource ini');
        }

        $categories = Category::all();

        return view('articles.edit', compact('article', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     * PUT/PATCH /articles/{id} - Update artikel
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        // Check authorization
        if (auth()->id() !== $article->user_id && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validated();

        // Handle upload gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }

            $image = $request->file('image');
            $imagePath = $image->store('articles', 'public');
            $validated['image'] = $imagePath;
        }

        // Update published_at jika status berubah ke published
        if ($request->input('status') === 'published' && $article->status !== 'published') {
            $validated['published_at'] = now();
        }

        $article->update($validated);

        return redirect()
            ->route('articles.show', $article)
            ->with('success', 'Artikel berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /articles/{id} - Hapus artikel
     */
    public function destroy(Article $article)
    {
        // Check authorization
        if (auth()->id() !== $article->user_id && !auth()->user()->isAdmin()) {
            abort(403);
        }

        // Hapus gambar jika ada
        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }

        $article->delete();

        return redirect()
            ->route('articles.index')
            ->with('success', 'Artikel berhasil dihapus!');
    }
}
