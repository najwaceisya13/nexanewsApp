@extends('layouts.admin')

@section('title', 'Edit Artikel - NexaNews')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold mb-8">Edit Artikel</h1>

    <form action="{{ route('articles.update', $article) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-sm p-8">
        @csrf
        @method('PUT')

        <!-- Title -->
        <div class="mb-6">
            <label for="title" class="block text-sm font-medium text-gray-900 mb-2">
                Judul Artikel <span class="text-red-600">*</span>
            </label>
            <input
                type="text"
                name="title"
                id="title"
                placeholder="Masukkan judul artikel"
                value="{{ old('title', $article->title) }}"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-red-600 @error('title') border-red-600 @enderror"
                required
            >
            @error('title')
            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Category -->
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-900 mb-2">
                    Kategori <span class="text-red-600">*</span>
                </label>
                <select
                    name="category_id"
                    id="category_id"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-red-600 @error('category_id') border-red-600 @enderror"
                    required
                >
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $article->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
                @error('category_id')
                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-900 mb-2">
                    Status <span class="text-red-600">*</span>
                </label>
                <select
                    name="status"
                    id="status"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-red-600"
                    required
                >
                    <option value="draft" {{ old('status', $article->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status', $article->status) === 'published' ? 'selected' : '' }}>Publish</option>
                </select>
            </div>
        </div>

        <!-- Penulis & Editor (dari Redaksi) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="penulis" class="block text-sm font-medium text-gray-900 mb-2">
                    Penulis <span class="text-gray-500 text-xs">(dari Redaksi)</span>
                </label>
                <input
                    type="text"
                    name="penulis"
                    id="penulis"
                    placeholder="Nama penulis dari redaksi"
                    value="{{ old('penulis', $article->penulis) }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-red-600"
                >
                @error('penulis')
                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="editor" class="block text-sm font-medium text-gray-900 mb-2">
                    Editor <span class="text-gray-500 text-xs">(dari Redaksi)</span>
                </label>
                <input
                    type="text"
                    name="editor"
                    id="editor"
                    placeholder="Nama editor dari redaksi"
                    value="{{ old('editor', $article->editor) }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-red-600"
                >
                @error('editor')
                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Current Image -->
        @if($article->image)
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-900 mb-2">Gambar Saat Ini</label>
            <div class="relative w-64">
                <img src="{{ asset('storage/' . $article->image) }}" class="w-full rounded-lg" alt="{{ $article->title }}">
                <p class="text-sm text-gray-500 mt-2">Upload gambar baru untuk mengganti</p>
            </div>
        </div>
        @endif

        <!-- Image Upload -->
        <div class="mb-6">
            <label for="image" class="block text-sm font-medium text-gray-900 mb-2">
                Gambar Baru <span class="text-gray-500">(JPG, PNG, GIF max 5MB)</span>
            </label>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-red-600 transition" onclick="document.getElementById('image').click()">
                <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                <p class="text-gray-600">Klik untuk upload atau drag & drop</p>
                <input
                    type="file"
                    name="image"
                    id="image"
                    accept="image/*"
                    class="hidden"
                    onchange="previewImage(this)"
                >
            </div>
            <div id="imagePreview" class="mt-4"></div>
            @error('image')
            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Content -->
        <div class="mb-6">
            <label for="content" class="block text-sm font-medium text-gray-900 mb-2">
                Isi Artikel <span class="text-red-600">*</span>
            </label>
            <textarea
                name="content"
                id="content"
                rows="12"
                placeholder="Tulis isi artikel di sini..."
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-red-600 font-mono @error('content') border-red-600 @enderror"
                required
            >{{ old('content', $article->content) }}</textarea>
            <p class="text-gray-500 text-sm mt-2">Minimal 50 karakter</p>
            @error('content')
            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Info -->
        <div class="bg-blue-50 border-l-4 border-blue-600 p-4 mb-6 rounded">
            <p class="text-sm text-blue-800">
                <i class="fas fa-info-circle mr-2"></i>
                <strong>Slug:</strong> {{ $article->slug }} (otomatis dihasilkan dari judul)
            </p>
        </div>

        <!-- Buttons -->
        <div class="flex gap-4 justify-end">
            <a href="{{ route('articles.index') }}" class="btn-outline">
                Batal
            </a>
            <button type="submit" class="btn-primary">
                <i class="fas fa-save mr-2"></i>Update Artikel
            </button>
        </div>
    </form>
</div>

@section('additional_js')
<script>
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.innerHTML = `
                    <div class="relative w-64">
                        <img src="${e.target.result}" class="w-full rounded-lg" alt="Preview">
                        <button type="button" onclick="clearImage()" class="absolute top-2 right-2 bg-red-600 text-white p-2 rounded-full hover:bg-red-700">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;
            };
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    function clearImage() {
        document.getElementById('image').value = '';
        document.getElementById('imagePreview').innerHTML = '';
    }
</script>
@endsection
@endsection
