@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Total Artikel</h6>
                        <h2 class="mb-0 mt-2">{{ $totalArticles }}</h2>
                    </div>
                    <i class="bi bi-file-text fs-1"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Total Kategori</h6>
                        <h2 class="mb-0 mt-2">{{ $totalCategories }}</h2>
                    </div>
                    <i class="bi bi-folder fs-1"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-info mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Total Admin</h6>
                        <h2 class="mb-0 mt-2">{{ $totalAuthors }}</h2>
                    </div>
                    <i class="bi bi-people fs-1"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Artikel Terbaru</h5>
            </div>
            <div class="card-body">
                @if($recentArticles->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Status</th>
                                    <th>Tanggal Publikasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentArticles as $index => $article)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $article->title }}</td>
                                        <td>{{ $article->category->name ?? '-' }}</td>
                                        <td>
                                            @if($article->status === 'published')
                                                <span class="badge bg-success">Published</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Draft</span>
                                            @endif
                                        </td>
                                        <td>{{ $article->publication_date->format('d M Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-inbox fs-1"></i>
                        <p class="mt-2">Belum ada artikel</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
