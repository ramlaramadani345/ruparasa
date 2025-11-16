@extends('dashboard.master')

@section('konten')
    <!-- 🟧 HEADER DENGAN GAMBAR LATAR -->
    <div class="header-cerita text-center py-5 mb-5">
        <div class="header-overlay">
            <h1 class="fw-bold text-uppercase mb-2 title-white">Kumpulan Cerita Inspiratif</h1>
            <p class="mb-0 subtitle-white">Berbagi pengalaman dan kisah menarik dari semua pengguna</p>
        </div>
    </div>

    <div class="container py-5" style="font-family: 'Inter', sans-serif;">
        <!-- 🧡 Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-orange text-uppercase">📝 Cerita Masyarakat</h2>
            <a href="{{ route('cerita.userCreate') }}" class="btn btn-orange rounded-pill px-4">
                ➕ Tambah Cerita
            </a>
        </div>

        @if($ceritas->isEmpty())
            <div class="alert alert-info text-center shadow-sm">Belum ada cerita.</div>
        @else
            <div class="row">
                @foreach($ceritas as $c)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card shadow-sm border-orange h-100 hover-card">
                            @if($c->gambar)
                                <img src="{{ asset('storage/' . $c->gambar) }}" class="card-img-top" alt="Gambar Cerita"
                                    style="height: 200px; object-fit: cover;">
                            @endif
                            <div class="card-body text-center">
                                <h5 class="card-title fw-bold text-orange">{{ $c->judul }}</h5>
                                <p class="card-text text-muted">{{ Str::limit(strip_tags($c->isi_cerita), 120) }}</p>
                                <p class="small text-muted">
                                    <i class="bi bi-person-circle"></i> {{ $c->user->name ?? 'Anonim' }}
                                </p>
                            </div>
                            <div class="card-footer bg-light text-center">
                                <a href="{{ route('cerita.userShow', $c->id) }}" class="btn btn-outline-orange rounded-pill px-3">
                                    📖 Lihat Detail
                                </a>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- 🧩 Style -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        body,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        button,
        input,
        textarea {
            font-family: 'Inter', sans-serif !important;
        }

        /* 🟧 HEADER DENGAN GAMBAR */
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
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.7);
        }

        .subtitle-white {
            color: #ffffff;
            opacity: 0.95;
            text-shadow: 1px 1px 8px rgba(0, 0, 0, 0.5);
        }

        /* 🟧 WARNA UTAMA */
        .text-orange {
            color: #f77f00 !important;
        }

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
            /* tetap oranye saat hover */
            color: #fff;
        }

        .btn-outline-orange {
            border: 2px solid #f77f00;
            color: #f77f00;
            background: transparent;
        }

        .btn-outline-orange:hover {
            background-color: transparent;
            /* tidak berubah warna */
            color: #f77f00;
            border-color: #f77f00;
        }

        /* 🟧 EFEK KARTU */
        .hover-card {
            transition: all 0.3s ease;
        }

        .hover-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }
    </style>
@endsection