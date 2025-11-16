@extends('dashboard.master') {{-- Ganti dengan layout user milikmu --}}

@section('konten')
<style>
    /* 🔸 HEADER DENGAN BACKGROUND GAMBAR */
    .header-agenda {
        background: url('/images/bg-rupa.png') center center/cover no-repeat;
        border-radius: 0 0 20px 20px;
        position: relative;
        overflow: hidden;
        height: 300px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .header-agenda .header-overlay {
        background-color: rgba(222, 215, 215, 0.4);
        padding: 40px;
        border-radius: 15px;
        text-align: center;
    }

    .title-white {
        color: #ffffff;
        text-shadow: 2px 2px 10px rgba(0,0,0,0.7);
        font-weight: bold;
    }

    .subtitle-white {
        color: #ffffff;
        opacity: 0.95;
        text-shadow: 1px 1px 8px rgba(0,0,0,0.5);
    }

    .text-orange {
        color: #f77f00 !important;
    }
</style>

{{-- 🔹 BAGIAN HEADER --}}
<div class="header-agenda">
    <div class="header-overlay">
        <h1 class="title-white mb-2">Galeri Rupa</h1>
        <p class="subtitle-white">Menampilkan karya seni dan budaya dari berbagai daerah</p>
    </div>
</div>

{{-- 🔹 BAGIAN ISI GALERI --}}
<div class="container my-5">
    @if($rupa->isEmpty())
        <p class="text-center text-muted">Belum ada konten rupa yang ditambahkan.</p>
    @else
        <div class="row">
            @foreach($rupa as $rp)
                @php
                    $ext = strtolower(pathinfo($rp->file_path, PATHINFO_EXTENSION));
                    $modalId = 'modalRupa' . $rp->id;
                @endphp

                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center">

                            {{-- PREVIEW --}}
                            @if (in_array($ext, ['jpg', 'jpeg', 'png']))
                                <img src="{{ asset('storage/' . $rp->file_path) }}"
                                    alt="{{ $rp->judul }}"
                                    class="img-fluid rounded mb-3"
                                    style="max-height: 250px; object-fit: cover;">
                            @elseif (in_array($ext, ['mp4', 'mov', 'avi']))
                                <video width="100%" height="250" controls class="rounded mb-3">
                                    <source src="{{ asset('storage/' . $rp->file_path) }}" type="video/mp4">
                                </video>
                            @endif

                            {{-- JUDUL --}}
                            <h5 class="card-title text-orange">{{ $rp->judul }}</h5>

                            {{-- DESKRIPSI --}}
                            <p class="card-text text-muted">{{ Str::limit($rp->deskripsi, 100) }}</p>

                            {{-- TIPE --}}
                            <span class="badge bg-primary mb-3">{{ $rp->tipe }}</span>

                            {{-- 🔸 TOMBOL LIHAT RUPA (dipindahkan ke bawah) --}}
                            <div class="d-grid">
                                <button class="btn btn-warning"
                                        data-bs-toggle="modal"
                                        data-bs-target="#{{ $modalId }}">
                                    Lihat Rupa
                                </button>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- 🔹 MODAL POPUP --}}
                <div class="modal fade" id="{{ $modalId }}" tabindex="-1">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title">{{ $rp->judul }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body text-center">

                                @if (in_array($ext, ['jpg', 'jpeg', 'png']))
                                    <img src="{{ asset('storage/' . $rp->file_path) }}"
                                        alt="{{ $rp->judul }}"
                                        class="img-fluid rounded"
                                        style="max-height: 500px; object-fit: contain;">
                                @elseif (in_array($ext, ['mp4', 'mov', 'avi']))
                                    <video width="100%" controls class="rounded">
                                        <source src="{{ asset('storage/' . $rp->file_path) }}" type="video/mp4">
                                    </video>
                                @endif

                                <p class="mt-3 text-muted">{{ $rp->deskripsi }}</p>

                            </div>

                        </div>
                    </div>
                </div>

            @endforeach
        </div>
    @endif
</div>

@endsection
