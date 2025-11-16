@extends('dashboard.master')

@section('konten')
<!-- 🟧 HEADER DENGAN GAMBAR LATAR -->
<div class="header-resep text-center py-5 mb-5">
    <div class="header-overlay">
        <h1 class="fw-bold text-uppercase mb-2 title-white">Kumpulan Resep Makanan Khas Sulawesi</h1>
        <p class="mb-0 subtitle-white">Menemukan cita rasa khas dari berbagai daerah di Pulau Sulawesi</p>
    </div>
</div>

<div class="container py-5" style="font-family: 'Inter', sans-serif;">

    {{-- Alert jika berhasil --}}
    @if (session('success'))
        <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Header -->
    <div class="row mb-4">
        <div class="col-lg-6">
            <h2 class="fw-bold text-orange text-uppercase">Daftar Resep</h2>
        </div>
    </div>

    <!-- 🥘 Daftar Kartu Resep -->
    <div class="row">
        @forelse($reseps as $resep)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0">

                    {{-- Gambar --}}
                    @if($resep->gambar)
                        <img src="{{ asset('storage/' . $resep->gambar) }}" class="card-img-top" alt="{{ $resep->nama_rasa }}" style="height: 220px; object-fit: cover;">
                    @else
                        <img src="{{ asset('assets/images/default-resep.jpg') }}" class="card-img-top" alt="Default" style="height: 220px; object-fit: cover;">
                    @endif

                    <div class="card-body d-flex flex-column">

                        <h5 class="card-title fw-bold text-orange">{{ $resep->nama_rasa }}</h5>

                        {{-- Provinsi --}}
                        @if(!empty($resep->provinsi_asal))
                            <p class="text-muted mb-2">
                                <i class="bi bi-geo-alt-fill text-orange"></i> {{ $resep->provinsi_asal }}
                            </p>
                        @endif


                        {{-- Tombol --}}
                        <a href="{{ route('rasa.show', $resep->id) }}" 
                           class="btn btn-outline-orange mt-auto rounded-pill">Lihat Resep</a>

                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted py-4">
                <p>Belum ada resep yang tersedia.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-3">
        {{ $reseps->links() }}
    </div>

    <div class="text-center mt-4">
        <a href="{{ url('/') }}" class="btn btn-outline-orange rounded-pill px-4 py-2">Kembali ke Beranda</a>
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
    position: relative;
    overflow: hidden;
    height: 300px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.header-resep .header-overlay {
    background-color: rgba(220, 212, 212, 0.45);
    padding: 40px;
    border-radius: 15px;
}

.title-white {
    color: #ffffff;
    text-shadow: 2px 2px 10px rgba(0,0,0,0.7);
}

.subtitle-white {
    color: #ffffff;
    opacity: 0.95;
    text-shadow: 1px 1px 8px rgba(0,0,0,0.5);
}

.text-orange { color: #f77f00 !important; }

.btn-orange {
    background-color: #f77f00;
    color: #fff;
    border: none;
}
.btn-orange:hover { background-color: #e56e00; color: #fff; }

.btn-outline-orange {
    border: 1px solid #f77f00;
    color: #f77f00;
    background: transparent;
}
.btn-outline-orange:hover {
    background-color: #f77f00;
    color: #fff;
}
</style>

@endsection
