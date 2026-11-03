<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::with('category')->latest()->paginate(10);
        return view('admin.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.articles.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'authors' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'abstract' => 'required|string',
            'keywords' => 'required|string',
            'content' => 'required|string',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
            'publication_date' => 'required|date',
            'status' => 'required|in:draft,published',
        ], [
            'title.required' => 'Judul artikel wajib diisi.',
            'authors.required' => 'Nama penulis wajib diisi.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori tidak valid.',
            'abstract.required' => 'Abstrak wajib diisi.',
            'keywords.required' => 'Kata kunci wajib diisi.',
            'content.required' => 'Isi artikel wajib diisi.',
            'pdf_file.mimes' => 'File harus berformat PDF.',
            'pdf_file.max' => 'Ukuran file maksimal 10MB.',
            'publication_date.required' => 'Tanggal publikasi wajib diisi.',
            'status.required' => 'Status publikasi wajib dipilih.',
        ]);

        // Generate slug from title
        $validated['slug'] = Str::slug($validated['title']);
        
        // Make slug unique if already exists
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (Article::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Handle PDF upload
        if ($request->hasFile('pdf_file')) {
            $pdfPath = $request->file('pdf_file')->store('articles/pdf', 'public');
            $validated['pdf_file'] = $pdfPath;
        }

        Article::create($validated);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return view('admin.articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'authors' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'abstract' => 'required|string',
            'keywords' => 'required|string',
            'content' => 'required|string',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
            'publication_date' => 'required|date',
            'status' => 'required|in:draft,published',
        ], [
            'title.required' => 'Judul artikel wajib diisi.',
            'authors.required' => 'Nama penulis wajib diisi.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori tidak valid.',
            'abstract.required' => 'Abstrak wajib diisi.',
            'keywords.required' => 'Kata kunci wajib diisi.',
            'content.required' => 'Isi artikel wajib diisi.',
            'pdf_file.mimes' => 'File harus berformat PDF.',
            'pdf_file.max' => 'Ukuran file maksimal 10MB.',
            'publication_date.required' => 'Tanggal publikasi wajib diisi.',
            'status.required' => 'Status publikasi wajib dipilih.',
        ]);

        // Generate slug if title changed
        if ($validated['title'] !== $article->title) {
            $validated['slug'] = Str::slug($validated['title']);
            
            // Make slug unique if already exists
            $originalSlug = $validated['slug'];
            $counter = 1;
            while (Article::where('slug', $validated['slug'])->where('id', '!=', $article->id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        // Handle PDF upload
        if ($request->hasFile('pdf_file')) {
            // Delete old PDF if exists
            if ($article->pdf_file && Storage::disk('public')->exists($article->pdf_file)) {
                Storage::disk('public')->delete($article->pdf_file);
            }
            
            $pdfPath = $request->file('pdf_file')->store('articles/pdf', 'public');
            $validated['pdf_file'] = $pdfPath;
        }

        $article->update($validated);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        // Delete PDF file if exists
        if ($article->pdf_file && Storage::disk('public')->exists($article->pdf_file)) {
            Storage::disk('public')->delete($article->pdf_file);
        }

        $article->delete();

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil dihapus.');
    }
}
