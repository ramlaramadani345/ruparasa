<?php

namespace App\Http\Controllers;

use App\Models\Cerita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CeritaController extends Controller
{
    // ================= ADMIN =================
    public function index()
    {
        $ceritas = Cerita::with('user')->get();
        return view('admin.lihatCerita', compact('ceritas'));
    }


    public function create()
    {
        return view('admin.tambahCerita');
    }

    public function store(Request $request)
    {
        // === Validasi manual seperti di RupaController ===
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'isi_cerita' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'judul.required' => 'Judul tidak boleh kosong.',
            'judul.max' => 'Judul maksimal 255 karakter.',
            'isi_cerita.required' => 'Isi cerita tidak boleh kosong.',
            'gambar.image' => 'File gambar harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
            'gambar.max' => 'Ukuran gambar maksimal 2 MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator) // kirim pesan error
                ->withInput(); // kembalikan input sebelumnya
        }

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('cerita_images', 'public');
        }

        Cerita::create([
            'judul' => $request->judul,
            'isi_cerita' => $request->isi_cerita,
            'gambar' => $gambarPath,
            'status' => 'diterima',
        ]);

        return redirect()->route('cerita.index')
            ->with('success', '✅ Cerita berhasil dibuat oleh admin.');
    }

    public function edit($id)
    {
        $cerita = Cerita::findOrFail($id);
        return view('admin.editCerita', compact('cerita'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'isi_cerita' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'judul.required' => 'Judul wajib diisi.',
            'isi_cerita.required' => 'Isi cerita wajib diisi.',
            'gambar.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
            'gambar.max' => 'Ukuran gambar maksimal 2 MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $cerita = Cerita::findOrFail($id);

        if ($request->hasFile('gambar')) {
            if ($cerita->gambar) {
                Storage::disk('public')->delete($cerita->gambar);
            }
            $gambarPath = $request->file('gambar')->store('cerita_images', 'public');
            $cerita->gambar = $gambarPath;
        }

        $cerita->update([
            'judul' => $request->judul,
            'isi_cerita' => $request->isi_cerita,
        ]);

        return redirect()->route('cerita.index')
            ->with('success', '✅ Cerita berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $cerita = Cerita::findOrFail($id);
        if ($cerita->gambar) {
            Storage::disk('public')->delete($cerita->gambar);
        }
        $cerita->delete();

        return redirect()->back()->with('success', '✅ Cerita berhasil dihapus.');
    }

    public function lihatStatus()
    {
        $ceritas = Cerita::with('user')->get();
        return view('admin.lihatStatus', compact('ceritas'));
    }

    public function ubahStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:menunggu,diterima,ditolak',
        ], [
            'status.required' => 'Status harus dipilih.',
            'status.in' => 'Status tidak valid.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        $cerita = Cerita::findOrFail($id);
        $cerita->update(['status' => $request->status]);

        return redirect()->back()
            ->with('success', '✅ Status cerita berhasil diperbarui.');
    }

    public function show($id)
{
    $cerita = Cerita::findOrFail($id);
    return view('admin.detailCerita', compact('cerita'));
}

    // ================= USER =================
    public function userCreate()
    {
        return view('dashboard.tambahCerita');
    }

    public function userStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'isi_cerita' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'judul.required' => 'Judul tidak boleh kosong.',
            'judul.max' => 'Judul maksimal 255 karakter.',
            'isi_cerita.required' => 'Isi cerita tidak boleh kosong.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
            'gambar.max' => 'Ukuran gambar maksimal 2 MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('cerita_images', 'public');
        }

        Cerita::create([
            'user_id' => Auth::id(),
            'judul' => $request->judul,
            'isi_cerita' => $request->isi_cerita,
            'gambar' => $gambarPath,
            'status' => 'menunggu',
        ]);

        return redirect()->route('cerita.userIndex')
            ->with('success', '✅ Cerita berhasil dikirim! Menunggu persetujuan admin.');
    }

    public function userIndex()
    {
        // hanya tampilkan cerita yang sudah diterima admin
        $ceritas = Cerita::where('status', 'diterima')->with('user')->get();
        return view('dashboard.Cerita', compact('ceritas'));
    }

public function userShow($id)
{
    $cerita = Cerita::findOrFail($id);

    return view('dashboard.detailcerita', compact('cerita'));
}

}
