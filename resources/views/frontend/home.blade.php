@extends('layouts.public')

@section('title', 'Beranda')

@section('content')
<!-- Hero Section -->
<section class="hero-section text-center">
    <div class="container">
        <h1><i class="bi bi-journal-text"></i> Jurnal Ilmiah</h1>
        <p class="lead">Platform Publikasi Artikel Penelitian Berkualitas</p>
        <p>Publikasi hasil penelitian di bidang Teknologi Informasi, Keamanan Sistem, dan Etika Profesi</p>
        <a href="{{ route('articles.index') }}" class="btn btn-light btn-lg px-5">
            <i class="bi bi-search"></i> Lihat Semua Artikel
        </a>
    </div>
</section>

<!-- Latest Articles Section -->
<section class="container mb-5">
    <h2 class="section-title">Artikel Terbaru</h2>
    
    @if($latestArticles->count() > 0)
        <div class="row">
            @foreach($latestArticles as $article)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card card-article">
                        <div class="card-header">
                            {{ Str::limit($article->title, 60) }}
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-2">
                                <i class="bi bi-person"></i> {{ Str::limit($article->authors, 40) }}
                            </p>
                            <p class="text-muted mb-2">
                                <i class="bi bi-calendar"></i> {{ $article->publication_date->format('d M Y') }}
                                <span class="badge-category ms-2">{{ $article->category->name }}</span>
                            </p>
                            <p class="card-text">
                                {{ Str::limit($article->abstract, 120) }}
                            </p>
                            <a href="{{ route('articles.show', $article->slug) }}" class="btn btn-primary-custom btn-sm w-100">
                                <i class="bi bi-book"></i> Baca Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="text-center mt-4">
            <a href="{{ route('articles.index') }}" class="btn btn-outline-primary btn-lg">
                Lihat Semua Artikel <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    @else
        <div class="text-center py-5 text-muted">
            <i class="bi bi-inbox" style="font-size: 3rem;"></i>
            <p class="mt-3">Belum ada artikel yang dipublikasikan</p>
        </div>
    @endif
</section>

<!-- Featured Articles Section -->
@if($featuredArticles->count() > 0)
<section class="container mb-5">
    <h2 class="section-title">Artikel Pilihan</h2>
    
    <div class="row">
        @foreach($featuredArticles as $article)
            <div class="col-md-4 mb-4">
                <div class="card card-article">
                    <div class="card-body">
                        <h5 class="card-title text-primary">{{ Str::limit($article->title, 50) }}</h5>
                        <p class="text-muted small mb-2">
                            <i class="bi bi-person"></i> {{ Str::limit($article->authors, 30) }}
                        </p>
                        <p class="text-muted small mb-3">
                            <i class="bi bi-calendar"></i> {{ $article->publication_date->format('d M Y') }}
                            <span class="badge-category ms-2">{{ $article->category->name }}</span>
                        </p>
                        <p class="card-text small">{{ Str::limit($article->abstract, 100) }}</p>
                        <a href="{{ route('articles.show', $article->slug) }}" class="btn btn-primary-custom btn-sm">
                            <i class="bi bi-book"></i> Baca
                        </a>
                        @if($article->pdf_file)
                            <a href="{{ asset('storage/' . $article->pdf_file) }}" 
                               target="_blank" 
                               class="btn btn-outline-success btn-sm">
                                <i class="bi bi-file-pdf"></i> PDF
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endif

<!-- About Section -->
<section class="bg-light py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2 class="section-title">Tentang Jurnal Ilmiah</h2>
                <p style="text-align: justify;">
                    Jurnal Ilmiah adalah platform publikasi artikel penelitian yang menyediakan wadah bagi peneliti, 
                    dosen, dan mahasiswa untuk mempublikasikan hasil penelitian mereka secara digital. 
                </p>
                <p style="text-align: justify;">
                    Fokus publikasi kami meliputi bidang Teknologi Informasi, Keamanan Sistem, Etika Profesi, 
                    Rekayasa Perangkat Lunak, dan Basis Data.
                </p>
                <a href="{{ route('about') }}" class="btn btn-primary-custom">
                    <i class="bi bi-info-circle"></i> Selengkapnya
                </a>
            </div>
            <div class="col-md-6">
                <div class="card card-article">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-journal-check text-primary" style="font-size: 5rem;"></i>
                        <h4 class="mt-3 text-primary">Publikasi Berkualitas</h4>
                        <p class="text-muted">Artikel penelitian yang telah direview dan terverifikasi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
