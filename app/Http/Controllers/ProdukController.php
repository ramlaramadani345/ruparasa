<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    // 🔹 Tampilkan semua produk di dashboard penjual
    // public function index()
    // {
    //     /** @var \App\Models\User $user */
    //     $user = Auth::user();

    //     if (!$user->penjual) {
    //         return redirect()->back()->with('error', 'Akun penjual belum terdaftar.');
    //     }

    //     $produks = Produk::where('penjual_id', $user->penjual->id)->get();
    //     return view('penjual.lihatproduk', compact('produks'));
    // }

//     public function index()
// {
//     // Tampilkan semua produk tanpa login
//     $produks = Produk::all(); // atau filter tertentu jika mau
//     return view('penjual.lihatproduk', compact('produks'));
// }
public function index()
{
    $penjual = auth()->user()->penjual; // pastikan profil penjual ada
    $produks = Produk::where('penjual_id', $penjual->id)
        ->orderBy('created_at', 'desc')
        ->get();

    return view('penjual.lihatproduk', compact('produks'));
}


    // 🔹 Tampilkan form tambah produk
    public function create()
    {
        return view('penjual.tambahproduk');
    }

    // 🔹 Simpan data produk ke database
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'deskripsi'   => 'required|string',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->penjual) {
            return back()->with('error', 'Akun penjual belum terdaftar di sistem.');
        }

        $path = $request->hasFile('gambar')
            ? $request->file('gambar')->store('gambar_produk', 'public')
            : null;

        Produk::create([
            'penjual_id'   => $user->penjual->id,
            'nama_produk'  => $request->nama_produk,
            'harga'        => $request->harga,
            'stok'         => $request->stok,
            'deskripsi'    => $request->deskripsi,
            'gambar'       => $path,
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    // 🔹 Edit Produk
    public function edit($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $produk = Produk::where('id', $id)
                        ->where('penjual_id', $user->penjual->id)
                        ->firstOrFail();

        return view('penjual.editproduk', compact('produk'));
    }

    // 🔹 Update Produk
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'deskripsi'   => 'required|string',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $produk = Produk::where('id', $id)
                        ->where('penjual_id', $user->penjual->id)
                        ->firstOrFail();

        $data = $request->only(['nama_produk', 'harga', 'stok', 'deskripsi']);

        // Upload gambar baru jika ada
        if ($request->hasFile('gambar')) {
            if ($produk->gambar && Storage::exists('public/' . $produk->gambar)) {
                Storage::delete('public/' . $produk->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('gambar_produk', 'public');
        }

        $produk->update($data);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');
    }

    // 🔹 Hapus Produk
    public function destroy($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $produk = Produk::where('id', $id)
                        ->where('penjual_id', $user->penjual->id)
                        ->firstOrFail();

        if ($produk->gambar && Storage::exists('public/' . $produk->gambar)) {
            Storage::delete('public/' . $produk->gambar);
        }

        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');
    }

    public function show($id)
{
    $produk = Produk::findOrFail($id);
    return view('penjual.detailProduk', compact('produk'));
}

}
