<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Artikel Siswa - Guru Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
        .sidebar { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        .sidebar .nav-link { color: rgba(255,255,255,0.8); border-radius: 8px; margin: 2px 8px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: rgba(255,255,255,0.1); color: white; }
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0 sidebar">
                <div class="p-3">
                    <div class="text-center mb-4">
                        <i class="fas fa-chalkboard-teacher fa-2x text-white mb-2"></i>
                        <h5 class="text-white mb-0">Madingaja</h5>
                        <small class="text-white-50">Guru Panel</small>
                    </div>
                    
                    <nav class="nav flex-column">
                        <a class="nav-link" href="{{ route('guru.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                        <a class="nav-link" href="{{ route('guru.posts.index') }}">
                            <i class="fas fa-edit me-2"></i> Artikel Saya
                        </a>
                        <a class="nav-link active" href="{{ route('guru.student-posts') }}">
                            <i class="fas fa-user-graduate me-2"></i> Artikel Siswa
                        </a>
                        <a class="nav-link" href="{{ route('guru.users') }}">
                            <i class="fas fa-users me-2"></i> Kelola User
                        </a>
                    </nav>
                </div>
                
                <div class="mt-auto p-3">
                    <form action="{{ route('guru.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm w-100">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </button>
                    </form>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10">
                <nav class="navbar navbar-expand-lg navbar-light bg-white mb-4">
                    <div class="container-fluid">
                        <h4 class="mb-0 fw-bold text-dark">Artikel Siswa Menunggu Persetujuan</h4>
                        <span class="badge bg-warning fs-6">{{ $pendingPosts->total() }} artikel</span>
                    </div>
                </nav>

                <div class="container-fluid px-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="card">
                        <div class="card-body">
                            @forelse($pendingPosts as $post)
                            <div class="border rounded p-4 mb-4">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h5 class="mb-2">{{ $post->title }}</h5>
                                        <p class="text-muted mb-2">
                                            <i class="fas fa-user me-1"></i>{{ $post->user->name ?? 'Unknown' }}
                                            <i class="fas fa-calendar ms-3 me-1"></i>{{ $post->created_at->format('d M Y H:i') }}
                                            <span class="badge bg-secondary ms-2">{{ ucfirst($post->category) }}</span>
                                        </p>
                                        <div class="mb-3">
                                            {{ strlen($post->content) > 300 ? substr(strip_tags($post->content), 0, 300) . '...' : strip_tags($post->content) }}
                                        </div>
                                        
                                        @if($post->image_path)
                                        <div class="mb-3">
                                            <img src="{{ asset('storage/' . $post->image_path) }}" alt="Article image" class="img-thumbnail" style="max-width: 200px;">
                                        </div>
                                        @endif
                                        
                                        @if($post->file_path)
                                        <div class="mb-3">
                                            <a href="{{ asset('storage/' . $post->file_path) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-download me-1"></i>Download Lampiran
                                            </a>
                                        </div>
                                        @endif
                                    </div>
                                    
                                    <div class="col-md-4 text-end">
                                        <div class="d-grid gap-2">
                                            <form action="{{ route('guru.student-posts.approve', $post->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success w-100" onclick="return confirm('Setujui artikel ini?')">
                                                    <i class="fas fa-check me-1"></i>Setujui
                                                </button>
                                            </form>
                                            
                                            <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $post->id }}">
                                                <i class="fas fa-times me-1"></i>Tolak
                                            </button>
                                            

                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-5">
                                <i class="fas fa-clipboard-check fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Tidak ada artikel siswa yang menunggu persetujuan</h5>
                                <p class="text-muted">Semua artikel siswa sudah diproses</p>
                            </div>
                            @endforelse
                            
                            @foreach($pendingPosts as $post)
                            <!-- Reject Modal -->
                            <div class="modal fade" id="rejectModal{{ $post->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title">
                                                <i class="fas fa-times me-2"></i>Tolak Artikel
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('guru.student-posts.reject', $post->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <h6>Artikel: {{ $post->title }}</h6>
                                                    <p class="text-muted">Penulis: {{ $post->user->name ?? 'Unknown' }}</p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                                                    <textarea name="notes" class="form-control" rows="4" placeholder="Berikan alasan yang jelas mengapa artikel ditolak..." required></textarea>
                                                    <div class="form-text">Alasan ini akan dikirim ke siswa sebagai notifikasi</div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    <i class="fas fa-times me-1"></i>Batal
                                                </button>
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-paper-plane me-1"></i>Kirim Penolakan
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            
                            @if($pendingPosts->hasPages())
                                <div class="d-flex justify-content-center">
                                    {{ $pendingPosts->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>