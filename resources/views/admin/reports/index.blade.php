<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Laporan - Madingaja Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
        .sidebar { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        .sidebar .nav-link { color: rgba(255,255,255,0.8); border-radius: 8px; margin: 2px 8px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: rgba(255,255,255,0.1); color: white; }
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .small-box { border-radius: 12px; padding: 20px; color: white; }
        .small-box .inner h3 { font-size: 2rem; font-weight: bold; }
        .small-box .icon { font-size: 3rem; opacity: 0.3; }
        @media print {
            .sidebar, .btn, .no-print { display: none !important; }
            .col-md-9 { width: 100% !important; margin-left: 0 !important; }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 px-0 sidebar no-print">
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
                        <a class="nav-link active" href="{{ route('admin.reports') }}">
                            <i class="fas fa-chart-bar me-2"></i> Laporan
                        </a>
                    </nav>
                </div>
            </div>
            <div class="col-md-9 col-lg-10">
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar mr-2"></i>Laporan E-Mading
                    </h3>
                    <div>
                        <button onclick="window.print()" class="btn btn-info">
                            <i class="fas fa-print mr-1"></i>Print
                        </button>
                        <a href="{{ route('admin.reports.pdf') }}" class="btn btn-danger">
                            <i class="fas fa-file-pdf mr-1"></i>Download PDF
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Statistik Artikel -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h4 class="text-primary">Statistik Artikel</h4>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ $totalPosts }}</h3>
                                    <p>Total Artikel</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-newspaper"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $publishedPosts }}</h3>
                                    <p>Artikel Dipublish</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>{{ $pendingPosts }}</h3>
                                    <p>Menunggu Review</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3>{{ $rejectedPosts }}</h3>
                                    <p>Artikel Ditolak</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-times-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistik User -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h4 class="text-primary">Statistik Pengguna</h4>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h3>{{ $totalUsers }}</h3>
                                    <p>Total Pengguna</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ $siswaCount }}</h3>
                                    <p>Siswa</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $guruCount }}</h3>
                                    <p>Guru</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>{{ $adminCount }}</h3>
                                    <p>Admin</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-user-shield"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Artikel per Kategori -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Artikel per Kategori</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Kategori</th>
                                                <th>Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($postsByCategory as $category)
                                            <tr>
                                                <td>{{ ucfirst($category->category) }}</td>
                                                <td>{{ $category->count }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Artikel Terbaru</h5>
                                </div>
                                <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                                    @foreach($recentPosts as $post)
                                    <div class="d-flex justify-content-between align-items-center mb-2 p-2 border-bottom">
                                        <div>
                                            <strong>{{ Str::limit($post->title, 30) }}</strong><br>
                                            <small class="text-muted">{{ $post->user->name ?? 'Unknown' }} - {{ $post->created_at->format('d/m/Y') }}</small>
                                        </div>
                                        <span class="badge badge-{{ $post->status == 'approved' ? 'success' : ($post->status == 'pending' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($post->status) }}
                                        </span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .btn, .card-header .btn {
        display: none !important;
    }
    .main-sidebar, .main-header {
        display: none !important;
    }
    .content-wrapper {
        margin-left: 0 !important;
    }
}
</style>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>