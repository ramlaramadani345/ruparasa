@extends('dashboard.master')

@section('konten')
<div class="container mt-4">
    <h2 class="fw-bold mb-4">➕ Tambah Cerita</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="ceritaForm" action="{{ route('cerita.userStore') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="judul" class="form-label fw-bold">Judul Cerita</label>
            <input type="text" name="judul" class="form-control" value="{{ old('judul') }}" required>
        </div>

        <div class="mb-3">
            <label for="gambar" class="form-label fw-bold">Gambar Cerita (opsional)</label>
            <input type="file" name="gambar" class="form-control" accept="image/*">
        </div>

        <div class="mb-3">
            <label for="isi_cerita" class="form-label fw-bold">Isi Cerita</label>
            <textarea name="isi_cerita" id="editor" class="form-control" rows="10">{{ old('isi_cerita') }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Kirim Cerita</button>
        <a href="{{ route('cerita.userIndex') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>

{{-- CKEditor Full --}}
<script src="https://cdn.ckeditor.com/4.22.1/full-all/ckeditor.js"></script>

<script>
CKEDITOR.replace('editor', {
    height: 300,
    removeButtons: '',
    toolbarGroups: [
        { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
        { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
        { name: 'styles', groups: [ 'styles' ] },
        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
        { name: 'colors', groups: [ 'colors' ] },
        { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
        { name: 'insert', groups: [ 'insert' ] },
        { name: 'links', groups: [ 'links' ] },
        { name: 'tools', groups: [ 'tools' ] },
        { name: 'about', groups: [ 'about' ] }
    ],
    font_names: 'Arial/Arial, Helvetica, sans-serif;' +
                'Courier New/Courier New, Courier, monospace;' +
                'Georgia/Georgia, serif;' +
                'Lucida Sans Unicode/Lucida Sans Unicode, Lucida Grande, sans-serif;' +
                'Tahoma/Tahoma, Geneva, sans-serif;' +
                'Times New Roman/Times New Roman, Times, serif;' +
                'Trebuchet MS/Trebuchet MS, Helvetica, sans-serif;' +
                'Verdana/Verdana, Geneva, sans-serif;',
    fontSize_sizes: '8/8px;9/9px;10/10px;11/11px;12/12px;14/14px;16/16px;18/18px;20/20px;22/22px;24/24px;26/26px;28/28px;36/36px;',
});
</script>
@endsection
