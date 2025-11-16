@extends('dashboard.master')

@section('konten')

<!-- 🟧 HEADER DENGAN GAMBAR LATAR – SAMA SEPERTI HALAMAN CERITA -->
<div class="header-cerita text-center py-5 mb-5">
    <div class="header-overlay">
        <h1 class="fw-bold text-uppercase mb-2 title-white">{{ $cerita->judul }}</h1>
        <p class="mb-0 subtitle-white">Cerita inspiratif dari masyarakat</p>
    </div>
</div>

<div class="container py-5">

    <div class="card shadow-lg border-orange">
        
        @if($cerita->gambar)
            <img src="{{ asset('storage/' . $cerita->gambar) }}"
                 class="card-img-top"
                 alt="Gambar Cerita"
                 style="height: 350px; object-fit: cover;">
        @endif

        <div class="card-body">
            <h2 class="fw-bold text-orange mb-3">{{ $cerita->judul }}</h2>

            <p class="text-muted">
                <i class="bi bi-person-circle"></i>
                {{ $cerita->user->name ?? 'Anonim' }}
            </p>

            <hr>

            <p style="font-size: 18px; line-height: 1.8;">
                {!! $cerita->isi_cerita !!}
            </p>

            <a href="{{ route('cerita.userIndex') }}" class="btn btn-orange mt-4">⬅ Kembali ke Daftar Cerita</a>
        </div>
    </div>

</div>

<!-- 🧩 STYLE (SAMA PERSIS DENGAN HALAMAN CERITA) -->
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

body, h1, h2, h3, h4, h5, h6, p, button, input, textarea {
    font-family: 'Inter', sans-serif !important;
}

/* 🟧 HEADER */
.header-cerita {
    background: url('/images/bg-cerita.png') center center/cover no-repeat;
    border-radius: 0 0 20px 20px;
    position: relative;
    overflow: hidden;
    height: 300px;
    display: flex;
    justify-content: center;
    align-items: center;
}
.header-cerita .header-overlay {
    background-color: rgba(0, 0, 0, 0.45);
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

/* 🟧 WARNA UTAMA */
.text-orange { color: #f77f00 !important; }

/* 🟧 BORDER KARTU */
.border-orange {
    border: 2px solid #f77f00 !important;
}

/* 🟧 TOMBOL */
.btn-orange {
    background-color: #f77f00;
    color: #fff;
    border: none;
}
.btn-orange:hover {
    background-color: #f77f00;
    color: #fff;
}
</style>

@endsection
