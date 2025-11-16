@extends('admin.master')

@section('konten')
<div class="container-fluid">

    <!-- Judul Halaman -->
    <h1 class="h3 mb-4 text-gray-800">Edit Rasa & Resep</h1>

    <!-- Notifikasi -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Terjadi kesalahan!</strong>
            <ul class="mb-0 mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Edit Resep Kuliner Daerah</h6>
                </div>

                <div class="card-body">

                    <form action="{{ route('resep.update', $resep->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Nama Rasa -->
                        <div class="form-group">
                            <label for="nama_rasa">Nama Rasa / Kuliner</label>
                            <input type="text" name="nama_rasa" id="nama_rasa"
                                class="form-control"
                                value="{{ old('nama_rasa', $resep->nama_rasa) }}"
                                required>
                        </div>

                        <!-- Provinsi Asal -->
                        <div class="form-group">
                            <label for="provinsi_asal">Provinsi Asal</label>
                            <select name="provinsi_asal" id="provinsi_asal" class="form-control" required>
                                <option value="">-- Pilih Provinsi Asal --</option>
                                @foreach (['Sulawesi Utara','Gorontalo','Sulawesi Tengah','Sulawesi Barat','Sulawesi Selatan','Sulawesi Tenggara'] as $prov)
                                    <option value="{{ $prov }}" {{ $resep->provinsi_asal == $prov ? 'selected' : '' }}>
                                        {{ $prov }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Resep -->
                        <div class="form-group">
                            <label for="resep">Resep</label>
                            <textarea name="resep" id="resep" rows="5" class="form-control" required>
                                {{ old('resep', $resep->resep) }}
                            </textarea>
                        </div>

                        <!-- Sejarah -->
                        <div class="form-group">
                            <label for="sejarah">Sejarah Kuliner</label>
                            <textarea name="sejarah" id="sejarah" rows="5" class="form-control" required>
                                {{ old('sejarah', $resep->sejarah) }}
                            </textarea>
                        </div>

                        <!-- Gambar -->
                        <div class="form-group">
                            <label for="gambar">Gambar Makanan</label><br>

                            @if ($resep->gambar)
                                <img src="{{ asset('storage/' . $resep->gambar) }}"
                                     width="150"
                                     class="img-thumbnail mb-2">
                            @endif

                            <input type="file" name="gambar" id="gambar" class="form-control-file" accept="image/*">
                            <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar.</small>
                        </div>

                        <!-- Tombol -->
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('resep.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

{{-- CKEditor --}}
<script src="https://cdn.ckeditor.com/4.22.1/full-all/ckeditor.js"></script>
<script>
CKEDITOR.replace('resep', {
    height: 250,
    toolbarGroups: [
        { name: 'clipboard', groups: ['clipboard', 'undo'] },
        { name: 'editing', groups: ['find', 'selection', 'spellchecker'] },
        { name: 'basicstyles', groups: ['basicstyles', 'cleanup'] },
        { name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align'] },
        { name: 'styles' },
        { name: 'colors' },
        { name: 'links' },
        { name: 'insert' },
        { name: 'tools' }
    ],
});

CKEDITOR.replace('sejarah', {
    height: 250,
    toolbarGroups: [
        { name: 'clipboard', groups: ['clipboard', 'undo'] },
        { name: 'editing', groups: ['find', 'selection', 'spellchecker'] },
        { name: 'basicstyles', groups: ['basicstyles', 'cleanup'] },
        { name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align'] },
        { name: 'styles' },
        { name: 'colors' },
        { name: 'links' },
        { name: 'insert' },
        { name: 'tools' }
    ],
});
</script>

@endsection
