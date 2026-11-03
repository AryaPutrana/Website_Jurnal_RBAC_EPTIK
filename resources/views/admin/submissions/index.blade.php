@extends('layouts.admin')

@section('title', 'Review Submission Artikel')

@section('content')
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h6 class="card-title">Pending Review</h6>
                <h2>{{ $pendingCount }}</h2>
                <small>Menunggu review</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6 class="card-title">Approved</h6>
                <h2>{{ $approvedCount }}</h2>
                <small>Telah disetujui</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <h6 class="card-title">Rejected</h6>
                <h2>{{ $rejectedCount }}</h2>
                <small>Ditolak</small>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Daftar Submission Artikel</h5>
    </div>
    <div class="card-body">
        @if($submissions->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="25%">Judul</th>
                            <th width="15%">Penulis/User</th>
                            <th width="12%">Kategori</th>
                            <th width="10%">Tanggal</th>
                            <th width="10%" class="text-center">Status</th>
                            <th width="13%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($submissions as $index => $submission)
                            <tr class="{{ $submission->status === 'pending' ? 'table-warning' : '' }}">
                                <td>{{ $submissions->firstItem() + $index }}</td>
                                <td>
                                    <strong>{{ Str::limit($submission->title, 40) }}</strong>
                                    @if($submission->pdf_file)
                                        <br><small class="text-success"><i class="bi bi-file-pdf"></i> PDF tersedia</small>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ Str::limit($submission->authors, 30) }}</strong><br>
                                    <small class="text-muted">by: {{ $submission->user->name }}</small>
                                </td>
                                <td><span class="badge bg-secondary">{{ $submission->category->name }}</span></td>
                                <td>{{ $submission->created_at->format('d M Y') }}</td>
                                <td class="text-center">
                                    @if($submission->status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($submission->status === 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @else
                                        <span class="badge bg-danger">Rejected</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.submissions.show', $submission->id) }}" 
                                           class="btn btn-info" title="Review">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <form action="{{ route('admin.submissions.destroy', $submission->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus submission ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
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
                {{ $submissions->links() }}
            </div>
        @else
            <div class="text-center py-5 text-muted">
                <i class="bi bi-inbox fs-1"></i>
                <p class="mt-2">Belum ada submission artikel</p>
            </div>
        @endif
    </div>
</div>
@endsection
