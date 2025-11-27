<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview: {{ $post->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .preview-header {
            background: linear-gradient(135deg, #007bff 0%, #6610f2 100%);
            color: white;
            padding: 2rem 0;
        }
        .article-content {
            line-height: 1.8;
            font-size: 1.1rem;
        }
        .publish-actions {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }
        .btn-action {
            margin: 5px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .article-meta {
            background: #f8f9fa;
            border-left: 4px solid #007bff;
            padding: 1rem;
            margin: 1rem 0;
        }
        .status-badge {
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
        }
    </style>
</head>
<body>
    <!-- Preview Header -->
    <div class="preview-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-light mb-3">
                        <i class="fas fa-info-circle"></i> <strong>Preview Artikel Anda</strong> - 
                        @if($post->status == 'approved')
                            Artikel sudah disetujui dan siap dipublish
                        @elseif($post->review_status == 'pending_admin')
                            Artikel sedang menunggu review admin
                        @elseif($post->review_status == 'pending_guru')
                            Artikel sedang menunggu review guru
                        @else
                            Status: {{ $post->status }}
                        @endif
                    </div>
                    <h1 class="display-4 mb-3">{{ $post->title }}</h1>
                    <div class="d-flex align-items-center">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" 
                             class="rounded-circle me-3" width="50" height="50" alt="Avatar">
                        <div>
                            <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                            <small class="opacity-75">{{ $post->created_at->format('d F Y, H:i') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Article Content -->
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Article Meta -->
                <div class="article-meta">
                    <div class="row">
                        <div class="col-md-3">
                            <strong>Penulis:</strong> {{ Auth::user()->name }}
                        </div>
                        <div class="col-md-3">
                            <strong>Kategori:</strong> 
                            <span class="badge bg-primary">{{ ucfirst($post->category) }}</span>
                        </div>
                        <div class="col-md-3">
                            <strong>Status:</strong> 
                            @if($post->status == 'approved')
                                <span class="badge bg-success status-badge">Disetujui</span>
                            @elseif($post->status == 'rejected')
                                <span class="badge bg-danger status-badge">Ditolak</span>
                            @else
                                <span class="badge bg-warning status-badge">Pending Review</span>
                            @endif
                        </div>
                        <div class="col-md-3">
                            <strong>Publikasi:</strong> 
                            @if($post->is_published)
                                <span class="badge bg-success status-badge">Published</span>
                            @else
                                <span class="badge bg-secondary status-badge">Draft</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Review History -->
                @if($post->guru_notes)
                <div class="alert alert-info">
                    <h6><i class="fas fa-user-tie"></i> Catatan Guru:</h6>
                    <p class="mb-1">{{ $post->guru_notes }}</p>
                    <small class="text-muted">{{ $post->guru_reviewed_at->format('d F Y, H:i') }}</small>
                </div>
                @endif

                @if($post->admin_notes)
                <div class="alert alert-success">
                    <h6><i class="fas fa-shield-alt"></i> Catatan Admin:</h6>
                    <p class="mb-1">{{ $post->admin_notes }}</p>
                    <small class="text-muted">{{ $post->admin_reviewed_at->format('d F Y, H:i') }}</small>
                </div>
                @endif

                <!-- Article Image -->
                @if($post->image_path)
                <div class="text-center mb-4">
                    <img src="{{ asset('storage/' . $post->image_path) }}" 
                         class="img-fluid rounded shadow" 
                         alt="{{ $post->title }}"
                         style="max-height: 400px; width: auto;">
                </div>
                @endif

                <!-- Article Content -->
                <div class="article-content">
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
                    <a href="{{ route('student.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Publish Actions (Only if approved) -->
    @if($post->status == 'approved' && !$post->is_published)
    <div class="publish-actions">
        <button class="btn btn-success btn-lg btn-action" data-bs-toggle="modal" data-bs-target="#publishModal">
            <i class="fas fa-globe"></i> Publish ke Website
        </button>
    </div>

    <!-- Publish Modal -->
    <div class="modal fade" id="publishModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Publish Artikel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('student.publish-post', $post->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin mempublish artikel "<strong>{{ $post->title }}</strong>" ke website?</p>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Artikel akan tampil di halaman publik dan bisa dibaca oleh semua pengunjung website.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-globe"></i> Ya, Publish Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>