@extends('layouts.admin')

@section('title', 'Dashboard Admin - NexaNews')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-950">Dashboard Admin</h1>
        <p class="text-slate-600">Kelola konten dan moderasi website NexaNews</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Articles -->
        <div class="bg-white rounded-lg p-6 shadow-sm border-l-4" style="border-color: var(--primary-red);">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Artikel</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['total_articles'] }}</p>
                </div>
                <i class="fas fa-newspaper text-3xl" style="color: var(--primary-red); opacity: 0.2;"></i>
            </div>
            <p class="text-sm text-gray-500 mt-4">
                <span class="text-green-600 font-semibold">{{ $stats['published_articles'] }}</span> Published
                <span class="text-yellow-600 font-semibold">{{ $stats['draft_articles'] }}</span> Draft
            </p>
        </div>

        <!-- Pending Comments -->
        <div class="bg-white rounded-lg p-6 shadow-sm border-l-4" style="border-color: #f59e0b;">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Komentar Pending</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['pending_comments'] }}</p>
                </div>
                <i class="fas fa-comments text-3xl opacity-20" style="color: #f59e0b;"></i>
            </div>
            <a href="{{ route('admin.comments', ['status' => 'pending']) }}" class="text-sm text-blue-600 hover:text-blue-800 mt-4 inline-block">
                Moderasi Komentar →
            </a>
        </div>

        <!-- Total Comments -->
        <div class="bg-white rounded-lg p-6 shadow-sm border-l-4" style="border-color: #8b5cf6;">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Komentar</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['total_comments'] }}</p>
                </div>
                <i class="fas fa-comments text-3xl opacity-20" style="color: #8b5cf6;"></i>
            </div>
        </div>

        <!-- Categories & Users -->
        <div class="bg-white rounded-lg p-6 shadow-sm border-l-4" style="border-color: #06b6d4;">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Kategori</p>
                    <p class="text-2xl font-bold mt-2">{{ $stats['total_categories'] }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm font-medium">User</p>
                    <p class="text-2xl font-bold mt-2">{{ $stats['total_users'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Recent Articles -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold">Artikel Terbaru</h2>
                    <a href="{{ route('articles.create') }}" class="btn-primary text-sm">
                        <i class="fas fa-plus mr-2"></i>Buat Artikel
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold">Judul</th>
                                <th class="px-4 py-3 text-left font-semibold">Status</th>
                                <th class="px-4 py-3 text-center font-semibold">Views</th>
                                <th class="px-4 py-3 text-left font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestArticles as $article)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <div class="font-medium">{{ Str::limit($article->title, 40) }}</div>
                                    <div class="text-xs text-gray-500">
                                        {{ $article->category->name }} • {{ $article->user->name }}
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $article->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($article->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <i class="fas fa-eye mr-1 text-gray-500"></i>{{ number_format($article->views) }}
                                </td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('articles.edit', $article) }}" class="text-blue-600 hover:text-blue-800 mr-3">Edit</a>
                                    <a href="{{ route('articles.show', $article->slug) }}" class="text-green-600 hover:text-green-800 mr-3">View</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                                    Belum ada artikel
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <a href="{{ route('articles.index') }}" class="text-blue-600 hover:text-blue-800 text-sm mt-4 inline-block">
                    Lihat Semua Artikel →
                </a>
            </div>

            <!-- Pending Comments -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold">Komentar Menunggu Moderasi</h2>
                    <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold">
                        {{ $stats['pending_comments'] }}
                    </span>
                </div>

                <div class="space-y-4">
                    @forelse($pendingComments as $comment)
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h4 class="font-semibold">
                                    {{ $comment->commentor_name }}
                                </h4>
                                <p class="text-xs text-gray-500">
                                    pada: <strong>{{ Str::limit($comment->article->title, 40) }}</strong>
                                </p>
                            </div>
                            <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-sm text-gray-700 mb-3">{{ Str::limit($comment->content, 100) }}</p>
                        <div class="flex gap-2">
                            <form action="{{ route('comments.approve', $comment) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-xs px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                                    Approve
                                </button>
                            </form>
                            <form action="{{ route('comments.reject', $comment) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-xs px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                    Reject
                                </button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-gray-500 py-8">
                        <i class="fas fa-check-circle text-2xl text-green-600 mb-2"></i>
                        <br>Semua komentar sudah dimoderasi!
                    </p>
                    @endforelse
                </div>

                @if($stats['pending_comments'] > 0)
                <a href="{{ route('admin.comments', ['status' => 'pending']) }}" class="text-blue-600 hover:text-blue-800 text-sm mt-4 inline-block">
                    Lihat Semua Komentar Pending →
                </a>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Notifications -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold">Notifikasi Baru</h3>
                    @if($unreadNotifications->count() > 0)
                    <form action="{{ route('notifications.readAll') }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="text-xs text-blue-600 hover:text-blue-800">
                            Tandai Semua
                        </button>
                    </form>
                    @endif
                </div>

                <div class="space-y-3">
                    @forelse($unreadNotifications as $notification)
                    <div class="border-l-4 pl-4 py-2 border-red-600 bg-red-50">
                        <p class="text-sm font-semibold text-gray-900">{{ $notification->message }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                        @if($notification->comment)
                        <a href="{{ route('articles.show', $notification->comment->article->slug) }}" class="text-xs text-blue-600 hover:text-blue-800 inline-block mt-2">
                            Lihat Komentar →
                        </a>
                        @endif
                    </div>
                    @empty
                    <p class="text-center text-gray-500 py-8">
                        Tidak ada notifikasi baru
                    </p>
                    @endforelse
                </div>
            </div>

            <!-- System Info -->
            <div class="bg-blue-50 rounded-lg p-6 border-l-4 border-blue-600">
                <h3 class="font-bold mb-3 text-blue-900">Informasi Sistem</h3>
                <ul class="space-y-2 text-sm text-blue-800">
                    <li>
                        <i class="fas fa-server mr-2"></i>
                        Laravel {{ app()->version() }}
                    </li>
                    <li>
                        <i class="fas fa-database mr-2"></i>
                        Database: PostgreSQL
                    </li>
                    <li>
                        <i class="fas fa-user mr-2"></i>
                        Login sebagai: <strong>{{ auth()->user()->name }}</strong>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
