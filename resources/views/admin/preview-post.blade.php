<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Admin: {{ $post->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .preview-header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 2rem 0;
        }
        .article-content {
            line-height: 1.8;
            font-size: 1.1rem;
        }
        .review-actions {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }
        .btn-review {
            margin: 5px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .article-meta {
            background: #f8f9fa;
            border-left: 4px solid #28a745;
            padding: 1rem;
            margin: 1rem 0;
        }
        .review-history {
            background: #e9ecef;
            border-radius: 8px;
            padding: 1rem;
            margin: 1rem 0;
        }
    </style>
</head>
<body>
    <!-- Preview Header -->
    <div class="preview-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-info mb-3">
                        <i class="fas fa-shield-alt"></i> <strong>Review Admin</strong> - Artikel sudah disetujui guru dan menunggu persetujuan admin
                    </div>
                    <h1 class="display-4 mb-3">{{ $post->title }}</h1>
                    <div class="d-flex align-items-center">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name) }}&background=random" 
                             class="rounded-circle me-3" width="50" height="50" alt="Avatar">
                        <div>
                            <h6 class="mb-0">{{ $post->user->name }}</h6>
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
                            <strong>Penulis:</strong> {{ $post->user->name }}
                        </div>
                        <div class="col-md-3">
                            <strong>Kategori:</strong> 
                            <span class="badge bg-primary">{{ ucfirst($post->category) }}</span>
                        </div>
                        <div class="col-md-3">
                            <strong>Status:</strong> 
                            <span class="badge bg-success">Disetujui Guru</span>
                        </div>
                        <div class="col-md-3">
                            <strong>Review Admin:</strong> 
                            <span class="badge bg-warning">Pending</span>
                        </div>
                    </div>
                </div>

                <!-- Review History -->
                @if($post->guru_notes)
                <div class="review-history">
                    <h6><i class="fas fa-user-tie"></i> Catatan Guru:</h6>
                    <p class="mb-0">{{ $post->guru_notes }}</p>
                    <small class="text-muted">Direview pada: {{ $post->guru_reviewed_at->format('d F Y, H:i') }}</small>
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
                    <a href="{{ route('admin.posts.pending-review') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Review
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Review Actions (Fixed Position) -->
    <div class="review-actions">
        <button class="btn btn-success btn-lg btn-review" data-bs-toggle="modal" data-bs-target="#approveModal">
            <i class="fas fa-check"></i> Setujui & Publish
        </button>
        <button class="btn btn-danger btn-lg btn-review" data-bs-toggle="modal" data-bs-target="#rejectModal">
            <i class="fas fa-times"></i> Tolak
        </button>
    </div>

    <!-- Approve Modal -->
    <div class="modal fade" id="approveModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Setujui & Publish Artikel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.posts.approve', $post->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menyetujui dan mempublish artikel "<strong>{{ $post->title }}</strong>"?</p>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Artikel akan langsung tampil di website publik setelah disetujui.
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Catatan untuk Siswa (Opsional):</label>
                            <textarea name="notes" class="form-control" rows="3" 
                                      placeholder="Berikan catatan untuk siswa..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check"></i> Ya, Setujui & Publish
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Tolak Artikel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.posts.reject', $post->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menolak artikel "<strong>{{ $post->title }}</strong>"?</p>
                        <div class="mb-3">
                            <label class="form-label">Alasan Penolakan <span class="text-danger">*</span>:</label>
                            <textarea name="notes" class="form-control" rows="4" 
                                      placeholder="Berikan alasan yang jelas mengapa artikel ditolak..." 
                                      required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-times"></i> Ya, Tolak
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>