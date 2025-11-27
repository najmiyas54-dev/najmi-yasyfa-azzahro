<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan E-Mading SMK Bakti Nusantara 666</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #333;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        .stats-row {
            display: table-row;
        }
        .stats-cell {
            display: table-cell;
            width: 25%;
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
            background-color: #f8f9fa;
        }
        .stats-number {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
        }
        .stats-label {
            font-size: 11px;
            color: #666;
            margin-top: 5px;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin: 20px 0 10px 0;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
            color: white;
        }
        .badge-success { background-color: #28a745; }
        .badge-warning { background-color: #ffc107; color: #212529; }
        .badge-danger { background-color: #dc3545; }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN E-MADING</h1>
        <p>SMK Bakti Nusantara 666</p>
        <p>Periode: {{ $generatedAt }}</p>
    </div>

    <div class="section-title">STATISTIK ARTIKEL</div>
    <div class="stats-grid">
        <div class="stats-row">
            <div class="stats-cell">
                <div class="stats-number">{{ $totalPosts }}</div>
                <div class="stats-label">Total Artikel</div>
            </div>
            <div class="stats-cell">
                <div class="stats-number">{{ $publishedPosts }}</div>
                <div class="stats-label">Artikel Dipublish</div>
            </div>
            <div class="stats-cell">
                <div class="stats-number">{{ $pendingPosts }}</div>
                <div class="stats-label">Menunggu Review</div>
            </div>
            <div class="stats-cell">
                <div class="stats-number">{{ $rejectedPosts }}</div>
                <div class="stats-label">Artikel Ditolak</div>
            </div>
        </div>
    </div>

    <div class="section-title">STATISTIK PENGGUNA</div>
    <div class="stats-grid">
        <div class="stats-row">
            <div class="stats-cell">
                <div class="stats-number">{{ $totalUsers }}</div>
                <div class="stats-label">Total Pengguna</div>
            </div>
            <div class="stats-cell">
                <div class="stats-number">{{ $siswaCount }}</div>
                <div class="stats-label">Siswa</div>
            </div>
            <div class="stats-cell">
                <div class="stats-number">{{ $guruCount }}</div>
                <div class="stats-label">Guru</div>
            </div>
            <div class="stats-cell">
                <div class="stats-number">{{ $adminCount }}</div>
                <div class="stats-label">Admin</div>
            </div>
        </div>
    </div>

    <div class="section-title">ARTIKEL PER KATEGORI</div>
    <table>
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Jumlah Artikel</th>
            </tr>
        </thead>
        <tbody>
            @foreach($postsByCategory as $category)
            <tr>
                <td>{{ ucfirst($category->category) }}</td>
                <td>{{ $category->count }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">ARTIKEL TERBARU (20 Terakhir)</div>
    <table>
        <thead>
            <tr>
                <th>Judul Artikel</th>
                <th>Penulis</th>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentPosts as $post)
            <tr>
                <td>{{ Str::limit($post->title, 40) }}</td>
                <td>{{ $post->user->name ?? 'Unknown' }}</td>
                <td>{{ $post->created_at->format('d/m/Y') }}</td>
                <td>
                    <span class="badge badge-{{ $post->status == 'approved' ? 'success' : ($post->status == 'pending' ? 'warning' : 'danger') }}">
                        {{ ucfirst($post->status) }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Laporan ini dibuat secara otomatis oleh sistem E-Mading SMK Bakti Nusantara 666</p>
        <p>Dicetak pada: {{ $generatedAt }}</p>
    </div>
</body>
</html>