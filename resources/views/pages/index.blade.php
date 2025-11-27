@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="hero-section" style="padding-top: 100px; min-height: 100vh; background-image: url('{{ asset('images/smk.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; position: relative;">
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5);"></div>
    <div class="container" style="position: relative; z-index: 1;">
        <div class="row align-items-center justify-content-center text-center">
            <div class="col-lg-8">
                <h1 class="display-4 text-white mb-4">Selamat Datang E-Mading SMK Bakti Nusantara 666</h1>
                <p class="lead text-white mb-4">Pengumuman, Prestasi, Lomba, Dan  Prestasi</p>
                <a href="{{ route('about') }}" class="btn btn-light btn-lg">Lihat Selengkapnya</a>
            </div>
        </div>
    </div>
</section>

<!-- Pengumuman Artikel Section -->
<section id="pengumuman" class="py-5" style="background-color: #c0e9fa;">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-4">
                <h2 class="display-6 mb-3">Pengumuman & Artikel Terbaru</h2>
                <p class="lead text-dark">Informasi dan artikel penting untuk seluruh warga SMK Bakti Nusantara 666</p>
            </div>
        </div>
        
        <div class="article-slider">
            <div class="slider-container">
                <div class="slider-wrapper">
                    @if(isset($sliderPosts) && $sliderPosts->count() > 0)
                        @foreach($sliderPosts as $index => $post)
                        <div class="slide {{ $index == 0 ? 'active' : '' }}">
                            <div class="card shadow-lg border-0 h-100">
                                <div class="row no-gutters h-100">
                                    <div class="col-md-5">
                                        @if($post->image_path && $post->image_path != '')
                                            <img src="{{ asset('storage/' . $post->image_path) }}" class="card-img h-100" alt="{{ $post->title }}" style="object-fit: cover;">
                                        @else
                                            <div class="card-img h-100 bg-secondary d-flex align-items-center justify-content-center">
                                                <i class="fa fa-newspaper fa-4x text-white"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-7">
                                        <div class="card-body d-flex flex-column h-100 p-4">
                                            <div class="mb-2">
                                                @if($post->category)
                                                    <span class="badge badge-primary">{{ $post->category }}</span>
                                                @endif
                                                <small class="text-muted ml-2">
                                                    <i class="fa fa-calendar"></i> {{ $post->created_at->format('d M Y') }}
                                                </small>
                                                <br>
                                                <small class="text-muted">
                                                    <i class="fa fa-user"></i> {{ $post->user->name ?? 'Admin' }}
                                                </small>
                                            </div>
                                            <h4 class="card-title text-primary mb-3">{{ Str::limit($post->title, 60) }}</h4>
                                            <p class="card-text flex-grow-1">{{ Str::limit(strip_tags($post->content), 150) }}</p>
                                            <div class="mt-auto">
                                                <a href="{{ route('single', $post->id) }}" class="btn btn-info btn-sm">Baca Selengkapnya</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                   
                </div>
                
                <button class="slider-btn prev-btn" onclick="changeArticleSlide(-1)">
                    <i class="fa fa-chevron-left"></i>
                </button>
                <button class="slider-btn next-btn" onclick="changeArticleSlide(1)">
                    <i class="fa fa-chevron-right"></i>
                </button>
            </div>
            
            @if(isset($sliderPosts) && $sliderPosts->count() > 0)
            <div class="slider-dots">
                @foreach($sliderPosts as $index => $post)
                    <span class="dot {{ $index == 0 ? 'active' : '' }}" onclick="currentArticleSlide({{ $index + 1 }})"></span>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</section>

<style>
.article-slider {
    position: relative;
    max-width: 1000px;
    margin: 0 auto;
}

.slider-container {
    position: relative;
    overflow: hidden;
    border-radius: 15px;
    min-height: 350px;
}

.slider-wrapper {
    display: flex;
    transition: transform 0.5s ease-in-out;
}

.slide {
    min-width: 100%;
    opacity: 0;
    transition: opacity 0.5s ease-in-out;
}

.slide.active {
    opacity: 1;
}

.slider-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(0,0,0,0.7);
    color: white;
    border: none;
    padding: 15px 20px;
    cursor: pointer;
    border-radius: 50%;
    font-size: 18px;
    transition: all 0.3s ease;
    z-index: 10;
}

.slider-btn:hover {
    background: rgba(0,0,0,0.9);
    transform: translateY(-50%) scale(1.1);
}

.prev-btn {
    left: -60px;
}

.next-btn {
    right: -60px;
}

.slider-dots {
    text-align: center;
    margin-top: 20px;
}

