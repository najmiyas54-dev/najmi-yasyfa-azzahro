@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Artikel {{ ucfirst($category) }}</h1>
        <a href="/admin/categories" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Artikel {{ ucfirst($category) }}</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Judul</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($posts as $post)
                        <tr>
                            <td>{{ $post->id }}</td>
                            <td>{{ Str::limit($post->title, 50) }}</td>
                            <td>{{ $post->created_at->format('d/m/Y') }}</td>
                            <td>
                                @if($category == 'pengumuman')
                                    <span class="badge badge-info">Pengumuman</span>
                                @elseif($category == 'prestasi')
                                    <span class="badge badge-success">Prestasi</span>
                                @elseif($category == 'berita')
                                    <span class="badge badge-primary">Berita</span>
                                @elseif($category == 'lomba')
                                    <span class="badge badge-warning">Lomba</span>
                                @endif
                            </td>
                            <td>
                                <a href="/admin/posts/{{ $post->id }}/edit" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <button class="btn btn-sm btn-danger" onclick="deletePost({{ $post->id }})">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada artikel {{ $category }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function deletePost(id) {
    if (confirm('Apakah Anda yakin ingin menghapus artikel ini?')) {
        fetch(`/admin/posts/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Gagal menghapus artikel');
            }
        });
    }
}
</script>
@endsection