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
                        <a class="nav-link active" href="{{ route('guru.articles.index') }}">
                            <i class="fa fa-newspaper"></i> Artikel Saya
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('guru.articles.create') }}">
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
                <h1 class="h2">Artikel Saya</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group mr-2">
                        <a href="{{ route('guru.articles.create') }}" class="btn btn-sm btn-primary">
                            <i class="fa fa-plus"></i> Tulis Artikel Baru
                        </a>
                    </div>
                </div>
            </div>

            <!-- Articles Table -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Tips Belajar Efektif untuk Siswa SMK</td>
                                    <td><span class="badge badge-info">Pengumuman</span></td>
                                    <td><span class="badge badge-success">Approved</span></td>
                                    <td>15 Des 2024</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-primary">Edit</a>
                                        <a href="#" class="btn btn-sm btn-info">Lihat</a>
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Pentingnya Soft Skills di Dunia Kerja</td>
                                    <td><span class="badge badge-primary">Berita</span></td>
                                    <td><span class="badge badge-warning">Pending</span></td>
                                    <td>12 Des 2024</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-primary">Edit</a>
                                        <a href="#" class="btn btn-sm btn-info">Lihat</a>
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Persiapan Ujian Nasional 2024</td>
                                    <td><span class="badge badge-warning">Kegiatan</span></td>
                                    <td><span class="badge badge-success">Approved</span></td>
                                    <td>10 Des 2024</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-primary">Edit</a>
                                        <a href="#" class="btn btn-sm btn-info">Lihat</a>
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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