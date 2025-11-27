<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrasi Siswa - Madingaja</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>

<body style="background: linear-gradient(135deg, #ffcbdf 0%, hsl(228, 100%, 93%) 50%, #edd2fe 100%); min-height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8 col-md-10">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">
                                <i class="fas fa-user-graduate text-primary"></i>
                                Registrasi Siswa
                            </h1>
                        </div>
                        
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('student.register.post') }}">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="name">Nama Lengkap</label>
                                <input type="text" class="form-control" name="name" placeholder="Masukkan Nama Lengkap..." value="{{ old('name') }}" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Masukkan Email..." value="{{ old('email') }}" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="nisn">NISN</label>
                                <input type="text" class="form-control" name="nisn" placeholder="Masukkan NISN..." value="{{ old('nisn') }}" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Password" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password_confirmation">Konfirmasi Password</label>
                                <input type="password" class="form-control" name="password_confirmation" placeholder="Konfirmasi Password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-user-plus"></i> Daftar
                            </button>
                        </form>
                        
                        <hr>
                        <div class="text-center">
                            <p class="mb-2">Sudah punya akun?</p>
                            <a href="{{ route('student.login') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-sign-in-alt me-1"></i>Login Sekarang
                            </a>
                        </div>
                        
                        <div class="alert alert-info mt-3">
                            <small><i class="fas fa-info-circle"></i> Akun Anda akan diverifikasi oleh admin sebelum dapat digunakan.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>