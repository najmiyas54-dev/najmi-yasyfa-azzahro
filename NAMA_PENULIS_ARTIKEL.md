# Nama Penulis Artikel - Update

## Tempat Nama Penulis Ditampilkan

### 1. Homepage (/)
- **Slider artikel**: Nama penulis di bawah tanggal
- **Section berita terbaru**: Nama penulis + tanggal dalam satu baris

### 2. Halaman Single Artikel (/single/{id})
- **Meta info artikel**: Kotak khusus dengan penulis dan tanggal publikasi
- **Format**: Penulis di kolom kiri, tanggal di kolom kanan

### 3. Halaman Prestasi (/prestasi)
- **Card artikel**: Nama penulis di atas tanggal publikasi
- **Format**: Icon user + nama, lalu icon calendar + tanggal

### 4. Halaman Preview Guru
- **Meta artikel**: Penulis, kategori, dan status dalam satu baris
- **Format**: 3 kolom (Penulis | Kategori | Status)

### 5. Halaman Preview Admin
- **Meta artikel**: Penulis, kategori, status guru, dan status admin
- **Format**: 4 kolom (Penulis | Kategori | Status | Review Admin)

### 6. Halaman Preview Siswa
- **Meta artikel**: Penulis, kategori, status, dan publikasi
- **Format**: 4 kolom (Penulis | Kategori | Status | Publikasi)

## Kode yang Ditambahkan

### Homepage Slider:
```html
<small class="text-muted">
    <i class="fa fa-user"></i> {{ $post->user->name ?? 'Admin' }}
</small>
```

### Homepage Berita:
```html
<small class="text-muted">
    <i class="fa fa-user"></i> {{ $post->user->name ?? 'Admin' }} | 
    <i class="fa fa-calendar"></i> {{ $post->created_at->format('d M Y') }}
</small>
```

### Single Artikel:
```html
<div class="mb-4 p-3 bg-light rounded">
    <div class="row">
        <div class="col-md-6">
            <p class="text-muted mb-1">
                <i class="fa fa-user"></i> <strong>Penulis:</strong> {{ $post->user->name ?? 'Admin' }}
            </p>
        </div>
        <div class="col-md-6">
            <p class="text-muted mb-1">
                <i class="fa fa-calendar"></i> <strong>Dipublikasikan:</strong> {{ $post->created_at->format('d F Y') }}
            </p>
        </div>
    </div>
</div>
```

### Halaman Prestasi:
```html
<div>
    <small class="text-muted">
        <i class="fa fa-user"></i> {{ $post->user->name ?? 'Admin' }}
    </small><br>
    <small class="text-muted">
        <i class="fa fa-calendar"></i> {{ $post->created_at->format('d M Y') }}
    </small>
</div>
```

## Controller Updates

### PageController:
```php
$latestPosts = Post::where('status', 'approved')
              ->where('is_published', true)
              ->with('user')  // Load relasi user
              ->latest()
              ->take(6)
              ->get();
```

### PostController:
```php
$post = Post::with('user')->findOrFail($id);  // Load relasi user
```

## Fallback untuk Nama Penulis

Jika artikel tidak memiliki user (data lama), akan menampilkan "Admin":
```php
{{ $post->user->name ?? 'Admin' }}
```

## Icon yang Digunakan

- **User**: `<i class="fa fa-user"></i>`
- **Calendar**: `<i class="fa fa-calendar"></i>`

## Styling

- **Homepage**: Text muted dengan icon
- **Single artikel**: Background light dengan border rounded
- **Prestasi**: Text muted dengan line break
- **Preview**: Meta box dengan grid layout

Sekarang semua artikel menampilkan nama penulis dengan jelas di berbagai halaman!