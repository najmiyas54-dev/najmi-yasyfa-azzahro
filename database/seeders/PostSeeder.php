<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PostSeeder extends Seeder
{
    public function run()
    {
        $posts = [
            // Blog Posts - Berita Sekolah
            [
                'title' => 'Prestasi Gemilang Siswa SMK Bakti Nusantara 666 di Kompetisi Nasional',
                'content' => 'SMK Bakti Nusantara 666 kembali menorehkan prestasi membanggakan. Tim robotika sekolah berhasil meraih juara 1 dalam kompetisi robotika tingkat nasional yang diselenggarakan di Jakarta. Prestasi ini merupakan buah dari kerja keras siswa dan dukungan penuh dari pihak sekolah dalam mengembangkan minat dan bakat siswa di bidang teknologi.',
                'image_path' => 'images/banner-image-1.jpg',
                'category' => 'Prestasi',
                'type' => 'blog',
                'comments_count' => 45,
                'views_count' => 345,
                'likes_count' => 89,
                'location' => 'Jakarta',
                'posted_date' => Carbon::now()->subDays(2)
            ],
            [
                'title' => 'Pelaksanaan Prakerin Siswa Kelas XI di Berbagai Industri',
                'content' => 'Siswa kelas XI SMK Bakti Nusantara 666 telah memulai program Praktek Kerja Industri (Prakerin) di berbagai perusahaan mitra. Program ini bertujuan untuk memberikan pengalaman kerja nyata kepada siswa sebelum lulus dan memasuki dunia kerja. Lebih dari 200 siswa tersebar di 50 perusahaan di seluruh Indonesia.',
                'image_path' => 'images/banner-image-2.jpg',
                'category' => 'Pendidikan',
                'type' => 'blog',
                'comments_count' => 32,
                'views_count' => 289,
                'likes_count' => 67,
                'location' => 'Berbagai Kota',
                'posted_date' => Carbon::now()->subDays(5)
            ],
            [
                'title' => 'Workshop Digital Marketing untuk Siswa Jurusan Bisnis Online',
                'content' => 'SMK Bakti Nusantara 666 mengadakan workshop digital marketing yang diikuti oleh siswa jurusan Bisnis Daring dan Pemasaran. Workshop ini menghadirkan praktisi digital marketing terkemuka untuk berbagi pengalaman dan strategi pemasaran digital yang efektif di era modern.',
                'image_path' => 'images/banner-image-3.jpg',
                'category' => 'Workshop',
                'type' => 'blog',
                'comments_count' => 28,
                'views_count' => 412,
                'likes_count' => 54,
                'location' => 'SMK Bakti Nusantara 666',
                'posted_date' => Carbon::now()->subWeek()
            ],
            [
                'title' => 'Kegiatan Bakti Sosial Siswa di Panti Asuhan Harapan Bangsa',
                'content' => 'Dalam rangka menumbuhkan rasa empati dan kepedulian sosial, siswa SMK Bakti Nusantara 666 mengadakan kegiatan bakti sosial di Panti Asuhan Harapan Bangsa. Kegiatan ini meliputi pemberian bantuan berupa sembako, alat tulis, dan mengajar anak-anak panti asuhan.',
                'image_path' => 'images/banner-image-4.jpg',
                'category' => 'Sosial',
                'type' => 'blog',
                'comments_count' => 51,
                'views_count' => 567,
                'likes_count' => 123,
                'location' => 'Panti Asuhan Harapan Bangsa',
                'posted_date' => Carbon::now()->subWeeks(2)
            ],
            [
                'title' => 'Penerimaan Siswa Baru Tahun Ajaran 2024/2025 Dibuka',
                'content' => 'SMK Bakti Nusantara 666 membuka pendaftaran siswa baru untuk tahun ajaran 2024/2025. Tersedia berbagai jurusan unggulan seperti Teknik Komputer dan Jaringan, Multimedia, Bisnis Daring dan Pemasaran, serta Akuntansi. Pendaftaran dapat dilakukan secara online maupun offline.',
                'image_path' => 'images/banner-image-1.jpg',
                'category' => 'Pendaftaran',
                'type' => 'blog',
                'comments_count' => 89,
                'views_count' => 1234,
                'likes_count' => 234,
                'location' => 'SMK Bakti Nusantara 666',
                'posted_date' => Carbon::now()->subMonth()
            ],
            [
                'title' => 'Kerjasama dengan Industri 4.0 untuk Peningkatan Kualitas Pembelajaran',
                'content' => 'SMK Bakti Nusantara 666 menjalin kerjasama strategis dengan berbagai perusahaan teknologi untuk menghadirkan pembelajaran berbasis Industri 4.0. Kerjasama ini meliputi penyediaan peralatan modern, pelatihan guru, dan program magang siswa.',
                'image_path' => 'images/banner-image-2.jpg',
                'category' => 'Kerjasama',
                'type' => 'blog',
                'comments_count' => 67,
                'views_count' => 890,
                'likes_count' => 156,
                'location' => 'SMK Bakti Nusantara 666',
                'posted_date' => Carbon::now()->subMonths(2)
            ],
            // Destinations
            [
                'title' => 'Study Tour Siswa ke Museum Teknologi Jakarta',
                'content' => 'Siswa jurusan Teknik Komputer dan Jaringan mengadakan study tour ke Museum Teknologi Jakarta untuk memperluas wawasan tentang perkembangan teknologi informasi di Indonesia.',
                'image_path' => 'images/banner-image-3.jpg',
                'category' => 'Edukasi',
                'type' => 'destination',
                'comments_count' => 28,
                'views_count' => 412,
                'likes_count' => 45,
                'location' => 'Jakarta',
                'posted_date' => Carbon::now()->subMonths(3)
            ],
            // Stories
            [
                'title' => 'Kisah Sukses Alumni: Dari Siswa SMK Menjadi Entrepreneur Muda',
                'content' => 'Profil alumni SMK Bakti Nusantara 666 yang berhasil membangun startup teknologi dan menjadi inspirasi bagi adik-adik kelasnya. Perjalanan karir yang dimulai dari bangku sekolah hingga menjadi pengusaha sukses.',
                'image_path' => 'images/banner-image-4.jpg',
                'category' => 'Inspirasi',
                'type' => 'story',
                'comments_count' => 51,
                'views_count' => 567,
                'likes_count' => 78,
                'location' => 'Indonesia',
                'posted_date' => Carbon::now()->subMonths(4)
            ]
        ];

        // Hapus data lama jika ada
        Post::truncate();
        
        foreach ($posts as $post) {
            Post::create($post);
        }
    }
}