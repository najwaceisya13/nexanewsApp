@extends('layouts.app')

@section('title', 'NexaNews - Berita Terkini')

@section('content')
<div class="min-h-screen">
    <!-- Hero Section -->
    @if($hero)
    <div class="hero-section" style="background-image: url('{{ asset('storage/' . $hero->image) }}')">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <div class="hero-badge">{{ $hero->category->name }}</div>
            <h1 class="hero-title">{{ $hero->title }}</h1>
            <p class="hero-description">
                {{ Str::limit($hero->content, 150, '...') }}
            </p>
            <a href="{{ route('articles.show', $hero->slug) }}" class="btn-primary inline-block mt-4">
                Baca Selengkapnya →
            </a>
        </div>
    </div>
    @endif

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Alerts -->
        @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Content Area (2 columns) -->
            <div class="lg:col-span-2">
                <!-- Berita Terbaru Section -->
                <div class="mb-12">
                    <h2 class="text-3xl font-bold mb-8" style="color: #1f2937;">
                        <span style="color: var(--primary-red); border-bottom: 3px solid var(--primary-red);">Berita</span> Terbaru
                    </h2>

                    <!-- Grid 2 Kolom -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        @forelse($latestArticles as $article)
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
                            <i class="fas fa-newspaper text-4xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500">Belum ada berita tersedia</p>
                        </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="flex justify-center">
                        {{ $latestArticles->links('pagination::tailwind') }}
                    </div>

                    <!-- Load More Button -->
                    <div class="text-center mt-8">
                        <button class="btn-outline">
                            <i class="fas fa-arrow-down mr-2"></i>LIHAT LEBIH BANYAK
                        </button>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar (1 column) -->
            <div class="lg:col-span-1">
                <!-- Trending Kini -->
                <div class="sidebar-section">
                    <h3 class="sidebar-title">
                        <i class="fas fa-fire mr-2" style="color: var(--primary-red);"></i>Trending Kini
                    </h3>

                    @if($trending->count() > 0)
                    <!-- Berita Trending Utama -->
                    @if($trending->first()->image)
                    <img
                        src="{{ asset('storage/' . $trending->first()->image) }}"
                        alt="{{ $trending->first()->title }}"
                        class="w-full h-40 object-cover rounded-lg mb-4"
                    >
                    @endif

                    <h4 class="font-semibold text-sm mb-4 leading-snug">
                        <a href="{{ route('articles.show', $trending->first()->slug) }}" class="hover:text-red-600 transition">
                            {{ $trending->first()->title }}
                        </a>
                    </h4>

                    <!-- Trending List 1, 2, 3 -->
                    <div class="mt-6">
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
                    @else
                    <p class="text-gray-500 text-sm">Tidak ada trending artikel</p>
                    @endif
                </div>

                <!-- Kategori -->
                <div class="sidebar-section">
                    <h3 class="sidebar-title">
                        <i class="fas fa-list mr-2" style="color: var(--primary-red);"></i>Kategori
                    </h3>

                    <div>
                        @foreach($categories as $category)
                        <a
                            href="{{ route('category.show', $category->slug) }}"
                            class="category-tag {{ request()->routeIs('category.show', $category->slug) ? 'active' : '' }}"
                        >
                            {{ $category->name }}
                        </a>
                        @endforeach
                    </div>
                </div>

                <!-- Umpan Balik / Feedback Form -->
                <div class="feedback-form">
                    <h3 class="text-lg font-bold mb-4">
                        <i class="fas fa-comment-dots mr-2"></i>Umpan Balik
                    </h3>
                    <p class="text-sm mb-4 opacity-90">
                        Kirimkan saran atau keluhan Anda kepada kami untuk meningkatkan kualitas layanan.
                    </p>

                    @if($errors->has('message'))
                    <div class="alert alert-error text-xs p-3 mb-3 rounded-lg flex items-center gap-2">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ $errors->first('message') }}</span>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('feedback.store') }}">
                        @csrf
                        <textarea
                            name="message"
                            placeholder="Tulis pesan Anda di sini..."
                            required
                        ></textarea>

                        <button type="submit">
                            <i class="fas fa-paper-plane mr-2"></i>KIRIM
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('additional_js')
<script>
    // Custom JS if needed in the future
</script>
@endsection
@endsection
