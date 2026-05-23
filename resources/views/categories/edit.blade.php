@extends('layouts.app')

@section('title', 'Edit Kategori - NexaNews')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold mb-8">Edit Kategori</h1>

    <form action="{{ route('categories.update', $category) }}" method="POST" class="bg-white rounded-lg shadow-sm p-8">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <label for="name" class="block text-sm font-medium text-gray-900 mb-2">Nama <span class="text-red-600">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" placeholder="Contoh: Teknologi" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-red-600 @error('name') border-red-600 @enderror" required>
            @error('name')<p class="text-red-600 text-sm mt-2">{{ $message }}</p>@enderror
        </div>

        <div class="mb-6">
            <label for="slug" class="block text-sm font-medium text-gray-900 mb-2">Slug</label>
            <input type="text" name="slug" id="slug" value="{{ old('slug', $category->slug) }}" placeholder="Akan otomatis jika kosong" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-red-600 @error('slug') border-red-600 @enderror">
            @error('slug')<p class="text-red-600 text-sm mt-2">{{ $message }}</p>@enderror
        </div>

        <div class="mb-6">
            <label for="description" class="block text-sm font-medium text-gray-900 mb-2">Deskripsi</label>
            <textarea name="description" id="description" rows="4" placeholder="Deskripsi kategori" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-red-600">{{ old('description', $category->description) }}</textarea>
        </div>

        <div class="mb-6">
            <label for="color" class="block text-sm font-medium text-gray-900 mb-2">Warna Badge</label>
            <div class="flex gap-4">
                <input type="color" name="color" id="color" value="{{ old('color', $category->color) }}" class="w-20 h-10 rounded-lg cursor-pointer">
                <input type="text" value="{{ old('color', $category->color) }}" readonly class="flex-1 px-4 py-3 border border-gray-300 rounded-lg bg-gray-50">
            </div>
        </div>

        <div class="flex gap-4">
            <a href="{{ route('categories.index') }}" class="btn-outline">Batal</a>
            <button type="submit" class="btn-primary">Update Kategori</button>
        </div>
    </form>
</div>
@endsection
