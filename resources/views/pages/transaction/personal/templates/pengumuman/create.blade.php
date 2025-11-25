@extends('layout.main')

@section('content')
<x-breadcrumb :values="[__('menu.transaction.menu'), 'Surat Pribadi', 'Buat Surat Pengumuman']" />

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show">
        <strong>Terjadi Kesalahan!</strong>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card mb-4">
    <form action="{{ route('transaction.personal.pengumuman.store') }}" method="POST" id="formPengumuman">
        @csrf
        <input type="hidden" name="template_type" value="pengumuman">

        <div class="card-header">
            <h5><i class="bi bi-megaphone"></i> Buat Surat Pengumuman</h5>
        </div>

        <div class="card-body row">
            {{-- Kop --}}
            <div class="col-md-6 mb-3">
                <label>Kop Surat <span class="text-danger">*</span></label>
                <select name="kop_type" class="form-select" required>
                    <option value="">-- Pilih Kop --</option>
                    <option value="klinik" {{ old('kop_type') == 'klinik' ? 'selected' : '' }}>Klinik</option>
                    <option value="lab" {{ old('kop_type') == 'lab' ? 'selected' : '' }}>Laboratorium</option>
                    <option value="pt" {{ old('kop_type') == 'pt' ? 'selected' : '' }}>PT</option>
                </select>
            </div>

            <div class="col-md-6 mb-3"></div>

            {{-- Nomor Manual --}}
            <div class="col-12 mb-3">
                <label>Nomor Surat <span class="text-danger">*</span></label>
                <input type="text" name="nomor" class="form-control" 
                       placeholder="Contoh: UM/001/XII/2024" value="{{ old('nomor') }}" required>
                <small class="text-muted">Format: UM/nomor/bulan(romawi)/tahun</small>
            </div>

            {{-- Tentang --}}
            <div class="col-12 mb-3">
                <label>Tentang <span class="text-danger">*</span></label>
                <input type="text" name="tentang" class="form-control" 
                       placeholder="Tuliskan pokok pengumuman" value="{{ old('tentang') }}" required>
            </div>

            {{-- Isi Pembuka --}}
            <div class="col-12 mb-3">
                <label>Isi Pengumuman <span class="text-danger">*</span></label>
                <div class="quill-editor" id="editor-pembuka" style="height: 250px;"></div>
                <input type="hidden" name="isi_pembuka" id="isi_pembuka" required>
            </div>

            {{-- Isi Penutup --}}
            <div class="col-12 mb-3">
                <label>Isi Penutup</label>
                <div class="quill-editor" id="editor-penutup" style="height: 200px;"></div>
                <input type="hidden" name="isi_penutup" id="isi_penutup">
            </div>

            <div class="col-12"><hr></div>

            {{-- Tempat & Tanggal --}}
            <div class="col-md-6 mb-3">
                <label>Tempat Dikeluarkan <span class="text-danger">*</span></label>
                <input type="text" name="tempat_ttd" class="form-control" 
                       value="{{ old('tempat_ttd', 'Surabaya') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Tanggal Dikeluarkan <span class="text-danger">*</span></label>
                <input type="date" name="tanggal_ttd" class="form-control" 
                       value="{{ old('tanggal_ttd', date('Y-m-d')) }}" required>
            </div>

            {{-- Jabatan, Nama, NIK --}}
            <div class="col-md-4 mb-3">
                <label>Jabatan <span class="text-danger">*</span></label>
                <input type="text" name="jabatan_pembuat" class="form-control" 
                       value="{{ old('jabatan_pembuat') }}" required>
            </div>
            <div class="col-md-4 mb-3">
                <label>Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" name="nama_pembuat" class="form-control" 
                       value="{{ old('nama_pembuat') }}" required>
            </div>
            <div class="col-md-4 mb-3">
                <label>NIK Pegawai</label>
                <input type="text" name="nik_pegawai" class="form-control" 
                       value="{{ old('nik_pegawai') }}">
            </div>
        </div>

        <div class="card-footer d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Simpan Surat
            </button>
            <a href="{{ route('transaction.personal.templates') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </form>
</div>
@endsection

@push('style')
<!-- Quill CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
.quill-editor {
    background: white;
}
.ql-editor {
    min-height: 200px;
    font-size: 14px;
}
</style>
@endpush

@push('scripts')
<!-- Quill JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Inisialisasi Quill Editor untuk Isi Pembuka
    const quillPembuka = new Quill('#editor-pembuka', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                [{ 'align': [] }],
                ['link'],
                ['clean']
            ]
        },
        placeholder: 'Tuliskan isi pengumuman di sini...'
    });

    // Inisialisasi Quill Editor untuk Isi Penutup
    const quillPenutup = new Quill('#editor-penutup', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                [{ 'align': [] }],
                ['link'],
                ['clean']
            ]
        },
        placeholder: 'Tuliskan penutup pengumuman di sini (opsional)...'
    });

    // --- SOLUSI B: Aktifkan TAB sebagai indent ---
    function enableTabIndent(quill) {
        quill.keyboard.addBinding({
            key: 9, // TAB
            handler: function(range, context) {
                quill.format('indent', '+1');
            }
        });
    }

    enableTabIndent(quillPembuka);
    enableTabIndent(quillPenutup);
    // --- END SOLUSI TAB ---

    // Simpan HTML ke hidden input
    quillPembuka.on('text-change', function() {
        document.getElementById('isi_pembuka').value = quillPembuka.root.innerHTML;
    });

    quillPenutup.on('text-change', function() {
        document.getElementById('isi_penutup').value = quillPenutup.root.innerHTML;
    });

    // Load old value jika ada validasi error
    @if(old('isi_pembuka'))
        quillPembuka.root.innerHTML = {!! json_encode(old('isi_pembuka')) !!};
    @endif

    @if(old('isi_penutup'))
        quillPenutup.root.innerHTML = {!! json_encode(old('isi_penutup')) !!};
    @endif
});
</script>
@endpush
