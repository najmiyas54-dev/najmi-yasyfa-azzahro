<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Pengumuman - Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Pengumuman</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.posts.update', $post->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="form-group">
                                <label>Judul</label>
                                <input type="text" name="title" class="form-control" value="{{ $post->title }}" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Konten</label>
                                <textarea name="content" class="form-control" rows="5" required>{{ $post->content }}</textarea>
                            </div>
                            
                            <div class="form-group">
                                <label>Kategori</label>
                                <select name="category" class="form-control" required>
                                    <option value="Pengumuman" {{ $post->category == 'Pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                                    <option value="Berita" {{ $post->category == 'Berita' ? 'selected' : '' }}>Berita</option>
                                    <option value="Kegiatan" {{ $post->category == 'Kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                                    <option value="Informasi" {{ $post->category == 'Informasi' ? 'selected' : '' }}>Informasi</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Tipe</label>
                                <select name="type" class="form-control" required>
                                    <option value="blog" {{ $post->type == 'blog' ? 'selected' : '' }}>Blog</option>
                                    <option value="story" {{ $post->type == 'story' ? 'selected' : '' }}>Story</option>
                                    <option value="destination" {{ $post->type == 'destination' ? 'selected' : '' }}>Destination</option>
                                </select>
                            </div>
                            
                            @if($post->image_path)
                            <div class="form-group">
                                <label>Gambar Saat Ini</label><br>
                                <img src="{{ asset('storage/' . $post->image_path) }}" width="200" class="img-thumbnail">
                            </div>
                            @endif
                            
                            <div class="form-group">
                                <label>Gambar Baru (opsional)</label>
                                <input type="file" name="image" class="form-control-file" accept="image/*">
                            </div>
                            
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Kembali</a>
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