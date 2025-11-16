@extends('dashboard.master')

@section('konten')

<!-- 🟧 HEADER DENGAN GAMBAR LATAR -->
<div class="header-resep text-center py-5 mb-5">
    <div class="header-overlay">
        <h1 class="fw-bold text-uppercase mb-2 title-white">{{ $resep->nama_rasa }}</h1>
        <p class="mb-0 subtitle-white">Menemukan cita rasa khas dari {{ $resep->provinsi_asal ?? 'Sulawesi' }}</p>
    </div>
</div>

<div class="container" style="padding-bottom: 60px;">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-sm p-3 border-0 rounded-4">

                {{-- GAMBAR --}}
                @if($resep->gambar)
                    <img src="{{ asset('storage/' . $resep->gambar) }}"
                         class="card-img-top rounded-3 mb-3"
                         alt="{{ $resep->nama_rasa }}"
                         style="object-fit: cover; max-height: 350px;">
                @else
                    <img src="{{ asset('assets/images/default-resep.jpg') }}"
                         class="card-img-top rounded-3 mb-3"
                         alt="Default"
                         style="object-fit: cover; max-height: 350px;">
                @endif

                <div class="card-body">

                    <h2 class="card-title fw-bold text-orange mb-3">
                        {{ $resep->nama_rasa }}
                    </h2>

                    {{-- Provinsi --}}
                    @if(!empty($resep->provinsi_asal))
                        <p class="text-muted">
                            <i class="bi bi-geo-alt-fill text-orange"></i>
                            {{ $resep->provinsi_asal }}
                        </p>
                    @endif

                    {{-- RESEP --}}
                    <h5 class="fw-semibold text-dark mt-4">Resep</h5>
                    <div class="card-text" style="white-space: pre-line;">
                        {!! $resep->resep !!}
                    </div>

                    {{-- SEJARAH --}}
                    <h5 class="fw-semibold text-dark mt-4">Sejarah</h5>
                    <div class="card-text" style="white-space: pre-line;">
                        {!! $resep->sejarah !!}
                    </div>

                    <a href="{{ url()->previous() }}" class="btn btn-outline-orange mt-4 rounded-pill px-4">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 🧩 STYLE -->
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

body, h1, h2, h3, h4, h5, h6, p, button, input, textarea {
    font-family: 'Inter', sans-serif !important;
}

.header-resep {
    background: url('/images/bg-rasa.jpg') center center/cover no-repeat;
    border-radius: 0 0 20px 20px;
    height: 300px;
    display: flex; justify-content: center; align-items: center;
}

.header-overlay {
    background-color: rgba(220, 212, 212, 0.45);
    padding: 40px; border-radius: 15px;
}

.title-white { color: #fff; text-shadow: 2px 2px 10px rgba(0,0,0,.7); }
.subtitle-white { color: #fff; text-shadow: 1px 1px 8px rgba(0,0,0,.5); }

.text-orange { color: #f77f00 !important; }

.btn-outline-orange {
    border: 1px solid #f77f00;
    color: #f77f00;
}
.btn-outline-orange:hover {
    background-color: #f77f00;
    color: white;
}
</style>

@endsection
