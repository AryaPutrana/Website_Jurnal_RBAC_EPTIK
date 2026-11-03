@extends('layouts.admin')

@section('title', 'Review Submission')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ $submission->title }}</h5>
                @if($submission->status === 'pending')
                    <span class="badge bg-warning text-dark">Pending</span>
                @elseif($submission->status === 'approved')
                    <span class="badge bg-success">Approved</span>
                @else
                    <span class="badge bg-danger">Rejected</span>
                @endif
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="text-muted">Penulis</h6>
                        <p>{{ $submission->authors }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Submitted By</h6>
                        <p><i class="bi bi-person"></i> {{ $submission->user->name }} ({{ $submission->user->email }})</p>
                    </div>
                </div>

                <div class="mb-3">
                    <h6 class="text-muted">Kategori</h6>
                    <span class="badge bg-secondary">{{ $submission->category->name }}</span>
                </div>

                <hr>

                <div class="mb-3">
                    <h6 class="text-muted">Abstrak</h6>
                    <p style="text-align: justify;">{{ $submission->abstract }}</p>
                </div>

                <div class="mb-3">
                    <h6 class="text-muted">Kata Kunci</h6>
                    <p>
                        @foreach(explode(',', $submission->keywords) as $keyword)
                            <span class="badge bg-light text-dark border">{{ trim($keyword) }}</span>
                        @endforeach
                    </p>
                </div>

                <hr>

                <div class="mb-3">
                    <h6 class="text-muted">Isi Artikel</h6>
                    <div style="text-align: justify; line-height: 1.8;">
                        {!! nl2br(e($submission->content)) !!}
                    </div>
                </div>

                @if($submission->pdf_file)
                    <hr>
                    <div class="mb-3">
                        <h6 class="text-muted">File PDF</h6>
                        <a href="{{ asset('storage/' . $submission->pdf_file) }}" 
                           target="_blank" class="btn btn-success me-2">
                            <i class="bi bi-file-pdf"></i> Buka PDF
                        </a>
                        <a href="{{ asset('storage/' . $submission->pdf_file) }}" 
                           download class="btn btn-outline-success">
                            <i class="bi bi-download"></i> Download PDF
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Info Card -->
        <div class="card mb-3">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="bi bi-info-circle"></i> Informasi Submission</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td><strong>Status:</strong></td>
                        <td>
                            @if($submission->status === 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($submission->status === 'approved')
                                <span class="badge bg-success">Approved</span>
                            @else
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Submitted:</strong></td>
                        <td>{{ $submission->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @if($submission->reviewed_at)
                        <tr>
                            <td><strong>Reviewed:</strong></td>
                            <td>{{ $submission->reviewed_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Reviewed By:</strong></td>
                            <td>{{ $submission->reviewer->name ?? 'Admin' }}</td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>

        @if($submission->status === 'pending')
            <!-- Approve Form -->
            <div class="card mb-3 border-success">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0"><i class="bi bi-check-circle"></i> Approve Artikel</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.submissions.approve', $submission->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="publication_date" class="form-label">Tanggal Publikasi <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('publication_date') is-invalid @enderror" 
                                   id="publication_date" name="publication_date" 
                                   value="{{ old('publication_date', date('Y-m-d')) }}" required>
                            @error('publication_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="admin_notes_approve" class="form-label">Catatan (Opsional)</label>
                            <textarea class="form-control" id="admin_notes_approve" 
                                      name="admin_notes" rows="3" 
                                      placeholder="Catatan untuk user...">{{ old('admin_notes') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-success w-100" 
                                onclick="return confirm('Yakin approve artikel ini?');">
                            <i class="bi bi-check-circle"></i> Approve & Publikasikan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Reject Form -->
            <div class="card mb-3 border-danger">
                <div class="card-header bg-danger text-white">
                    <h6 class="mb-0"><i class="bi bi-x-circle"></i> Reject Artikel</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.submissions.reject', $submission->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="admin_notes_reject" class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('admin_notes') is-invalid @enderror" 
                                      id="admin_notes_reject" name="admin_notes" rows="4" 
                                      placeholder="Jelaskan alasan penolakan..." required>{{ old('admin_notes') }}</textarea>
                            @error('admin_notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <button type="submit" class="btn btn-danger w-100" 
                                onclick="return confirm('Yakin reject artikel ini?');">
                            <i class="bi bi-x-circle"></i> Reject Artikel
                        </button>
                    </form>
                </div>
            </div>
        @else
            <!-- Status Info -->
            <div class="card mb-3">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0">Status Review</h6>
                </div>
                <div class="card-body">
                    @if($submission->admin_notes)
                        <div class="alert alert-{{ $submission->status === 'approved' ? 'success' : 'danger' }}">
                            <strong>Catatan:</strong><br>
                            {{ $submission->admin_notes }}
                        </div>
                    @endif
                    <p class="text-muted mb-0">
                        Artikel ini sudah di-review pada {{ $submission->reviewed_at->format('d/m/Y H:i') }}
                    </p>
                </div>
            </div>
        @endif

        <!-- Back Button -->
        <div class="card">
            <div class="card-body">
                <a href="{{ route('admin.submissions.index') }}" class="btn btn-secondary w-100">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
