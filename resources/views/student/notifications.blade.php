@extends('layouts.student')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Notifikasi</h3>
                    @if($notifications->where('is_read', false)->count() > 0)
                    <div class="card-tools">
                        <button class="btn btn-sm btn-primary" onclick="markAllRead()">
                            Tandai Semua Dibaca
                        </button>
                    </div>
                    @endif
                </div>
                <div class="card-body">
                    @if($notifications->count() > 0)
                        @foreach($notifications as $notification)
                        <div class="alert {{ $notification->is_read ? 'alert-light' : 'alert-info' }} d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="alert-heading">{{ $notification->title }}</h6>
                                <p class="mb-1">{{ $notification->message }}</p>
                                <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                            </div>
                            @if(!$notification->is_read)
                            <button class="btn btn-sm btn-outline-primary" onclick="markAsRead({{ $notification->id }})">
                                Tandai Dibaca
                            </button>
                            @endif
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Tidak ada notifikasi</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function markAsRead(id) {
    fetch(`/student/notifications/${id}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    }).then(() => {
        location.reload();
    });
}

function markAllRead() {
    // Implementation for marking all as read
    location.reload();
}
</script>
@endsection