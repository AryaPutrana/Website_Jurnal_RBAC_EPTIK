@extends('layouts.admin')

@section('title', 'Detail Artikel')
@section('page-title', 'Detail Artikel')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ $article->title }}</h5>
                @if($article->status === 'published')
                    <span class="badge bg-success">Published</span>
                @else
                    <span class="badge bg-warning text-dark">Draft</span>
                @endif
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6 class="text-muted">Penulis</h6>
                    <p>{{ $article->authors }}</p>
                </div>

                <div class="mb-3">
                    <h6 class="text-muted">Kategori</h6>
                    <span class="badge bg-secondary">{{ $article->category->name }}</span>
                </div>

                <div class="mb-3">
                    <h6 class="text-muted">Tanggal Publikasi</h6>
                    <p>{{ $article->publication_date->format('d F Y') }}</p>
                </div>

                <hr>

                <div class="mb-3">
                    <h6 class="text-muted">Abstrak</h6>
                    <p style="text-align: justify;">{{ $article->abstract }}</p>
                </div>

                <div class="mb-3">
                    <h6 class="text-muted">Kata Kunci</h6>
                    <p>
                        @foreach(explode(',', $article->keywords) as $keyword)
                            <span class="badge bg-light text-dark border">{{ trim($keyword) }}</span>
                        @endforeach
                    </p>
                </div>

                <hr>

                <div class="mb-3">
                    <h6 class="text-muted">Isi Artikel</h6>
                    <div style="text-align: justify; line-height: 1.8;">
                        {!! nl2br(e($article->content)) !!}
                    </div>
                </div>

                @if($article->pdf_file)
                    <hr>
                    <div class="mb-3">
                        <h6 class="text-muted">File PDF</h6>
                        <a href="{{ asset('storage/' . $article->pdf_file) }}" 
                           target="_blank" 
                           class="btn btn-success">
                            <i class="bi bi-file-earmark-pdf"></i> Buka PDF
                        </a>
                        <a href="{{ asset('storage/' . $article->pdf_file) }}" 
                           download 
                           class="btn btn-primary">
                            <i class="bi bi-download"></i> Download PDF
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="bi bi-info-circle"></i> Informasi</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td><strong>ID Artikel:</strong></td>
                        <td>{{ $article->id }}</td>
                    </tr>
                    <tr>
                        <td><strong>Slug:</strong></td>
                        <td><small>{{ $article->slug }}</small></td>
                    </tr>
                    <tr>
                        <td><strong>Dibuat:</strong></td>
                        <td>{{ $article->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Diupdate:</strong></td>
                        <td>{{ $article->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.articles.edit', $article->id) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Edit Artikel
                    </a>
                    <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <form action="{{ route('admin.articles.destroy', $article->id) }}" 
                          method="POST" 
                          onsubmit="return confirm('Yakin ingin menghapus artikel ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="bi bi-trash"></i> Hapus Artikel
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
