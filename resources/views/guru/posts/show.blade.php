@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h2>{{ $post->title }}</h2>
                    <p class="text-muted">
                        Oleh: {{ $post->user->name ?? $post->author_name }} | 
                        {{ $post->created_at->format('d M Y H:i') }}
                    </p>
                    
                    @if($post->image_path)
                        <img src="{{ asset('storage/' . $post->image_path) }}" class="img-fluid mb-3" alt="Gambar artikel">
                    @endif
                    
                    <div class="content">
                        {!! nl2br(e($post->content)) !!}
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Review Artikel</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('guru.posts.approve', $post->id) }}" method="POST" class="mb-2">
                        @csrf
                        <div class="mb-3">
                            <label for="notes" class="form-label">Catatan (opsional)</label>
                            <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="Berikan catatan untuk siswa..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Setujui Artikel</button>
                    </form>
                    
                    <form action="{{ route('guru.posts.reject', $post->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="reject_notes" class="form-label">Alasan Penolakan *</label>
                            <textarea name="notes" id="reject_notes" class="form-control" rows="3" placeholder="Jelaskan alasan penolakan..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger w-100">Tolak Artikel</button>
                    </form>
                    
                    <a href="{{ route('guru.posts.index') }}" class="btn btn-secondary w-100 mt-2">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection