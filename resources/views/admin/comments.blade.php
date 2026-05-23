@extends('layouts.app')

@section('title', 'Moderasi Komentar - NexaNews')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-2">Moderasi Komentar</h1>
        <p class="text-gray-600">Approve atau reject komentar dari pengunjung website</p>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex gap-2">
            <a href="{{ route('admin.comments', ['status' => 'pending']) }}" class="px-4 py-2 rounded-lg {{ request('status') === 'pending' || !request('status') ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700' }}">
                <i class="fas fa-hourglass-half mr-2"></i>Pending ({{ \App\Models\Comment::pending()->count() }})
            </a>
            <a href="{{ route('admin.comments', ['status' => 'approved']) }}" class="px-4 py-2 rounded-lg {{ request('status') === 'approved' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700' }}">
                <i class="fas fa-check mr-2"></i>Approved ({{ \App\Models\Comment::where('status', 'approved')->count() }})
            </a>
            <a href="{{ route('admin.comments', ['status' => 'rejected']) }}" class="px-4 py-2 rounded-lg {{ request('status') === 'rejected' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700' }}">
                <i class="fas fa-times mr-2"></i>Rejected ({{ \App\Models\Comment::where('status', 'rejected')->count() }})
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success mb-6">{{ session('success') }}</div>
    @endif

    <!-- Comments List -->
    <div class="space-y-6">
        @forelse($comments as $comment)
        <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 {{ $comment->status === 'pending' ? 'border-yellow-500' : ($comment->status === 'approved' ? 'border-green-500' : 'border-red-500') }}">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="font-semibold text-lg">
                        {{ $comment->user ? $comment->user->name : $comment->name }}
                    </h3>
                    <p class="text-sm text-gray-500">
                        {{ $comment->user ? $comment->user->email : $comment->email }}
                    </p>
                </div>
                <div class="text-right">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $comment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($comment->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                        {{ ucfirst($comment->status) }}
                    </span>
                    <p class="text-sm text-gray-500 mt-2">{{ $comment->created_at->diffForHumans() }}</p>
                </div>
            </div>

            <div class="mb-4 pb-4 border-b">
                <p class="text-sm text-gray-600 mb-2">
                    <strong>Pada Artikel:</strong>
                    <a href="{{ route('articles.show', $comment->article->slug) }}" class="text-blue-600 hover:text-blue-800">
                        {{ $comment->article->title }}
                    </a>
                </p>
                <p class="text-gray-700">{{ $comment->content }}</p>
            </div>

            @if($comment->status === 'pending')
            <div class="flex gap-3">
                <form action="{{ route('comments.approve', $comment) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn-primary text-sm">
                        <i class="fas fa-check mr-2"></i>Approve
                    </button>
                </form>
                <form action="{{ route('comments.reject', $comment) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn-outline text-sm">
                        <i class="fas fa-times mr-2"></i>Reject
                    </button>
                </form>
            </div>
            @else
            <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="inline" onsubmit="return confirm('Hapus komentar ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-outline text-sm text-red-600 border-red-600">
                    <i class="fas fa-trash mr-2"></i>Hapus
                </button>
            </form>
            @endif
        </div>
        @empty
        <div class="bg-white rounded-lg shadow-sm p-12 text-center">
            <i class="fas fa-check-circle text-4xl text-green-600 mb-4"></i>
            <p class="text-gray-500">Tidak ada komentar untuk dimoderasi</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $comments->links('pagination::tailwind') }}
    </div>
</div>
@endsection
