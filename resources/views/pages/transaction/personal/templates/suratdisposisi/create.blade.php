@extends('layout.main')

@section('content')
<x-breadcrumb :values="[__('menu.transaction.menu'), 'Surat Pribadi', 'Formulir Disposisi']" />

<div class="card mb-4">
    <form action="{{ route('transaction.personal.suratdisposisi.store') }}" method="POST" id="formDisposisi">
        @csrf
        <input type="hidden" name="template_type" value="suratdisposisi">
        <input type="hidden" name="signature" id="signatureInput">

        <div class="card-header">
            <h5>Buat Formulir Disposisi</h5>
        </div>

        <div class="card-body row">
            {{-- Informasi Header --}}
            <div class="col-12 mb-4">
                <h6 class="border-bottom pb-2">Informasi Dasar</h6>
            </div>

            <div class="col-md-4 mb-3">
                <label for="logo_type" class="form-label">Pilih Logo</label>
                <select class="form-select" id="logo_type" name="logo_type" required>
                    <option value="klinik" {{ old('logo_type') == 'klinik' ? 'selected' : '' }}>Klinik</option>
                    <option value="lab" {{ old('logo_type') == 'lab' ? 'selected' : '' }}>Laboratorium</option>
                    <option value="pt" {{ old('logo_type') == 'pt' ? 'selected' : '' }}>PT</option>
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label for="kop_type" class="form-label">Pilih Kop Surat</label>
                <select class="form-select" id="kop_type" name="kop_type" required>
                    <option value="klinik" {{ old('kop_type') == 'klinik' ? 'selected' : '' }}>Klinik</option>
                    <option value="lab" {{ old('kop_type') == 'lab' ? 'selected' : '' }}>Laboratorium</option>
                    <option value="pt" {{ old('kop_type') == 'pt' ? 'selected' : '' }}>PT</option>
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <x-input-form name="nomor_dokumen" label="No. Dokumen" 
                    placeholder="LD/001/X/2025" :value="old('nomor_dokumen')" />
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="no_revisi" label="No. Revisi" 
                    placeholder="00" :value="old('no_revisi', '00')" />
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="halaman_dari" type="number" label="Halaman dari" 
                    :value="old('halaman_dari', 1)" />
            </div>

            {{-- Tabel Kiri --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Informasi Pembuat (Tabel Kiri)</h6>
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="bagian_pembuat" label="Dari (Bagian Pembuat)" 
                    :value="old('bagian_pembuat')" />
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="nomor_tanggal" label="Nomor/Tanggal" 
                    placeholder="001/2025" :value="old('nomor_tanggal')" />
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="perihal" label="Perihal" 
                    :value="old('perihal')" />
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="kepada" label="Kepada" 
                    :value="old('kepada')" />
            </div>

            <div class="col-12 mb-3">
                <label for="ringkasan_isi" class="form-label">Ringkasan Isi</label>
                <textarea class="form-control" id="ringkasan_isi" name="ringkasan_isi" rows="3">{{ old('ringkasan_isi') }}</textarea>
            </div>

            <div class="col-12 mb-3">
                <label for="instruksi_1" class="form-label">Instruksi (Tabel Kiri)</label>
                <textarea class="form-control" id="instruksi_1" name="instruksi_1" rows="3">{{ old('instruksi_1') }}</textarea>
            </div>

            {{-- Tabel Kanan --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Informasi Disposisi (Tabel Kanan)</h6>
            </div>

            <div class="col-md-4 mb-3">
                <x-input-form name="tanggal_pembuatan" type="date" label="Tanggal (Pembuatan)" 
                    :value="old('tanggal_pembuatan')" />
            </div>

            <div class="col-md-4 mb-3">
                <x-input-form name="no_agenda" label="No. Agenda" 
                    :value="old('no_agenda')" />
            </div>

            {{-- Tanda Tangan Digital --}}
            <div class="col-md-12 mb-3">
                <label class="form-label">Tanda Tangan Digital</label>
                <div class="signature-container">
                    <canvas id="signaturePad" class="signature-pad"></canvas>
                </div>
                <div class="mt-2">
                    <button type="button" class="btn btn-sm btn-warning" onclick="clearSignature()">
                        <i class="bi bi-eraser"></i> Hapus Tanda Tangan
                    </button>
                </div>
                <small class="text-muted">Tanda tangan di area canvas di atas</small>
            </div>

            <div class="col-12 mb-3">
                <label class="form-label">Diteruskan Kepada</label>
                <div id="diteruskan-container">
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" name="diteruskan_kepada[]" placeholder="Nama/Jabatan">
                        <button type="button" class="btn btn-success" onclick="addDiteruskan()">
                            <i class="bi bi-plus"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="tanggal_diserahkan" type="date" label="Tanggal Diserahkan" 
                    :value="old('tanggal_diserahkan')" />
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="tanggal_kembali" type="date" label="Tanggal Kembali" 
                    :value="old('tanggal_kembali')" />
            </div>

            <div class="col-12 mb-3">
                <label for="instruksi_2" class="form-label">Instruksi (Tabel Kanan)</label>
                <textarea class="form-control" id="instruksi_2" name="instruksi_2" rows="3">{{ old('instruksi_2') }}</textarea>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Simpan Formulir
            </button>
            <a href="{{ route('transaction.personal.templates') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </form>
</div>
@endsection

@push('style')
<style>
.border-bottom {
    border-bottom: 2px solid #dee2e6 !important;
}

.signature-container {
    border: 2px solid #dee2e6;
    border-radius: 8px;
    background-color: #fff;
    padding: 10px;
}

.signature-pad {
    width: 100%;
    height: 200px;
    border: 1px dashed #ccc;
    border-radius: 4px;
    cursor: crosshair;
    touch-action: none;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
<script>
let signaturePad;

document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('signaturePad');
    signaturePad = new SignaturePad(canvas, {
        backgroundColor: 'rgb(255, 255, 255)',
        penColor: 'rgb(0, 0, 0)'
    });

    // Resize canvas
    function resizeCanvas() {
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
        signaturePad.clear();
    }

    window.addEventListener("resize", resizeCanvas);
    resizeCanvas();
});

function clearSignature() {
    signaturePad.clear();
}

// Submit form
document.getElementById('formDisposisi').addEventListener('submit', function(e) {
    if (!signaturePad.isEmpty()) {
        document.getElementById('signatureInput').value = signaturePad.toDataURL();
    }
});

function addDiteruskan() {
    const container = document.getElementById('diteruskan-container');
    const div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = `
        <input type="text" class="form-control" name="diteruskan_kepada[]" placeholder="Nama/Jabatan">
        <button type="button" class="btn btn-danger" onclick="this.parentElement.remove()">
            <i class="bi bi-trash"></i>
        </button>
    `;
    container.appendChild(div);
}
</script>
@endpush