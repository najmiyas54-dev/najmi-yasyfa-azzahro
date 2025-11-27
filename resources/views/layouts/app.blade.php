<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>E-Mading SMK Bakti Nusantara 666</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700|Playfair+Display:400,700,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    
    @stack('styles')
    
    <style>
    .top-login-bar {
        background: #2c3e50;
        padding: 8px 0;
        border-bottom: 1px solid #34495e;
    }
    
    .top-login-bar .form-control {
        border-radius: 15px 0 0 15px;
    }
    
    .top-login-bar .btn {
        border-radius: 0 15px 15px 0;
    }
    
    .top-login-bar .input-group {
        max-width: 300px;
    }
    
    .navbar.cyan {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .footer-section {
        background: linear-gradient(135deg, #750f53 0%, #bfd8fe 100%);
        color: white;
        padding: 40px 0 20px;
    }
    
    .footer-section h5 {
        color: #dcecf1;
        margin-bottom: 20px;
    }
    
    .footer-section a {
        color: #dcecf1;
        text-decoration: none;
    }
    
    .footer-section a:hover {
        color: white;
    }
    
    body, html {
        background: #ffffff !important;
        background-color: #ffffff !important;
        background-image: none !important;
    }
    
    main {
        background: #ffffff !important;
        min-height: 100vh;
    }
    
    .bg-light {
        margin-bottom: 0 !important;
        padding-bottom: 60px !important;
    }
    
    .footer-section {
        margin-top: 0 !important;
    }
    
    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {
            transform: translateY(0);
        }
        40% {
            transform: translateY(-10px);
        }
        60% {
            transform: translateY(-5px);
        }
    }
    </style>
</head>
<body>
    <!-- Top Login Bar -->
    <div class="top-login-bar">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <!-- Search moved to navbar -->
                </div>
                <div class="col-md-6 text-right">
                    @if(Auth::check() || session('admin_logged_in'))
                        <span class="text-white mr-2">
                            @if(Auth::check())
                                {{ Auth::user()->name }}
                            @else
                                {{ session('admin_name', 'Admin') }}
                            @endif
                        </span>
                        @if(Auth::check() && str_contains(Auth::user()->email, 'guru'))
                            <form action="{{ route('guru.logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fa fa-sign-out"></i> Logout
                                </button>
                            </form>
                        @elseif((Auth::check() && Auth::user()->role == 'admin') || session('admin_logged_in'))
                            <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fa fa-sign-out"></i> Logout
                                </button>
                            </form>
                        @elseif(Auth::check() && Auth::user()->role == 'siswa')
                            <form action="{{ route('student.logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fa fa-sign-out"></i> Logout
                                </button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark cyan fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <img src="{{ asset('images/logosmk.png') }}" alt="logosmk" style="height: 60px;">
                <h4 class="mb-0 ml-3" style="color: #dcecf1; font-family: 'Baloo 2', cursive; font-weight: 700; text-shadow: 2px 2px 4px rgba(0,0,0,0.4); letter-spacing: 1px; font-size: 1.6rem;">E-MAGAZINE BAKNUS</h4>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-4">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item dropdown {{ Request::is('pengumuman') || Request::is('prestasi') || Request::is('kegiatan') || Request::is('lomba') || Request::is('blog') ? 'active' : '' }} mr-3">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
                            Kategori
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('pengumuman') }}">
                                <i class="fa fa-bullhorn"></i> Pengumuman
                            </a>
                            <a class="dropdown-item" href="{{ route('prestasi') }}">
                                <i class="fa fa-trophy"></i> Prestasi
                            </a>
                            <a class="dropdown-item" href="{{ route('lomba') }}">
                                <i class="fa fa-medal"></i> Lomba
                            </a>
                            <a class="dropdown-item" href="{{ route('kegiatan') }}">
                                <i class="fa fa-calendar"></i> Kegiatan
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('blog') }}">
                                <i class="fa fa-newspaper"></i> Berita
                            </a>
                        </div>
                    </li>
                    <li class="nav-item mr-1">
                        <form class="form-inline my-2 my-lg-0" action="{{ route('search') }}" method="GET">
                            <div class="input-group">
                                <input class="form-control" type="search" name="q" placeholder="Cari artikel..." value="{{ request('q') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-light" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </li>
                    
                    @if(!Auth::check() && !session('admin_logged_in'))
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="loginDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-sign-in"></i> Login
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="loginDropdown">
                                <a class="dropdown-item" href="{{ route('admin.login') }}">
                                    <i class="fa fa-user-shield"></i> Admin
                                </a>
                                <a class="dropdown-item" href="{{ route('guru.login') }}">
                                    <i class="fa fa-chalkboard-teacher"></i> Guru
                                </a>
                                <a class="dropdown-item" href="{{ route('student.login') }}">
                                    <i class="fa fa-user-graduate"></i> Siswa
                                </a>
                            </div>
                        </li>
                    @else
                        <li class="nav-item">
                            @if(Auth::check() && str_contains(Auth::user()->email, 'guru'))
                                <a class="nav-link" href="{{ route('guru.dashboard') }}">
                                    <i class="fa fa-user"></i> {{ Auth::user()->name }}
                                </a>
                            @elseif((Auth::check() && Auth::user()->role == 'admin') || session('admin_logged_in'))
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                    <i class="fa fa-user"></i> 
                                    @if(Auth::check())
                                        {{ Auth::user()->name }}
                                    @else
                                        {{ session('admin_name', 'Admin') }}
                                    @endif
                                </a>
                            @elseif(Auth::check() && Auth::user()->role == 'siswa')
                                <a class="nav-link" href="{{ route('student.dashboard') }}">
                                    <i class="fa fa-user"></i> {{ Auth::user()->name }}
                                </a>
                            @endif
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer-section">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>E-Magazine BAKNUS</h5>
                    <p>Platform digital untuk berbagi informasi, prestasi, dan kegiatan SMK Bakti Nusantara 666.</p>
                </div>
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('pengumuman') }}">Pengumuman</a></li>
                        <li><a href="{{ route('prestasi') }}">Prestasi</a></li>
                        <li><a href="{{ route('lomba') }}">Lomba</a></li>
                        <li><a href="{{ route('kegiatan') }}">Kegiatan</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contact Info</h5>
                    <p><i class="fa fa-map-marker"></i> SMK Bakti Nusantara 666</p>
                    <p><i class="fa fa-phone"></i> (021) 123-4567</p>
                    <p><i class="fa fa-envelope"></i> info@smkbaknus.sch.id</p>
                </div>
            </div>
            <div class="text-center">
                <p>&copy; 2024 E-Magazine SMK Bakti Nusantara 666. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    
    <script>
    $(document).ready(function() {
        // Ensure dropdown works
        $('.dropdown-toggle').dropdown();
    });
    </script>
</body>
</html>