@extends('layouts.app')

@section('title', $category->name . ' - NexaNews')

@section('content')
<div class="min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Category Header -->
        <div class="mb-12">
            <h1 class="text-4xl font-bold mb-2">
                <span style="color: var(--primary-red); border-bottom: 3px solid var(--primary-red);">
                    {{ $category->name }}
                </span>
            </h1>
            @if($category->description)
            <p class="text-gray-600">{{ $category->description }}</p>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content (2 columns) -->
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
                        <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">Belum ada berita di kategori ini</p>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="flex justify-center">
                    {{ $articles->links('pagination::tailwind') }}
                </div>

                <!-- Load More Button -->
                <div class="text-center mt-8">
                    <button class="btn-outline">
                        <i class="fas fa-arrow-down mr-2"></i>LIHAT LEBIH BANYAK
                    </button>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Trending Articles -->
                <div class="sidebar-section">
                    <h3 class="sidebar-title">
                        <i class="fas fa-fire mr-2" style="color: var(--primary-red);"></i>Trending Kini
                    </h3>

                    @if($trending->count() > 0)
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
                    <h3 class="sidebar-title">Kategori</h3>
                    <div>
                        @foreach($categories as $cat)
                        <a
                            href="{{ route('category.show', $cat->slug) }}"
                            class="category-tag {{ $cat->id === $category->id ? 'active' : '' }}"
                        >
                            {{ $cat->name }}
                        </a>
                        @endforeach
                    </div>
                </div>

                <!-- Umpan Balik -->
                <div class="feedback-form">
                    <h3 class="text-lg font-bold mb-4">
                        <i class="fas fa-comment-dots mr-2"></i>Umpan Balik
                    </h3>
                    <p class="text-sm mb-4 opacity-90">
                        Kirimkan saran atau keluhan Anda kepada kami.
                    </p>

                    <form method="POST" action="{{ route('feedback.store') }}">
                        @csrf
                        <textarea
                            name="message"
                            placeholder="Tulis pesan Anda di sini..."
                            required
                        ></textarea>

                        <input
                            type="email"
                            name="email"
                            placeholder="Email Anda (opsional)"
                            class="w-full mb-3 p-2 rounded-lg text-gray-900"
                        >

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
