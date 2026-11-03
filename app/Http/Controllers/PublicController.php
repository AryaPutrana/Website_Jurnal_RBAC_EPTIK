<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;

class PublicController extends Controller
{
    /**
     * Display homepage with latest articles
     */
    public function home()
    {
        $latestArticles = Article::with('category')
            ->where('status', 'published')
            ->latest('publication_date')
            ->take(5)
            ->get();
        
        $featuredArticles = Article::with('category')
            ->where('status', 'published')
            ->orderBy('publication_date', 'desc')
            ->skip(5)
            ->take(3)
            ->get();

        return view('frontend.home', compact('latestArticles', 'featuredArticles'));
    }

    /**
     * Display all published articles with search
     */
    public function articles(Request $request)
    {
        $query = Article::with('category')
            ->where('status', 'published');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $articles = $query->latest('publication_date')->paginate(9);
        $totalArticles = Article::where('status', 'published')->count();

        return view('frontend.articles.index', compact('articles', 'totalArticles'));
    }

    /**
     * Display article detail by slug
     */
    public function articleDetail($slug)
    {
        $article = Article::with('category')
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return view('frontend.articles.show', compact('article'));
    }

    /**
     * Display about page
     */
    public function about()
    {
        return view('frontend.about');
    }
}
