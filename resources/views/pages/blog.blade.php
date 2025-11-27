@extends('layouts.app')

@section('content')
<!-- Blog Header -->
<section class="py-5" style="background: linear-gradient(135deg, #d8c5fa 0%, #f2b2d0 100%); margin-top: 70px;">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center text-white">
                <div class="mb-4">
                    <i class="fa fa-newspaper fa-3x mb-3" style="opacity: 0.8;"></i>
                </div>
                <h1 class="mb-3" style="font-family: 'Baloo 2', cursive; font-weight: 700; font-size: 2.5rem;">Blog & Berita</h1>
                <p class="mb-4 lead">Artikel terbaru dan berita menarik dari SMK Bakti Nusantara 666</p>
                <div class="d-flex justify-content-center flex-wrap">
                    <span class="badge badge-light badge-pill px-3 py-2 mr-3 mb-2" style="font-size: 0.9rem;">
                        <i class="fa fa-newspaper mr-1"></i> {{ $posts->total() }} Artikel
                    </span>
                    <span class="badge badge-light badge-pill px-3 py-2 mb-2" style="font-size: 0.9rem;">
                        <i class="fa fa-eye mr-1"></i> {{ number_format(\App\Models\Post::sum('views_count')) }} Views
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Blog-Section -->
<section class="blog-page py-5" style="background: #f8f9fa;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <div class="d-flex align-items-center mb-4">
                    <div class="mr-3">
                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="fa fa-newspaper text-white"></i>
                        </div>
                    </div>
                    <div>
                        <h2 class="mb-1" style="color: #2c3e50; font-weight: 600;">Blog & Berita Terbaru</h2>
                        <p class="text-muted mb-0">Artikel informatif dan berita terkini seputar dunia pendidikan</p>
                    </div>
                </div>
                
                @if($posts->count() > 0)
                    @foreach($posts as $post)
                    <article class="card mb-4 shadow-sm border-0 hover-card">
                        @if($post->image_path && $post->image_path != '')
                            <div class="position-relative overflow-hidden">
                                <img src="{{ asset('storage/' . $post->image_path) }}" class="card-img-top" alt="{{ $post->title }}" style="height: 250px; object-fit: cover; transition: transform 0.3s ease;">
                                <div class="position-absolute" style="top: 15px; left: 15px;">
                                    @if($post->category)
                                        <span class="badge badge-primary px-3 py-2" style="font-size: 0.8rem;">{{ ucfirst($post->category) }}</span>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="card-img-top bg-gradient-primary d-flex align-items-center justify-content-center" style="height: 250px;">
                                <div class="text-center text-white">
                                    <i class="fa fa-newspaper fa-4x mb-3 opacity-50"></i>
                                    @if($post->category)
                                        <div><span class="badge badge-light px-3 py-2">{{ ucfirst($post->category) }}</span></div>
                                    @endif
                                </div>
                            </div>
                        @endif
                        <div class="card-body p-4">
                            <div class="mb-2">
                                <small class="text-muted d-flex align-items-center">
                                    <i class="fa fa-user mr-1"></i> {{ $post->user->name ?? 'Admin' }}
                                    <span class="mx-2">•</span>
                                    <i class="fa fa-calendar mr-1"></i> {{ $post->created_at->format('d M Y') }}
                                </small>
                            </div>
                            <h5 class="card-title mb-3">
                                <a href="{{ route('single', $post->id) }}" class="text-decoration-none text-dark hover-link">{{ $post->title }}</a>
                            </h5>
                            <p class="card-text text-muted mb-4">{{ Str::limit(strip_tags($post->content), 180) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="text-muted small mr-3 d-flex align-items-center">
                                        <i class="fa fa-eye mr-1"></i> {{ number_format($post->views_count ?? 0) }}
                                    </div>
                                    <button onclick="likePost({{ $post->id }})" class="like-button-{{ $post->id }} btn btn-sm d-flex align-items-center" style="border: none; background: {{ $post->isLikedBy() ? 'linear-gradient(135deg, #ff6b6b, #ee5a52)' : '#f8f9fa' }}; color: {{ $post->isLikedBy() ? 'white' : '#6c757d' }}; padding: 6px 12px; border-radius: 20px; transition: all 0.3s ease;">
                                        <i class="fa fa-heart mr-1"></i> <span id="likes-count-{{ $post->id }}">{{ number_format($post->likes_count ?? 0) }}</span>
                                    </button>

                                </div>
                                <a href="{{ route('single', $post->id) }}" class="btn btn-info btn-sm px-4" style="border-radius: 20px; font-weight: 500; transition: all 0.3s ease;">
                                    Baca Selengkapnya <i class="fa fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                    @endforeach
                @else
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="fa fa-newspaper fa-5x text-muted opacity-50"></i>
                        </div>
                        <h4 class="text-muted mb-3">Belum Ada Artikel</h4>
                        <p class="text-muted mb-4">Artikel dan berita menarik akan segera hadir. Silakan kembali lagi nanti.</p>
                        <a href="{{ route('home') }}" class="btn btn-info px-4" style="border-radius: 20px;">
                            <i class="fa fa-home mr-2"></i> Kembali ke Beranda
                        </a>
                    </div>
                @endif
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="sticky-top" style="top: 100px;">
                    <!-- About Widget -->
                    <div class="card mb-4 shadow-sm" style="border: none; border-radius: 15px; overflow: hidden;">
                        <div class="card-header text-white" style="background: linear-gradient(135deg,  #d8c5fa 0%, #f2b2d0 100%); border: none;">
                            <h5 class="mb-0 d-flex align-items-center">
                                <i class="fa fa-info-circle mr-2"></i> Tentang Blog
                            </h5>
                        </div>
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <img src="{{ asset('images/logosmk.png') }}" alt="Logo SMK" style="width: 60px; height: 60px; object-fit: contain;">
                            </div>
                            <h5 class="mb-2" style="color: #2c3e50; font-family: 'Baloo 2', cursive; font-weight: 700;">E-MAGAZINE BAKNUS</h5>
                            <p class="text-muted mb-0" style="font-size: 0.9rem; line-height: 1.5;">Platform media digital untuk berbagi artikel, berita, dan informasi terkini seputar SMK Bakti Nusantara 666.</p>
                        </div>
                    </div>
                    
                    <!-- Quick Stats -->
                    <div class="card mb-4 shadow-sm" style="border: none; border-radius: 15px; overflow: hidden;">
                        <div class="card-header text-white" style="background: linear-gradient(135deg, #d8c5fa 0%, #f2b2d0 100%); border: none;">
                            <h5 class="mb-0 d-flex align-items-center">
                                <i class="fa fa-chart-bar mr-2"></i> Statistik Konten
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row text-center">
                                <div class="col-6 mb-3">
                                    <div class="p-3 rounded" style="background: rgba(108, 117, 125, 0.1);">
                                        <h4 class="text-secondary mb-1">{{ \App\Models\Post::where('approval_status', 'published')->count() }}</h4>
                                        <small class="text-muted">Artikel</small>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="p-3 rounded" style="background: rgba(40, 167, 69, 0.1);">
                                        <h4 class="text-success mb-1">{{ \App\Models\Post::where('category', 'prestasi')->where('approval_status', 'published')->count() }}</h4>
                                        <small class="text-muted">Prestasi</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 rounded" style="background: rgba(255, 193, 7, 0.1);">
                                        <h4 class="text-warning mb-1">{{ \App\Models\Post::where('category', 'lomba')->where('approval_status', 'published')->count() }}</h4>
                                        <small class="text-muted">Lomba</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 rounded" style="background: rgba(23, 162, 184, 0.1);">
                                        <h4 class="text-info mb-1">{{ \App\Models\Post::where('category', 'kegiatan')->where('approval_status', 'published')->count() }}</h4>
                                        <small class="text-muted">Kegiatan</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Navigation Links -->
                    <div class="card shadow-sm" style="border: none; border-radius: 15px; overflow: hidden;">
                        <div class="card-header text-white" style="background: linear-gradient(135deg, #d8c5fa 0%, #f2b2d0 100%); border: none;">
                            <h5 class="mb-0 d-flex align-items-center">
                                <i class="fa fa-compass mr-2"></i> Jelajahi Lainnya
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                <a href="{{ route('home') }}" class="list-group-item list-group-item-action border-0 py-3" style="transition: all 0.3s ease;">
                                    <i class="fa fa-home mr-3 text-primary"></i> Beranda
                                </a>
                                <a href="{{ route('pengumuman') }}" class="list-group-item list-group-item-action border-0 py-3" style="transition: all 0.3s ease;">
                                    <i class="fa fa-bullhorn mr-3 text-danger"></i> Pengumuman
                                </a>
                                <a href="{{ route('prestasi') }}" class="list-group-item list-group-item-action border-0 py-3" style="transition: all 0.3s ease;">
                                    <i class="fa fa-trophy mr-3 text-success"></i> Prestasi
                                </a>
                                <a href="{{ route('kegiatan') }}" class="list-group-item list-group-item-action border-0 py-3" style="transition: all 0.3s ease;">
                                    <i class="fa fa-calendar-alt mr-3 text-info"></i> Kegiatan
                                </a>
                                <a href="{{ route('lomba') }}" class="list-group-item list-group-item-action border-0 py-3" style="transition: all 0.3s ease;">
                                    <i class="fa fa-medal mr-3 text-warning"></i> Lomba
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($posts->hasPages())
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <div class="card shadow-sm mt-4" style="border: none; border-radius: 15px; background: white;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="text-muted d-flex align-items-center">
                                <i class="fa fa-list mr-2"></i>
                                <span>Menampilkan {{ $posts->firstItem() }} - {{ $posts->lastItem() }} dari {{ $posts->total() }} artikel</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <nav aria-label="Blog pagination">
                                <ul class="pagination pagination-lg mb-0" style="border-radius: 10px; overflow: hidden;">
                                    @if ($posts->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link" style="border: none; background: #f8f9fa; color: #6c757d;">
                                                <i class="fa fa-chevron-left"></i> Previous
                                            </span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $posts->previousPageUrl() }}" rel="prev" style="border: none; background: #6f42c1; color: white; transition: all 0.3s ease;">
                                                <i class="fa fa-chevron-left"></i> Previous
                                            </a>
                                        </li>
                                    @endif

                                    @foreach ($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                                        @if ($page == $posts->currentPage())
                                            <li class="page-item active">
                                                <span class="page-link" style="border: none; background: #e83e8c; color: white;">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $url }}" style="border: none; background: white; color: #6f42c1; transition: all 0.3s ease;">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endforeach

                                    @if ($posts->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $posts->nextPageUrl() }}" rel="next" style="border: none; background: #6f42c1; color: white; transition: all 0.3s ease;">
                                                Next <i class="fa fa-chevron-right"></i>
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link" style="border: none; background: #f8f9fa; color: #6c757d;">
                                                Next <i class="fa fa-chevron-right"></i>
                                            </span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection

