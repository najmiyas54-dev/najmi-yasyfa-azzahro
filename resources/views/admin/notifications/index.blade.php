<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Notifikasi Verifikasi - Madingaja</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
        .sidebar { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        .sidebar .nav-link { color: rgba(255,255,255,0.8); border-radius: 8px; margin: 2px 8px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: rgba(255,255,255,0.1); color: white; }
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .navbar { background: white !important; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .notification-item { border-left: 4px solid #ffc107; background: #fff9e6; }
        .notification-item:hover { background: #fff3cd; }
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
                        <a class="nav-link active" href="{{ route('admin.notifications.index') }}">
                            <i class="fas fa-bell me-2"></i> Notifikasi
                            @if($notifications->total() > 0)
                                <span class="badge bg-danger ms-auto">{{ $notifications->total() }}</span>
                            @endif
                        </a>
                        <a class="nav-link" href="{{ route('admin.categories.index') }}">
                            <i class="fas fa-tags me-2"></i> Kategori
                        </a>
                        <a class="nav-link" href="{{ route('admin.achievements.index') }}">
                            <i class="fas fa-trophy me-2"></i> Prestasi
                        </a>
                        <a class="nav-link" href="{{ route('admin.competitions.index') }}">
                            <i class="fas fa-medal me-2"></i> Kompetisi
                        </a>
                        <a class="nav-link" href="{{ route('admin.users') }}">
                            <i class="fas fa-users me-2"></i> Kelola Users
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
                        <h4 class="mb-0 fw-bold text-dark">
                            <i class="fas fa-bell text-warning me-2"></i>Notifikasi Verifikasi Artikel
                        </h4>
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

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h5 class="mb-0">Artikel Menunggu Verifikasi</h5>
                            <small class="text-muted">{{ $notifications->total() }} artikel perlu diverifikasi</small>
                        </div>
                        @if($notifications->total() > 0)
                        <form action="{{ route('admin.notifications.mark-all-read') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-check-double me-1"></i>Tandai Semua Dibaca
                            </button>
                        </form>
                        @endif
                    </div>

                    @if($notifications->count() > 0)
                        <div class="row">
                            @foreach($notifications as $notification)
                            <div class="col-12 mb-3">
                                <div class="card notification-item">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-md-8">
                                                <div class="d-flex align-items-start">
                                                    <div class="bg-warning rounded-circle p-2 me-3">
                                                        <i class="fas fa-file-alt text-white"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-1 fw-bold">{{ $notification->title }}</h6>
                                                        <p class="text-muted mb-1">
                                                            <i class="fas fa-user me-1"></i>{{ $notification->user->name ?? 'Unknown' }}
                                                            <span class="mx-2">•</span>
                                                            <i class="fas fa-tag me-1"></i>{{ $notification->category }}
                                                        </p>
                                                        <small class="text-muted">
                                                            <i class="fas fa-clock me-1"></i>{{ $notification->created_at->diffForHumans() }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 text-end">
                                                <form action="{{ route('admin.notifications.approve', $notification->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm me-1" title="Setujui">
                                                        <i class="fas fa-check"></i> Setujui
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.notifications.reject', $notification->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Tolak" onclick="return confirm('Yakin tolak artikel ini?')">
                                                        <i class="fas fa-times"></i> Tolak
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        
                                        @if($notification->content)
                                        <div class="mt-3 pt-3 border-top">
                                            <p class="text-muted mb-0">
                                                {{ strlen($notification->content) > 150 ? substr($notification->content, 0, 150) . '...' : $notification->content }}
                                            </p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $notifications->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Tidak ada notifikasi</h5>
                            <p class="text-muted">Semua artikel sudah diverifikasi</p>
                        </div>
                    @endif
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>