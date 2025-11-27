<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Tulis Artikel - Guru Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
        .sidebar { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        .sidebar .nav-link { color: rgba(255,255,255,0.8); border-radius: 8px; margin: 2px 8px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: rgba(255,255,255,0.1); color: white; }
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0 sidebar">
                <div class="p-3">
                    <div class="text-center mb-4">
                        <i class="fas fa-chalkboard-teacher fa-2x text-white mb-2"></i>
                        <h5 class="text-white mb-0">Madingaja</h5>
                        <small class="text-white-50">Guru Panel</small>
                    </div>
                    
                    <nav class="nav flex-column">
                        <a class="nav-link" href="{{ route('guru.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                        <a class="nav-link" href="{{ route('guru.posts.index') }}">
                            <i class="fas fa-edit me-2"></i> Artikel Saya
                        </a>
                        <a class="nav-link" href="{{ route('guru.student-posts') }}">
                            <i class="fas fa-user-graduate me-2"></i> Artikel Siswa
                        </a>
                        <a class="nav-link" href="{{ route('guru.comments') }}">
                            <i class="fas fa-comments me-2"></i> Komentar
                        </a>
                    </nav>
                </div>
                
                <div class="mt-auto p-3">
                    <form action="{{ route('guru.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm w-100">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </button>
                    </form>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10">
                <nav class="navbar navbar-expand-lg navbar-light bg-white mb-4">
                    <div class="container-fluid">
                        <h4 class="mb-0 fw-bold text-dark">Tulis Artikel Baru</h4>
                        <a href="{{ route('guru.posts.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Kembali
                        </a>
                    </div>
                </nav>

                <div class="container-fluid px-4">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('guru.posts.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Judul Artikel</label>
                                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="content" class="form-label">Konten</label>
                                            <textarea class="form-control" id="content" name="content" rows="15" required>{{ old('content') }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="category" class="form-label">Kategori</label>
                                            <select class="form-select" id="category" name="category" required>
                                                <option value="">Pilih Kategori</option>
                                                <option value="pengumuman" {{ old('category') == 'pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                                                <option value="prestasi" {{ old('category') == 'prestasi' ? 'selected' : '' }}>Prestasi</option>
                                                <option value="lomba" {{ old('category') == 'lomba' ? 'selected' : '' }}>Lomba</option>
                                                <option value="kegiatan" {{ old('category') == 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="image" class="form-label">Gambar</label>
                                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                            <small class="text-muted">Format: JPG, PNG, GIF. Max: 2MB</small>
                                        </div>

                                        <div class="mb-3">
                                            <label for="file" class="form-label">File Lampiran</label>
                                            <input type="file" class="form-control" id="file" name="file" accept=".pdf,.doc,.docx,.ppt,.pptx">
                                            <small class="text-muted">Format: PDF, DOC, PPT. Max: 5MB</small>
                                        </div>

                                        <div class="mb-3">
                                            <label for="posted_date" class="form-label">Tanggal Posting</label>
                                            <input type="date" class="form-control" id="posted_date" name="posted_date" value="{{ old('posted_date', date('Y-m-d')) }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="author_name" class="form-label">Nama Penulis</label>
                                            <input type="text" class="form-control" id="author_name" name="author_name" value="{{ old('author_name', Auth::user()->name) }}" required>
                                        </div>

                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save me-1"></i>Kirim untuk Review Admin
                                            </button>
                                            <a href="{{ route('guru.posts.index') }}" class="btn btn-outline-secondary">
                                                <i class="fas fa-times me-1"></i>Batal
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>