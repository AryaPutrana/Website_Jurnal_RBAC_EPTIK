
@extends('layouts.public')

@section('title', $article->title)

@section('content')

<style>
    /* ==============================
       ARTICLE DETAIL PAGE
    ============================== */

    .article-detail-page {
        width: 100%;
        overflow-x: hidden;
    }

    .article-header-container {
        max-width: 1100px;
        margin: 0 auto;
    }

    .article-detail-container {
        max-width: 1100px;
        margin: 0 auto;
    }

    /* Header Artikel */
    .article-header {
        background-color: #f8f9fa;
        padding: 45px 0;
    }

    .article-header h1 {
        color: var(--primary-color);
        font-size: 2rem;
        font-weight: 700;
        line-height: 1.4;
        word-wrap: break-word;
    }

    .article-meta {
        font-size: 0.95rem;
        line-height: 1.8;
    }

    /* Semua Card */
    .article-detail-page .card {
        width: 100%;
        height: auto !important;
        min-height: 0 !important;
        border-radius: 10px;
        border: 1px solid #e9ecef;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
        overflow: hidden;
    }

    .article-detail-page .card-body {
        padding: 25px !important;
    }

    .article-detail-page .card h4,
    .article-detail-page .card h5 {
        font-weight: 600;
    }

    /* Abstrak */
    .abstract-content {
        color: #444;
        font-size: 1rem;
        line-height: 1.9;
        text-align: justify;
        margin-bottom: 0;
        overflow-wrap: anywhere;
    }

    /* Kata Kunci */
    .keyword-badge {
        display: inline-block;
        background: #f1f5f9;
        color: #334155;
        border: 1px solid #dbe3ec;
        border-radius: 20px;
        padding: 7px 14px;
        margin: 0 6px 8px 0;
        font-size: 0.85rem;
    }

    /* Isi Artikel */
    .article-content {
        color: #333;
        font-size: 1.05rem;
        line-height: 1.9;
        text-align: justify;
        overflow-wrap: anywhere;
    }

    /* Informasi Artikel */
    .article-info-item {
        padding: 5px 0;
    }

    /* PDF */
    .pdf-section {
        background: #fff;
    }

    /* Tombol Kembali */
    .article-back-button {
        margin-top: 15px;
    }

    /* Responsive Tablet dan HP */
    @media (max-width: 768px) {
        .article-header {
            padding: 30px 0;
        }

        .article-header h1 {
            font-size: 1.5rem;
        }

        .article-detail-page .card-body {
            padding: 18px !important;
        }

        .article-content {
            font-size: 0.98rem;
        }
    }
</style>