<style>
.hover-card {
    transition: all 0.3s ease;
    border-radius: 15px;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
}

.hover-card:hover .card-img-top {
    transform: scale(1.05);
}

.hover-link {
    transition: color 0.3s ease;
}

.hover-link:hover {
    color: #007bff !important;
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}



.opacity-50 {
    opacity: 0.5;
}

.like-button:hover {
    transform: scale(1.1);
}

.btn-read-more {
    background: linear-gradient(135deg, #D2B48C 0%, #8B4513 100%);
    color: white;
    padding: 10px 20px;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    border: none;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(210, 180, 140, 0.3);
}

.btn-read-more:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(210, 180, 140, 0.4);
    color: white;
    text-decoration: none;
}

.btn-read-more:hover .fa-arrow-right {
    transform: translateX(5px);
}

.btn-read-more .fa-arrow-right {
    transition: transform 0.3s ease;
}

.btn-read-more::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.btn-read-more:hover::before {
    left: 100%;
}

.pagination-lg .page-link {
    padding: 12px 20px;
    font-size: 1rem;
    border-radius: 8px;
    margin: 0 2px;
    border: 1px solid #dee2e6;
    color: #495057;
    transition: all 0.3s ease;
}

.pagination-lg .page-item.active .page-link {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-color: #667eea;
    color: white;
    box-shadow: 0 4px 8px rgba(102, 126, 234, 0.3);
}

