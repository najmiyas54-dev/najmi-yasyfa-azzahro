@extends('layouts.admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Kelola Post</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Semua Artikel</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Penulis</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                    <tr>
                        <td>{{ Str::limit($post->title, 50) }}</td>
                        <td>
                            <span class="badge badge-secondary">{{ ucfirst($post->category) }}</span>
                        </td>
                        <td>{{ $post->user->name ?? 'Admin' }}</td>
                        <td>
                            @if($post->status == 'pending')
                                <span class="badge badge-warning">Menunggu</span>
                            @elseif($post->status == 'approved')
                                @if($post->is_published)
                                    <span class="badge badge-success">Dipublish</span>
                                @else
                                    <span class="badge badge-info">Disetujui</span>
                                @endif
                            @else
                                <span class="badge badge-danger">Ditolak</span>
                            @endif
                        </td>
                        <td>{{ $post->created_at->format('d/m/Y') }}</td>
                        <td>
                            @if($post->status == 'pending')
                                <form method="POST" action="{{ route('admin.approve-post', $post->id) }}" class="d-inline">
                                    @csrf
                                    <button class="btn btn-success btn-sm" title="Setujui">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.reject-post', $post->id) }}" class="d-inline">
                                    @csrf
                                    <button class="btn btn-warning btn-sm" title="Tolak">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $posts->links() }}
    </div>
</div>
@endsection