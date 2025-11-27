# E-Magazine BAKNUS 📰

E-Magazine BAKNUS adalah platform digital untuk SMK Bakti Nusantara 666 yang memungkinkan siswa, guru, dan admin untuk berbagi artikel, berita, prestasi, dan kegiatan sekolah.

## 🚀 Fitur Utama

### 👨‍🎓 Untuk Siswa
- **Dashboard Siswa**: Kelola artikel dan lihat statistik
- **Buat Artikel**: Tulis artikel dengan editor rich text
- **Draft System**: Simpan artikel sebagai draft sebelum submit
- **Sistem Review**: Artikel akan direview oleh guru sebelum dipublish
- **Notifikasi**: Terima notifikasi status artikel
- **Like System**: Like artikel yang menarik

### 👨‍🏫 Untuk Guru  
- **Dashboard Guru**: Kelola dan review artikel siswa
- **Review Artikel**: Approve/reject artikel siswa dengan catatan
- **Buat Artikel**: Tulis artikel sendiri
- **Manajemen User**: Kelola akun siswa
- **Statistik**: Lihat statistik artikel dan aktivitas

### 👨‍💼 Untuk Admin
- **Dashboard Admin**: Overview lengkap sistem
- **Manajemen User**: Kelola semua user (siswa, guru)
- **Manajemen Konten**: Kelola semua artikel dan kategori
- **Sistem Approval**: Final approval untuk publikasi artikel
- **Laporan**: Generate laporan aktivitas
- **Notifikasi**: Kelola notifikasi sistem

## 📱 Kategori Konten

- **🏆 Prestasi**: Pencapaian siswa dan sekolah
- **📢 Pengumuman**: Informasi penting sekolah
- **🎯 Lomba**: Kompetisi dan perlombaan
- **📅 Kegiatan**: Aktivitas dan event sekolah
- **📰 Blog & Berita**: Artikel umum dan berita

## 🛠️ Teknologi

- **Framework**: Laravel 11
- **Database**: MySQL
- **Frontend**: Bootstrap 4, jQuery
- **Authentication**: Custom multi-role auth
- **File Storage**: Laravel Storage
- **Icons**: Font Awesome

## 📋 Persyaratan Sistem

- PHP >= 8.2
- Composer
- MySQL >= 5.7
- Node.js & NPM (untuk asset compilation)
- Web Server (Apache/Nginx)

## 🔧 Instalasi

1. **Clone Repository**
   ```bash
   git clone https://github.com/najmiyas54-dev/najmi-yasyfa-azzahro.git
   cd najmi-yasyfa-azzahro
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Configuration**
   Edit file `.env` dan sesuaikan konfigurasi database:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=madingaja
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Database Migration & Seeding**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Storage Link**
   ```bash
   php artisan storage:link
   ```

7. **Compile Assets**
   ```bash
   npm run build
   ```

8. **Run Application**
   ```bash
   php artisan serve
   ```

## 👥 Default Users

Setelah seeding, Anda dapat login dengan:

### Admin
- **Email**: admin@baknus.sch.id
- **Password**: admin123

### Guru
- **Email**: guru@baknus.sch.id  
- **Password**: guru123

### Siswa
- **Email**: siswa@baknus.sch.id
- **Password**: siswa123

## 🔄 Alur Kerja Artikel

1. **Siswa** membuat artikel dan submit untuk review
2. **Guru** mereview artikel siswa (approve/reject)
3. **Admin** melakukan final approval untuk publikasi
4. Artikel yang disetujui akan tampil di website publik

## 📁 Struktur Project

```
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/          # Controller untuk admin
│   │   ├── Guru/           # Controller untuk guru  
│   │   └── StudentController.php
│   ├── Models/
│   └── Middleware/
├── resources/views/
│   ├── admin/              # Views admin
│   ├── guru/               # Views guru
│   ├── student/            # Views siswa
│   ├── pages/              # Views publik
│   └── layouts/
├── database/
│   ├── migrations/
│   └── seeders/
└── public/
    ├── images/
    └── css/
```

## 🎨 Fitur UI/UX

- **Responsive Design**: Optimal di desktop dan mobile
- **Modern Interface**: Design yang clean dan user-friendly
- **Dark/Light Theme**: Sesuai preferensi user
- **Interactive Elements**: Hover effects dan animations
- **Loading States**: Feedback visual untuk user actions

## 🔒 Keamanan

- **Multi-role Authentication**: Sistem login terpisah untuk setiap role
- **CSRF Protection**: Perlindungan dari CSRF attacks
- **Input Validation**: Validasi ketat untuk semua input
- **File Upload Security**: Validasi tipe dan ukuran file
- **SQL Injection Prevention**: Menggunakan Eloquent ORM

## 📊 Fitur Analytics

- **View Counter**: Hitung jumlah pembaca artikel
- **Like System**: Sistem like dengan IP tracking
- **User Statistics**: Statistik aktivitas user
- **Content Analytics**: Analytics konten per kategori

## 🚀 Deployment

Untuk production deployment:

1. Set `APP_ENV=production` di `.env`
2. Set `APP_DEBUG=false`
3. Configure proper database credentials
4. Set up proper web server configuration
5. Enable HTTPS
6. Set up backup system

## 🤝 Kontribusi

1. Fork repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

## 📝 License

Project ini menggunakan [MIT License](LICENSE).

## 👨‍💻 Developer

**Najmi Yasyfa Azzahro**
- GitHub: [@najmiyas54-dev](https://github.com/najmiyas54-dev)
- Email: najmiyas54@gmail.com

## 🏫 Tentang SMK Bakti Nusantara 666

SMK Bakti Nusantara 666 adalah sekolah menengah kejuruan yang berkomitmen untuk menghasilkan lulusan yang kompeten dan siap kerja di era digital.

---

⭐ **Jika project ini bermanfaat, jangan lupa berikan star!** ⭐