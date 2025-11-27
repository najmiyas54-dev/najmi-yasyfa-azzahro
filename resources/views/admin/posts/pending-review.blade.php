@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Artikel Perlu Review Admin</h3>
                </div>
                <div class="card-body">
                    @if($posts->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Judul</th>
                                        <th>Siswa</th>
                                        <th>Kategori</th>
                                        <th>Review Guru</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($posts as $post)
                                    <tr>
                                        <td>{{ $post->title }}</td>
                                        <td>{{ $post->user->name }}</td>
                                        <td>
                                            <span class="badge badge-info">{{ ucfirst($post->category) }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-success">Disetujui Guru</span>
                                            @if($post->guru_notes)
                                                <br><small class="text-muted">{{ $post->guru_notes }}</small>
                                            @endif
                                        </td>
                                        <td>{{ $post->guru_reviewed_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('admin.posts.preview', $post->id) }}" 
                                               class="btn btn-sm btn-info" target="_blank">
                                                <i class="fas fa-eye"></i> Preview
                                            </a>
                                            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#adminReviewModal{{ $post->id }}">
                                                <i class="fas fa-edit"></i> Review
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Admin Review Modal -->
                                    <div class="modal fade" id="adminReviewModal{{ $post->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Review Admin: {{ $post->title }}</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <strong>Siswa:</strong> {{ $post->user->name }}<br>
                                                        <strong>Kategori:</strong> {{ ucfirst($post->category) }}<br>
                                                        <strong>Tanggal:</strong> {{ $post->created_at->format('d/m/Y H:i') }}<br>
                                                        <strong>Disetujui Guru:</strong> {{ $post->guru_reviewed_at->format('d/m/Y H:i') }}
                                                    </div>

                                                    @if($post->guru_notes)
                                                    <div class="mb-3">
                                                        <strong>Catatan Guru:</strong>
                                                        <div class="alert alert-info">{{ $post->guru_notes }}</div>
                                                    </div>
                                                    @endif
                                                    
                                                    <div class="mb-3">
                                                        <strong>Konten:</strong>
                                                        <div class="border p-3 mt-2">
                                                            {!! nl2br(e($post->content)) !!}
                                                        </div>
                                                    </div>

                                                    @if($post->image_path)
                                                    <div class="mb-3">
                                                        <strong>Gambar:</strong><br>
                                                        <img src="{{ asset('storage/' . $post->image_path) }}" class="img-fluid" style="max-height: 200px;">
                                                    </div>
                                                    @endif

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <form action="{{ route('admin.posts.approve', $post->id) }}" method="POST">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <label>Catatan (Opsional):</label>
                                                                    <textarea name="notes" class="form-control" rows="3" placeholder="Berikan catatan untuk siswa..."></textarea>
                                                                </div>
                                                                <button type="submit" class="btn btn-success btn-block">
                                                                    <i class="fas fa-check"></i> Setujui & Publikasikan
                                                                </button>
                                                            </form>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <form action="{{ route('admin.posts.reject', $post->id) }}" method="POST">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <label>Alasan Penolakan:</label>
                                                                    <textarea name="notes" class="form-control" rows="3" placeholder="Berikan alasan penolakan..." required></textarea>
                                                                </div>
                                                                <button type="submit" class="btn btn-danger btn-block">
                                                                    <i class="fas fa-times"></i> Tolak
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $posts->links() }}
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Tidak ada artikel yang perlu direview</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection