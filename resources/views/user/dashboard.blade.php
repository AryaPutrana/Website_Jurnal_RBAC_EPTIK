@extends('layouts.user')

@section('title', 'Dashboard User')
@section('page-title', 'Dashboard User')

@section('content')
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Total Submission</h6>
                        <h2 class="mb-0 mt-2">{{ $totalSubmissions }}</h2>
                    </div>
                    <i class="bi bi-file-text fs-1"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Pending</h6>
                        <h2 class="mb-0 mt-2">{{ $pendingSubmissions }}</h2>
                    </div>
                    <i class="bi bi-clock-history fs-1"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Approved</h6>
                        <h2 class="mb-0 mt-2">{{ $approvedSubmissions }}</h2>
                    </div>
                    <i class="bi bi-check-circle fs-1"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-danger mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Rejected</h6>
                        <h2 class="mb-0 mt-2">{{ $rejectedSubmissions }}</h2>
                    </div>
                    <i class="bi bi-x-circle fs-1"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Submission Terbaru</h5>
                <a href="{{ route('user.submissions.create') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-plus-circle"></i> Submit Artikel Baru
                </a>
            </div>
            <div class="card-body">
                @if($recentSubmissions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Status</th>
                                    <th>Tanggal Submit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentSubmissions as $index => $submission)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ Str::limit($submission->title, 50) }}</td>
                                        <td>{{ $submission->category->name ?? '-' }}</td>
                                        <td>
                                            @if($submission->status === 'pending')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @elseif($submission->status === 'approved')
                                                <span class="badge bg-success">Approved</span>
                                            @else
                                                <span class="badge bg-danger">Rejected</span>
                                            @endif
                                        </td>
                                        <td>{{ $submission->created_at->format('d M Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3 text-center">
                        <a href="{{ route('user.submissions.index') }}" class="btn btn-primary">
                            Lihat Semua Submission
                        </a>
                    </div>
                @else
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1"></i>
                        <p class="mt-2">Belum ada submission artikel</p>
                        <a href="{{ route('user.submissions.create') }}" class="btn btn-primary mt-2">
                            <i class="bi bi-plus-circle"></i> Submit Artikel Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
