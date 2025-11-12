<?php

namespace App\Http\Controllers;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Schema;

use Illuminate\Http\Request;

class penjualController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $penjual = $user->penjual; // pastikan relasi ada

        // (Opsional) kalau profil penjual belum dibuat
        if (!$penjual) {
            return redirect()->route('penjual.profile.edit')
                ->with('success', 'Lengkapi profil penjual terlebih dahulu.');
        }
        $totalProduk = Produk::where('penjual_id', $penjual->id)->count();

        // === TOTAL PESANAN yang mengandung produk milik penjual ini ===
        $totalPesanan = Pesanan::whereHas('items.produk', function ($q) use ($penjual) {
            $q->where('penjual_id', $penjual->id);
        })->count();


        return view('penjual.dashboard', compact(
            'totalProduk',
            'totalPesanan',
        ));
    }

    public function Penjual()
    {
        return view('penjual.dashboard');
    }
}
