@extends('admin.master')

@section('konten')
    <div class="container mt-5">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">📖 Detail Cerita</h4>
                <a href="{{ route('cerita.index') }}" class="btn btn-light btn-sm">Kembali</a>
            </div>

            <div class="card-body">
                <h5 class="fw-bold mb-3">{{ $cerita->judul }}</h5>

                <p><strong>Isi Cerita:</strong></p>
                <div class="text-muted" style="line-height: 1.8;">
                    {!! $cerita->isi_cerita ?? 'Tidak ada isi cerita.' !!}
                </div>


                @if ($cerita->gambar)
                    <hr>
                    <p><strong>Gambar Cerita:</strong></p>
                    <img src="{{ asset('storage/' . $cerita->gambar) }}" alt="Gambar Cerita" class="img-fluid rounded shadow-sm"
                        style="max-height: 400px; object-fit: cover;">
                @else
                    <p class="text-muted">Tidak ada gambar cerita.</p>
                @endif
            </div>
        </div>
    </div>
@endsection