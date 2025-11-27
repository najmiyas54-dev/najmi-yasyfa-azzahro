@extends('layouts.guru')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Artikel Siswa Perlu Review</h3>
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
                                        <th>Tanggal</th>
                                        <th>Status</th>
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
                                        <td>{{ $post->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <span class="badge badge-warning">Menunggu Review</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('guru.detail-post', $post->id) }}" 
                                               class="btn btn-sm btn-success">
                                                <i class="fas fa-file-alt"></i> Detail
                                            </a>
                                            <a href="{{ route('guru.review-article', $post->id) }}" 
                                               class="btn btn-sm btn-primary">
                                                <i class="fas fa-clipboard-check"></i> Review
                                            </a>
                                        </td>
                                    </tr>

                                    <!-- Review Modal -->
                                    <div class="modal fade" id="reviewModal{{ $post->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Review Artikel: {{ $post->title }}</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <strong>Siswa:</strong> {{ $post->user->name }}<br>
                                                        <strong>Kategori:</strong> {{ ucfirst($post->category) }}<br>
                                                        <strong>Tanggal:</strong> {{ $post->created_at->format('d/m/Y H:i') }}
                                                    </div>
                                                    
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
                                                            <form action="{{ route('guru.approve-post', $post->id) }}" method="POST">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <label>Catatan (Opsional):</label>
                                                                    <textarea name="notes" class="form-control" rows="3" placeholder="Berikan catatan untuk siswa..."></textarea>
                                                                </div>
                                                                <button type="submit" class="btn btn-success btn-block">
                                                                    <i class="fas fa-check"></i> Setujui
                                                                </button>
                                                            </form>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <form action="{{ route('guru.reject-post', $post->id) }}" method="POST">
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