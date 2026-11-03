@extends('layouts.admin')

@section('title', 'Daftar Artikel')
@section('page-title', 'Kelola Artikel')

@section('content')
<div class="row mb-3">
    <div class="col-md-12">
        <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Artikel
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Daftar Artikel</h5>
    </div>
    <div class="card-body">
        @if($articles->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="30%">Judul</th>
                            <th width="15%">Penulis</th>
                            <th width="15%">Kategori</th>
                            <th width="10%">Tanggal</th>
                            <th width="10%" class="text-center">Status</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($articles as $index => $article)
                            <tr>
                                <td>{{ $articles->firstItem() + $index }}</td>
                                <td>
                                    <strong>{{ Str::limit($article->title, 50) }}</strong>
                                    @if($article->pdf_file)
                                        <br>
                                        <a href="{{ asset('storage/' . $article->pdf_file) }}" 
                                           target="_blank" 
                                           class="text-success text-decoration-none">
                                            <i class="bi bi-file-earmark-pdf"></i> PDF tersedia
                                        </a>
                                    @endif
                                </td>
                                <td>{{ Str::limit($article->authors, 30) }}</td>
                                <td>
                                    <span class="badge bg-secondary">{{ $article->category->name ?? '-' }}</span>
                                </td>
                                <td>{{ $article->publication_date->format('d M Y') }}</td>
                                <td class="text-center">
                                    @if($article->status === 'published')
                                        <span class="badge bg-success">Published</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Draft</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.articles.show', $article->id) }}" 
                                           class="btn btn-info" 
                                           title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.articles.edit', $article->id) }}" 
                                           class="btn btn-warning" 
                                           title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.articles.destroy', $article->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus artikel ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $articles->links() }}
            </div>
        @else
            <div class="text-center py-5 text-muted">
                <i class="bi bi-inbox fs-1"></i>
                <p class="mt-2">Belum ada artikel</p>
                <a href="{{ route('admin.articles.create') }}" class="btn btn-primary mt-2">
                    <i class="bi bi-plus-circle"></i> Tambah Artikel Pertama
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
