# Sistem Review dan Notifikasi Artikel

## Alur Sistem Review

### 1. Siswa Membuat Artikel
- Siswa login dan membuat artikel baru
- Status artikel: `pending`, review_status: `pending_guru`
- **Notifikasi otomatis dikirim ke semua guru**

### 2. Guru Review Artikel
- Guru menerima notifikasi artikel baru perlu review
- Guru dapat melihat daftar artikel di menu "Review Artikel"
- Guru dapat:
  - **Menyetujui**: Status berubah ke `pending_admin`, notifikasi dikirim ke admin
  - **Menolak**: Status berubah ke `rejected`, notifikasi dikirim ke siswa

### 3. Admin Review Artikel
- Admin menerima notifikasi artikel yang sudah disetujui guru
- Admin dapat melihat daftar artikel di menu "Pending Review"
- Admin dapat:
  - **Menyetujui**: Status berubah ke `approved`, notifikasi dikirim ke siswa
  - **Menolak**: Status berubah ke `rejected`, notifikasi dikirim ke siswa

### 4. Siswa Publish Artikel
- Setelah artikel disetujui admin, siswa menerima notifikasi
- Siswa dapat mempublish artikel ke halaman publik

## File yang Dibuat/Dimodifikasi

### Controllers
1. **StudentController.php** - Ditambahkan notifikasi ke guru saat buat artikel
2. **GuruController.php** - Ditambahkan method approve/reject dengan notifikasi
3. **Admin/PostController.php** - Ditambahkan method review admin dengan notifikasi

### Views
1. **guru/review-posts.blade.php** - Halaman review artikel untuk guru
2. **admin/posts/pending-review.blade.php** - Halaman review artikel untuk admin
3. **student/notifications.blade.php** - Halaman notifikasi untuk siswa
4. **components/notification-badge.blade.php** - Komponen badge notifikasi

### Database
1. **Migration review fields** - Field review_status, reviewed_by_guru, reviewed_by_admin, dll
2. **Migration publish fields** - Field is_published, published_at

### Routes
```php
// Guru routes
Route::get('review-posts', [GuruController::class, 'studentPosts'])->name('review-posts');
Route::post('approve-post/{id}', [GuruController::class, 'approveStudentPost'])->name('approve-post');
Route::post('reject-post/{id}', [GuruController::class, 'rejectStudentPost'])->name('reject-post');

// Admin routes
Route::get('posts/pending-review', [PostController::class, 'pendingReview'])->name('posts.pending-review');
Route::post('posts/{id}/approve', [PostController::class, 'approve'])->name('posts.approve');
Route::post('posts/{id}/reject', [PostController::class, 'reject'])->name('posts.reject');
```

## Status Artikel

### Review Status
- `pending_guru` - Menunggu review guru
- `pending_admin` - Disetujui guru, menunggu review admin
- `approved_admin` - Disetujui admin, siap publish
- `rejected_guru` - Ditolak guru
- `rejected_admin` - Ditolak admin

### Status Umum
- `pending` - Sedang dalam proses review
- `approved` - Disetujui dan bisa dipublish
- `rejected` - Ditolak

## Tipe Notifikasi

1. **pending_guru_review** - Artikel baru perlu review guru
2. **pending_admin_review** - Artikel perlu review admin
3. **approved_admin** - Artikel disetujui admin
4. **rejected_guru** - Artikel ditolak guru
5. **rejected_admin** - Artikel ditolak admin

## Cara Menggunakan

### Untuk Siswa
1. Login ke dashboard siswa
2. Klik "Buat Artikel"
3. Isi form dan submit
4. Tunggu notifikasi dari guru/admin
5. Jika disetujui, publish artikel

### Untuk Guru
1. Login ke dashboard guru
2. Lihat notifikasi artikel baru
3. Klik "Review Artikel" di menu
4. Review artikel dan beri keputusan
5. Tambahkan catatan jika perlu

### Untuk Admin
1. Login ke dashboard admin
2. Lihat notifikasi artikel dari guru
3. Klik "Pending Review" di menu Posts
4. Review artikel dan beri keputusan final
5. Tambahkan catatan jika perlu

## Fitur Notifikasi

- **Real-time notifications** saat status artikel berubah
- **Badge counter** untuk notifikasi yang belum dibaca
- **Riwayat notifikasi** lengkap dengan timestamp
- **Catatan review** dari guru dan admin
- **Auto-redirect** ke artikel terkait dari notifikasi