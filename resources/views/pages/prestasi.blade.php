@extends('layouts.app')

@section('content')
<!-- Prestasi Header -->
<section class="py-5" style="background: linear-gradient(135deg, #f8c6f0 0%, #c8d4fc 100%); margin-top: 70px;">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center text-white">
                <div class="mb-4">
                    <i class="fa fa-trophy fa-3x mb-3" style="opacity: 0.8;"></i>
                </div>
                <h1 class="mb-3" style="font-family: 'Baloo 2', cursive; font-weight: 700; font-size: 2.5rem;">Prestasi Sekolah</h1>
                <p class="mb-4 lead">Pencapaian membanggakan siswa dan sekolah SMK Bakti Nusantara 666</p>
                <div class="d-flex justify-content-center flex-wrap">
                    <span class="badge badge-light badge-pill px-3 py-2 mr-3 mb-2" style="font-size: 0.9rem;">
                        <i class="fa fa-trophy mr-1"></i> {{ \App\Models\Post::where('category', 'prestasi')->where('status', 'approved')->count() }} Prestasi
                    </span>
                    <span class="badge badge-light badge-pill px-3 py-2 mb-2" style="font-size: 0.9rem;">
                        <i class="fa fa-eye mr-1"></i> {{ number_format(\App\Models\Post::where('category', 'prestasi')->sum('views_count')) }} Views
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Prestasi Section -->
<section class="prestasi-page py-5" style="background: #f8f9fa;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <div class="d-flex align-items-center mb-4">
                    <div class="mr-3">
                        <div class="bg-success rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="fa fa-trophy text-white"></i>
                        </div>
                    </div>
                    <div>
                        <h2 class="mb-1" style="color: #2c3e50; font-weight: 600;">Prestasi Terbaru</h2>
                        <p class="text-muted mb-0">Raihan prestasi membanggakan dari siswa-siswi terbaik</p>
                    </div>
                </div>
                
                @if($prestasi->count() > 0)
                    @foreach($prestasi as $post)
                    <article class="card mb-4 shadow-sm hover-card" style="border: none; border-radius: 15px; overflow: hidden; transition: all 0.3s ease;">
                        @if($post->image_path && $post->image_path != '')
                            <div class="position-relative" style="overflow: hidden;">
                                <img src="{{ asset('storage/' . $post->image_path) }}" class="card-img-top" alt="{{ $post->title }}" style="height: 280px; object-fit: cover; transition: transform 0.3s ease;">
                                <div class="position-absolute" style="top: 15px; left: 15px;">
                                    <span class="badge badge-success px-3 py-2" style="font-size: 0.8rem; border-radius: 20px;">
                                        <i class="fa fa-trophy mr-1"></i> Prestasi
                                    </span>
                                </div>
                            </div>
                        @endif
                        <div class="card-body p-4">
                            <h5 class="card-title mb-3" style="font-weight: 600; line-height: 1.4;">
                                <a href="{{ route('single', $post->id) }}" class="text-decoration-none" style="color: #2c3e50; transition: color 0.3s ease;">{{ $post->title }}</a>
                            </h5>
                            <p class="card-text text-muted mb-4" style="line-height: 1.6;">{{ Str::limit(strip_tags($post->content), 180) }}</p>
                            
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center">
                                    @if($post->location)
                                        <span class="badge badge-outline-secondary mr-2" style="border: 1px solid #6c757d; color: #6c757d; background: transparent; border-radius: 15px; padding: 5px 12px;">
                                            <i class="fa fa-map-marker-alt mr-1"></i> {{ $post->location }}
                                        </span>
                                    @endif
                                </div>
                                <div class="d-flex align-items-center text-muted small">
                                    <div class="mr-3 d-flex align-items-center">
                                        <i class="fa fa-eye mr-1"></i> {{ number_format($post->views_count ?? 0) }}
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="fa fa-heart mr-1" style="color: #e74c3c;"></i> {{ number_format($post->likes_count ?? 0) }}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center text-muted small">
                                    <i class="fa fa-clock mr-2"></i>
                                    <span>{{ $post->created_at->format('d M Y') }}</span>
                                    @if($post->user)
                                        <span class="mx-2">•</span>
                                        <span>{{ $post->user->name ?? 'Admin' }}</span>
                                    @endif
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
                            <i class="fa fa-trophy fa-5x text-muted" style="opacity: 0.3;"></i>
                        </div>
                        <h4 class="text-muted mb-3">Belum Ada Prestasi</h4>
                        <p class="text-muted mb-4">Prestasi membanggakan akan segera hadir. Pantau terus halaman ini untuk update terbaru!</p>
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
                        <div class="card-header text-white" style="background: linear-gradient(135deg, #f8c6f0 0%, #c8d4fc  100%); border: none;">
                            <h5 class="mb-0 d-flex align-items-center">
                                <i class="fa fa-info-circle mr-2"></i> Tentang Prestasi
                            </h5>
                        </div>
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <img src="{{ asset('images/logosmk.png') }}" alt="Logo SMK" style="width: 60px; height: 60px; object-fit: contain;">
                            </div>
                            <h5 class="mb-2" style="color: #2c3e50; font-family: 'Baloo 2', cursive; font-weight: 700;">E-MAGAZINE BAKNUS</h5>
                            <p class="text-muted mb-0" style="font-size: 0.9rem; line-height: 1.5;">Media dokumentasi prestasi dan pencapaian membanggakan siswa SMK Bakti Nusantara 666.</p>
                        </div>
                    </div>
                    
                    <!-- Quick Stats -->
                    <div class="card mb-4 shadow-sm" style="border: none; border-radius: 15px; overflow: hidden;">
                        <div class="card-header text-white" style="background: linear-gradient(135deg, #f8c6f0 0%, #c8d4fc  100%); border: none;">
                            <h5 class="mb-0 d-flex align-items-center">
                                <i class="fa fa-chart-bar mr-2"></i> Statistik Konten
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row text-center">
                                <div class="col-6 mb-3">
                                    <div class="p-3 rounded" style="background: rgba(40, 167, 69, 0.1);">
                                        <h4 class="text-success mb-1">{{ \App\Models\Post::where('category', 'prestasi')->where('status', 'approved')->count() }}</h4>
                                        <small class="text-muted">Prestasi</small>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="p-3 rounded" style="background: rgba(220, 53, 69, 0.1);">
                                        <h4 class="text-danger mb-1">{{ \App\Models\Post::where('category', 'pengumuman')->where('status', 'approved')->count() }}</h4>
                                        <small class="text-muted">Pengumuman</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 rounded" style="background: rgba(23, 162, 184, 0.1);">
                                        <h4 class="text-info mb-1">{{ \App\Models\Post::where('category', 'kegiatan')->where('status', 'approved')->count() }}</h4>
                                        <small class="text-muted">Kegiatan</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 rounded" style="background: rgba(255, 193, 7, 0.1);">
                                        <h4 class="text-warning mb-1">{{ \App\Models\Post::where('category', 'lomba')->where('status', 'approved')->count() }}</h4>
                                        <small class="text-muted">Lomba</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Navigation Links -->
                    <div class="card shadow-sm" style="border: none; border-radius: 15px; overflow: hidden;">
                        <div class="card-header text-white" style="background: linear-gradient(135deg, #f8c6f0 0%, #c8d4fc  100%); border: none;">
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
                                <a href="{{ route('kegiatan') }}" class="list-group-item list-group-item-action border-0 py-3" style="transition: all 0.3s ease;">
                                    <i class="fa fa-calendar-alt mr-3 text-info"></i> Kegiatan
                                </a>
                                <a href="{{ route('lomba') }}" class="list-group-item list-group-item-action border-0 py-3" style="transition: all 0.3s ease;">
                                    <i class="fa fa-medal mr-3 text-warning"></i> Lomba
                                </a>
                                <a href="{{ route('blog') }}" class="list-group-item list-group-item-action border-0 py-3" style="transition: all 0.3s ease;">
                                    <i class="fa fa-newspaper mr-3 text-secondary"></i> Blog & Berita
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($prestasi->hasPages())
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <div class="card shadow-sm mt-4" style="border: none; border-radius: 15px; background: white;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="text-muted d-flex align-items-center">
                                <i class="fa fa-list mr-2"></i>
                                <span>Menampilkan {{ $prestasi->firstItem() }} - {{ $prestasi->lastItem() }} dari {{ $prestasi->total() }} prestasi</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <nav aria-label="Prestasi pagination">
                                <ul class="pagination pagination-lg mb-0" style="border-radius: 10px; overflow: hidden;">
                                    @if ($prestasi->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link" style="border: none; background: #f8f9fa; color: #6c757d;">
                                                <i class="fa fa-chevron-left"></i> Previous
                                            </span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $prestasi->previousPageUrl() }}" rel="prev" style="border: none; background: #f8c6f0 ; color: white; transition: all 0.3s ease;">
                                                <i class="fa fa-chevron-left"></i> Previous
                                            </a>
                                        </li>
                                    @endif

                                    @foreach ($prestasi->getUrlRange(1, $prestasi->lastPage()) as $page => $url)
                                        @if ($page == $prestasi->currentPage())
                                            <li class="page-item active">
                                                <span class="page-link" style="border: none; background: #20c997; color: white;">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $url }}" style="border: none; background: white; color: #28a745; transition: all 0.3s ease;">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endforeach

                                    @if ($prestasi->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $prestasi->nextPageUrl() }}" rel="next" style="border: none; background: #28a745; color: white; transition: all 0.3s ease;">
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
/* Prestasi Page Styles */
.prestasi-page {
    min-height: 100vh;
}

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

