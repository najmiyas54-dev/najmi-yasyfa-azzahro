<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kategori - Admin Madingaja</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
        .sidebar { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        .sidebar .nav-link { color: rgba(255,255,255,0.8); border-radius: 8px; margin: 2px 8px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: rgba(255,255,255,0.1); color: white; }
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .category-card { transition: transform 0.2s; cursor: pointer; }
        .category-card:hover { transform: translateY(-2px); }
        .navbar { background: white !important; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0 sidebar">
                <div class="p-3">
                    <div class="text-center mb-4">
                        <i class="fas fa-newspaper fa-2x text-white mb-2"></i>
                        <h5 class="text-white mb-0">Madingaja</h5>
                        <small class="text-white-50">Admin Panel</small>
                    </div>
                    
                    <nav class="nav flex-column">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                        <a class="nav-link" href="{{ route('admin.posts.index') }}">
                            <i class="fas fa-edit me-2"></i> Posts
                        </a>
                        <a class="nav-link" href="{{ route('admin.notifications.index') }}">
                            <i class="fas fa-bell me-2"></i> Notifikasi
                        </a>
                        <a class="nav-link active" href="{{ route('admin.categories.index') }}">
                            <i class="fas fa-tags me-2"></i> Kategori
                        </a>
                        <a class="nav-link" href="{{ route('admin.achievements.index') }}">
                            <i class="fas fa-trophy me-2"></i> Prestasi
                        </a>
                        <a class="nav-link" href="{{ route('admin.competitions.index') }}">
                            <i class="fas fa-medal me-2"></i> Kompetisi
                        </a>
                    </nav>
                </div>
                
                <div class="mt-auto p-3">
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm w-100">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </button>
                    </form>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10">
                <!-- Header -->
                <nav class="navbar navbar-expand-lg navbar-light bg-white mb-4">
                    <div class="container-fluid">
                        <h4 class="mb-0 fw-bold text-dark">Manajemen Kategori</h4>
                        <div class="d-flex align-items-center">
                            <span class="me-3 text-muted">{{ session('admin_name', 'Admin') }}</span>
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="fas fa-user text-white"></i>
                            </div>
                        </div>
                    </div>
                </nav>

                <!-- Content -->
                <div class="container-fluid px-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Categories Grid -->
                    <div class="row g-4">
                        <!-- Pengumuman -->
                        <div class="col-lg-6 col-xl-3">
                            <div class="card category-card bg-primary text-white" onclick="location.href='{{ route('admin.categories.show', 'pengumuman') }}'">
                                <div class="card-body text-center py-4">
                                    <i class="fas fa-bullhorn fa-3x mb-3 opacity-75"></i>
                                    <h5 class="card-title">Pengumuman</h5>
                                    <h2 class="fw-bold mb-2">{{ $pengumumanCount }}</h2>
                                    <p class="card-text opacity-75">Total artikel</p>
                                    <div class="mt-3">
                                        <a href="{{ route('admin.categories.create', 'pengumuman') }}" class="btn btn-light btn-sm me-2">
                                            <i class="fas fa-plus"></i> Tambah
                                        </a>
                                        <a href="{{ route('admin.categories.show', 'pengumuman') }}" class="btn btn-outline-light btn-sm">
                                            <i class="fas fa-eye"></i> Lihat
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Prestasi -->
                        <div class="col-lg-6 col-xl-3">
                            <div class="card category-card bg-success text-white" onclick="location.href='{{ route('admin.categories.show', 'prestasi') }}'">
                                <div class="card-body text-center py-4">
                                    <i class="fas fa-trophy fa-3x mb-3 opacity-75"></i>
                                    <h5 class="card-title">Prestasi</h5>
                                    <h2 class="fw-bold mb-2">{{ $prestasiCount }}</h2>
                                    <p class="card-text opacity-75">Total artikel</p>
                                    <div class="mt-3">
                                        <a href="{{ route('admin.categories.create', 'prestasi') }}" class="btn btn-light btn-sm me-2">
                                            <i class="fas fa-plus"></i> Tambah
                                        </a>
                                        <a href="{{ route('admin.categories.show', 'prestasi') }}" class="btn btn-outline-light btn-sm">
                                            <i class="fas fa-eye"></i> Lihat
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Berita -->
                        <div class="col-lg-6 col-xl-3">
                            <div class="card category-card bg-info text-white" onclick="location.href='{{ route('admin.categories.show', 'berita') }}'">
                                <div class="card-body text-center py-4">
                                    <i class="fas fa-newspaper fa-3x mb-3 opacity-75"></i>
                                    <h5 class="card-title">Berita</h5>
                                    <h2 class="fw-bold mb-2">{{ $beritaCount }}</h2>
                                    <p class="card-text opacity-75">Total artikel</p>
                                    <div class="mt-3">
                                        <a href="{{ route('admin.categories.create', 'berita') }}" class="btn btn-light btn-sm me-2">
                                            <i class="fas fa-plus"></i> Tambah
                                        </a>
                                        <a href="{{ route('admin.categories.show', 'berita') }}" class="btn btn-outline-light btn-sm">
                                            <i class="fas fa-eye"></i> Lihat
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Lomba -->
                        <div class="col-lg-6 col-xl-3">
                            <div class="card category-card bg-warning text-white" onclick="location.href='{{ route('admin.categories.show', 'lomba') }}'">
                                <div class="card-body text-center py-4">
                                    <i class="fas fa-medal fa-3x mb-3 opacity-75"></i>
                                    <h5 class="card-title">Lomba</h5>
                                    <h2 class="fw-bold mb-2">{{ $lombaCount }}</h2>
                                    <p class="card-text opacity-75">Total artikel</p>
                                    <div class="mt-3">
                                        <a href="{{ route('admin.categories.create', 'lomba') }}" class="btn btn-light btn-sm me-2">
                                            <i class="fas fa-plus"></i> Tambah
                                        </a>
                                        <a href="{{ route('admin.categories.show', 'lomba') }}" class="btn btn-outline-light btn-sm">
                                            <i class="fas fa-eye"></i> Lihat
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-white">
                                    <h5 class="card-title mb-0"><i class="fas fa-chart-bar text-primary me-2"></i>Ringkasan Kategori</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-md-3">
                                            <div class="border-end">
                                                <h4 class="text-primary">{{ $pengumumanCount + $prestasiCount + $beritaCount + $lombaCount }}</h4>
                                                <p class="text-muted mb-0">Total Artikel</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="border-end">
                                                <h4 class="text-success">4</h4>
                                                <p class="text-muted mb-0">Kategori Aktif</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="border-end">
                                                <h4 class="text-info">{{ max($pengumumanCount, $prestasiCount, $beritaCount, $lombaCount) }}</h4>
                                                <p class="text-muted mb-0">Terbanyak</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <h4 class="text-warning">{{ min($pengumumanCount, $prestasiCount, $beritaCount, $lombaCount) }}</h4>
                                            <p class="text-muted mb-0">Tersedikit</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <footer class="mt-5 py-4 bg-light text-center">
                    <div class="container-fluid">
                        <span class="text-muted">&copy; 2024 Madingaja Admin Panel. All rights reserved.</span>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>