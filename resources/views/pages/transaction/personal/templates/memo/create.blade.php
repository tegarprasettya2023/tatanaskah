@extends('layout.main')

@section('content')
<x-breadcrumb :values="[__('menu.transaction.menu'), 'Surat Pribadi', 'Buat Internal Memo']" />

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
    <form action="{{ route('transaction.personal.memo.store') }}" method="POST" id="formMemo">
        @csrf
        <input type="hidden" name="template_type" value="internal_memo">

        <div class="card-header">
            <h5><i class="bi bi-envelope"></i> Buat Internal Memo</h5>
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
                       placeholder="IM/001/X/2025" value="{{ old('nomor') }}" required>
                <small class="text-muted">Format: IM/nomor/bulan(romawi)/tahun</small>
            </div>

            {{-- Tanggal --}}
            <div class="col-md-6 mb-3">
                <label>Tempat Dikeluarkan <span class="text-danger">*</span></label>
                <input type="text" name="tempat_ttd" class="form-control" 
                       value="{{ old('tempat_ttd', 'Surabaya') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Tanggal Surat <span class="text-danger">*</span></label>
                <input type="date" name="letter_date" class="form-control" 
                       value="{{ old('letter_date', date('Y-m-d')) }}" required>
            </div>

            {{-- Penerima --}}
            <div class="col-md-6 mb-3">
                <label>Yth. (Penerima) <span class="text-danger">*</span></label>
                <input type="text" name="yth_nama" class="form-control" 
                       placeholder="Nama penerima" value="{{ old('yth_nama') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Hal <span class="text-danger">*</span></label>
                <input type="text" name="hal" class="form-control" 
                       placeholder="Perihal surat" value="{{ old('hal') }}" required>
            </div>

            <div class="col-12"><hr></div>

            {{-- Isi Memo dengan Rich Text Editor --}}
            <div class="col-12 mb-3">
                <label>Sehubungan Dengan <span class="text-danger">*</span></label>
                <div class="quill-editor" id="editor-sehubungan" style="height: 200px;"></div>
                <input type="hidden" name="sehubungan_dengan" id="sehubungan_dengan" required>
                <small class="text-muted">Awali dengan "Sehubungan dengan..."</small>
            </div>

            <div class="col-12 mb-3">
                <label>Isi Memo <span class="text-danger">*</span></label>
                <div class="quill-editor" id="editor-alinea" style="height: 250px;"></div>
                <input type="hidden" name="alinea_isi" id="alinea_isi" required>
            </div>

            <div class="col-12 mb-3">
                <label>Isi Penutup</label>
                <div class="quill-editor" id="editor-penutup" style="height: 150px;"></div>
                <input type="hidden" name="isi_penutup" id="isi_penutup">
                <small class="text-muted">Jika kosong, akan menggunakan penutup default</small>
            </div>

            <div class="col-12"><hr></div>

            {{-- Penandatangan --}}
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
                <input type="text" name="nik_pembuat" class="form-control" 
                       value="{{ old('nik_pembuat') }}">
            </div>

            {{-- Tembusan --}}
            <div class="col-12 mb-4 mt-3">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2">
                    <h6 class="mb-0">Tembusan (Opsional)</h6>
                    <button type="button" id="add-tembusan" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-plus-circle"></i> Tambah Tembusan
                    </button>
                </div>
            </div>

            <div class="col-12">
                <div id="tembusan-wrapper">
                    <div class="tembusan-item card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <strong>Tembusan 1</strong>
                            </div>
                            <input type="text" name="tembusan[]" class="form-control" 
                                   placeholder="Contoh: Kepala Divisi HR" value="{{ old('tembusan.0') }}">
                        </div>
                    </div>
                </div>
                <small class="text-muted">Kosongkan jika tidak ada tembusan</small>
            </div>
        </div>

        <div class="card-footer d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Simpan Surat
            </button>
            <a href="{{ route('transaction.personal.memo.index') }}" class="btn btn-secondary">
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
.ql-editor { min-height: 150px; font-size: 14px; }
.tembusan-item { background-color: #f8f9fa; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Inisialisasi Quill Editors
    const quillSehubungan = new Quill('#editor-sehubungan', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                [{ 'align': [] }],
                ['clean']
            ],
            keyboard: {
                bindings: {
                    tab: {
                        key: 9,
                        handler: function(range, context) {
                            this.quill.format('indent', '+1', 'user');
                            return false;
                        }
                    },
                    shiftTab: {
                        key: 9,
                        shiftKey: true,
                        handler: function(range, context) {
                            this.quill.format('indent', '-1', 'user');
                            return false;
                        }
                    }
                }
            }
        },
        placeholder: 'Sehubungan dengan...'
    });

    const quillAlinea = new Quill('#editor-alinea', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                [{ 'align': [] }],
                ['clean']
            ]
        },
        placeholder: 'Isi memo...'
    });

    const quillPenutup = new Quill('#editor-penutup', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                [{ 'align': [] }],
                ['clean']
            ]
        },
        placeholder: 'Penutup memo (opsional)...'
    });

    // Enable TAB for indent
    function enableTabIndent(quill) {
        quill.keyboard.addBinding({
            key: 9,
            handler: function() {
                quill.format('indent', '+1');
            }
        });
    }

    enableTabIndent(quillSehubungan);
    enableTabIndent(quillAlinea);
    enableTabIndent(quillPenutup);

    // Sync ke hidden input
    quillSehubungan.on('text-change', function() {
        document.getElementById('sehubungan_dengan').value = quillSehubungan.root.innerHTML;
    });

    quillAlinea.on('text-change', function() {
        document.getElementById('alinea_isi').value = quillAlinea.root.innerHTML;
    });

    quillPenutup.on('text-change', function() {
        document.getElementById('isi_penutup').value = quillPenutup.root.innerHTML;
    });

    // Load old values
    @if(old('sehubungan_dengan'))
        quillSehubungan.root.innerHTML = {!! json_encode(old('sehubungan_dengan')) !!};
    @endif

    @if(old('alinea_isi'))
        quillAlinea.root.innerHTML = {!! json_encode(old('alinea_isi')) !!};
    @endif

    @if(old('isi_penutup'))
        quillPenutup.root.innerHTML = {!! json_encode(old('isi_penutup')) !!};
    @endif

    // Tembusan Dynamic
    const tembusanWrapper = document.getElementById("tembusan-wrapper");
    const addTembusan = document.getElementById("add-tembusan");
    let tembusanIndex = 1;

    addTembusan.addEventListener("click", function () {
        const div = document.createElement("div");
        div.classList.add("tembusan-item", "card", "mb-3");
        div.innerHTML = `
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <strong>Tembusan ${tembusanIndex + 1}</strong>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-tembusan">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </div>
                <input type="text" name="tembusan[]" class="form-control" placeholder="Contoh: Kepala Divisi...">
            </div>
        `;
        tembusanWrapper.appendChild(div);
        tembusanIndex++;
    });

    tembusanWrapper.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-tembusan') || e.target.closest('.remove-tembusan')) {
            e.target.closest('.tembusan-item').remove();
            reindexTembusan();
        }
    });

    function reindexTembusan() {
        const items = tembusanWrapper.querySelectorAll('.tembusan-item');
        tembusanIndex = items.length;
        items.forEach((item, idx) => {
            item.querySelector('strong').textContent = `Tembusan ${idx + 1}`;
        });
    }
});
</script>
@endpush