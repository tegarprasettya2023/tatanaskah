@extends('layout.main')

@section('content')
<x-breadcrumb :values="[__('menu.transaction.menu'), 'Surat Pribadi', 'Buat Surat Panggilan']" />

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
    <form action="{{ route('transaction.personal.surat_panggilan.store') }}" method="POST">
        @csrf
        <input type="hidden" name="template_type" value="surat_panggilan">

        <div class="card-header"><h5>Buat Surat Panggilan</h5></div>
        
        <div class="card-body row">
            <!-- Kop Surat -->
            <div class="col-md-6 mb-3">
                <label for="kop_type">Pilih Kop <span class="text-danger">*</span></label>
                <select name="kop_type" id="kop_type" class="form-select" required>
                    <option value="">-- Pilih Kop --</option>
                    <option value="klinik" {{ old('kop_type') == 'klinik' ? 'selected' : '' }}>Klinik</option>
                    <option value="lab" {{ old('kop_type') == 'lab' ? 'selected' : '' }}>Laboratorium</option>
                    <option value="pt" {{ old('kop_type') == 'pt' ? 'selected' : '' }}>PT</option>
                </select>
                @error('kop_type')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <!-- Tanggal Surat -->
            <div class="col-md-6 mb-3">
                <label for="letter_date">Tanggal Surat <span class="text-danger">*</span></label>
                <input type="date" name="letter_date" id="letter_date" class="form-control" 
                       value="{{ old('letter_date', date('Y-m-d')) }}" required>
                @error('letter_date')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <!-- Sifat -->
            <div class="col-md-4 mb-3">
                <label for="sifat">Sifat</label>
                <input type="text" name="sifat" id="sifat" class="form-control" 
                       value="{{ old('sifat') }}" placeholder="Contoh: Penting">
                @error('sifat')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <!-- Lampiran -->
            <div class="col-md-4 mb-3">
                <label for="lampiran">Lampiran</label>
                <input type="text" name="lampiran" id="lampiran" class="form-control" 
                       value="{{ old('lampiran') }}" placeholder="Contoh: 1 lembar">
                @error('lampiran')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <!-- Perihal -->
            <div class="col-md-4 mb-3">
                <label for="perihal">Perihal <span class="text-danger">*</span></label>
                <input type="text" name="perihal" id="perihal" class="form-control" 
                       value="{{ old('perihal') }}" placeholder="Contoh: Panggilan" required>
                @error('perihal')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <!-- Kepada -->
            <div class="col-12 mb-3">
                <label for="kepada">Kepada <span class="text-danger">*</span></label>
                <input type="text" name="kepada" id="kepada" class="form-control" 
                       value="{{ old('kepada') }}" placeholder="Masukkan Nama" required>
                @error('kepada')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <!-- Isi Pembuka -->
            <div class="col-12 mb-3">
                <label for="isi_pembuka">Sehubungan dengan <span class="text-danger">*</span></label>
                <textarea name="isi_pembuka" id="isi_pembuka" rows="3" class="form-control" 
                          placeholder="Tuliskan alasan pemanggilan" required>{{ old('isi_pembuka') }}</textarea>
                @error('isi_pembuka')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12"><hr></div>
            <div class="col-12 mb-3">
                <h6 class="text-primary">Detail Pemanggilan</h6>
            </div>

            <!-- Hari Tanggal -->
            <div class="col-md-6 mb-3">
                <label for="hari_tanggal">Hari, Tanggal <span class="text-danger">*</span></label>
                <input type="date" name="hari_tanggal" id="hari_tanggal" class="form-control" 
                       value="{{ old('hari_tanggal') }}" required>
                <small class="text-muted">Tanggal pemanggilan (akan ditampilkan: Hari, Tanggal Bulan Tahun)</small>
                @error('hari_tanggal')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <!-- Waktu -->
            <div class="col-md-6 mb-3">
                <label for="waktu">Waktu <span class="text-danger">*</span></label>
                <input type="time" name="waktu" id="waktu" class="form-control" 
                       value="{{ old('waktu', '09:00') }}" required>
                @error('waktu')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <!-- Tempat -->
            <div class="col-md-6 mb-3">
                <label for="tempat">Tempat <span class="text-danger">*</span></label>
                <input type="text" name="tempat" id="tempat" class="form-control" 
                       value="{{ old('tempat') }}" placeholder="Masukkan lokasi tempat" required>
                @error('tempat')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <!-- Menghadap -->
            <div class="col-md-6 mb-3">
                <label for="menghadap">Menghadap Kepada <span class="text-danger">*</span></label>
                <input type="text" name="menghadap" id="menghadap" class="form-control" 
                       value="{{ old('menghadap') }}" placeholder="Contoh: Direktur Utama" required>
                @error('menghadap')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <!-- Alamat Pemanggil -->
            <div class="col-12 mb-3">
                <label for="alamat_pemanggil">Alamat Pemanggil <span class="text-danger">*</span></label>
                <textarea name="alamat_pemanggil" id="alamat_pemanggil" rows="2" class="form-control" 
                          placeholder="Masukkan alamat pemanggil" required>{{ old('alamat_pemanggil') }}</textarea>
                @error('alamat_pemanggil')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12"><hr></div>
            <div class="col-12 mb-3">
                <h6 class="text-primary">Data Penandatangan</h6>
            </div>

            <!-- Jabatan -->
            <div class="col-md-6 mb-3">
                <label for="jabatan">Jabatan Penandatangan <span class="text-danger">*</span></label>
                <input type="text" name="jabatan" id="jabatan" class="form-control" 
                       value="{{ old('jabatan') }}" placeholder="Contoh: Direktur Utama" required>
                @error('jabatan')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <!-- Nama Pejabat -->
            <div class="col-md-6 mb-3">
                <label for="nama_pejabat">Nama Pejabat <span class="text-danger">*</span></label>
                <input type="text" name="nama_pejabat" id="nama_pejabat" class="form-control" 
                       value="{{ old('nama_pejabat') }}" placeholder="Masukkan Nama Pejabat" required>
                @error('nama_pejabat')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <!-- NIK -->
            <div class="col-md-6 mb-3">
                <label for="nik">NIK <span class="text-danger">*</span></label>
                <input type="text" name="nik" id="nik" class="form-control" 
                       value="{{ old('nik') }}" placeholder="Contoh: 3578012345678901" required>
                @error('nik')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12"><hr></div>
            <!-- TEMBUSAN DYNAMIC -->
            <div class="col-12 mb-4 mt-3">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2">
                    <h6 class="text-primary mb-0">Tembusan (Opsional)</h6>
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
                                   placeholder="Contoh: Kepala Bagian HRD" value="{{ old('tembusan.0') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
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
<style>
.border-bottom {
    border-bottom: 2px solid #dee2e6 !important;
}
.tembusan-item {
    background-color: #f8f9fa;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
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
                <input type="text" name="tembusan[]" class="form-control" placeholder="Contoh: Kepala Divisi ...">
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