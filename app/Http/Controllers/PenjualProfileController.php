<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Penjual;

class PenjualProfileController extends Controller
{

    // ==============================
    //  TAMPILKAN HALAMAN EDIT PROFIL
    // ==============================
    public function editProfile()
    {
        $user = Auth::user(); // Data akun
        $penjual = Penjual::where('user_id', $user->id)->first(); // Data toko

        return view('penjual.editprofil', compact('user', 'penjual'));
    }


    // ==================
    //  UPDATE DATA AKUN
    // ==================
    public function updateAkun(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ], [
            'email.unique' => 'Email sudah digunakan!',
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return back()->with('success', 'Data akun berhasil diperbarui!');
    }


    // ======================
    //  UPDATE PROFIL TOKO
    // ======================
    public function updateToko(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'alamat'    => 'nullable|string',
            'kontak'    => 'nullable|string|max:20',
        ]);

        $penjual = Penjual::where('user_id', $user->id)->first();

        if (!$penjual) {
            // Jika belum ada data toko → buat baru
            Penjual::create([
                'user_id'   => $user->id,
                'nama_toko' => $request->nama_toko,
                'alamat'    => $request->alamat,
                'kontak'    => $request->kontak,
            ]);
        } else {
            $penjual->update([
                'nama_toko' => $request->nama_toko,
                'alamat'    => $request->alamat,
                'kontak'    => $request->kontak,
            ]);
        }

        return back()->with('success', 'Profil toko berhasil diperbarui!');
    }


    // =====================
    //  UPDATE PASSWORD
    // =====================
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password'          => 'required',
            'new_password'              => 'required|min:6',
            'new_password_confirmation' => 'required|same:new_password',
        ], [
            'new_password.min' => 'Password baru minimal 6 karakter!',
            'new_password_confirmation.same' => 'Konfirmasi password tidak sama!',
        ]);

        // Cek apakah password lama benar
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama salah!']);
        }

        // Cek apakah password baru sama dengan password lama
        if ($request->current_password === $request->new_password) {
            return back()->withErrors(['new_password' => 'Password baru tidak boleh sama dengan password lama!']);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password berhasil diperbarui!');
    }

    
    public function edit(Request $request)
    {
        $user = $request->user();

        // buat record penjual jika belum ada (sekali saja)
        $penjual = $user->penjual()->firstOrCreate([
            'user_id' => $user->id,
        ], [
            'nama_toko' => $user->name ?? 'Toko Saya',
            'alamat'   => null,
            'kontak'   => null,
        ]);

        return view('penjual.editprofil', compact('penjual'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'nama_toko' => ['required','string','max:255'],
            'alamat'    => ['nullable','string','max:255'],
            'kontak'    => ['nullable','string','max:100'],
        ]);

        $penjual = $request->user()->penjual;
        $penjual->update($data);

        return redirect()
            ->route('penjual.editprofil')
            ->with('success', 'Profil toko berhasil diperbarui.');
    }
}
