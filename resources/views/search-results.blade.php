@extends('layouts.app')

@section('title', 'Hasil Pencarian: ' . $query . ' - NexaNews')

@section('content')
<div class="min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Search Header -->
        <div class="mb-12">
            <h1 class="text-4xl font-bold mb-2">
                Hasil Pencarian untuk "{{ $query }}"
            </h1>
            <p class="text-gray-600">
                Ditemukan <span class="font-bold text-red-600">{{ $articles->total() }}</span> hasil
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Articles Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    @forelse($articles as $article)
                    <article class="news-card">
                        <img
                            src="{{ asset('storage/' . $article->image) }}"
                            alt="{{ $article->title }}"
                            class="news-card-image"
                        >
                        <div class="news-card-content">
                            <span class="news-category-badge">{{ $article->category->name }}</span>
                            <h3 class="news-card-title">
                                <a href="{{ route('articles.show', $article->slug) }}" class="hover:text-red-600 transition">
                                    {{ $article->title }}
                                </a>
                            </h3>
                            <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                                {{ Str::limit($article->content, 100) }}
                            </p>
                            <div class="news-card-meta">
                                <span>
                                    <i class="fas fa-user mr-1"></i>{{ $article->user->name }}
                                </span>
                                <span>
                                    <i class="fas fa-calendar mr-1"></i>{{ $article->published_at->format('d M Y') }}
                                </span>
                            </div>
                        </div>
                    </article>
                    @empty
                    <div class="col-span-2 text-center py-12">
                        <i class="fas fa-search text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500 mb-4">Tidak ada hasil untuk pencarian "{{ $query }}"</p>
                        <a href="{{ route('home') }}" class="btn-primary">
                            Kembali ke Beranda
                        </a>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="flex justify-center">
                    {{ $articles->links('pagination::tailwind') }}
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Search Tips -->
                <div class="sidebar-section">
                    <h3 class="sidebar-title">
                        <i class="fas fa-lightbulb mr-2" style="color: var(--primary-red);"></i>Tips Pencarian
                    </h3>

                    <ul class="space-y-3 text-sm text-gray-600">
                        <li>
                            <i class="fas fa-check text-green-600 mr-2"></i>
                            Gunakan kata kunci yang spesifik
                        </li>
                        <li>
                            <i class="fas fa-check text-green-600 mr-2"></i>
                            Coba tata bahasa yang berbeda
                        </li>
                        <li>
                            <i class="fas fa-check text-green-600 mr-2"></i>
                            Periksa ejaan Anda
                        </li>
                        <li>
                            <i class="fas fa-check text-green-600 mr-2"></i>
                            Gunakan filter kategori di bawah
                        </li>
                    </ul>
                </div>

                <!-- Trending Articles -->
                <div class="sidebar-section">
                    <h3 class="sidebar-title">
                        <i class="fas fa-fire mr-2" style="color: var(--primary-red);"></i>Trending Kini
                    </h3>

                    <div class="space-y-4">
                        @foreach($trending as $index => $article)
                        <div class="trending-item">
                            <div class="trending-number">{{ $index + 1 }}</div>
                            <div class="trending-info">
                                <div class="trending-title">
                                    <a href="{{ route('articles.show', $article->slug) }}" class="hover:text-red-600 transition">
                                        {{ $article->title }}
                                    </a>
                                </div>
                                <div class="trending-views">
                                    <i class="fas fa-eye mr-1"></i>{{ number_format($article->views) }} views
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Kategori -->
                <div class="sidebar-section">
                    <h3 class="sidebar-title">Kategori</h3>
                    <div>
                        @foreach($categories as $category)
                        <a
                            href="{{ route('category.show', $category->slug) }}"
                            class="category-tag"
                        >
                            {{ $category->name }}
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
