@extends('layouts.user')

@section('title', 'Submit Artikel Baru')
@section('page-title', 'Submit Artikel Baru')

@section('content')
<form action="{{ route('user.submissions.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Informasi Artikel</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Artikel <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="authors" class="form-label">Nama Penulis <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('authors') is-invalid @enderror" 
                               id="authors" name="authors" value="{{ old('authors') }}" required>
                        @error('authors')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="text-muted">Pisahkan dengan koma jika lebih dari satu penulis</small>
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select @error('category_id') is-invalid @enderror" 
                                id="category_id" name="category_id" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="abstract" class="form-label">Abstrak <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('abstract') is-invalid @enderror" 
                                  id="abstract" name="abstract" rows="5" required>{{ old('abstract') }}</textarea>
                        @error('abstract')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="keywords" class="form-label">Kata Kunci <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('keywords') is-invalid @enderror" 
                               id="keywords" name="keywords" value="{{ old('keywords') }}" required>
                        @error('keywords')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="text-muted">Pisahkan dengan koma</small>
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Isi Artikel <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                  id="content" name="content" rows="15" required>{{ old('content') }}</textarea>
                        @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">Upload PDF (Opsional)</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="pdf_file" class="form-label">File PDF</label>
                        <input type="file" class="form-control @error('pdf_file') is-invalid @enderror" 
                               id="pdf_file" name="pdf_file" accept=".pdf">
                        @error('pdf_file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="text-muted">Maksimal 10MB. Format: PDF</small>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send"></i> Submit Artikel
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