<div class="article-detail-page">

    <!-- ==============================
         ARTICLE HEADER
    ============================== -->
    <section class="article-header">
        <div class="container article-header-container">
            <div class="row">
                <div class="col-12">

                    <div class="mb-3">
                        <span class="badge-category">
                            {{ $article->category->name }}
                        </span>

                        <span class="badge bg-success ms-2">
                            <i class="bi bi-check-circle"></i>
                            Published
                        </span>
                    </div>

                    <h1 class="mb-3">
                        {{ $article->title }}
                    </h1>

                    <div class="text-muted article-meta">

                        <p class="mb-2">
                            <i class="bi bi-person-circle"></i>
                            <strong>Penulis:</strong>
                            {{ $article->authors }}
                        </p>

                        <p class="mb-0">
                            <i class="bi bi-calendar-check"></i>
                            <strong>Dipublikasikan:</strong>
                            {{ $article->publication_date->format('d F Y') }}
                        </p>

                    </div>

                </div>
            </div>
        </div>
    </section>


    <!-- ==============================
         ARTICLE CONTENT
    ============================== -->
    <section class="container article-detail-container my-5">

        <div class="row justify-content-center">
            <div class="col-12">

                <!-- ABSTRACT -->
                <div class="card card-article mb-4">
                    <div class="card-body">

                        <h4 class="text-primary mb-3">
                            <i class="bi bi-file-text"></i>
                            Abstrak
                        </h4>

                        <p class="abstract-content">
                            {{ $article->abstract }}
                        </p>

                    </div>
                </div>


                <!-- KEYWORDS -->
                <div class="card card-article mb-4">
                    <div class="card-body">

                        <h5 class="text-primary mb-3">
                            <i class="bi bi-tags"></i>
                            Kata Kunci
                        </h5>

                        <div>
                            @foreach(explode(',', $article->keywords) as $keyword)
                                <span class="keyword-badge">
                                    {{ trim($keyword) }}
                                </span>
                            @endforeach
                        </div>

                    </div>
                </div>


                <!-- FULL ARTICLE CONTENT -->
                <div class="card card-article mb-4">
                    <div class="card-body">

                        <h4 class="text-primary mb-4">
                            <i class="bi bi-journal-text"></i>
                            Isi Artikel
                        </h4>

                        <div class="article-content">
                            {!! nl2br(e($article->content)) !!}
                        </div>

                    </div>
                </div>


                <!-- PDF DOWNLOAD -->
                @if($article->pdf_file)

                    <div class="card card-article pdf-section mb-4 border-success">
                        <div class="card-body text-center">

                            <i class="bi bi-file-earmark-pdf text-success"
                               style="font-size: 3rem;"></i>

                            <h5 class="mt-3 mb-2">
                                Unduh Artikel dalam Format PDF
                            </h5>

                            <p class="text-muted mb-4">
                                Tersedia versi PDF lengkap untuk artikel ini.
                            </p>

                            <div class="d-flex flex-wrap gap-2 justify-content-center">

                                <a href="{{ asset('storage/' . $article->pdf_file) }}"
                                   target="_blank"
                                   class="btn btn-success px-4">

                                    <i class="bi bi-file-earmark-pdf"></i>
                                    Buka PDF

                                </a>

                                <a href="{{ asset('storage/' . $article->pdf_file) }}"
                                   download
                                   class="btn btn-outline-success px-4">

                                    <i class="bi bi-download"></i>
                                    Download PDF

                                </a>

                            </div>

                        </div>
                    </div>

                @endif


                <!-- ARTICLE INFORMATION -->
                <div class="card bg-light mb-4">
                    <div class="card-body">

                        <h6 class="text-muted mb-4">
                            <i class="bi bi-info-circle"></i>
                            Informasi Artikel
                        </h6>

                        <div class="row g-4">

                            <div class="col-md-6 article-info-item">
                                <small class="text-muted d-block mb-2">
                                    Kategori
                                </small>

                                <span class="badge-category">
                                    {{ $article->category->name }}
                                </span>
                            </div>

                            <div class="col-md-6 article-info-item">
                                <small class="text-muted d-block mb-2">
                                    Tanggal Publikasi
                                </small>

                                <strong>
                                    {{ $article->publication_date->format('d F Y') }}
                                </strong>
                            </div>

                            <div class="col-md-6 article-info-item">
                                <small class="text-muted d-block mb-2">
                                    Dibuat
                                </small>

                                <strong>
                                    {{ $article->created_at->format('d/m/Y H:i') }}
                                </strong>
                            </div>

                            <div class="col-md-6 article-info-item">
                                <small class="text-muted d-block mb-2">
                                    Terakhir Diupdate
                                </small>

                                <strong>
                                    {{ $article->updated_at->format('d/m/Y H:i') }}
                                </strong>
                            </div>

                        </div>

                    </div>
                </div>


                <!-- BACK BUTTON -->
                <div class="text-center article-back-button mb-5">

                    <a href="{{ route('articles.index') }}"
                       class="btn btn-outline-primary px-4 py-2">

                        <i class="bi bi-arrow-left"></i>
                        Kembali ke Daftar Artikel

                    </a>

                </div>

            </div>
        </div>

    </section>

</div>

@endsection
