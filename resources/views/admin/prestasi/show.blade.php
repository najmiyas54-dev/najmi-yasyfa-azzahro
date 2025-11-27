@extends('layouts.admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Prestasi</h1>
    <a href="{{ route('admin.prestasi.index') }}" class="btn btn-secondary">Kembali</a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-body">
                <h5>{{ $prestasi->title }}</h5>
                <p class="text-muted">Dikirim oleh: {{ $prestasi->user->name ?? 'Admin' }} pada {{ $prestasi->created_at->format('d/m/Y H:i') }}</p>
                
                @if($prestasi->image_path)
                    <img src="{{ Storage::url($prestasi->image_path) }}" class="img-fluid mb-3" style="max-height: 300px;">
                @endif
                
                <div class="mb-3">{{ $prestasi->content }}</div>
                
                @if($prestasi->file_path)
                    <a href="{{ Storage::url($prestasi->file_path) }}" class="btn btn-outline-primary" target="_blank">
                        <i class="fas fa-download"></i> Download File
                    </a>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Aksi Verifikasi</h6>
            </div>
            <div class="card-body">
                <p>Status: 
                    @if($prestasi->status == 'pending')
                        <span class="badge badge-warning">Menunggu</span>
                    @elseif($prestasi->status == 'approved')
                        <span class="badge badge-success">Disetujui</span>
                    @else
                        <span class="badge badge-danger">Ditolak</span>
                    @endif
                </p>
                
                @if($prestasi->status == 'pending')
                    <form method="POST" action="{{ route('admin.prestasi.approve', $prestasi) }}" class="mb-2">
                        @csrf
                        <button class="btn btn-success btn-block">Setujui Prestasi</button>
                    </form>
                    
                    <form method="POST" action="{{ route('admin.prestasi.reject', $prestasi) }}">
                        @csrf
                        <textarea name="admin_notes" class="form-control mb-2" placeholder="Alasan penolakan..."></textarea>
                        <button class="btn btn-danger btn-block">Tolak Prestasi</button>
                    </form>
                @endif
                
                @if($prestasi->admin_notes)
                    <div class="mt-3">
                        <strong>Catatan Admin:</strong>
                        <p>{{ $prestasi->admin_notes }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection