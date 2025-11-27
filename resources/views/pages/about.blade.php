@extends('layouts.app')

@section('content')
<section style="padding-top: 100px; min-height: 80vh;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center mb-5">About Us</h1>
                <div class="row">
                    <div class="col-lg-6">
                        <h3>E-Mading SMK Bakti Nusantara 666</h3>
                        <p>Selamat datang di website E-Magazine SMK Bakti Nusantara 66</p>
                        <p> E-Mading ini di buat agar masyarakat smk baknus 666 ini terutama murid bisa melihat kegiatan, pengumuman, prestasi maupun lomba yang ada di smk bakti nusantara 666 ini</p>
                    </div>
                    <div class="col-lg-6">
                        <img src="{{ asset('images/smk.jpg') }}" class="img-fluid rounded" alt="About Us">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

