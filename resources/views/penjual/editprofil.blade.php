{{-- resources/views/penjual/profile/edit.blade.php --}}
@extends('penjual.master')

@section('konten')

<style>
:root {
  --blue: #1e90ff;        /* biru utama */
  --blue-dark: #0b70d1;   /* biru gelap */
  --profile-bg1: #ffffff; /* sidebar tidak biru */
  --profile-bg2: #f4f4f4;
  --card-shadow: 0 6px 20px rgba(34,34,34,0.08);
  --radius: 14px;
}

.wrap {
  max-width: 980px;
  margin: auto;
  display: grid;
  grid-template-columns: 330px 1fr;
  gap: 25px;
}

.card {
  background: #fff;
  border-radius: var(--radius);
  box-shadow: var(--card-shadow);
  padding: 22px;
}

/* SIDEBAR PROFIL - TIDAK BIRU */
.profile {
  text-align: center;
  background: linear-gradient(180deg, var(--profile-bg1) 0%, var(--profile-bg2) 100%);
}

/* AVATAR BIRU */
.avatar-placeholder {
  width: 110px;
  height: 110px;
  border-radius: 20px;
  background: linear-gradient(135deg, var(--blue), var(--blue-dark));
  color: white;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 38px;
  margin: 20px auto 10px;
}

/* TOMBOL BIRU */
.btn-orange {
  background: linear-gradient(90deg, var(--blue), var(--blue-dark));
  color: #fff;
  border: none;
  border-radius: 10px;
  padding: 10px;
  font-weight: 600;
  width: 100%;
}

/* TEKS BIRU UTAMA (JUDUL – GARIS – HEADING) */
h5, h4, label, .fw-bold, .title-blue {
  color: var(--blue-dark) !important;
}

/* INPUT */
input, textarea {
  border: 1px solid #bcd6ff !important;
}

input:focus, textarea:focus {
  border-color: var(--blue);
  box-shadow: 0 0 4px rgba(30,144,255,0.4);
}

.toggle-password {
  position: absolute;
  right: 12px;
  top: 38px;
  cursor: pointer;
  color: #777;
}


</style>

<div class="container py-4">
  <div class="wrap">

    {{-- SIDEBAR – INFORMASI PENJUAL --}}
    <aside class="card profile">
      <div class="avatar-placeholder">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
      <h4 class="fw-bold">{{ $user->name }}</h4>
      <p class="text-muted">{{ $user->email }}</p>

      <a href="/dashboardpenjual" class="btn btn-outline-secondary w-75 mt-3">
        Kembali
      </a>
    </aside>

    {{-- FORM EDIT --}}
    <main class="card">
      <h5 class="fw-bold mb-3" style="color: var(--orange);">Edit Data Akun</h5>

      {{-- UPDATE DATA AKUN --}}
      <form action="{{ route('penjual.profile.updateAkun') }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
          <label class="form-label">Nama Lengkap</label>
          <input type="text" name="name" class="form-control"
                 value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control"
                 value="{{ old('email', $user->email) }}" required>
        </div>

        <button type="submit" class="btn-orange w-100 mb-4">
          Simpan Perubahan Akun
        </button>
      </form>

      <hr>

      {{-- UPDATE DATA TOKO --}}
      <h5 class="fw-bold mb-3 mt-4" style="color: var(--orange);">Edit Profil Toko</h5>

      <form action="{{ route('penjual.profile.updateToko') }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
          <label class="form-label">Nama Toko</label>
          <input type="text" name="nama_toko" class="form-control"
                 value="{{ old('nama_toko', $penjual->nama_toko) }}" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Alamat Toko</label>
          <input type="text" name="alamat" class="form-control"
                 value="{{ old('alamat', $penjual->alamat) }}">
        </div>

        <div class="mb-3">
          <label class="form-label">Kontak</label>
          <input type="text" name="kontak" class="form-control"
                 value="{{ old('kontak', $penjual->kontak) }}">
        </div>

        <button type="submit" class="btn-orange w-100 mb-4">
          Simpan Perubahan Toko
        </button>
      </form>

      <hr>

      {{-- UPDATE PASSWORD --}}
      <h5 class="fw-bold mb-3 mt-4" style="color: var(--orange);">Ubah Password</h5>

      <form action="{{ route('penjual.profile.updatePassword') }}" method="POST">
        @csrf

        <div class="mb-3 position-relative">
          <label>Password Lama</label>
          <input type="password" name="current_password" class="form-control" required>
        </div>

        <div class="mb-3 position-relative">
          <label>Password Baru</label>
          <input type="password" name="new_password" class="form-control" required>
        </div>

        <div class="mb-3 position-relative">
          <label>Konfirmasi Password Baru</label>
          <input type="password" name="new_password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn-orange w-100">Perbarui Password</button>
      </form>

    </main>

  </div>
</div>

{{-- SWEETALERT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Sukses!',
      text: '{{ session('success') }}',
      confirmButtonColor: ' rgba(30,144,255,0.4)'
    })
  </script>
@endif

@if($errors->any())
  <script>
    Swal.fire({
      icon: "error",
      title: "Terjadi Kesalahan",
      html: `{!! implode('<br>', $errors->all()) !!}`,
      confirmButtonColor: " rgba(30,144,255,0.4)"
    })
  </script>
@endif

@endsection
