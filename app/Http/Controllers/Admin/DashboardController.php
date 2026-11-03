<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use App\Models\ArticleSubmission;

class DashboardController extends Controller
{
    public function index()
    {
        $totalArticles = Article::count();
        $totalCategories = Category::count();
        $totalAuthors = User::where('role', 'admin')->count();
        $pendingSubmissions = ArticleSubmission::where('status', 'pending')->count();
        $recentArticles = Article::with('category')->latest()->take(5)->get();

        return view('admin.dashboard', compact('totalArticles', 'totalCategories', 'totalAuthors', 'pendingSubmissions', 'recentArticles'));
    }
}
