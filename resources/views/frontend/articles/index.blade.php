@extends('layouts.public')

@section('title', 'Daftar Artikel')

@section('content')
<!-- Page Header -->
<section class="bg-light py-5">
    <div class="container">
        <h1 class="text-center mb-3" style="color: var(--primary-color);">
            <i class="bi bi-file-text"></i> Daftar Artikel
        </h1>
        <p class="text-center text-muted">Total {{ $totalArticles }} artikel telah dipublikasikan</p>
    </div>
</section>

<!-- Search Section -->
<section class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="{{ route('articles.index') }}" method="GET" class="mb-4">
                <div class="input-group input-group-lg">
                    <input type="text" 
                           class="form-control" 
                           name="search" 
                           placeholder="Cari artikel berdasarkan judul..." 
                           value="{{ request('search') }}">
                    <button class="btn btn-primary-custom" type="submit">
                        <i class="bi bi-search"></i> Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('articles.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle"></i> Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    @if(request('search'))
        <div class="alert alert-info text-center">
            <i class="bi bi-info-circle"></i> Menampilkan hasil pencarian untuk: <strong>"{{ request('search') }}"</strong>
            ({{ $articles->total() }} artikel ditemukan)
        </div>
    @endif
</section>

<!-- Articles Grid -->
<section class="container mb-5">
    @if($articles->count() > 0)
        <div class="row">
            @foreach($articles as $article)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card card-article h-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-primary">
                                {{ Str::limit($article->title, 60) }}
                            </h5>
                            
                            <div class="mb-2">
                                <span class="badge-category">{{ $article->category->name }}</span>
                            </div>
                            
                            <p class="text-muted small mb-2">
                                <i class="bi bi-person"></i> {{ Str::limit($article->authors, 40) }}
                            </p>
                            
                            <p class="text-muted small mb-3">
                                <i class="bi bi-calendar3"></i> {{ $article->publication_date->format('d F Y') }}
                            </p>
                            
                            <p class="card-text flex-grow-1" style="text-align: justify;">
                                {{ Str::limit($article->abstract, 150) }}
                            </p>
                            
                            <div class="mt-auto">
                                <a href="{{ route('articles.show', $article->slug) }}" 
                                   class="btn btn-primary-custom btn-sm w-100 mb-2">
                                    <i class="bi bi-book-half"></i> Baca Selengkapnya
                                </a>
                                
                                @if($article->pdf_file)
                                    <a href="{{ asset('storage/' . $article->pdf_file) }}" 
                                       target="_blank" 
                                       class="btn btn-outline-success btn-sm w-100">
                                        <i class="bi bi-file-earmark-pdf"></i> Download PDF
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $articles->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-search" style="font-size: 4rem; color: #ccc;"></i>
            <h4 class="mt-3 text-muted">Artikel Tidak Ditemukan</h4>
            <p class="text-muted">
                @if(request('search'))
                    Tidak ada artikel yang sesuai dengan kata kunci "{{ request('search') }}"
                @else
                    Belum ada artikel yang dipublikasikan
                @endif
            </p>
            @if(request('search'))
                <a href="{{ route('articles.index') }}" class="btn btn-primary-custom mt-3">
                    <i class="bi bi-arrow-left"></i> Lihat Semua Artikel
                </a>
            @endif
        </div>
    @endif
</section>
@endsection
