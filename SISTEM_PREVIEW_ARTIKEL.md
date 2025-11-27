# Sistem Preview Artikel

## Fitur Preview yang Ditambahkan

### 1. Preview untuk Guru
- **URL**: `/guru/preview-post/{id}`
- **Tampilan**: Seperti website dengan header khusus guru
- **Fitur**:
  - Melihat artikel dalam format website
  - Tombol approve/reject langsung di halaman preview
  - Alert bahwa ini mode preview
  - Informasi siswa penulis
  - Kategori dan status artikel

### 2. Preview untuk Admin
- **URL**: `/admin/posts/preview/{id}`
- **Tampilan**: Seperti website dengan header khusus admin
- **Fitur**:
  - Melihat artikel dalam format website
  - Riwayat review dari guru
  - Tombol approve/reject dengan opsi publish
  - Catatan dari guru ditampilkan
  - Status lengkap artikel

### 3. Preview untuk Siswa
- **URL**: `/student/preview-post/{id}`
- **Tampilan**: Seperti website dengan header khusus siswa
- **Fitur**:
  - Melihat artikel mereka sendiri
  - Status review lengkap
  - Catatan dari guru dan admin
  - Tombol publish (jika sudah disetujui)
  - Riwayat review

## Tombol Preview Ditambahkan

### Di Halaman Review Guru
```html
<a href="{{ route('guru.preview-post', $post->id) }}" 
   class="btn btn-sm btn-info" target="_blank">
    <i class="fas fa-eye"></i> Preview
</a>
```

### Di Halaman Review Admin
```html
<a href="{{ route('admin.posts.preview', $post->id) }}" 
   class="btn btn-sm btn-info" target="_blank">
    <i class="fas fa-eye"></i> Preview
</a>
```

## Route yang Ditambahkan

```php
// Guru routes
Route::get('preview-post/{id}', [GuruController::class, 'previewPost'])->name('preview-post');

// Admin routes  
Route::get('posts/preview/{id}', [PostController::class, 'previewPost'])->name('posts.preview');

// Student routes
Route::get('preview-post/{id}', [StudentController::class, 'previewPost'])->name('preview-post');
```

## Method Controller yang Ditambahkan

### GuruController
```php
public function previewPost($id)
{
    $post = Post::where('review_status', 'pending_guru')
        ->with('user')
        ->findOrFail($id);
        
    return view('guru.preview-post', compact('post'));
}
```

### Admin PostController
```php
public function previewPost($id)
{
    $post = Post::where('review_status', 'pending_admin')
        ->with('user')
        ->findOrFail($id);
        
    return view('admin.preview-post', compact('post'));
}
```

### StudentController
```php
public function previewPost($id)
{
    $post = Post::where('user_id', Auth::id())->findOrFail($id);
    return view('student.preview-post', compact('post'));
}
```

## Keunggulan Sistem Preview

1. **Tampilan Real Website**: Artikel ditampilkan persis seperti di website publik
2. **Review Langsung**: Guru/admin bisa approve/reject langsung dari halaman preview
3. **Riwayat Lengkap**: Menampilkan catatan dari guru dan admin
4. **Responsive Design**: Tampilan bagus di desktop dan mobile
5. **Fixed Action Buttons**: Tombol review/publish selalu terlihat
6. **Modal Confirmation**: Konfirmasi sebelum approve/reject/publish
7. **Status Indicator**: Badge status yang jelas untuk setiap tahap review

## Alur Penggunaan

### Untuk Guru:
1. Masuk ke halaman "Review Artikel"
2. Klik tombol "Preview" pada artikel
3. Artikel terbuka di tab baru dengan tampilan website
4. Review artikel, lalu klik "Setujui" atau "Tolak"
5. Isi catatan dan konfirmasi keputusan

### Untuk Admin:
1. Masuk ke halaman "Pending Review"
2. Klik tombol "Preview" pada artikel
3. Lihat artikel + catatan guru
4. Klik "Setujui & Publish" atau "Tolak"
5. Artikel langsung publish jika disetujui

### Untuk Siswa:
1. Masuk ke dashboard
2. Klik "Preview" pada artikel mereka
3. Lihat status dan catatan review
4. Jika disetujui, klik "Publish ke Website"
5. Artikel tampil di website publik

Sistem ini memastikan semua pihak bisa melihat artikel dalam format yang sama seperti di website sebelum memutuskan untuk approve atau publish.