.dot {
    height: 15px;
    width: 15px;
    margin: 0 5px;
    background-color: #bbb;
    border-radius: 50%;
    display: inline-block;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.dot.active, .dot:hover {
    background-color: #717171;
}

/* Global cream chocolate button styling */
.btn-read-more {
    background: linear-gradient(135deg, #D2B48C 0%, #8B4513 100%) !important;
    border-color: #8B4513 !important;
    color: white !important;
    padding: 10px 20px;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
    box-shadow: 0 4px 15px rgba(210, 180, 140, 0.3);
    display: inline-block;
}

.btn-read-more:hover {
    background: linear-gradient(135deg, #8B4513 0%, #654321 100%) !important;
    color: white !important;
    text-decoration: none;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(139, 69, 19, 0.4);
}

@media (max-width: 768px) {
    .prev-btn {
        left: 10px;
    }
    
    .next-btn {
        right: 10px;
    }
    
    .slider-btn {
        padding: 10px 15px;
        font-size: 14px;
    }
    
    .card .row {
        flex-direction: column;
    }
    
    .card-img {
        height: 200px !important;
    }
}
</style>

<script>
let articleSlideIndex = 1;
let articleSlideCount = {{ isset($sliderPosts) ? $sliderPosts->count() : 1 }};

function changeArticleSlide(n) {
    showArticleSlide(articleSlideIndex += n);
}

function currentArticleSlide(n) {
    showArticleSlide(articleSlideIndex = n);
}

function showArticleSlide(n) {
    let slides = document.getElementsByClassName('slide');
    let dots = document.getElementsByClassName('dot');
    
    if (n > slides.length) { articleSlideIndex = 1 }
    if (n < 1) { articleSlideIndex = slides.length }
    
    for (let i = 0; i < slides.length; i++) {
        slides[i].classList.remove('active');
    }
    
    for (let i = 0; i < dots.length; i++) {
        dots[i].classList.remove('active');
    }
    
    if (slides[articleSlideIndex - 1]) {
        slides[articleSlideIndex - 1].classList.add('active');
    }
    
    if (dots[articleSlideIndex - 1]) {
        dots[articleSlideIndex - 1].classList.add('active');
    }
}

// Like functionality
function likePost(postId) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        alert('CSRF token tidak ditemukan. Silakan refresh halaman.');
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
            const button = document.querySelector(`[data-post-id="${postId}"]`);
            const heart = button.querySelector('.fa-heart');
            const count = button.querySelector('.likes-count');
            
            count.textContent = data.likes_count;
            
            if (data.liked) {
                heart.classList.remove('text-secondary');
                heart.classList.add('text-white');
                button.classList.remove('btn-outline-danger');
                button.classList.add('btn-danger');
            } else {
                heart.classList.remove('text-white');
                heart.classList.add('text-secondary');
                button.classList.remove('btn-danger');
                button.classList.add('btn-outline-danger');
            }
        } else {
            alert('Error: ' + (data.message || 'Terjadi kesalahan'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat memproses like');
    });
}
</script>

<!-- Latest News Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="display-5 mb-3">Berita Terbaru</h2>
                <p class="lead text-muted">Ikuti perkembangan terbaru dari SMK Bakti Nusantara 666</p>
            </div>
        </div>
        
        @if(isset($latestPosts) && $latestPosts->count() > 0)
        <div class="row">
            @foreach($latestPosts as $post)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    @if($post->image_path && $post->image_path != '')
                        <img src="{{ asset('storage/' . $post->image_path) }}" class="card-img-top" alt="{{ $post->title }}" style="height: 200px; object-fit: cover;">
                    @else
                        <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="fa fa-image fa-3x text-white"></i>
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ Str::limit($post->title, 50) }}</h5>
                        <p class="card-text text-muted flex-grow-1">{{ Str::limit(strip_tags($post->content), 100) }}</p>
                        <div class="mb-2">
                            <small class="text-muted">
                                <i class="fa fa-user"></i> {{ $post->user->name ?? 'Admin' }} | 
                                <i class="fa fa-calendar"></i> {{ $post->created_at->format('d M Y') }}
                            </small>
                        </div>
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-muted">
                                    <i class="fa fa-calendar"></i> {{ $post->created_at->format('d M Y') }}
                                    @if($post->category)
                                        <span class="badge badge-primary ml-2">{{ $post->category }}</span>
                                    @endif
                                </small>
                                <div class="d-flex align-items-center">
                                    <button onclick="likePost({{ $post->id }})" class="btn btn-sm {{ $post->isLikedBy() ? 'btn-danger' : 'btn-outline-danger' }} like-btn mr-2" data-post-id="{{ $post->id }}">
                                        <i class="fa fa-heart {{ $post->isLikedBy() ? 'text-white' : 'text-secondary' }}"></i>
                                        <span class="likes-count">{{ $post->likes_count ?? 0 }}</span>
                                    </button>
                                    <small class="text-muted">
                                        <i class="fa fa-eye"></i> {{ $post->views_count ?? 0 }}
                                    </small>
                                </div>
                            </div>
                            <div class="mt-2">
                                <a href="{{ route('single', $post->id) }}" class="btn btn-info btn-sm">Baca Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="row">
            <div class="col-12 text-center">
                <p class="text-muted">Belum ada berita tersedia.</p>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection