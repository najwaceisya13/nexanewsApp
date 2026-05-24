@extends('layouts.admin')

@section('title', 'Umpan Balik Pengunjung - NexaNews')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-slate-950 mb-2">Umpan Balik Pengunjung</h1>
            <p class="text-slate-600">Saran, kritik, atau masukan yang dikirimkan oleh pengunjung website</p>
        </div>
        <div class="bg-blue-100 text-blue-800 font-bold px-4 py-2 rounded-lg text-sm">
            Total Masukan: {{ $feedbacks->total() }}
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success mb-6">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    </div>
    @endif

    <!-- Feedback List -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4 font-semibold text-slate-700 text-sm w-1/2">Pesan Umpan Balik</th>
                    <th class="px-6 py-4 font-semibold text-slate-700 text-sm w-1/6">Waktu Kirim</th>
                    <th class="px-6 py-4 font-semibold text-slate-700 text-sm w-1/12 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($feedbacks as $feedback)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4 text-slate-700 text-sm whitespace-pre-line leading-relaxed">
                        {{ $feedback->message }}
                    </td>
                    <td class="px-6 py-4 text-slate-500 text-xs">
                        {{ $feedback->created_at->format('d M Y') }}
                        <div class="text-[10px] text-slate-400 mt-0.5">{{ $feedback->created_at->format('H:i') }} WIB</div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <form action="{{ route('admin.feedback.destroy', $feedback) }}" method="POST" onsubmit="return confirm('Hapus umpan balik ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 p-2 rounded-full hover:bg-red-50 transition" title="Hapus Umpan Balik">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-16 text-center text-slate-500">
                        <div class="mb-4">
                            <i class="fas fa-comment-slash text-4xl text-slate-300"></i>
                        </div>
                        <p class="font-medium">Belum ada umpan balik yang masuk</p>
                        <p class="text-xs text-slate-400 mt-1">Umpan balik yang dikirim pengunjung melalui form sidebar akan muncul di sini.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $feedbacks->links('pagination::tailwind') }}
    </div>
</div>
@endsection
