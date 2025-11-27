@extends('layouts.guru')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-eye"></i> Detail Artikel untuk Review
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <strong>Penulis:</strong> {{ $post->user->name }}
                        </div>
                        <div class="col-md-3">
                            <strong>Kategori:</strong> 
                            <span class="badge badge-primary">{{ ucfirst($post->category) }}</span>
                        </div>
                        <div class="col-md-3">
                            <strong>Status:</strong> 
                            <span class="badge badge-warning">Menunggu Review</span>
                        </div>
                        <div class="col-md-3">
                            <strong>Tanggal:</strong> {{ $post->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Article Content -->
            <div class="card">
                <div class="card-body">
                    <!-- Title -->
                    <h1 class="mb-4">{{ $post->title }}</h1>

                    <!-- Image -->
                    @if($post->image_path)
                    <div class="text-center mb-4">
                        <img src="{{ asset('storage/' . $post->image_path) }}" 
                             class="img-fluid rounded shadow" 
                             alt="{{ $post->title }}"
                             style="max-height: 400px;">
                    </div>
                    @endif

                    <!-- Content -->
                    <div class="article-content" style="line-height: 1.8; font-size: 1.1rem;">
                        {!! nl2br(e($post->content)) !!}
                    </div>

                    <!-- File Attachment -->
                    @if($post->file_path)
                    <div class="mt-4 p-3 bg-light rounded">
                        <h6><i class="fas fa-paperclip"></i> File Lampiran:</h6>
                        <a href="{{ asset('storage/' . $post->file_path) }}" 
                           class="btn btn-outline-primary btn-sm" 
                           target="_blank">
                            <i class="fas fa-download"></i> Download File
                        </a>
                    </div>
                    @endif

                    <!-- Back Button -->
                    <div class="mt-5">
                        <a href="{{ route('guru.review-posts') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Review
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection