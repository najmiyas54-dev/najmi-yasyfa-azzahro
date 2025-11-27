@extends('layouts.guru')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3>Artikel Saya</h3>
                    <a href="{{ route('guru.posts.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Tulis Artikel Baru
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Status</th>
                                    <th>Tanggal Dibuat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($posts as $post)
                                <tr>
                                    <td>{{ $post->title }}</td>
                                    <td>
                                        <span class="badge badge-info">{{ ucfirst($post->category) }}</span>
                                    </td>
                                    <td>
                                        @if($post->status == 'pending')
                                            <span class="badge badge-warning">Menunggu Verifikasi Admin</span>
                                        @elseif($post->status == 'approved')
                                            @if($post->is_published)
                                                <span class="badge badge-success">Dipublikasi</span>
                                            @else
                                                <span class="badge badge-primary">Disetujui - Siap Publish</span>
                                            @endif
                                        @elseif($post->status == 'rejected')
                                            <span class="badge badge-danger">Ditolak Admin</span>
                                        @else
                                            <span class="badge badge-secondary">Draft</span>
                                        @endif
                                    </td>
                                    <td>{{ $post->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if($post->status == 'approved' && !$post->is_published)
                                            <form action="{{ route('guru.posts.publish', $post->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success" title="Publish">
                                                    <i class="fa fa-globe"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        @if(in_array($post->approval_status, ['rejected', 'draft']))
                                            <a href="{{ route('guru.posts.edit', $post->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form action="{{ route('guru.posts.destroy', $post->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus artikel ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada artikel</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection