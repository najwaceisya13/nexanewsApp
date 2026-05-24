@extends('layouts.app')

@section('title', $article->title . ' - NexaNews')

@section('content')
<div class="min-h-screen">
    <!-- Article Header -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <span class="news-category-badge">{{ $article->category->name }}</span>
        </div>

        <h1 class="text-4xl font-bold mb-4">{{ $article->title }}</h1>

        <div class="flex flex-wrap items-center gap-6 text-gray-600 mb-8 pb-8 border-b">
            <div class="flex items-center">
                <i class="fas fa-user-circle text-2xl mr-2" style="color: var(--primary-red);"></i>
                <div>
                    <div class="font-semibold text-gray-900">{{ $article->penulis ?: $article->user->name }}</div>
                    <div class="text-xs">Penulis</div>
                </div>
            </div>
            
            @if($article->editor)
            <div class="flex items-center">
                <i class="fas fa-user-edit text-2xl mr-2" style="color: var(--primary-red);"></i>
                <div>
                    <div class="font-semibold text-gray-900">{{ $article->editor }}</div>
                    <div class="text-xs">Editor</div>
                </div>
            </div>
            @endif

            <div class="flex items-center">
                <i class="fas fa-calendar mr-2" style="color: var(--primary-red);"></i>
                <div>
                    <div class="font-semibold text-gray-900">{{ $article->published_at->format('d M Y') }}</div>
                    <div class="text-xs">{{ $article->published_at->format('H:i') }} WIB</div>
                </div>
            </div>
            
            <div class="flex items-center">
                <i class="fas fa-eye text-2xl mr-2" style="color: var(--primary-red);"></i>
                <div>
                    <div class="font-semibold text-gray-900">{{ number_format($article->views) }}</div>
                    <div class="text-xs">Views</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Article Image -->
    @if($article->image)
    <div class="mb-8 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <img
            src="{{ asset('storage/' . $article->image) }}"
            alt="{{ $article->title }}"
            class="w-full h-96 object-cover rounded-lg"
        >
    </div>
    @endif

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Article Content -->
                <div class="prose prose-lg max-w-none mb-12">
                    <div class="bg-white rounded-lg p-8 shadow-sm">
                        {!! nl2br(e($article->content)) !!}
                    </div>
                </div>

                <!-- Like Section -->
                <div class="bg-white rounded-lg p-6 mb-12 flex items-center justify-between">
                    <span class="text-gray-700 font-semibold">Apakah artikel ini bermanfaat?</span>
                    <button
                        onclick="toggleLike({{ $article->id }})"
                        class="flex items-center space-x-2 px-6 py-3 rounded-lg border-2 border-red-600 {{ $isLiked ? 'bg-red-600 text-white' : 'text-red-600 hover:bg-red-50' }} transition"
                    >
                        <i class="fas fa-heart"></i>
                        <span>
                            <span id="likes-count">{{ $article->likes()->count() }}</span> Suka
                        </span>
                    </button>
                </div>

                <!-- Comments Section -->
                <div class="bg-white rounded-lg p-8 shadow-sm">
                    <h3 class="text-2xl font-bold mb-6">
                        <i class="fas fa-comments mr-2" style="color: var(--primary-red);"></i>
                        Komentar ({{ $article->comments()->approved()->count() }})
                    </h3>

                    <!-- Comment Form -->
                    <div class="mb-8 pb-8 border-b">
                        <h4 class="font-semibold mb-4">Tambahkan Komentar</h4>
                        <form action="{{ route('comments.store', $article) }}" method="POST">
                            @csrf
                            <textarea
                                name="content"
                                placeholder="Tulis komentar Anda..."
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg mb-4 focus:outline-none focus:border-red-600 resize-none"
                                rows="4"
                                required
                            ></textarea>

                            @error('content')
                            <div class="alert alert-error mb-4">{{ $message }}</div>
                            @enderror

                            <button type="submit" class="btn-primary">
                                <i class="fas fa-paper-plane mr-2"></i>Kirim Komentar
                            </button>
                        </form>
                    </div>

                    <!-- Comments List -->
                    <div class="space-y-6">
                        @forelse($comments as $comment)
                        <div class="bg-gray-50 rounded-lg p-6">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <h5 class="font-semibold">
                                        {{ $comment->commentor_name }}
                                    </h5>
                                    <p class="text-sm text-gray-500">
                                        <i class="fas fa-clock mr-1"></i>
                                        {{ $comment->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                @if(auth()->check() && auth()->user()->isAdmin())
                                <div class="flex space-x-2">
                                    <form action="{{ route('comments.approve', $comment) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-xs px-2 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                                            Approve
                                        </button>
                                    </form>
                                    <form action="{{ route('comments.reject', $comment) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-xs px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                            Reject
                                        </button>
                                    </form>
                                </div>
                                @endif
                            </div>
                            <p class="text-gray-700">{{ $comment->content }}</p>
                        </div>
                        @empty
                        <p class="text-gray-500 text-center py-8">
                            Belum ada komentar. Jadilah yang pertama!
                        </p>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($comments->hasPages())
                    <div class="mt-8">
                        {{ $comments->links('pagination::tailwind') }}
                    </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Trending Articles -->
                <div class="sidebar-section">
                    <h3 class="sidebar-title">
                        <i class="fas fa-fire mr-2" style="color: var(--primary-red);"></i>Trending
                    </h3>

                    <div class="space-y-4">
                        @foreach($trending as $index => $trendingArticle)
                        <div class="trending-item">
                            <div class="trending-number">{{ $index + 1 }}</div>
                            <div class="trending-info">
                                <div class="trending-title">
                                    <a href="{{ route('articles.show', $trendingArticle->slug) }}" class="hover:text-red-600 transition">
                                        {{ $trendingArticle->title }}
                                    </a>
                                </div>
                                <div class="trending-views">
                                    {{ $trendingArticle->category->name }}
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

                <!-- Related Articles -->
                <div class="sidebar-section">
                    <h3 class="sidebar-title">
                        <i class="fas fa-link mr-2" style="color: var(--primary-red);"></i>Artikel Terkait
                    </h3>

                    <div class="space-y-4">
                        @php
                            $related = \App\Models\Article::published()
                                ->where('category_id', $article->category_id)
                                ->where('id', '!=', $article->id)
                                ->limit(3)
                                ->get();
                        @endphp

                        @forelse($related as $relatedArticle)
                        <div class="pb-4 border-b">
                            <a href="{{ route('articles.show', $relatedArticle->slug) }}" class="font-semibold text-sm hover:text-red-600 transition line-clamp-2">
                                {{ $relatedArticle->title }}
                            </a>
                            <div class="text-xs text-gray-500 mt-2">
                                {{ $relatedArticle->published_at->format('d M Y') }}
                            </div>
                        </div>
                        @empty
                        <p class="text-gray-500 text-sm">Tidak ada artikel terkait</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('additional_js')
<script>
    function toggleLike(articleId) {
        fetch(`/articles/${articleId}/like`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('likes-count').textContent = data.likes_count;
            // Refresh page to update UI
            location.reload();
        })
        .catch(error => console.error('Error:', error));
    }
</script>
@endsection
@endsection
