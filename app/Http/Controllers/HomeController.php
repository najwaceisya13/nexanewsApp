<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

/**
 * Controller untuk halaman Frontend
 * Fitur: Homepage, detail berita, kategori, search
 */
class HomeController extends Controller
{
    /**
     * Tampilkan homepage dengan berita terbaru
     * GET / - Homepage
     */
    public function index()
    {
        // Berita terbaru untuk hero section
        $hero = Article::published()->latest()->first();

        // Berita terbaru untuk grid (excluding hero)
        $latestArticles = Article::published()
            ->with('category', 'user')
            ->when($hero, function ($query) use ($hero) {
                return $query->where('id', '!=', $hero->id);
            })
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        // Trending (artikel dengan views terbanyak)
        $trending = Article::published()
            ->orderBy('views', 'desc')
            ->limit(3)
            ->get();

        // Kategori untuk sidebar
        $categories = Category::has('articles')->get();

        return view('home', compact('hero', 'latestArticles', 'trending', 'categories'));
    }

    /**
     * Tampilkan detail berita
     * GET /articles/{slug} - Detail berita
     */
    public function show($slug)
    {
        $article = Article::where('slug', $slug)
            ->published()
            ->with('category', 'user', 'comments')
            ->firstOrFail();

        // Increment views
        $article->increment('views');

        // Get session ID atau user ID untuk track like
        $sessionId = Session::getId();
        $userId = auth()->id();

        $isLiked = $article->likes()
            ->where(function ($query) use ($sessionId, $userId) {
                $query->where('session_id', $sessionId)
                      ->orWhere('user_id', $userId);
            })
            ->exists();

        // Komentar yang approved
        $comments = $article->comments()
            ->approved()
            ->with('user')
            ->latest()
            ->paginate(5);

        // Kategori untuk sidebar
        $categories = Category::has('articles')->get();

        // Trending
        $trending = Article::published()
            ->orderBy('views', 'desc')
            ->limit(3)
            ->get();

        return view('articles.show', compact('article', 'isLiked', 'comments', 'categories', 'trending'));
    }

    /**
     * Tampilkan berita berdasarkan kategori
     * GET /category/{slug} - Berita per kategori
     */
    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $articles = $category->articles()
            ->published()
            ->with('category', 'user')
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        // Trending
        $trending = Article::published()
            ->orderBy('views', 'desc')
            ->limit(3)
            ->get();

        // Semua kategori
        $categories = Category::has('articles')->get();

        return view('categories.show', compact('category', 'articles', 'trending', 'categories'));
    }

    /**
     * Tampilkan hasil pencarian berita
     * GET /search?q=keyword - Search berita
     */
    public function search(Request $request)
    {
        $query = $request->input('q');

        if (!$query || strlen($query) < 3) {
            return redirect()->route('home')->with('error', 'Masukkan minimal 3 karakter untuk pencarian');
        }

        $articles = Article::published()
            ->search($query)
            ->with('category', 'user')
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        // Trending
        $trending = Article::published()
            ->orderBy('views', 'desc')
            ->limit(3)
            ->get();

        // Semua kategori
        $categories = Category::has('articles')->get();

        return view('search-results', compact('query', 'articles', 'trending', 'categories'));
    }
}
