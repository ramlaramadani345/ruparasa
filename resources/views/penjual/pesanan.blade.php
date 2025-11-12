@extends('penjual.master')

@section('konten')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Konfirmasi Pesanan</h1>

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
                    <th>User</th>
                    <th>Total (Rp)</th>
                    <th>Ongkir (Rp)</th>
                    {{-- <th>Metode Pembayaran</th>  --}} {{-- DIHAPUS --}}
                    <th>Status</th>
                    <th>Item Pesanan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- TIDAK ADA MERGE LAGI: gunakan $pesanan langsung --}}
                @if($pesanan->isEmpty())
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            Belum ada pesanan untuk saat ini.
                        </td>
                    </tr>
                @else
                    @foreach($pesanan as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->user->name ?? '-' }}</td>
                            <td class="text-right">{{ number_format($p->total,0,',','.') }}</td>
                            <td class="text-right">{{ number_format($p->ongkir,0,',','.') }}</td>
                            {{-- <td>{{ strtoupper($p->metode_pembayaran) }}</td> --}} {{-- DIHAPUS --}}
                            <td>
                                @switch($p->status)
                                    @case('dikemas') <span class="badge badge-warning">Dikemas</span> @break
                                    @case('dikirim') <span class="badge badge-primary">Dikirim</span> @break
                                    @case('selesai') <span class="badge badge-success">Selesai</span> @break
                                    @default <span class="badge badge-secondary">{{ ucfirst($p->status) }}</span>
                                @endswitch
                            </td>

                            {{-- Item Pesanan tanpa bullet --}}
                            <td class="text-left">
                                @foreach($p->items as $item)
                                    <div>{{ $item->produk->nama_produk }} x {{ $item->jumlah }}</div>
                                @endforeach
                            </td>

                            <td>
                                <form action="{{ route('penjual.updateStatus', $p->id) }}" method="POST">
                                    @csrf
                                    <select name="status" class="form-control form-control-sm mb-1">
                                        <option value="dikemas" {{ $p->status == 'dikemas' ? 'selected' : '' }}>Dikemas</option>
                                        <option value="dikirim" {{ $p->status == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                            
                                    </select>
                                    <button type="submit" class="btn btn-primary btn-sm btn-block">Update</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
