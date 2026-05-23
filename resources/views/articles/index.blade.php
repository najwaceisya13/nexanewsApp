@extends('layouts.app')

@section('title', 'Kelola Artikel - NexaNews')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Kelola Artikel</h1>
        <a href="{{ route('articles.create') }}" class="btn-primary">
            <i class="fas fa-plus mr-2"></i>Buat Artikel Baru
        </a>
    </div>

    <!-- Search & Filter -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <form action="{{ route('articles.index') }}" method="GET" class="flex gap-4">
            <input
                type="text"
                name="search"
                placeholder="Cari artikel..."
                value="{{ request('search') }}"
                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-red-600"
            >
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-red-600">
                <option value="">Semua Status</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
            </select>
            <button type="submit" class="btn-primary">
                <i class="fas fa-search mr-2"></i>Cari
            </button>
        </form>
    </div>

    <!-- Alerts -->
    @if(session('success'))
    <div class="alert alert-success mb-6">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    </div>
    @endif

    <!-- Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-4 text-left font-semibold text-sm">Judul</th>
                    <th class="px-6 py-4 text-left font-semibold text-sm">Kategori</th>
                    <th class="px-6 py-4 text-left font-semibold text-sm">Status</th>
                    <th class="px-6 py-4 text-center font-semibold text-sm">Views</th>
                    <th class="px-6 py-4 text-left font-semibold text-sm">Dibuat</th>
                    <th class="px-6 py-4 text-left font-semibold text-sm">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($articles as $article)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <div class="font-medium">{{ Str::limit($article->title, 50) }}</div>
                        <div class="text-xs text-gray-500">{{ $article->slug }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm">{{ $article->category->name }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $article->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($article->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <i class="fas fa-eye text-gray-400 mr-2"></i>{{ number_format($article->views) }}
                    </td>
                    <td class="px-6 py-4 text-sm">
                        {{ $article->created_at->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-3">
                            <a href="{{ route('articles.show', $article->slug) }}" class="text-green-600 hover:text-green-800" title="Lihat">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('articles.edit', $article) }}" class="text-blue-600 hover:text-blue-800" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('articles.destroy', $article) }}" method="POST" class="inline" onsubmit="return confirm('Hapus artikel ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                        <i class="fas fa-inbox text-3xl mb-2"></i>
                        <p>Belum ada artikel</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $articles->links('pagination::tailwind') }}
    </div>
</div>
@endsection
