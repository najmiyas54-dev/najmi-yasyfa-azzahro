<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>E-Mading SMK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">E-Mading SMK</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('mystories') }}">My Stories</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-light py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h1 class="display-4">Selamat Datang di E-Mading SMK</h1>
                    <p class="lead">Portal informasi terkini sekolah</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Content Sections -->
    <div class="container my-5">
        <!-- Pengumuman Section -->
        @if($pengumuman->count() > 0)
        <section class="mb-5">
            <h2 class="text-primary mb-4"><i class="fas fa-bullhorn"></i> Pengumuman Terbaru</h2>
            <div class="row">
                @foreach($pengumuman as $item)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        @if($item->image_path)
                        <img src="{{ $item->image_path }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->title }}</h5>
                            <p class="card-text">{{ Str::limit($item->content, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">{{ $item->published_at ? $item->published_at->format('d M Y') : $item->created_at->format('d M Y') }}</small>
                                <button onclick="likePost({{ $item->id }})" class="like-button-{{ $item->id }} btn btn-sm" style="border: none; background: {{ $item->isLikedBy(auth()->id() ?: request()->ip()) ? 'linear-gradient(135deg, #ff6b6b, #ee5a52)' : '#f8f9fa' }}; color: {{ $item->isLikedBy(auth()->id() ?: request()->ip()) ? 'white' : '#6c757d' }}; padding: 4px 8px; border-radius: 15px;">
                                    <i class="fa fa-heart"></i> <span id="likes-count-{{ $item->id }}">{{ $item->likes_count ?? 0 }}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- Prestasi Section -->
        @if($prestasi->count() > 0)
        <section class="mb-5">
            <h2 class="text-success mb-4"><i class="fas fa-trophy"></i> Prestasi Terbaru</h2>
            <div class="row">
                @foreach($prestasi as $item)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        @if($item->image_path)
                        <img src="{{ $item->image_path }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->title }}</h5>
                            <p class="card-text">{{ Str::limit($item->content, 100) }}</p>
                            <small class="text-muted">{{ $item->published_at ? $item->published_at->format('d M Y') : $item->created_at->format('d M Y') }}</small>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- Berita Section -->
        @if($berita->count() > 0)
        <section class="mb-5">
            <h2 class="text-info mb-4"><i class="fas fa-newspaper"></i> Berita Terbaru</h2>
            <div class="row">
                @foreach($berita as $item)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        @if($item->image_path)
                        <img src="{{ $item->image_path }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->title }}</h5>
                            <p class="card-text">{{ Str::limit($item->content, 100) }}</p>
                            <small class="text-muted">{{ $item->published_at ? $item->published_at->format('d M Y') : $item->created_at->format('d M Y') }}</small>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- Lomba Section -->
        @if($lomba->count() > 0)
        <section class="mb-5">
            <h2 class="text-warning mb-4"><i class="fas fa-medal"></i> Lomba Terbaru</h2>
            <div class="row">
                @foreach($lomba as $item)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        @if($item->image_path)
                        <img src="{{ $item->image_path }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->title }}</h5>
                            <p class="card-text">{{ Str::limit($item->content, 100) }}</p>
                            <small class="text-muted">{{ $item->published_at ? $item->published_at->format('d M Y') : $item->created_at->format('d M Y') }}</small>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endif
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <p>&copy; 2024 E-Mading SMK. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    function likePost(postId) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (!csrfToken) {
            alert('Error: CSRF token not found');
            return;
        }
        
        fetch('/post/' + postId + '/like', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const likesCountElement = document.getElementById('likes-count-' + postId);
                const button = document.querySelector('.like-button-' + postId);
                
                if (likesCountElement) {
                    likesCountElement.textContent = data.likes_count;
                }
                
                if (button) {
                    if (data.liked) {
                        button.style.background = 'linear-gradient(135deg, #ff6b6b, #ee5a52)';
                        button.style.color = 'white';
                    } else {
                        button.style.background = '#f8f9fa';
                        button.style.color = '#6c757d';
                    }
                }
            } else {
                alert('Error: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memproses like.');
        });
    }
    </script>
</body>
</html>