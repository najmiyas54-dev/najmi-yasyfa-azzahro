<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Guru Panel - Madingaja')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
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
                        <a class="nav-link {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}" href="{{ route('guru.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                        <a class="nav-link {{ request()->routeIs('guru.posts.*') ? 'active' : '' }}" href="{{ route('guru.posts.index') }}">
                            <i class="fas fa-edit me-2"></i> Artikel Saya
                        </a>
                        <a class="nav-link {{ request()->routeIs('guru.review-posts') ? 'active' : '' }}" href="{{ route('guru.review-posts') }}">
                            <i class="fas fa-user-graduate me-2"></i> Review Artikel
                        </a>
                        <a class="nav-link {{ request()->routeIs('guru.users*') ? 'active' : '' }}" href="{{ route('guru.users') }}">
                            <i class="fas fa-users me-2"></i> Kelola User
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
                        <h4 class="mb-0 fw-bold text-dark">@yield('page-title', 'Guru Panel')</h4>
                    </div>
                </nav>

                <div class="container-fluid px-4">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>