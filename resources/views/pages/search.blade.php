@extends('layouts.app')

@section('content')
<!-- Search Header -->
<section class="py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); margin-top: 70px;">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center text-white">
                <h1 class="display-4 mb-3">Hasil Pencarian</h1>
                <p class="lead">Pencarian untuk: "{{ $query }}"</p>
            </div>
        </div>
    </div>
</section>

<!-- Search Results Section -->
<section class="search-page py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12">
                @if($posts->count() > 0)
                    <h2 class="mb-4">Ditemukan {{ $posts->total() }} artikel</h2>
                    
                    @foreach($posts as $post)
                    <div class="card mb-4 shadow-sm">
                        @if($post->image_path && $post->image_path != '')
                            <img src="{{ asset('storage/' . $post->image_path) }}" class="card-img-top" alt="{{ $post->title }}" style="height: 250px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="{{ route('single', $post->id) }}" class="text-decoration-none text-dark">{{ $post->title }}</a>
                            </h5>
                            <p class="card-text text-muted">{{ Str::limit(strip_tags($post->content), 200) }}</p>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <span class="badge badge-primary">{{ $post->category }}</span>
                                    @if($post->location)
                                        <span class="badge badge-secondary ml-1">{{ $post->location }}</span>
                                    @endif
                                </div>
                                <div class="text-muted small">
                                    <i class="fa fa-eye"></i> {{ $post->views_count ?? 0 }}
                                    <i class="fa fa-comment ml-2"></i> {{ $post->comments_count ?? 0 }}
                                    <i class="fa fa-heart ml-2"></i> {{ $post->likes_count ?? 0 }}
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="fa fa-calendar"></i> {{ $post->created_at->format('d M Y') }}
                                </small>
                                <a href="{{ route('single', $post->id) }}" class="btn btn-primary btn-sm">Baca Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="alert alert-info text-center">
                        <h4>Tidak Ada Hasil</h4>
                        <p>Tidak ditemukan artikel untuk pencarian "{{ $query }}". Coba kata kunci lain.</p>
                        <a href="{{ route('home') }}" class="btn btn-primary">Kembali ke Beranda</a>
                    </div>
                @endif
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="sticky-top" style="top: 100px;">
                    <!-- Search Widget -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Pencarian Lain</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('search') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" name="q" class="form-control" placeholder="Cari artikel..." value="{{ $query }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Quick Stats -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">Statistik</h5>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-3">
                                    <h4 class="text-danger">{{ \App\Models\Post::where('category', 'pengumuman')->where('status', 'approved')->count() }}</h4>
                                    <small class="text-muted">Pengumuman</small>
                                </div>
                                <div class="col-3">
                                    <h4 class="text-success">{{ \App\Models\Post::where('category', 'prestasi')->where('status', 'approved')->count() }}</h4>
                                    <small class="text-muted">Prestasi</small>
                                </div>
                                <div class="col-3">
                                    <h4 class="text-warning">{{ \App\Models\Post::where('category', 'lomba')->where('status', 'approved')->count() }}</h4>
                                    <small class="text-muted">Lomba</small>
                                </div>
                                <div class="col-3">
                                    <h4 class="text-info">{{ \App\Models\Post::where('category', 'kegiatan')->where('status', 'approved')->count() }}</h4>
                                    <small class="text-muted">Kegiatan</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Navigation Links -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">Kategori</h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <a href="{{ route('pengumuman') }}" class="list-group-item list-group-item-action">
                                    <i class="fa fa-bullhorn"></i> Pengumuman
                                </a>
                                <a href="{{ route('prestasi') }}" class="list-group-item list-group-item-action">
                                    <i class="fa fa-trophy"></i> Prestasi
                                </a>
                                <a href="{{ route('lomba') }}" class="list-group-item list-group-item-action">
                                    <i class="fa fa-medal"></i> Lomba
                                </a>
                                <a href="{{ route('kegiatan') }}" class="list-group-item list-group-item-action">
                                    <i class="fa fa-calendar"></i> Kegiatan
                                </a>
                                <a href="{{ route('blog') }}" class="list-group-item list-group-item-action">
                                    <i class="fa fa-newspaper"></i> Berita
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($posts->hasPages())
        <div class="row">
            <div class="col-12 d-flex justify-content-center mt-4">
                {{ $posts->appends(['q' => $query])->links() }}
            </div>
        </div>
        @endif
    </div>
</section>
@endsection