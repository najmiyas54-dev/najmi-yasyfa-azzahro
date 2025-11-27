# Solusi Masalah Guru Tidak Bisa Like

## Masalah yang Ditemukan:
1. Guru menggunakan sistem Auth Laravel standar, tapi ada kemungkinan konflik dengan session
2. Method `isLikedBy` di view mungkin tidak mengenali guru yang login
3. Kemungkinan masalah CSRF atau JavaScript

## Solusi yang Sudah Diterapkan:

### 1. Memperbaiki PostController
- Menambahkan logging yang lebih detail
- Menambahkan debug info dalam response JSON
- Menyederhanakan logika like untuk semua user yang login

### 2. Menambahkan Debug Info di View
- Menampilkan status autentikasi di halaman artikel (jika debug mode aktif)
- Menambahkan console.log untuk debugging JavaScript

## Langkah Troubleshooting untuk Guru:

### 1. Aktifkan Debug Mode
Ubah di file `.env`:
```
APP_DEBUG=true
```

### 2. Test Login Guru
1. Login sebagai guru
2. Buka artikel
3. Lihat debug info di halaman (jika muncul)
4. Buka Developer Tools (F12) di browser
5. Klik tombol like
6. Periksa Console untuk melihat log

### 3. Periksa Response
Jika ada error, periksa:
- Status HTTP response
- Debug info dalam response JSON
- Error message di console

## Kemungkinan Penyebab Lain:

### 1. Session Expired
- Session guru mungkin expired
- Logout dan login ulang

### 2. CSRF Token Issue
- Refresh halaman sebelum mencoba like
- Pastikan meta tag csrf-token ada di head

### 3. Database Issue
- Periksa tabel `post_likes` apakah ada constraint yang mencegah insert
- Periksa apakah user_id guru valid

## Cara Test Manual:

1. Login sebagai guru
2. Buka artikel: `/single/{id}`
3. Buka Developer Tools (F12)
4. Klik tab Console
5. Klik tombol like
6. Periksa log yang muncul

Jika masih bermasalah, kirim screenshot dari:
1. Debug info di halaman artikel
2. Console log setelah klik like
3. Network tab untuk melihat request/response