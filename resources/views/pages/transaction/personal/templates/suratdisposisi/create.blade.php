@extends('layout.main')

@section('content')
<x-breadcrumb :values="[__('menu.transaction.menu'), 'Surat Pribadi', 'Buat Formulir Disposisi']" />

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
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
    <form action="{{ route('transaction.personal.disposisi.store') }}" method="POST">
        @csrf

        <div class="card-header">
            <h5>Buat Formulir Disposisi</h5>
        </div>

        <div class="card-body row">
            {{-- Informasi Header --}}
            <div class="col-12 mb-4">
                <h6 class="border-bottom pb-2">Informasi Header</h6>
            </div>

            <div class="col-md-4 mb-3">
                <label for="kop_type" class="form-label">Pilih Logo/Kop <span class="text-danger">*</span></label>
                <select class="form-select @error('kop_type') is-invalid @enderror" id="kop_type" name="kop_type" required>
                    <option value="">-- Pilih Logo --</option>
                    <option value="klinik" {{ old('kop_type') == 'klinik' ? 'selected' : '' }}>Klinik</option>
                    <option value="lab" {{ old('kop_type', 'lab') == 'lab' ? 'selected' : '' }}>Laboratorium</option>
                    <option value="pt" {{ old('kop_type') == 'pt' ? 'selected' : '' }}>PT</option>
                </select>
                @error('kop_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="logo" class="form-label">Pilih Logo (otomatis) <span class="text-danger">*</span></label>
                <select name="logo" id="logo" class="form-select @error('logo') is-invalid @enderror" required>
                    <option value="">-- Pilih Logo --</option>
                    <option value="logo_klinik.png" {{ old('logo') == 'logo_klinik.png' ? 'selected' : '' }}>Logo Klinik</option>
                    <option value="logo_lab.png" {{ old('logo') == 'logo_lab.png' ? 'selected' : '' }}>Logo Laboratorium</option>
                    <option value="logo_pt.png" {{ old('logo') == 'logo_pt.png' ? 'selected' : '' }}>Logo PT</option>
                </select>
                @error('logo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Logo akan otomatis diambil dari folder <code>public/logo/</code></small>
            </div>

            <div class="col-md-4 mb-3">
                <label for="nomor_ld" class="form-label">Nomor LD <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nomor_ld') is-invalid @enderror" 
                       id="nomor_ld" name="nomor_ld" 
                       placeholder="001" 
                       value="{{ old('nomor_ld', '001') }}" required>
                <small class="text-muted">Format: 001, 002, dst</small>
                @error('nomor_ld')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="tanggal_dokumen" class="form-label">Tanggal Dokumen <span class="text-danger">*</span></label>
                <input type="date" class="form-control @error('tanggal_dokumen') is-invalid @enderror" 
                       id="tanggal_dokumen" name="tanggal_dokumen" 
                       value="{{ old('tanggal_dokumen', date('Y-m-d')) }}" required>
                <small class="text-muted">Untuk No. Dokumen LD/bulan/tahun</small>
                @error('tanggal_dokumen')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="no_revisi" class="form-label">No. Revisi <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('no_revisi') is-invalid @enderror" 
                       id="no_revisi" name="no_revisi" 
                       placeholder="00" 
                       value="{{ old('no_revisi', '00') }}" required>
                <small class="text-muted">Contoh: 00, 01, 02</small>
                @error('no_revisi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="tanggal_pembuatan" class="form-label">Tanggal Pembuatan <span class="text-danger">*</span></label>
                <input type="date" class="form-control @error('tanggal_pembuatan') is-invalid @enderror" 
                       id="tanggal_pembuatan" name="tanggal_pembuatan" 
                       value="{{ old('tanggal_pembuatan', date('Y-m-d')) }}" required>
                @error('tanggal_pembuatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Perihal & Paraf --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Perihal & Paraf</h6>
            </div>

            <div class="col-md-8 mb-3">
                <label for="perihal" class="form-label">Perihal <span class="text-danger">*</span></label>
                <textarea class="form-control @error('perihal') is-invalid @enderror" 
                          id="perihal" name="perihal" rows="3" 
                          placeholder="Tuliskan perihal disposisi" required>{{ old('perihal') }}</textarea>
                @error('perihal')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="paraf" class="form-label">Paraf</label>
                <input type="text" class="form-control @error('paraf') is-invalid @enderror" 
                       id="paraf" name="paraf" 
                       placeholder="Nama/Inisial" 
                       value="{{ old('paraf') }}">
                @error('paraf')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Diteruskan Kepada --}}
            <div class="col-12 mb-4 mt-3">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2">
                    <h6 class="mb-0">Diteruskan Kepada</h6>
                    <button type="button" id="add-penerima" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-plus-circle"></i> Tambah Penerima
                    </button>
                </div>
            </div>

            <div class="col-12">
                <div id="penerima-wrapper">
                    <div class="penerima-item card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <strong>Penerima 1</strong>
                            </div>
                            <input type="text" name="diteruskan_kepada[]" 
                                   class="form-control" placeholder="Nama Penerima" required>
                        </div>
                    </div>
                    <div class="penerima-item card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <strong>Penerima 2</strong>
                            </div>
                            <input type="text" name="diteruskan_kepada[]" 
                                   class="form-control" placeholder="Nama Penerima" required>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tanggal Diserahkan & Kembali --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Tanggal Diserahkan & Kembali</h6>
            </div>

            <div class="col-md-6 mb-3">
                <label for="tanggal_diserahkan" class="form-label">Tanggal Diserahkan</label>
                <input type="date" class="form-control @error('tanggal_diserahkan') is-invalid @enderror" 
                       id="tanggal_diserahkan" name="tanggal_diserahkan" 
                       value="{{ old('tanggal_diserahkan') }}">
                @error('tanggal_diserahkan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                <input type="date" class="form-control @error('tanggal_kembali') is-invalid @enderror" 
                       id="tanggal_kembali" name="tanggal_kembali" 
                       value="{{ old('tanggal_kembali') }}">
                @error('tanggal_kembali')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Catatan --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Catatan</h6>
            </div>

            <div class="col-md-6 mb-3">
                <label for="catatan_1" class="form-label">Catatan Kolom 1</label>
                <textarea class="form-control @error('catatan_1') is-invalid @enderror" 
                          id="catatan_1" name="catatan_1" rows="4" 
                          placeholder="Catatan kolom pertama">{{ old('catatan_1') }}</textarea>
                @error('catatan_1')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="catatan_2" class="form-label">Catatan Kolom 2</label>
                <textarea class="form-control @error('catatan_2') is-invalid @enderror" 
                          id="catatan_2" name="catatan_2" rows="4" 
                          placeholder="Catatan kolom kedua">{{ old('catatan_2') }}</textarea>
                @error('catatan_2')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Simpan Disposisi
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
.penerima-item {
    background-color: #f8f9fa;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const wrapper = document.getElementById("penerima-wrapper");
    const addBtn = document.getElementById("add-penerima");
    let penerimaIndex = 2;

    addBtn.addEventListener("click", function () {
        const div = document.createElement("div");
        div.classList.add("penerima-item", "card", "mb-3");
        div.innerHTML = `
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <strong>Penerima ${penerimaIndex + 1}</strong>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-penerima">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </div>
                <input type="text" name="diteruskan_kepada[]" 
                       class="form-control" placeholder="Nama Penerima" required>
            </div>
        `;
        wrapper.appendChild(div);
        penerimaIndex++;
    });

    wrapper.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-penerima') || e.target.closest('.remove-penerima')) {
            e.target.closest('.penerima-item').remove();
            reindexPenerima();
        }
    });

    function reindexPenerima() {
        const items = wrapper.querySelectorAll('.penerima-item');
        penerimaIndex = items.length;
        items.forEach((item, idx) => {
            item.querySelector('strong').textContent = `Penerima ${idx + 1}`;
        });
    }
});
</script>
@endpush