@extends('layouts.app')

@section('content')
<div class="container py-5" style="margin-top: 100px;">
    <div class="row justify-content-center">
        <div class="col-lg-6 text-center">
            <div class="error-page">
                <h1 class="display-1 text-primary">404</h1>
                <h2 class="mb-4">Artikel Tidak Ditemukan</h2>
                <p class="lead text-muted mb-4">
                    Artikel yang Anda cari mungkin:
                </p>
                <ul class="list-unstyled text-muted mb-4">
                    <li>• Sedang dalam proses review</li>
                    <li>• Belum dipublikasikan</li>
                    <li>• Tidak tersedia untuk umum</li>
                    <li>• URL tidak valid</li>
                </ul>
                <div class="mt-4">
                    <a href="{{ route('home') }}" class="btn btn-primary btn-lg me-3">
                        <i class="fa fa-home"></i> Kembali ke Beranda
                    </a>
                    <a href="{{ route('blog') }}" class="btn btn-outline-primary btn-lg">
                        <i class="fa fa-newspaper"></i> Lihat Artikel Lain
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.error-page h1 {
    font-size: 8rem;
    font-weight: bold;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
}

@media (max-width: 768px) {
    .error-page h1 {
        font-size: 6rem;
    }
}
</style>
@endsection