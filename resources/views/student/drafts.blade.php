<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Draft Artikel - Madingaja</title>

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
                        <a class="nav-link" href="{{ route('student.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                        <a class="nav-link" href="{{ route('student.create-post') }}">
                            <i class="fas fa-plus me-2"></i> Tulis Artikel
                        </a>
                        <a class="nav-link active" href="{{ route('student.drafts') }}">
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
                            <h4 class="mb-0 fw-bold text-dark">Draft Artikel</h4>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="me-3 text-muted">{{ Auth::user()->name }}</span>
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

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="card">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-file-alt text-secondary me-2"></i>Draft Artikel Saya
                            </h5>
                            <span class="badge bg-secondary">{{ $drafts->total() }} draft</span>
                        </div>
                        <div class="card-body">
                            @forelse($drafts as $draft)
                            <div class="border rounded p-4 mb-4">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h5 class="mb-2">{{ $draft->title }}</h5>
                                        <p class="text-muted mb-2">
                                            <i class="fas fa-calendar me-1"></i>{{ $draft->created_at->format('d M Y H:i') }}
                                            @if($draft->category)
                                                <span class="badge bg-secondary ms-2">{{ ucfirst($draft->category) }}</span>
                                            @endif
                                        </p>
                                        <div class="mb-3">
                                            @if($draft->content)
                                                {{ strlen($draft->content) > 200 ? substr(strip_tags($draft->content), 0, 200) . '...' : strip_tags($draft->content) }}
                                            @else
                                                <em class="text-muted">Belum ada konten</em>
                                            @endif
                                        </div>
                                        
                                        @if($draft->image_path)
                                        <div class="mb-3">
                                            <img src="{{ asset('storage/' . $draft->image_path) }}" alt="Draft image" class="img-thumbnail" style="max-width: 150px;">
                                        </div>
                                        @endif
                                    </div>
                                    
                                    <div class="col-md-4 text-end">
                                        <div class="d-grid gap-2">
                                            <a href="{{ route('student.edit-post', $draft->id) }}" class="btn btn-primary">
                                                <i class="fas fa-edit me-1"></i>Edit Draft
                                            </a>
                                            
                                            @if($draft->content && $draft->category && $draft->posted_date && $draft->author_name)
                                                <form action="{{ route('student.submit-draft', $draft->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success w-100" onclick="return confirm('Kirim draft ini untuk review?')">
                                                        <i class="fas fa-paper-plane me-1"></i>Kirim untuk Review
                                                    </button>
                                                </form>
                                            @else
                                                <button class="btn btn-outline-success w-100" disabled title="Lengkapi semua field terlebih dahulu">
                                                    <i class="fas fa-exclamation-triangle me-1"></i>Belum Lengkap
                                                </button>
                                            @endif
                                            
                                            <form action="{{ route('student.delete-post', $draft->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger w-100" onclick="return confirm('Hapus draft ini?')">
                                                    <i class="fas fa-trash me-1"></i>Hapus Draft
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-5">
                                <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum ada draft artikel</h5>
                                <p class="text-muted">Mulai menulis artikel dan simpan sebagai draft</p>
                                <a href="{{ route('student.create-post') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Tulis Artikel Baru
                                </a>
                            </div>
                            @endforelse
                            
                            @if($drafts->hasPages())
                                <div class="d-flex justify-content-center">
                                    {{ $drafts->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>