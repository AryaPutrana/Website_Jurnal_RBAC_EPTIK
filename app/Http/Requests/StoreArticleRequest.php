<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'authors' => 'required|string|max:500',
            'category_id' => 'required|exists:categories,id',
            'abstract' => 'required|string',
            'keywords' => 'required|string|max:500',
            'content' => 'required|string',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
            'publication_date' => 'required|date',
            'status' => 'required|in:draft,published',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Judul artikel wajib diisi.',
            'title.max' => 'Judul artikel maksimal 255 karakter.',
            'authors.required' => 'Nama penulis wajib diisi.',
            'authors.max' => 'Nama penulis maksimal 500 karakter.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori tidak valid.',
            'abstract.required' => 'Abstrak wajib diisi.',
            'keywords.required' => 'Kata kunci wajib diisi.',
            'keywords.max' => 'Kata kunci maksimal 500 karakter.',
            'content.required' => 'Isi artikel wajib diisi.',
            'pdf_file.mimes' => 'File harus berformat PDF.',
            'pdf_file.max' => 'Ukuran file maksimal 10MB.',
            'publication_date.required' => 'Tanggal publikasi wajib diisi.',
            'publication_date.date' => 'Format tanggal tidak valid.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status harus draft atau published.',
        ];
    }
}
