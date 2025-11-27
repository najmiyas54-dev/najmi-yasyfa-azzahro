<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard Siswa - Madingaja</title>

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
                        <i class="fas fa-graduation-cap fa-2x text-white mb-2"></i>
                        <h5 class="text-white mb-0">Madingaja</h5>
                        <small class="text-white-50">Siswa Panel</small>
                    </div>
                    
                    <nav class="nav flex-column">
                        <a class="nav-link active" href="{{ route('student.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                        <a class="nav-link" href="{{ route('student.create-post') }}">
                            <i class="fas fa-plus me-2"></i> Tulis Artikel
                        </a>
                        <a class="nav-link" href="{{ route('student.drafts') }}">
                            <i class="fas fa-file-alt me-2"></i> Draft Artikel
                        </a>
                        <a class="nav-link" href="{{ route('student.users.index') }}">
                            <i class="fas fa-users me-2"></i> Kelola User
                        </a>
                    </nav>
                </div>
                
                <div class="mt-auto p-3">
                    <form action="{{ route('student.logout') }}" method="POST">
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
                            <h4 class="mb-0 fw-bold text-dark">Dashboard Siswa</h4>
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
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

                    <!-- Stats Cards -->
                    <div class="row g-4 mb-4">
                        <div class="col-xl-3 col-md-6">
                            <div class="card stat-card bg-primary text-white">
                                <div class="card-body d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h6 class="card-title text-white-50 mb-1">Total Artikel</h6>
                                        <h3 class="mb-0 fw-bold">{{ $allMyPosts->count() }}</h3>
                                    </div>
                                    <div class="ms-3">
                                        <i class="fas fa-newspaper fa-2x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6">
                            <div class="card stat-card bg-success text-white">
                                <div class="card-body d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h6 class="card-title text-white-50 mb-1">Artikel Disetujui</h6>
                                        <h3 class="mb-0 fw-bold">{{ $allMyPosts->where('status', 'approved')->count() }}</h3>
                                    </div>
                                    <div class="ms-3">
                                        <i class="fas fa-check-circle fa-2x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6">
                            <div class="card stat-card bg-warning text-white">
                                <div class="card-body d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h6 class="card-title text-white-50 mb-1">Menunggu Review</h6>
                                        <h3 class="mb-0 fw-bold">{{ $allMyPosts->where('status', 'pending')->count() }}</h3>
                                    </div>
                                    <div class="ms-3">
                                        <i class="fas fa-clock fa-2x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6">
                            <div class="card stat-card bg-info text-white">
                                <div class="card-body d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h6 class="card-title text-white-50 mb-1">Artikel Dipublish</h6>
                                        <h3 class="mb-0 fw-bold">{{ $allMyPosts->where('is_published', true)->count() }}</h3>
                                    </div>
                                    <div class="ms-3">
                                        <i class="fas fa-globe fa-2x opacity-75"></i>
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
                                            <a href="{{ route('student.posts.index') }}" class="btn btn-primary w-100 py-3">
                                                <i class="fas fa-newspaper me-2"></i>Artikel Saya
                                            </a>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="{{ route('student.users.index') }}" class="btn btn-success w-100 py-3">
                                                <i class="fas fa-users me-2"></i>Kelola User
                                            </a>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="{{ route('public') }}" class="btn btn-info w-100 py-3" target="_blank">
                                                <i class="fas fa-globe me-2"></i>Lihat Website
                                            </a>
                                        </div>
                                        <div class="col-md-6">
                                            <button class="btn btn-outline-primary w-100 py-3" onclick="window.location.reload()">
                                                <i class="fas fa-sync me-2"></i>Refresh Dashboard
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            
                            @if(isset($notifications) && $notifications->count() > 0)
                            <div class="card mt-4">
                                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0"><i class="fas fa-bell text-warning me-2"></i>Notifikasi</h5>
                                    <span class="badge bg-warning">{{ $notifications->count() }}</span>
                                </div>
                                <div class="card-body">
                                    @foreach($notifications->take(3) as $notification)
                                    <div class="d-flex align-items-center p-3 mb-2 bg-light rounded">
                                        <div class="bg-{{ $notification->type == 'approved' ? 'success' : 'danger' }} rounded-circle p-2 me-3">
                                            <i class="fas fa-bell text-white"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ $notification->title }}</h6>
                                            <small class="text-muted">{{ $notification->message }}</small>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            
                            @if(isset($drafts) && $drafts->count() > 0)
                            <div class="card mt-4">
                                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0"><i class="fas fa-file-alt text-secondary me-2"></i>Draft Artikel</h5>
                                    <span class="badge bg-secondary">{{ $drafts->count() }}</span>
                                </div>
                                <div class="card-body">
                                    @foreach($drafts->take(3) as $draft)
                                    <div class="d-flex justify-content-between align-items-center p-3 mb-2 bg-light rounded">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ Str::limit($draft->title, 40) }}</h6>
                                            <small class="text-muted">{{ $draft->created_at->diffForHumans() }}</small>
                                        </div>
                                        <div>
                                            <a href="{{ route('student.edit-post', $draft->id) }}" class="btn btn-sm btn-outline-primary me-1" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('student.submit-draft', $draft->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success" title="Kirim untuk Review" onclick="return confirm('Kirim draft ini untuk review?')">
                                                    <i class="fas fa-paper-plane"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Recent Activity -->
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header bg-white">
                                    <h5 class="card-title mb-0"><i class="fas fa-user-edit text-success me-2"></i>Artikel Saya Terbaru</h5>
                                </div>
                                <div class="card-body">
                                    @forelse($myPosts->take(5) as $post)
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <h6 class="mb-1">{{ Str::limit($post->title, 30) }}</h6>
                                            <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                                        </div>
                                        <div>
                                            <span class="badge bg-{{ $post->status == 'approved' ? 'success' : ($post->status == 'pending' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($post->status) }}
                                            </span>
                                            @if($post->status == 'approved' && !$post->is_published)
                                                <form action="{{ route('student.publish-post', $post->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-success btn-sm ms-1" title="Publish" onclick="return confirm('Publish artikel ini?')">
                                                        <i class="fas fa-upload"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            @if($post->status == 'rejected')
                                                <form action="{{ route('student.delete-post', $post->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm ms-1" title="Hapus" onclick="return confirm('Hapus artikel ini?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                    @empty
                                    <p class="text-muted">Belum ada artikel</p>
                                    @endforelse
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
                        <span class="text-muted">&copy; 2024 Madingaja Siswa Panel. All rights reserved.</span>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>