.pagination-lg .page-link:hover {
    background-color: #f8f9fa;
    border-color: #667eea;
    color: #667eea;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.pagination-lg .page-item.disabled .page-link {
    background-color: #f8f9fa;
    border-color: #dee2e6;
    color: #6c757d;
}

@media (max-width: 768px) {
    .hover-card:hover {
        transform: none;
    }
    
    .card-body {
        padding: 1rem !important;
    }
    
    .pagination-lg .page-link {
        padding: 8px 12px;
        font-size: 0.9rem;
        margin: 0 1px;
    }
    
    .pagination-lg {
        justify-content: center;
        flex-wrap: wrap;
    }
    
    .btn-read-more {
        padding: 8px 16px;
        font-size: 0.85rem;
    }
}
</style>

<script>


function likePost(postId) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        showAlert('CSRF token tidak ditemukan. Silakan refresh halaman.', 'error');
        return;
    }
    
    const button = document.querySelector('.like-button-' + postId);
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fa fa-spinner fa-spin mr-1"></i> Loading...';
    button.disabled = true;
    
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
            
            if (likesCountElement) {
                likesCountElement.textContent = new Intl.NumberFormat().format(data.likes_count);
            }
            
            if (button) {
                if (data.liked) {
                    button.style.background = 'linear-gradient(135deg, #ff6b6b, #ee5a52)';
                    button.style.color = 'white';
                } else {
                    button.style.background = '#f8f9fa';
                    button.style.color = '#6c757d';
                }
                button.innerHTML = `<i class="fa fa-heart mr-1"></i> <span id="likes-count-${postId}">${new Intl.NumberFormat().format(data.likes_count)}</span>`;
            }
        } else {
            showAlert(data.message || 'Terjadi kesalahan', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Terjadi kesalahan saat memproses like.', 'error');
    })
    .finally(() => {
        button.disabled = false;
        if (button.innerHTML.includes('Loading')) {
            button.innerHTML = originalText;
        }
    });
}

function showAlert(message, type = 'info') {
    const alertClass = type === 'error' ? 'alert-danger' : 'alert-info';
    const alertHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show position-fixed" style="top: 100px; right: 20px; z-index: 9999; min-width: 300px;">
            ${message}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', alertHtml);
    
    setTimeout(() => {
        const alert = document.querySelector('.alert');
        if (alert) alert.remove();
    }, 5000);
}
</script>

