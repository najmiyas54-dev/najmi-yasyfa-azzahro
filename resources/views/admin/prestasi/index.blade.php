@extends('layouts.admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Kelola Prestasi</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Prestasi</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Pengirim</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prestasi as $item)
                    <tr>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->user->name ?? 'Admin' }}</td>
                        <td>
                            @if($item->status == 'pending')
                                <span class="badge badge-warning">Menunggu</span>
                            @elseif($item->status == 'approved')
                                <span class="badge badge-success">Disetujui</span>
                            @else
                                <span class="badge badge-danger">Ditolak</span>
                            @endif
                        </td>
                        <td>{{ $item->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('admin.prestasi.show', $item) }}" class="btn btn-info btn-sm">Detail</a>
                            @if($item->status == 'pending')
                                <form method="POST" action="{{ route('admin.prestasi.approve', $item) }}" class="d-inline">
                                    @csrf
                                    <button class="btn btn-success btn-sm">Setujui</button>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('admin.prestasi.destroy', $item) }}" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $prestasi->links() }}
    </div>
</div>
@endsection