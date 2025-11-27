@extends('layouts.app')

@section('content')
<div class="container-fluid" style="padding-top: 100px;">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 sidebar">
            <div class="sidebar-sticky">
                <h5 class="sidebar-heading">Dashboard Guru</h5>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('guru.dashboard') }}">
                            <i class="fa fa-tachometer"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('guru.articles.index') }}">
                            <i class="fa fa-newspaper"></i> Artikel Saya
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('guru.articles.create') }}">
                            <i class="fa fa-plus"></i> Tulis Artikel
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('guru.student-articles') }}">
                            <i class="fa fa-check-circle"></i> Artikel Siswa
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('guru.comments') }}">
                            <i class="fa fa-comments"></i> Komentar
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main content -->
        <div class="col-md-9 col-lg-10 main-content">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Tulis Artikel Baru</h1>
            </div>

            <!-- Create Article Form -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="{{ route('guru.articles.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="title">Judul Artikel</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>

                        <div class="form-group">
                            <label for="category">Kategori</label>
                            <select class="form-control" id="category" name="category" required>
                                <option value="">Pilih Kategori</option>
                                <option value="pengumuman">Pengumuman</option>
                                <option value="berita">Berita</option>
                                <option value="kegiatan">Kegiatan</option>
                                <option value="prestasi">Prestasi</option>
                                <option value="lomba">Lomba</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="image">Gambar (Opsional)</label>
                            <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
                        </div>

                        <div class="form-group">
                            <label for="content">Konten Artikel</label>
                            <textarea class="form-control" id="content" name="content" rows="10" required></textarea>
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_published" name="is_published" value="1">
                                <label class="form-check-label" for="is_published">
                                    Publikasikan artikel
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Simpan Artikel</button>
                            <a href="{{ route('guru.articles.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.sidebar {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    z-index: 100;
    padding: 100px 0 0;
    background-color: #f8f9fa;
    border-right: 1px solid #dee2e6;
}

.sidebar-sticky {
    position: relative;
    top: 0;
    height: calc(100vh - 100px);
    padding-top: 0.5rem;
    overflow-x: hidden;
    overflow-y: auto;
}

.sidebar .nav-link {
    color: #333;
    padding: 0.75rem 1rem;
}

.sidebar .nav-link.active {
    color: #007bff;
    background-color: rgba(0, 123, 255, 0.1);
}

.sidebar .nav-link:hover {
    color: #007bff;
}

.main-content {
    margin-left: 0;
    padding: 0 15px;
}

@media (min-width: 768px) {
    .main-content {
        margin-left: 25%;
    }
}

@media (min-width: 992px) {
    .main-content {
        margin-left: 16.666667%;
    }
}
</style>
@endsection