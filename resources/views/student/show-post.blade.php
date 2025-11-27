<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $post->title }} - Madingaja</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('student.dashboard') }}">
                <i class="fas fa-newspaper me-2"></i>Madingaja Siswa
            </a>
        </div>
    </nav>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-md-8">
                <!-- Artikel -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <span class="badge bg-secondary">{{ $post->category }}</span>
                            <small class="text-muted">{{ $post->created_at->format('d M Y, H:i') }}</small>
                        </div>
                        
                        <h1 class="h3 mb-3">{{ $post->title }}</h1>
                        
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="fas fa-user text-white"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">{{ $post->user->name ?? 'Unknown' }}</h6>
                                <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        
                        <div class="content">
                            {!! nl2br(e($post->content)) !!}
                        </div>
                    </div>
                </div>

                <!-- Komentar -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-comments me-2"></i>Komentar ({{ $post->comments->count() }})</h5>
                    </div>
                    <div class="card-body">
                        <!-- Form Komentar -->
                        @auth
                        <form action="{{ route('student.add-comment', $post->id) }}" method="POST" class="mb-4">
                            @csrf
                            <div class="mb-3">
                                <textarea class="form-control" name="comment" rows="3" placeholder="Tulis komentar..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-paper-plane me-1"></i>Kirim Komentar
                            </button>
                        </form>
                        @endauth

                        <!-- Daftar Komentar -->
                        @forelse($post->comments as $comment)
                        <div class="d-flex mb-3">
                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                                <i class="fas fa-user text-white small"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="bg-light p-3 rounded">
                                    <h6 class="mb-1">{{ $comment->user->name ?? 'Unknown' }}</h6>
                                    <p class="mb-1">{{ $comment->comment }}</p>
                                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        </div>
                        @empty
                        <p class="text-muted text-center">Belum ada komentar</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Navigasi</h6>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('student.dashboard') }}" class="btn btn-outline-primary w-100 mb-2">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                        </a>
                        <a href="{{ route('student.create-post') }}" class="btn btn-primary w-100">
                            <i class="fas fa-plus me-2"></i>Tulis Artikel Baru
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>