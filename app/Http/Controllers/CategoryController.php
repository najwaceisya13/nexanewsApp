<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

/**
 * Controller untuk mengelola Kategori Berita
 * Fitur: Create, Read, Update, Delete kategori
 */
class CategoryController extends Controller
{
    /**
     * Constructor untuk middleware
     * Hanya admin yang bisa mengakses
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a listing of categories.
     * GET /categories - Tampilkan daftar kategori
     */
    public function index()
    {
        $categories = Category::withCount('articles')->paginate(15);

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     * GET /categories/create - Form buat kategori baru
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created category in storage.
     * POST /categories - Simpan kategori baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:categories|max:100',
            'slug' => 'nullable|string|unique:categories|max:100',
            'description' => 'nullable|string|max:500',
            'color' => 'nullable|regex:/^#[a-f0-9]{6}$/i',
        ], [
            'name.required' => 'Nama kategori harus diisi',
            'name.unique' => 'Nama kategori sudah ada',
            'slug.unique' => 'Slug sudah digunakan',
            'color.regex' => 'Format warna harus hex (contoh: #c1121f)',
        ]);

        // Generate slug otomatis jika tidak diisi
        if (!$validated['slug']) {
            $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']);
        }

        Category::create($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori berhasil dibuat!');
    }

    /**
     * Show the form for editing the specified category.
     * GET /categories/{id}/edit - Form edit kategori
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     * PUT /categories/{id} - Update kategori
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,' . $category->id,
            'slug' => 'nullable|string|max:100|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string|max:500',
            'color' => 'nullable|regex:/^#[a-f0-9]{6}$/i',
        ]);

        // Generate slug otomatis jika tidak diisi
        if (!$validated['slug']) {
            $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']);
        }

        $category->update($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori berhasil diupdate!');
    }

    /**
     * Remove the specified category from storage.
     * DELETE /categories/{id} - Hapus kategori
     */
    public function destroy(Category $category)
    {
        // Check apakah ada artikel dalam kategori ini
        if ($category->articles()->count() > 0) {
            return redirect()
                ->route('categories.index')
                ->with('error', 'Tidak dapat menghapus kategori yang memiliki artikel!');
        }

        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus!');
    }
}
