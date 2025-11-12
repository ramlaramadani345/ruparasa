<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Pesanan;
use App\Models\PesananItem;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    // ======================
    // USER SECTION
    // ======================

    // Tambah produk ke "keranjang"
    public function beli(Request $request, $produk_id)
    {
        $produk = Produk::findOrFail($produk_id);
        $jumlah = $request->jumlah ?? 1;

        // Buat / ambil pesanan aktif (status dikemas)
        $pesanan = Pesanan::firstOrCreate(
            ['user_id' => Auth::id(), 'status' => 'dikemas'],
            ['total' => 0, 'ongkir' => 0]
        );

        // Tambah atau update item
        PesananItem::updateOrCreate(
            ['pesanan_id' => $pesanan->id, 'produk_id' => $produk_id],
            ['jumlah' => $jumlah, 'harga' => $produk->harga]
        );

        return redirect()->route('pesanan.index')->with('success', 'Produk ditambahkan ke pesanan.');
    }

    // Halaman daftar pesanan (keranjang)
    public function index()
    {
        $pesanan = Pesanan::with('items.produk')
            ->where('user_id', Auth::id())
            ->where('status', 'dikemas')
            ->first();

        return view('dashboard.pesanan', compact('pesanan'));
    }

    // Update jumlah item
    public function updateItem(Request $request, $item_id)
    {
        $item = PesananItem::findOrFail($item_id);
        $item->jumlah = $request->jumlah;
        $item->save();

        return redirect()->back();
    }

    // Checkout (langsung dikemas karena hanya COD)
    public function checkout(Request $request)
    {
        $pesanan = Pesanan::with('items')
            ->where('user_id', Auth::id())
            ->where('status', 'dikemas')
            ->firstOrFail();

        $pesanan->ongkir = 10000;
        $pesanan->total = $pesanan->items->sum(fn($i) => $i->harga * $i->jumlah) + $pesanan->ongkir;
        $pesanan->status = 'dikemas'; // tetap 'dikemas'
        $pesanan->save();

        return redirect()->route('pesanan.pembayaran', $pesanan->id);
    }

    // Halaman pembayaran (hanya info COD)
    public function pembayaran($pesanan_id)
    {
        $pesanan = Pesanan::with('items.produk')->findOrFail($pesanan_id);
        return view('dashboard.pembayaran', compact('pesanan'));
    }

    // Konfirmasi COD
    public function bayar(Request $request, $pesanan_id)
    {
        $pesanan = Pesanan::with('items')->findOrFail($pesanan_id);

        $pesanan->status = 'dikemas';
        $pesanan->ongkir = 10000;
        $pesanan->total = $pesanan->items->sum(fn($i) => $i->harga * $i->jumlah) + $pesanan->ongkir;
        $pesanan->save();

        return redirect()->route('pesananuser.lihat')->with('success', 'Pesanan berhasil dibuat (COD).');
    }

    // Lihat status pengiriman
    public function lihatPengiriman()
    {
        $pesanan = Pesanan::with('items.produk')
            ->where('user_id', Auth::id())
            ->whereIn('status', ['dikemas', 'dikirim', 'selesai'])
            ->get();

        return view('dashboard.lihatpengiriman', compact('pesanan'));
    }

    // ======================
    // PENJUAL SECTION
    // ======================

    // Daftar pesanan penjual
public function penjualPesanan()
{
    $pesanan = Pesanan::with(['items.produk','user'])
        ->whereHas('items.produk.penjual', function ($q) {
            $q->where('user_id', auth()->id());
        })
        // tampilkan yang belum selesai
        ->whereIn('status', ['menunggu_konfirmasi','dikemas','dikirim'])
        ->orderByDesc('id')
        ->get();

    return view('penjual.pesanan', compact('pesanan'));
}

public function penjualPesananSelesai()
{
    $pesanan = Pesanan::with(['items.produk','user'])
        ->whereHas('items.produk.penjual', function ($q) {
            $q->where('user_id', auth()->id()); // <- perbaiki named arg
        })
        ->where('status', 'selesai')
        ->orderBy('id', 'asc')->get();

    return view('penjual.lihatpesanan', compact('pesanan'));
}


    // Update status (penjual)
    public function penjualUpdateStatus(Request $request, $pesanan_id)
    {
        $request->validate([
            'status' => 'required|in:dikemas,dikirim,selesai'
        ]);

        $pesanan = Pesanan::findOrFail($pesanan_id);
        $pesanan->status = $request->status;
        $pesanan->save();

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    // Hapus pesanan
    public function destroy($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->delete();

        return redirect()->back()->with('success', 'Pesanan berhasil dihapus.');
    }

    // User menandai pesanan selesai
public function terimaPesanan($id)
{
    $pesanan = Pesanan::with('items')
        ->where('user_id', auth()->id())
        ->where('status','dikirim')
        ->findOrFail($id);

    $pesanan->status = 'selesai'; // ← penting: tandai selesai
    $pesanan->save();

    // kembali ke halaman user (Pesanan Saya)
    return back()->with('success', 'Terima kasih! Pesanan telah ditandai selesai.');
}
    // Penjual lihat semua pesanan
    public function lihat()
{
    $pesanan = Pesanan::with(['items.produk'])
        ->whereHas('items.produk.penjual', function ($q) {
            $q->where('user_id', auth()->id());
        })
        ->whereIn('status', ['dikemas','dikirim','selesai'])
        ->orderByDesc('id')
        ->get();

    return view('penjual.lihatpesanan', compact('pesanan'));
}
}