.hover-card .card-title a:hover {
    color: #28a745 !important;
}

.hover-card .btn:hover {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%) !important;
    border-color: transparent !important;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(23, 162, 184, 0.4);
}

/* Sidebar hover effects */
.list-group-item:hover {
    background: linear-gradient(135deg, rgba(40, 167, 69, 0.1) 0%, rgba(32, 201, 151, 0.1) 100%) !important;
    transform: translateX(5px);
    border-left: 3px solid #28a745 !important;
}

/* Pagination hover effects */
.pagination .page-link:hover {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
    color: white !important;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
}

/* Badge animations */
.badge {
    transition: all 0.3s ease;
}

.badge:hover {
    transform: scale(1.05);
}

/* Stats cards hover */
.card-body .row > div:hover .p-3 {
    transform: translateY(-3px);
    transition: all 0.3s ease;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .prestasi-page .container {
        padding-left: 15px;
        padding-right: 15px;
    }
    
    .hover-card {
        margin-bottom: 20px;
    }
    
    .card-body {
        padding: 20px !important;
    }
    
    .sticky-top {
        position: relative !important;
        top: auto !important;
        margin-top: 30px;
    }
    
    .pagination {
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .pagination .page-item {
        margin: 2px;
    }
}

@media (max-width: 576px) {
    .card-img-top {
        height: 200px !important;
    }
    
    .card-title {
        font-size: 1.1rem;
    }
    
    .btn-sm {
        font-size: 0.8rem;
        padding: 6px 12px;
    }
}

/* Loading animation for images */
.card-img-top {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: loading 1.5s infinite;
}

@keyframes loading {
    0% {
        background-position: 200% 0;
    }
    100% {
        background-position: -200% 0;
    }
}

.card-img-top[src] {
    background: none;
    animation: none;
}

/* Smooth scroll behavior */
html {
    scroll-behavior: smooth;
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #20c997 0%, #28a745 100%);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Lazy loading untuk gambar
    const images = document.querySelectorAll('.card-img-top');
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.classList.add('loaded');
                observer.unobserve(img);
            }
        });
    });

    images.forEach(img => imageObserver.observe(img));

    // Smooth scroll untuk pagination
    const paginationLinks = document.querySelectorAll('.pagination .page-link');
    paginationLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            if (this.getAttribute('href') && this.getAttribute('href') !== '#') {
                setTimeout(() => {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }, 100);
            }
        });
    });

    // Animasi counter untuk statistik
    const counters = document.querySelectorAll('.card-body h4');
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                const target = parseInt(counter.textContent);
                let current = 0;
                const increment = target / 50;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        counter.textContent = target;
                        clearInterval(timer);
                    } else {
                        counter.textContent = Math.floor(current);
                    }
                }, 30);
                counterObserver.unobserve(counter);
            }
        });
    });

    counters.forEach(counter => counterObserver.observe(counter));
});
</script>