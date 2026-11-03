@extends('layouts.user')

@section('title', 'Detail Submission')
@section('page-title', 'Detail Submission')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
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
                <div class="mb-3">
                    <h6 class="text-muted">Penulis</h6>
                    <p>{{ $submission->authors }}</p>
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
                           target="_blank" class="btn btn-success">
                            <i class="bi bi-file-pdf"></i> Buka PDF
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header 
                @if($submission->status === 'pending') bg-warning text-dark
                @elseif($submission->status === 'approved') bg-success text-white
                @else bg-danger text-white @endif">
                <h6 class="mb-0"><i class="bi bi-info-circle"></i> Status Review</h6>
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

                @if($submission->admin_notes)
                    <div class="alert alert-{{ $submission->status === 'approved' ? 'success' : 'danger' }} mt-3">
                        <strong>Catatan Admin:</strong><br>
                        {{ $submission->admin_notes }}
                    </div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="d-grid gap-2">
                    @if($submission->status !== 'approved')
                        <a href="{{ route('user.submissions.edit', $submission->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                    @endif
                    <a href="{{ route('user.submissions.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    @if($submission->status !== 'approved')
                        <form action="{{ route('user.submissions.destroy', $submission->id) }}" 
                              method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
