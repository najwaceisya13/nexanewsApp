<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form Request untuk validasi input saat membuat artikel baru
 */
class StoreArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|min:10|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required|string|min:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // max 5MB
            'status' => 'required|in:draft,published',
        ];
    }

    /**
     * Custom error messages
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Judul berita harus diisi',
            'title.min' => 'Judul minimal 10 karakter',
            'title.max' => 'Judul maksimal 255 karakter',
            'category_id.required' => 'Kategori harus dipilih',
            'content.required' => 'Isi berita harus diisi',
            'content.min' => 'Isi berita minimal 50 karakter',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
            'image.max' => 'Ukuran gambar maksimal 5MB',
            'status.required' => 'Status harus dipilih',
            'status.in' => 'Status harus draft atau published',
        ];
    }
}
