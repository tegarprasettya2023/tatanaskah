@extends('layout.main')

@section('content')
<x-breadcrumb :values="[__('menu.transaction.menu'), 'Surat Pribadi', 'Edit Surat Pengumuman']" />

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
  <form action="{{ route('transaction.personal.pengumuman.update', $data->id) }}" method="POST" id="formPengumuman">
    @csrf
    @method('PUT')

        <div class="card-header">
            <h5><i class="bi bi-megaphone"></i> Edit Surat Pengumuman</h5>
        </div>

        <div class="card-body row">

            <div class="col-md-6 mb-3">
                <label>Kop Surat <span class="text-danger">*</span></label>
                <select name="kop_type" class="form-select" required>
                    <option value="klinik" {{ $data->kop_type=='klinik'?'selected':'' }}>Klinik</option>
                    <option value="lab" {{ $data->kop_type=='lab'?'selected':'' }}>Laboratorium</option>
                    <option value="pt" {{ $data->kop_type=='pt'?'selected':'' }}>PT</option>
                </select>
            </div>

            <div class="col-md-6 mb-3"></div>

            <div class="col-12 mb-3">
                <label>Nomor Surat <span class="text-danger">*</span></label>
                <input type="text" name="nomor" class="form-control"
                       value="{{ old('nomor', $data->nomor) }}" required>
                <small class="text-muted">Format: UM/nomor/bulan(romawi)/tahun</small>
            </div>

            <div class="col-12 mb-3">
                <label>Tentang <span class="text-danger">*</span></label>
                <input type="text" name="tentang" class="form-control"
                       value="{{ old('tentang', $data->tentang) }}" required>
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

            <div class="col-md-6 mb-3">
                <label>Tempat Dikeluarkan <span class="text-danger">*</span></label>
                <input type="text" name="tempat_ttd" class="form-control"
                       value="{{ old('tempat_ttd', $data->tempat_ttd) }}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Tanggal Dikeluarkan <span class="text-danger">*</span></label>
                <input type="date" name="tanggal_ttd" class="form-control"
                       value="{{ old('tanggal_ttd', \Carbon\Carbon::parse($data->tanggal_ttd)->format('Y-m-d')) }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label>Jabatan <span class="text-danger">*</span></label>
                <input type="text" name="jabatan_pembuat" class="form-control"
                       value="{{ old('jabatan_pembuat', $data->jabatan_pembuat) }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label>Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" name="nama_pembuat" class="form-control"
                       value="{{ old('nama_pembuat', $data->nama_pembuat) }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label>NIK Pegawai</label>
                <input type="text" name="nik_pegawai" class="form-control"
                       value="{{ old('nik_pegawai', $data->nik_pegawai) }}">
            </div>
        </div>

        <div class="card-footer d-flex gap-2">
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Perbarui</button>
            <a href="{{ route('transaction.personal.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

    </form>
</div>
@endsection

@push('style')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
.quill-editor { background: white; }
.ql-editor { min-height: 200px; font-size: 14px; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    // Quill Pembuka
    const quillPembuka = new Quill('#editor-pembuka', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1,2,3,4,5,6,false] }],
                ['bold','italic','underline','strike'],
                [{ 'list':'ordered' },{ 'list':'bullet' }],
                [{ 'indent':'-1' },{ 'indent':'+1' }],
                [{ 'align':[] }],
                ['link'],
                ['clean']
            ]
        },
        placeholder: 'Tuliskan isi pengumuman di sini...'
    });

    // Quill Penutup
    const quillPenutup = new Quill('#editor-penutup', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header':[1,2,3,4,5,6,false] }],
                ['bold','italic','underline','strike'],
                [{ 'list':'ordered' },{ 'list':'bullet' }],
                [{ 'indent':'-1' },{ 'indent':'+1' }],
                [{ 'align':[] }],
                ['link'],
                ['clean']
            ]
        },
        placeholder: 'Tuliskan penutup pengumuman di sini...'
    });

    // --- TAMBAHKAN TAB = INDENT ---
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
    // --------------------------------

    // Load existing data dari database
    quillPembuka.root.innerHTML = {!! json_encode(old('isi_pembuka', $data->isi_pembuka)) !!};
    quillPenutup.root.innerHTML = {!! json_encode(old('isi_penutup', $data->isi_penutup)) !!};

    // Sync ke hidden input
    quillPembuka.on('text-change', function() {
        document.getElementById('isi_pembuka').value = quillPembuka.root.innerHTML;
    });

    quillPenutup.on('text-change', function() {
        document.getElementById('isi_penutup').value = quillPenutup.root.innerHTML;
    });

    // Sync awal
    document.getElementById('isi_pembuka').value = quillPembuka.root.innerHTML;
    document.getElementById('isi_penutup').value = quillPenutup.root.innerHTML;
});
</script>
@endpush
