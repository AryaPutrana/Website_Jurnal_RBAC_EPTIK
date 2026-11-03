@extends('layouts.public')

@section('title', $article->title)

@section('content')
<!-- Article Header -->
<section class="bg-light py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-10 mx-auto">
                <div class="mb-3">
                    <span class="badge-category">{{ $article->category->name }}</span>
                    <span class="badge bg-success ms-2">
                        <i class="bi bi-check-circle"></i> Published
                    </span>
                </div>
                <h1 class="mb-3" style="color: var(--primary-color); font-weight: 700;">
                    {{ $article->title }}
                </h1>
                <div class="text-muted">
                    <p class="mb-2">
                        <i class="bi bi-person-circle"></i> <strong>Penulis:</strong> {{ $article->authors }}
                    </p>
                    <p class="mb-0">
                        <i class="bi bi-calendar-check"></i> <strong>Dipublikasikan:</strong> 
                        {{ $article->publication_date->format('d F Y') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Article Content -->
<section class="container my-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Abstract -->
            <div class="card card-article mb-4">
                <div class="card-body">
                    <h4 class="text-primary mb-3">
                        <i class="bi bi-file-text"></i> Abstrak
                    </h4>
                    <p style="text-align: justify; line-height: 1.8;">
                        {{ $article->abstract }}
                    </p>
                </div>
            </div>

            <!-- Keywords -->
            <div class="card card-article mb-4">
                <div class="card-body">
                    <h5 class="text-primary mb-3">
                        <i class="bi bi-tags"></i> Kata Kunci
                    </h5>
                    <div>
                        @foreach(explode(',', $article->keywords) as $keyword)
                            <span class="badge bg-light text-dark border me-2 mb-2" 
                                  style="font-size: 0.9rem; padding: 8px 15px;">
                                {{ trim($keyword) }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Full Content -->
            <div class="card card-article mb-4">
                <div class="card-body">
                    <h4 class="text-primary mb-4">
                        <i class="bi bi-journal-text"></i> Isi Artikel
                    </h4>
                    <div style="text-align: justify; line-height: 2; font-size: 1.05rem;">
                        {!! nl2br(e($article->content)) !!}
                    </div>
                </div>
            </div>

            <!-- PDF Download Section -->
            @if($article->pdf_file)
                <div class="card card-article mb-4 border-success">
                    <div class="card-body text-center">
                        <i class="bi bi-file-earmark-pdf text-success" style="font-size: 3rem;"></i>
                        <h5 class="mt-3">Unduh Artikel dalam Format PDF</h5>
                        <p class="text-muted mb-3">Tersedia versi PDF lengkap untuk artikel ini</p>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                            <a href="{{ asset('storage/' . $article->pdf_file) }}" 
                               target="_blank" 
                               class="btn btn-success btn-lg">
                                <i class="bi bi-file-earmark-pdf"></i> Buka PDF
                            </a>
                            <a href="{{ asset('storage/' . $article->pdf_file) }}" 
                               download 
                               class="btn btn-outline-success btn-lg">
                                <i class="bi bi-download"></i> Download PDF
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Article Info -->
            <div class="card bg-light mb-4">
                <div class="card-body">
                    <h6 class="text-muted mb-3"><i class="bi bi-info-circle"></i> Informasi Artikel</h6>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <small class="text-muted">Kategori:</small><br>
                            <span class="badge-category">{{ $article->category->name }}</span>
                        </div>
                        <div class="col-md-6 mb-2">
                            <small class="text-muted">Tanggal Publikasi:</small><br>
                            <strong>{{ $article->publication_date->format('d F Y') }}</strong>
                        </div>
                        <div class="col-md-6 mb-2">
                            <small class="text-muted">Dibuat:</small><br>
                            <strong>{{ $article->created_at->format('d/m/Y H:i') }}</strong>
                        </div>
                        <div class="col-md-6 mb-2">
                            <small class="text-muted">Terakhir Diupdate:</small><br>
                            <strong>{{ $article->updated_at->format('d/m/Y H:i') }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Back Button -->
            <div class="text-center mb-4">
                <a href="{{ route('articles.index') }}" class="btn btn-outline-primary btn-lg">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar Artikel
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
