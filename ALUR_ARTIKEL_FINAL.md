# Alur Artikel Final - Tidak Langsung Publish

## Alur Lengkap Sistem Review

### 1. Siswa Membuat Artikel
- Status: `pending`
- Review Status: `pending_guru`
- Published: `false`
- **Artikel TIDAK tampil di website publik**
- Notifikasi dikirim ke semua guru

### 2. Guru Review Artikel
- Guru melihat artikel di halaman review
- Guru bisa klik "Preview" untuk melihat artikel dalam format website
- **Artikel tetap TIDAK tampil di website publik**
- Pilihan guru:
  - **Setujui**: Status → `pending`, Review Status → `pending_admin`, Published → `false`
  - **Tolak**: Status → `rejected`, Published → `false`

### 3. Admin Review Artikel
- Admin melihat artikel yang sudah disetujui guru
- Admin bisa klik "Preview" untuk melihat artikel + catatan guru
- **Artikel tetap TIDAK tampil di website publik**
- Pilihan admin:
  - **Setujui**: Status → `approved`, Published → `false` (siswa yang publish)
  - **Tolak**: Status → `rejected`, Published → `false`

### 4. Siswa Publish Artikel
- Setelah admin setujui, siswa dapat notifikasi
- Siswa bisa preview artikel mereka
- Siswa klik "Publish ke Website"
- Status: `approved`, Published: `true`
- **BARU SEKARANG artikel tampil di website publik**

## Filter Website Publik

Semua halaman publik hanya menampilkan artikel dengan kondisi:
- `status = 'approved'`
- `is_published = true`

### Halaman yang Terfilter:
- Homepage (`/`)
- Blog (`/blog`)
- Prestasi (`/prestasi`)
- Lomba (`/lomba`)
- Kegiatan (`/kegiatan`)
- Pengumuman (`/pengumuman`)
- Search (`/search`)

## Status Artikel

### Status Umum:
- `pending` - Sedang dalam proses review
- `approved` - Disetujui admin, siap publish
- `rejected` - Ditolak guru/admin

### Review Status:
- `pending_guru` - Menunggu review guru
- `pending_admin` - Disetujui guru, menunggu admin
- `approved_admin` - Disetujui admin, siap publish
- `rejected_guru` - Ditolak guru
- `rejected_admin` - Ditolak admin

### Published Status:
- `false` - Artikel tidak tampil di website publik
- `true` - Artikel tampil di website publik

## Keamanan Sistem

✅ **Artikel siswa tidak langsung publish** - Harus melalui review guru dan admin  
✅ **Guru tidak bisa langsung publish** - Hanya bisa approve ke admin  
✅ **Admin tidak langsung publish** - Artikel approved tapi siswa yang publish  
✅ **Website publik aman** - Hanya artikel approved + published yang tampil  
✅ **Preview tersedia** - Guru dan admin bisa lihat artikel sebelum approve  
✅ **Notifikasi lengkap** - Semua pihak dapat notifikasi status artikel  

## Alur Testing

1. **Login siswa**: `siswa123@smk.com` / `siswa123`
2. **Buat artikel** → Artikel tidak tampil di website
3. **Login guru**: `guru@smk.com` / `guru123`
4. **Review artikel** → Preview artikel → Approve
5. **Login admin**: `admin@smk.com` / `admin123`
6. **Review artikel** → Preview artikel → Approve
7. **Login siswa** → Dapat notifikasi → Publish artikel
8. **Cek website publik** → Artikel baru tampil setelah dipublish

Sistem ini memastikan kontrol penuh terhadap konten yang tampil di website publik!