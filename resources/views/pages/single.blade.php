@extends('layouts.app')

@push('styles')
<link href="{{ asset('css/comments.css') }}" rel="stylesheet">
@endpush

@section('content')
<!-- Article Header -->
<section class="py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); margin-top: 70px;">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center text-white">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white">Home</a></li>
                        <li class="breadcrumb-item">
                            @if($post->type == 'competition')
                                <a href="{{ route('competitions') }}" class="text-white">Lomba</a>
                            @else
                                <a href="{{ route('blog') }}" class="text-white">Blog</a>
                            @endif
                        </li>
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ Str::limit($post->title, 50) }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Article Content -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <article class="card shadow-sm">
                    <!-- Featured Image -->
                    @if($post->image_path)
                        <img src="{{ asset('storage/' . $post->image_path) }}" class="card-img-top" alt="{{ $post->title }}" style="height: 400px; object-fit: cover;">
                    @endif
                    
                    <div class="card-body">
                        <!-- Article Meta -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                @if($post->category)
                                    <span class="badge badge-primary badge-lg px-3 py-2" style="font-size: 0.9rem;">{{ ucfirst($post->category) }}</span>
                                @endif
                                @if($post->location)
                                    <span class="badge badge-secondary badge-lg px-3 py-2 ml-2" style="font-size: 0.9rem;">{{ $post->location }}</span>
                                @endif
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center mr-3" style="padding: 6px 10px; background: #f8f9fa; border-radius: 6px;">
                                    <div class="text-primary mr-2" style="font-size: 0.9rem;">
                                        <i class="fa fa-eye"></i>
                                    </div>
                                    <div class="font-weight-bold" style="font-size: 0.85rem; color: #495057;">{{ number_format($post->views_count) }}</div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <button onclick="likePost({{ $post->id }})" class="like-button d-flex align-items-center" style="border: none; background: none; padding: 6px 10px; border-radius: 6px; cursor: pointer; {{ $post->isLikedBy() ? 'background: linear-gradient(135deg, #ff6b6b, #ee5a52) !important; color: white;' : 'background: #f8f9fa;' }}">
                                        <div class="mr-2" style="font-size: 0.9rem;">
                                            <i class="fa fa-heart {{ $post->isLikedBy() ? 'text-white' : 'text-secondary' }}"></i>
                                        </div>
                                        <div class="font-weight-bold {{ $post->isLikedBy() ? 'text-white' : 'text-secondary' }}" style="font-size: 0.85rem;"><span id="likes-count">{{ number_format($post->likes_count ?? 0) }}</span></div>
                                    </button>
                                </div>

                            </div>
                        </div>
                        
                        <!-- Article Title -->
                        <h1 class="card-title mb-3">{{ $post->title }}</h1>
                        
                        <!-- Article Meta Info -->
                        <div class="mb-4 p-3 bg-light rounded">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="text-muted mb-1">
                                        <i class="fa fa-user"></i> <strong>Penulis:</strong> {{ $post->user->name ?? 'Admin' }}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-muted mb-1">
                                        <i class="fa fa-calendar"></i> <strong>Dipublikasikan:</strong> {{ $post->created_at->format('d F Y') }}
                                    </p>
                                </div>
                            </div>

                        </div>
                        
                        <!-- Article Content -->
                        <div class="article-content">
                            {!! nl2br(e($post->content)) !!}
                        </div>
                        

                        

                    </div>
                </article>
                
                <!-- Navigation -->
                <div class="row mt-4">
                    <div class="col-6">
                        @if($post->type == 'competition')
                            <a href="{{ route('competitions') }}" class="btn btn-outline-secondary">
                                <i class="fa fa-arrow-left"></i> Kembali ke Lomba
                            </a>
                        @else
                            <a href="{{ route('blog') }}" class="btn btn-outline-secondary">
                                <i class="fa fa-arrow-left"></i> Kembali ke Blog
                            </a>
                        @endif
                    </div>
                    <div class="col-6 text-right">
                        <a href="{{ route('home') }}" class="btn btn-outline-primary">
                            <i class="fa fa-home"></i> Beranda
                        </a>
                    </div>
                </div>

                <!-- Related Posts -->
                @php
                    $relatedPosts = App\Models\Post::where('id', '!=', $post->id)
                                                   ->where('type', $post->type)
                                                   ->latest()
                                                   ->take(2)
                                                   ->get();
                @endphp
                
                @if($relatedPosts->count() > 0)
                <div class="mt-5">
                    <h3 class="mb-4">Artikel Terkait</h3>
                    <div class="row">
                        @foreach($relatedPosts as $related)
                        <div class="col-md-6 mb-3">
                            <div class="card h-100 shadow-sm">
                                @if($related->image_path)
                                    <img src="{{ asset('storage/' . $related->image_path) }}" class="card-img-top" alt="{{ $related->title }}" style="height: 200px; object-fit: cover;">
                                @endif
                                <div class="card-body">
                                    <h6 class="card-title">{{ Str::limit($related->title, 60) }}</h6>
                                    <p class="card-text text-muted small">{{ Str::limit(strip_tags($related->content), 80) }}</p>
                                    <a href="{{ route('single', $related->id) }}" class="btn btn-primary btn-sm">Baca Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif



            </div>
        </div>
    </div>
</section>
@endsection

<style>


@keyframes heartbeat {
    0% { transform: scale(1); }
    25% { transform: scale(1.2); }
    50% { transform: scale(1); }
    75% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

@keyframes likeAnimation {
    0% { transform: scale(1); }
    15% { transform: scale(1.3); }
    30% { transform: scale(0.9); }
    45% { transform: scale(1.2); }
    60% { transform: scale(1); }
    75% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

@keyframes countUp {
    0% { transform: translateY(0) scale(1); }
    50% { transform: translateY(-5px) scale(1.1); }
    100% { transform: translateY(0) scale(1); }
}

.heart-animate {
    animation: heartbeat 0.6s ease-in-out;
}

.like-animate {
    animation: likeAnimation 0.8s ease-in-out;
}

.count-animate {
    animation: countUp 0.5s ease-out;
}
</style>

<script>


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
            const likesCountElement = document.getElementById('likes-count');
            if (likesCountElement) {
                likesCountElement.textContent = data.likes_count;
            }
            
            const button = document.querySelector('.like-button');
            const heart = button.querySelector('.fa-heart');
            const count = button.querySelector('.font-weight-bold');
            
            if (data.liked) {
                button.style.background = 'linear-gradient(135deg, #ff6b6b, #ee5a52)';
                button.style.color = 'white';
                heart.className = 'fa fa-heart text-white';
                count.className = 'font-weight-bold text-white';

            } else {
                button.style.background = '#f8f9fa';
                button.style.color = '';
                heart.className = 'fa fa-heart text-secondary';
                count.className = 'font-weight-bold text-secondary';

            }
            

            

        } else {

            
            if (data.redirect) {
                if (confirm(data.message + '. Login sekarang?')) {
                    window.location.href = data.redirect;
                }
            } else {
                alert('Error: ' + (data.message || 'Unknown error'));
            }
        }
    })
    .catch(error => {
        alert('Terjadi kesalahan saat memproses like');
    });
}
</script>


