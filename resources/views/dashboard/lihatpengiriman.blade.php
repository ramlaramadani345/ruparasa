@extends('dashboard.master')

@section('konten')
<div class="container my-5">

    {{-- Bagian Header + Tombol Kembali --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-orange fw-bold mb-0">Pesanan Saya</h2>
    </div>

    {{-- Cek Data Pesanan --}}
    @forelse($pesanan as $p)
    <div class="card mb-3 shadow-sm">
        <div class="card-header fw-bold">
            Pesanan #{{ $p->id }}
            <span class="float-end">
                Total: Rp {{ number_format($p->items->sum(fn($i) => $i->harga * $i->jumlah) + 10000,0,',','.') }}
            </span>
        </div>
        <div class="card-body">
            <ul>
                @foreach($p->items as $item)
                <li>{{ $item->produk->nama_produk }} x {{ $item->jumlah }}</li>
                @endforeach
            </ul>

            <p>Status: <span class="fw-bold text-orange">{{ ucfirst($p->status) }}</span></p>

            {{-- Tombol Terima --}}
@if($p->status === 'dikirim')
    <form id="form-terima-{{ $p->id }}" action="{{ route('pesanan.terima', $p->id) }}" method="POST">
        @csrf
        <button type="button" class="btn btn-success mt-2" onclick="konfirmasiTerima({{ $p->id }})">
            <i class="fas fa-check"></i> Pesanan Diterima
        </button>
    </form>
@elseif($p->status === 'selesai') {{-- ganti dari 'diterima' jika enum = 'selesai' --}}
    <span class="badge bg-success mt-2 p-2">Pesanan Selesai</span>
@endif
        </div>
    </div>
    @empty
    <p class="text-muted text-center py-4">Belum ada pengiriman.</p>
    @endforelse
</div>
@endsection

{{-- ====== STYLE SECTION ====== --}}
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

body, h1, h2, h3, h4, h5, h6, p, button, input, textarea {
    font-family: 'Inter', sans-serif !important;
}

/* 🔸 Warna utama */
.text-orange { color: #f77f00 !important; }

.btn-orange {
    background-color: #f77f00 !important;
    color: black !important;
    border: none;
    border-radius: 8px;
    padding: 8px 16px;
    font-weight: 600;
    transition: all 0.3s ease;
}
.btn-orange:hover {
    background-color: #ff8c1a !important;
    color: black !important;
}

/* 🔹 Card Style */
.card {
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid #eee;
}
.card-header {
    background-color: #fffaf5;
    color: #333;
}
</style>

{{-- ====== SCRIPT SECTION ====== --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function konfirmasiTerima(id) {
    Swal.fire({
        title: 'Konfirmasi Penerimaan',
        text: 'Pastikan pesanan Anda sudah diterima dengan baik sebelum menekan tombol ini.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, pesanan sudah diterima',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('form-terima-' + id).submit();
        }
    });
}
</script>
