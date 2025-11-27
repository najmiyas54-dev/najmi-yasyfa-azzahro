<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tulis Artikel - Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('guru.dashboard') }}">
                <i class="fas fa-chalkboard-teacher me-2"></i>Guru Panel
            </a>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-pen me-2"></i>Tulis Artikel Baru</h5>
                    </div>
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('guru.store.artikel') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Judul Artikel</label>
                                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="content" class="form-label">Isi Artikel</label>
                                        <textarea class="form-control" id="content" name="content" rows="15" required>{{ old('content') }}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="category" class="form-label">Kategori</label>
                                        <select class="form-select" id="category" name="category" required>
                                            <option value="">Pilih Kategori</option>
                                            <option value="pengumuman" {{ old('category') == 'pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                                            <option value="prestasi" {{ old('category') == 'prestasi' ? 'selected' : '' }}>Prestasi</option>
                                            <option value="lomba" {{ old('category') == 'lomba' ? 'selected' : '' }}>Lomba</option>
                                            <option value="kegiatan" {{ old('category') == 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="author_name" class="form-label">Nama Penulis</label>
                                        <input type="text" class="form-control" id="author_name" name="author_name" value="{{ old('author_name', Auth::check() ? Auth::user()->name : '') }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="posted_date" class="form-label">Tanggal Posting</label>
                                        <input type="date" class="form-control" id="posted_date" name="posted_date" value="{{ old('posted_date', date('Y-m-d')) }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="image" class="form-label">Gambar (Opsional)</label>
                                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                        <div class="form-text">Format: JPG, PNG, GIF. Max: 2MB</div>
                                    </div>


                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('guru.dashboard') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Kirim untuk Review Admin
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>