<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ArticleSubmission;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class UserDashboardController extends Controller
{
    /**
     * Display user dashboard
     */
    public function index()
    {
        $totalSubmissions = auth()->user()->articleSubmissions()->count();
        $pendingSubmissions = auth()->user()->articleSubmissions()->where('status', 'pending')->count();
        $approvedSubmissions = auth()->user()->articleSubmissions()->where('status', 'approved')->count();
        $rejectedSubmissions = auth()->user()->articleSubmissions()->where('status', 'rejected')->count();
        
        $recentSubmissions = auth()->user()->articleSubmissions()
            ->with('category')
            ->latest()
            ->take(5)
            ->get();

        return view('user.dashboard', compact(
            'totalSubmissions',
            'pendingSubmissions',
            'approvedSubmissions',
            'rejectedSubmissions',
            'recentSubmissions'
        ));
    }

    /**
     * Display list of user's submissions
     */
    public function mySubmissions()
    {
        $submissions = auth()->user()->articleSubmissions()
            ->with('category', 'reviewer')
            ->latest()
            ->paginate(10);

        return view('user.submissions.index', compact('submissions'));
    }

    /**
     * Show form to create new submission
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('user.submissions.create', compact('categories'));
    }

    /**
     * Store new submission
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
        ]);

        // Generate slug
        $validated['slug'] = Str::slug($validated['title']);
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (ArticleSubmission::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Handle PDF upload
        if ($request->hasFile('pdf_file')) {
            $pdfPath = $request->file('pdf_file')->store('submissions/pdf', 'public');
            $validated['pdf_file'] = $pdfPath;
        }

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';

        ArticleSubmission::create($validated);

        return redirect()->route('user.submissions.index')
            ->with('success', 'Artikel berhasil disubmit dan menunggu review admin.');
    }

    /**
     * Show submission detail
     */
    public function show(ArticleSubmission $submission)
    {
        // Make sure user can only view their own submission
        if ($submission->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        return view('user.submissions.show', compact('submission'));
    }

    /**
     * Show edit form (only for pending/rejected)
     */
    public function edit(ArticleSubmission $submission)
    {
        // Check ownership
        if ($submission->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        // Can't edit approved submissions
        if ($submission->status === 'approved') {
            return redirect()->route('user.submissions.index')
                ->with('error', 'Artikel yang sudah diapprove tidak bisa diedit.');
        }

        $categories = Category::orderBy('name')->get();
        return view('user.submissions.edit', compact('submission', 'categories'));
    }

    /**
     * Update submission
     */
    public function update(Request $request, ArticleSubmission $submission)
    {
        // Check ownership
        if ($submission->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        // Can't edit approved submissions
        if ($submission->status === 'approved') {
            return redirect()->route('user.submissions.index')
                ->with('error', 'Artikel yang sudah diapprove tidak bisa diedit.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'authors' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'abstract' => 'required|string',
            'keywords' => 'required|string',
            'content' => 'required|string',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
        ], [
            'title.required' => 'Judul artikel wajib diisi.',
            'authors.required' => 'Nama penulis wajib diisi.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'abstract.required' => 'Abstrak wajib diisi.',
            'keywords.required' => 'Kata kunci wajib diisi.',
            'content.required' => 'Isi artikel wajib diisi.',
            'pdf_file.mimes' => 'File harus berformat PDF.',
            'pdf_file.max' => 'Ukuran file maksimal 10MB.',
        ]);

        // Generate slug if title changed
        if ($validated['title'] !== $submission->title) {
            $validated['slug'] = Str::slug($validated['title']);
            $originalSlug = $validated['slug'];
            $counter = 1;
            while (ArticleSubmission::where('slug', $validated['slug'])->where('id', '!=', $submission->id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        // Handle PDF upload
        if ($request->hasFile('pdf_file')) {
            if ($submission->pdf_file && Storage::disk('public')->exists($submission->pdf_file)) {
                Storage::disk('public')->delete($submission->pdf_file);
            }
            $pdfPath = $request->file('pdf_file')->store('submissions/pdf', 'public');
            $validated['pdf_file'] = $pdfPath;
        }

        // Reset to pending if rejected was edited
        if ($submission->status === 'rejected') {
            $validated['status'] = 'pending';
            $validated['admin_notes'] = null;
            $validated['reviewed_by'] = null;
            $validated['reviewed_at'] = null;
        }

        $submission->update($validated);

        return redirect()->route('user.submissions.index')
            ->with('success', 'Artikel berhasil diupdate.');
    }

    /**
     * Delete submission (only pending/rejected)
     */
    public function destroy(ArticleSubmission $submission)
    {
        // Check ownership
        if ($submission->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        // Can't delete approved submissions
        if ($submission->status === 'approved') {
            return redirect()->route('user.submissions.index')
                ->with('error', 'Artikel yang sudah diapprove tidak bisa dihapus.');
        }

        // Delete PDF
        if ($submission->pdf_file && Storage::disk('public')->exists($submission->pdf_file)) {
            Storage::disk('public')->delete($submission->pdf_file);
        }

        $submission->delete();

        return redirect()->route('user.submissions.index')
            ->with('success', 'Artikel berhasil dihapus.');
    }
}
