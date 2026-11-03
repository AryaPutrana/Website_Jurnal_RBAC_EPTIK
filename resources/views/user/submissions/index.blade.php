@extends('layouts.user')

@section('title', 'Artikel Saya')
@section('page-title', 'Artikel Saya')

@section('content')
<div class="row mb-3">
    <div class="col-md-12">
        <a href="{{ route('user.submissions.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Submit Artikel Baru
        </a>
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
                            <th width="30%">Judul</th>
                            <th width="15%">Kategori</th>
                            <th width="10%">Tanggal</th>
                            <th width="10%" class="text-center">Status</th>
                            <th width="30%">Keterangan</th>
                            <th width="10%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($submissions as $index => $submission)
                            <tr>
                                <td>{{ $submissions->firstItem() + $index }}</td>
                                <td><strong>{{ Str::limit($submission->title, 40) }}</strong></td>
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
                                <td>
                                    @if($submission->status === 'pending')
                                        <small class="text-muted">Menunggu review admin</small>
                                    @elseif($submission->status === 'approved')
                                        <small class="text-success">Disetujui oleh {{ $submission->reviewer->name ?? 'Admin' }}</small>
                                    @else
                                        <small class="text-danger">{{ Str::limit($submission->admin_notes, 50) }}</small>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('user.submissions.show', $submission->id) }}" 
                                           class="btn btn-info" title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if($submission->status !== 'approved')
                                            <a href="{{ route('user.submissions.edit', $submission->id) }}" 
                                               class="btn btn-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('user.submissions.destroy', $submission->id) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Yakin ingin menghapus submission ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endif
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
                <a href="{{ route('user.submissions.create') }}" class="btn btn-primary mt-2">
                    <i class="bi bi-plus-circle"></i> Submit Artikel Pertama
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
