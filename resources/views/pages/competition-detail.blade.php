@extends('layouts.app')

@section('title', $competition->title)

@section('content')
<!-- Article Header -->
<section class="py-5 bg-light" style="margin-top: 70px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center bg-transparent">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('competitions') }}">Lomba</a></li>
                        <li class="breadcrumb-item active">{{ Str::limit($competition->title, 30) }}</li>
                    </ol>
                </nav>
                
                <div class="mb-3">
                    <span class="badge {{ $competition->type == 'internal' ? 'badge-primary' : 'badge-success' }} mr-2">
                        {{ $competition->type == 'internal' ? 'Lomba Sekolah' : 'Lomba Eksternal' }}
                    </span>
                    <span class="badge badge-{{ $competition->status == 'upcoming' ? 'info' : ($competition->status == 'ongoing' ? 'warning' : 'secondary') }}">
                        @if($competition->status == 'upcoming')
                            Akan Datang
                        @elseif($competition->status == 'ongoing')
                            Sedang Berlangsung
                        @else
                            Selesai
                        @endif
                    </span>
                </div>
                
                <h1 class="display-4 mb-4">{{ $competition->title }}</h1>
                
                <div class="article-meta text-muted">
                    <span class="mr-3">
                        <i class="fa fa-calendar"></i> {{ $competition->formatted_competition_date }}
                    </span>
                    @if($competition->organizer)
                    <span class="mr-3">
                        <i class="fa fa-user"></i> {{ $competition->organizer }}
                    </span>
                    @endif
                    @if($competition->registration_deadline)
                    <span class="text-danger">
                        <i class="fa fa-clock-o"></i> Deadline: {{ $competition->formatted_registration_deadline }}
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Article Content -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <article class="card border-0 shadow-sm">
                    @if($competition->image_path)
                    <img src="{{ asset($competition->image_path) }}" class="card-img-top" alt="{{ $competition->title }}" style="height: 400px; object-fit: cover;">
                    @endif
                    
                    <div class="card-body p-5">
                        <div class="article-content">
                            <h3 class="h4 mb-4">Deskripsi Lomba</h3>
                            <div class="lead mb-4">{{ $competition->description }}</div>
                            
                            @if($competition->requirements)
                            <h3 class="h4 mb-3 mt-5">Persyaratan Peserta</h3>
                            <div class="requirements-content">
                                {!! nl2br(e($competition->requirements)) !!}
                            </div>
                            @endif
                            
                            @if($competition->prizes)
                            <h3 class="h4 mb-3 mt-5">Hadiah Pemenang</h3>
                            <div class="prizes-content">
                                {!! nl2br(e($competition->prizes)) !!}
                            </div>
                            @endif
                        </div>
                    </div>
                </article>
                
                <!-- Navigation -->
                <div class="mt-4 d-flex justify-content-between">
                    <a href="{{ route('competitions') }}" class="btn btn-outline-secondary">
                        <i class="fa fa-arrow-left"></i> Kembali ke Daftar Lomba
                    </a>
                    
                    @if($competition->status == 'upcoming')
                    <a href="#" class="btn btn-primary">
                        <i class="fa fa-edit"></i> Daftar Sekarang
                    </a>
                    @endif
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="sticky-top" style="top: 100px;">
                    <!-- Competition Info -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fa fa-info-circle"></i> Informasi Lomba</h5>
                        </div>
                        <div class="card-body">
                            <div class="info-item mb-3">
                                <strong class="d-block text-muted small">TANGGAL LOMBA</strong>
                                <span>{{ $competition->formatted_competition_date }}</span>
                            </div>
                            
                            @if($competition->registration_deadline)
                            <div class="info-item mb-3">
                                <strong class="d-block text-muted small">BATAS PENDAFTARAN</strong>
                                <span class="text-danger">{{ $competition->formatted_registration_deadline }}</span>
                            </div>
                            @endif
                            
                            @if($competition->organizer)
                            <div class="info-item mb-3">
                                <strong class="d-block text-muted small">PENYELENGGARA</strong>
                                <span>{{ $competition->organizer }}</span>
                            </div>
                            @endif
                            
                            @if($competition->contact_person)
                            <div class="info-item mb-3">
                                <strong class="d-block text-muted small">KONTAK PERSON</strong>
                                <span>{{ $competition->contact_person }}</span>
                            </div>
                            @endif
                            
                            <div class="info-item">
                                <strong class="d-block text-muted small">STATUS</strong>
                                <span class="badge badge-{{ $competition->status == 'upcoming' ? 'info' : ($competition->status == 'ongoing' ? 'warning' : 'secondary') }}">
                                    @if($competition->status == 'upcoming')
                                        Akan Datang
                                    @elseif($competition->status == 'ongoing')
                                        Sedang Berlangsung
                                    @else
                                        Selesai
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Share Article -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-secondary text-white">
                            <h6 class="mb-0"><i class="fa fa-share-alt"></i> Bagikan</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-around">
                                <a href="#" class="btn btn-outline-primary btn-sm">
                                    <i class="fa fa-facebook"></i>
                                </a>
                                <a href="#" class="btn btn-outline-info btn-sm">
                                    <i class="fa fa-twitter"></i>
                                </a>
                                <a href="#" class="btn btn-outline-success btn-sm">
                                    <i class="fa fa-whatsapp"></i>
                                </a>
                                <a href="#" class="btn btn-outline-secondary btn-sm">
                                    <i class="fa fa-link"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection