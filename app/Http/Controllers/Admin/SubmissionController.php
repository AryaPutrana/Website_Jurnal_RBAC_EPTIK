<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ArticleSubmission;
use App\Models\Article;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{
    /**
     * Display list of submissions
     */
    public function index()
    {
        $submissions = ArticleSubmission::with('user', 'category', 'reviewer')
            ->latest()
            ->paginate(10);

        $pendingCount = ArticleSubmission::where('status', 'pending')->count();
        $approvedCount = ArticleSubmission::where('status', 'approved')->count();
        $rejectedCount = ArticleSubmission::where('status', 'rejected')->count();

        return view('admin.submissions.index', compact('submissions', 'pendingCount', 'approvedCount', 'rejectedCount'));
    }

    /**
     * Show submission detail for review
     */
    public function show(ArticleSubmission $submission)
    {
        $submission->load('user', 'category', 'reviewer');
        return view('admin.submissions.show', compact('submission'));
    }

    /**
     * Approve submission and convert to article
     */
    public function approve(Request $request, ArticleSubmission $submission)
    {
        $validated = $request->validate([
            'publication_date' => 'required|date',
            'admin_notes' => 'nullable|string',
        ]);

        // Create article from submission
        $article = Article::create([
            'title' => $submission->title,
            'slug' => $submission->slug,
            'authors' => $submission->authors,
            'category_id' => $submission->category_id,
            'abstract' => $submission->abstract,
            'keywords' => $submission->keywords,
            'content' => $submission->content,
            'pdf_file' => $submission->pdf_file,
            'publication_date' => $validated['publication_date'],
            'status' => 'published',
        ]);

        // Update submission status
        $submission->update([
            'status' => 'approved',
            'admin_notes' => $validated['admin_notes'],
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return redirect()->route('admin.submissions.index')
            ->with('success', 'Artikel berhasil diapprove dan dipublikasikan.');
    }

    /**
     * Reject submission
     */
    public function reject(Request $request, ArticleSubmission $submission)
    {
        $validated = $request->validate([
            'admin_notes' => 'required|string',
        ], [
            'admin_notes.required' => 'Alasan penolakan wajib diisi.',
        ]);

        $submission->update([
            'status' => 'rejected',
            'admin_notes' => $validated['admin_notes'],
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return redirect()->route('admin.submissions.index')
            ->with('success', 'Artikel ditolak. User akan menerima notifikasi.');
    }

    /**
     * Delete submission permanently
     */
    public function destroy(ArticleSubmission $submission)
    {
        // Delete PDF file
        if ($submission->pdf_file && Storage::disk('public')->exists($submission->pdf_file)) {
            Storage::disk('public')->delete($submission->pdf_file);
        }

        $submission->delete();

        return redirect()->route('admin.submissions.index')
            ->with('success', 'Submission berhasil dihapus.');
    }
}
