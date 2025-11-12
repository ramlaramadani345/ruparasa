@extends('penjual.master')

@section('konten')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Daftar Pesanan</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered text-center">
            <thead class="thead-light">
                <tr>
                    <th>No</th>
                    <th>Nomor Pesanan</th>
                    <th>Total (Rp)</th>
                    <th>Ongkir (Rp)</th>
                    <th>Status</th>
                    <th>Item Pesanan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pesanan as $index => $p)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>#{{ $p->id }}</td>
                        <td class="text-right">{{ number_format($p->total,0,',','.') }}</td>
                        <td class="text-right">{{ number_format($p->ongkir,0,',','.') }}</td>
                        <td>
                            @if($p->status == 'menunggu_konfirmasi')
                                <span class="badge badge-secondary">Menunggu Konfirmasi</span>
                            @elseif($p->status == 'dikemas')
                                <span class="badge badge-warning">Dikemas</span>
                            @elseif($p->status == 'dikirim')
                                <span class="badge badge-primary">Dikirim</span>
                            @elseif($p->status == 'selesai')
                                <span class="badge badge-success">Selesai</span>
                            @else
                                <span class="badge badge-secondary">{{ ucfirst($p->status) }}</span>
                            @endif
                        </td>
                        <td class="text-left">
                            <ul class="mb-0">
                                @foreach($p->items as $item)
                                    <li>{{ $item->produk->nama_produk }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            <form action="{{ route('pesanan.hapus', $p->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pesanan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Belum ada pesanan dikirim.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
