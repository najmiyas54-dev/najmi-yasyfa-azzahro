<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tambah Pengumuman - Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Tambah Pengumuman Baru</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="form-group">
                                <label>Judul</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Konten</label>
                                <textarea name="content" class="form-control" rows="5" required></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label>Kategori</label>
                                <select name="category" class="form-control" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="Pengumuman">Pengumuman</option>
                                    <option value="Berita">Berita</option>
                                    <option value="Kegiatan">Kegiatan</option>
                                    <option value="Informasi">Informasi</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Tipe</label>
                                <select name="type" class="form-control" required>
                                    <option value="">Pilih Tipe</option>
                                    <option value="blog">Blog</option>
                                    <option value="story">Story</option>
                                    <option value="destination">Destination</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Gambar</label>
                                <input type="file" name="image" class="form-control-file" accept="image/*">
                            </div>
                            
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>