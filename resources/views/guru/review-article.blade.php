@extends('layouts.guru')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header Review -->
            <div class="card mb-4">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">
                        <i class="fas fa-clipboard-check"></i> Review Artikel Siswa
                    </h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> 
                        <strong>Mode Review:</strong> Halaman khusus untuk mereview artikel siswa. Artikel ini belum tampil di website publik.
                    </div>
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
                            <span class="badge badge-warning">Menunggu Review Guru</span>
                        </div>
                        <div class="col-md-3">
                            <strong>Tanggal:</strong> {{ $post->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Article Content -->
            <div class="card mb-4">
                <div class="card-body">
                    <!-- Title -->
                    <h1 class="mb-4 text-primary">{{ $post->title }}</h1>

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
                    <div class="article-content" style="line-height: 1.8; font-size: 1.1rem; text-align: justify;">
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
                </div>
            </div>

            <!-- Review Actions -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-gavel"></i> Keputusan Review
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Approve Form -->
                        <div class="col-md-6">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    <h6 class="mb-0">
                                        <i class="fas fa-check"></i> Setujui Artikel
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('guru.approve-post', $post->id) }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label>Catatan untuk Siswa (Opsional):</label>
                                            <textarea name="notes" class="form-control" rows="4" 
                                                      placeholder="Berikan catatan positif untuk siswa..."></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-success btn-block">
                                            <i class="fas fa-check"></i> Setujui & Kirim ke Admin
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Reject Form -->
                        <div class="col-md-6">
                            <div class="card border-danger">
                                <div class="card-header bg-danger text-white">
                                    <h6 class="mb-0">
                                        <i class="fas fa-times"></i> Tolak Artikel
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('guru.reject-post', $post->id) }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label>Alasan Penolakan <span class="text-danger">*</span>:</label>
                                            <textarea name="notes" class="form-control" rows="4" 
                                                      placeholder="Berikan alasan yang jelas mengapa artikel ditolak..." 
                                                      required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-danger btn-block">
                                            <i class="fas fa-times"></i> Tolak Artikel
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Back Button -->
                    <div class="mt-4 text-center">
                        <a href="{{ route('guru.review-posts') }}" class="btn btn-secondary btn-lg">
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Review
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection