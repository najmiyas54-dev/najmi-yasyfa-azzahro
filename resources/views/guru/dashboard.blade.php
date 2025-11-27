<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard Guru - Madingaja</title>

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
        .stat-card { transition: transform 0.2s; }
        .stat-card:hover { transform: translateY(-2px); }
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
                        <i class="fas fa-chalkboard-teacher fa-2x text-white mb-2"></i>
                        <h5 class="text-white mb-0">Madingaja</h5>
                        <small class="text-white-50">Guru Panel</small>
                    </div>
                    
                    <nav class="nav flex-column">
                        <a class="nav-link active" href="{{ route('guru.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                        <a class="nav-link" href="{{ route('guru.posts.index') }}">
                            <i class="fas fa-edit me-2"></i> Artikel Saya
                        </a>
                        <a class="nav-link" href="{{ route('guru.all-posts') }}">
                            <i class="fas fa-newspaper me-2"></i> Semua Artikel
                        </a>
                        <a class="nav-link" href="{{ route('guru.student-posts') }}">
                            <i class="fas fa-user-graduate me-2"></i> Artikel Siswa
                            @if(isset($pendingStudentPosts) && $pendingStudentPosts->count() > 0)
                                <span class="badge bg-danger ms-auto">{{ $pendingStudentPosts->count() }}</span>
                            @endif
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
                <!-- Header -->
                <nav class="navbar navbar-expand-lg navbar-light bg-white mb-4">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('home') }}" class="btn btn-outline-primary btn-sm me-3" target="_blank">
                                <i class="fas fa-external-link-alt me-1"></i>Lihat Website
                            </a>
                            <h4 class="mb-0 fw-bold text-dark">Dashboard Guru</h4>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="me-3 text-muted">Selamat datang, {{ Auth::user()->name }}</span>
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

                    <!-- Stats Cards -->
                    <div class="row g-4 mb-4">
                        <div class="col-xl-3 col-md-6">
                            <div class="card stat-card bg-primary text-white">
                                <div class="card-body d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h6 class="card-title text-white-50 mb-1">Artikel Saya</h6>
                                        <h3 class="mb-0 fw-bold">{{ $stats['my_posts'] }}</h3>
                                    </div>
                                    <div class="ms-3">
                                        <i class="fas fa-edit fa-2x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6">
                            <div class="card stat-card bg-warning text-white">
                                <div class="card-body d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h6 class="card-title text-white-50 mb-1">Artikel Siswa Pending</h6>
                                        <h3 class="mb-0 fw-bold">{{ $stats['pending_student_posts'] }}</h3>
                                    </div>
                                    <div class="ms-3">
                                        <i class="fas fa-user-graduate fa-2x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6">
                            <div class="card stat-card bg-success text-white">
                                <div class="card-body d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h6 class="card-title text-white-50 mb-1">Artikel Disetujui</h6>
                                        <h3 class="mb-0 fw-bold">{{ $stats['approved_posts'] }}</h3>
                                    </div>
                                    <div class="ms-3">
                                        <i class="fas fa-check fa-2x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6">
                            <div class="card stat-card bg-info text-white">
                                <div class="card-body d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h6 class="card-title text-white-50 mb-1">Total User</h6>
                                        <h3 class="mb-0 fw-bold">{{ $stats['total_users'] ?? 0 }}</h3>
                                    </div>
                                    <div class="ms-3">
                                        <i class="fas fa-users fa-2x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content Row -->
                    <div class="row g-4">
                        <!-- Quick Actions -->
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header bg-white">
                                    <h5 class="card-title mb-0"><i class="fas fa-bolt text-primary me-2"></i>Quick Actions</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <a href="{{ route('guru.create.article') }}" class="btn btn-primary w-100 py-3">
                                                <i class="fas fa-plus me-2"></i>Tulis Artikel
                                            </a>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="{{ route('guru.posts.index') }}" class="btn btn-info w-100 py-3">
                                                <i class="fas fa-list me-2"></i>Kelola Artikel
                                            </a>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="{{ route('guru.student-posts') }}" class="btn btn-warning w-100 py-3">
                                                <i class="fas fa-user-graduate me-2"></i>Setujui Artikel Siswa
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            @if($pendingStudentPosts->count() > 0)
                            <div class="card mt-4">
                                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                    <a href="{{ route('guru.student-posts') }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-bell me-2"></i>Artikel Siswa Menunggu Persetujuan
                                    </a>
                                    <span class="badge bg-warning">{{ $pendingStudentPosts->count() }}</span>
                                </div>
                                <div class="card-body">
                                    @foreach($pendingStudentPosts->take(3) as $post)
                                    <div class="d-flex align-items-center p-3 mb-2 bg-light rounded">
                                        <div class="bg-warning rounded-circle p-2 me-3">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ strlen($post->title) > 50 ? substr($post->title, 0, 50) . '...' : $post->title }}</h6>
                                            <small class="text-muted">{{ $post->user->name ?? 'Unknown' }} • {{ $post->created_at->diffForHumans() }}</small>
                                        </div>
                                        <div>
                                            <a href="{{ route('guru.student-posts') }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                    @endforeach
                                    
                                    @if($pendingStudentPosts->count() > 3)
                                    <div class="text-center mt-3">
                                        <a href="{{ route('guru.student-posts') }}" class="btn btn-outline-warning btn-sm">
                                            Lihat {{ $pendingStudentPosts->count() - 3 }} artikel lainnya
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Recent Activity -->
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header bg-white">
                                    <h5 class="card-title mb-0"><i class="fas fa-newspaper text-success me-2"></i>Artikel Terbaru Saya</h5>
                                </div>
                                <div class="card-body">
                                    @if($myPosts->count() > 0)
                                        @foreach($myPosts->take(5) as $post)
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div>
                                                <h6 class="mb-1">{{ strlen($post->title) > 30 ? substr($post->title, 0, 30) . '...' : $post->title }}</h6>
                                                <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                                            </div>
                                            <span class="badge bg-{{ $post->status == 'approved' ? 'success' : 'warning' }}">
                                                {{ ucfirst($post->status) }}
                                            </span>
                                        </div>
                                        @endforeach
                                    @else
                                        <p class="text-muted">Belum ada artikel</p>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="card mt-4">
                                <div class="card-header bg-white">
                                    <h5 class="card-title mb-0"><i class="fas fa-info-circle text-info me-2"></i>Info Sistem</h5>
                                </div>
                                <div class="card-body">
                                    <p class="mb-2"><i class="fas fa-server text-muted me-2"></i>Laravel {{ app()->version() }}</p>
                                    <p class="mb-2"><i class="fas fa-calendar text-muted me-2"></i>{{ date('d F Y') }}</p>
                                    <p class="mb-0"><i class="fas fa-clock text-muted me-2"></i>{{ date('H:i') }} WIB</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

                <!-- Footer -->
                <footer class="mt-5 py-4 bg-light text-center">
                    <div class="container-fluid">
                        <span class="text-muted">&copy; 2024 Madingaja Guru Panel. All rights reserved.</span>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>