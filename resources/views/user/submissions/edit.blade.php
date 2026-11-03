@extends('layouts.user')

@section('title', 'Edit Submission')
@section('page-title', 'Edit Submission')

@section('content')
<form action="{{ route('user.submissions.update', $submission->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Edit Artikel</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Artikel <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title', $submission->title) }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="authors" class="form-label">Nama Penulis <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('authors') is-invalid @enderror" 
                               id="authors" name="authors" value="{{ old('authors', $submission->authors) }}" required>
                        @error('authors')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select @error('category_id') is-invalid @enderror" 
                                id="category_id" name="category_id" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                    {{ old('category_id', $submission->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="abstract" class="form-label">Abstrak <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('abstract') is-invalid @enderror" 
                                  id="abstract" name="abstract" rows="5" required>{{ old('abstract', $submission->abstract) }}</textarea>
                        @error('abstract')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="keywords" class="form-label">Kata Kunci <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('keywords') is-invalid @enderror" 
                               id="keywords" name="keywords" value="{{ old('keywords', $submission->keywords) }}" required>
                        @error('keywords')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Isi Artikel <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                  id="content" name="content" rows="15" required>{{ old('content', $submission->content) }}</textarea>
                        @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0">File PDF</h6>
                </div>
                <div class="card-body">
                    @if($submission->pdf_file)
                        <div class="alert alert-info py-2 mb-2">
                            <i class="bi bi-file-pdf"></i> File PDF sudah ada
                        </div>
                    @endif
                    <div class="mb-3">
                        <label for="pdf_file" class="form-label">Upload PDF Baru</label>
                        <input type="file" class="form-control @error('pdf_file') is-invalid @enderror" 
                               id="pdf_file" name="pdf_file" accept=".pdf">
                        @error('pdf_file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="text-muted">Maksimal 10MB</small>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Update
                        </button>
                        <a href="{{ route('user.submissions.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
