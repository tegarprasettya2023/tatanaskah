@extends('layout.main')

@section('content')
<x-breadcrumb :values="[__('menu.transaction.menu'), 'Surat Pribadi', 'Edit Berita Acara']" />

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
    <form action="{{ route('transaction.personal.beritaacara.update', $data->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card-header">
            <h5>Edit Berita Acara</h5>
        </div>

        <div class="card-body row">
            {{-- Informasi Dasar --}}
            <div class="col-12 mb-4">
                <h6 class="border-bottom pb-2">Informasi Dasar</h6>
            </div>

            <div class="col-md-6 mb-3">
                <label for="kop_type" class="form-label">Pilih Kop Surat <span class="text-danger">*</span></label>
                <select class="form-select @error('kop_type') is-invalid @enderror" id="kop_type" name="kop_type" required>
                    <option value="">-- Pilih Kop --</option>
                    <option value="klinik" {{ old('kop_type', $data->kop_type) == 'klinik' ? 'selected' : '' }}>Klinik</option>
                    <option value="lab" {{ old('kop_type', $data->kop_type) == 'lab' ? 'selected' : '' }}>Laboratorium</option>
                    <option value="pt" {{ old('kop_type', $data->kop_type) == 'pt' ? 'selected' : '' }}>PT</option>
                </select>
                @error('kop_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="nomor" class="form-label">Nomor <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nomor') is-invalid @enderror" 
                       id="nomor" name="nomor" 
                       value="{{ old('nomor', $data->nomor) }}" required>
                @error('nomor')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-12 mb-3">
                <label for="tanggal_acara" class="form-label">Tanggal Acara <span class="text-danger">*</span></label>
                <input type="date" class="form-control @error('tanggal_acara') is-invalid @enderror" 
                       id="tanggal_acara" name="tanggal_acara" 
                       value="{{ old('tanggal_acara', $data->tanggal_acara?->format('Y-m-d')) }}" required>
                @error('tanggal_acara')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Pihak Pertama --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Pihak Pertama</h6>
            </div>

            <div class="col-md-4 mb-3">
                <label for="nama_pihak_pertama" class="form-label">Nama Pejabat <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nama_pihak_pertama') is-invalid @enderror" 
                       id="nama_pihak_pertama" name="nama_pihak_pertama" 
                       value="{{ old('nama_pihak_pertama', $data->nama_pihak_pertama) }}" required>
                @error('nama_pihak_pertama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="nip_pihak_pertama" class="form-label">NIP <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nip_pihak_pertama') is-invalid @enderror" 
                       id="nip_pihak_pertama" name="nip_pihak_pertama" 
                       value="{{ old('nip_pihak_pertama', $data->nip_pihak_pertama) }}" required>
                @error('nip_pihak_pertama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="jabatan_pihak_pertama" class="form-label">Jabatan <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('jabatan_pihak_pertama') is-invalid @enderror" 
                       id="jabatan_pihak_pertama" name="jabatan_pihak_pertama" 
                       value="{{ old('jabatan_pihak_pertama', $data->jabatan_pihak_pertama) }}" required>
                @error('jabatan_pihak_pertama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Pihak Kedua --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Pihak Kedua</h6>
            </div>

            <div class="col-md-12 mb-3">
                <label for="pihak_kedua" class="form-label">Pihak Lain <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('pihak_kedua') is-invalid @enderror" 
                       id="pihak_kedua" name="pihak_kedua" 
                       value="{{ old('pihak_kedua', $data->pihak_kedua) }}" required>
                @error('pihak_kedua')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- NIK Pihak Kedua --}}
            <div class="col-md-12 mb-3">
                <label for="nik_pihak_kedua" class="form-label">NIK Pihak Kedua</label>
                <input type="text" class="form-control @error('nik_pihak_kedua') is-invalid @enderror"
                    id="nik_pihak_kedua" name="nik_pihak_kedua"
                    value="{{ old('nik_pihak_kedua', $data->nik_pihak_kedua) }}"
                    placeholder="NIK Kepegawaian">
                @error('nik_pihak_kedua')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Telah Melaksanakan --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Telah Melaksanakan</h6>
            </div>

            <div class="col-12 mb-3">
                <label for="telah_melaksanakan" class="form-label">Keterangan <span class="text-danger">*</span></label>
                <textarea class="form-control @error('telah_melaksanakan') is-invalid @enderror" 
                          id="telah_melaksanakan" name="telah_melaksanakan" rows="2" required>{{ old('telah_melaksanakan', $data->telah_melaksanakan) }}</textarea>
                @error('telah_melaksanakan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Kegiatan Dinamis --}}
            <div class="col-12 mb-4 mt-3">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2">
                    <h6 class="mb-0">Daftar Kegiatan</h6>
                    <button type="button" id="add-kegiatan" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-plus-circle"></i> Tambah Kegiatan
                    </button>
                </div>
            </div>

            <div class="col-12">
                <div id="kegiatan-wrapper">
                    @if(!empty(old('kegiatan', $data->kegiatan)))
                        @foreach(old('kegiatan', $data->kegiatan) as $i => $kegiatan)
                        <div class="kegiatan-item mb-2">
                            <div class="input-group">
                                <span class="input-group-text">{{ $i + 1 }}.</span>
                                <input type="text" name="kegiatan[]" class="form-control" 
                                       value="{{ $kegiatan }}" required>
                                @if($i > 0)
                                <button type="button" class="btn btn-outline-danger remove-kegiatan">
                                    <i class="bi bi-trash"></i>
                                </button>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>

            {{-- Dibuat Berdasarkan --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Penutup</h6>
            </div>

            <div class="col-12 mb-3">
                <label for="dibuat_berdasarkan" class="form-label">Berita acara ini dibuat dengan sesungguhnya berdasarkan <span class="text-danger">*</span></label>
                <textarea class="form-control @error('dibuat_berdasarkan') is-invalid @enderror" 
                          id="dibuat_berdasarkan" name="dibuat_berdasarkan" rows="2" required>{{ old('dibuat_berdasarkan', $data->dibuat_berdasarkan) }}</textarea>
                @error('dibuat_berdasarkan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tempat & Tanggal TTD --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Penandatangan</h6>
            </div>

            <div class="col-md-6 mb-3">
                <label for="tempat_ttd" class="form-label">Tempat <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('tempat_ttd') is-invalid @enderror" 
                       id="tempat_ttd" name="tempat_ttd" 
                       value="{{ old('tempat_ttd', $data->tempat_ttd) }}" required>
                @error('tempat_ttd')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="tanggal_ttd" class="form-label">Tanggal TTD <span class="text-danger">*</span></label>
                <input type="date" class="form-control @error('tanggal_ttd') is-invalid @enderror" 
                       id="tanggal_ttd" name="tanggal_ttd" 
                       value="{{ old('tanggal_ttd', $data->tanggal_ttd?->format('Y-m-d')) }}" required>
                @error('tanggal_ttd')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Mengetahui/Mengesahkan --}}
            <div class="col-12 mb-3">
                <label for="nama_mengetahui" class="form-label">Mengetahui/Mengesahkan - Nama <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nama_mengetahui') is-invalid @enderror" 
                       id="nama_mengetahui" name="nama_mengetahui" 
                       value="{{ old('nama_mengetahui', $data->nama_mengetahui) }}" required>
                @error('nama_mengetahui')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="jabatan_mengetahui" class="form-label">Jabatan <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('jabatan_mengetahui') is-invalid @enderror" 
                       id="jabatan_mengetahui" name="jabatan_mengetahui" 
                       value="{{ old('jabatan_mengetahui', $data->jabatan_mengetahui) }}" required>
                @error('jabatan_mengetahui')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="nik_mengetahui" class="form-label">NIK</label>
                <input type="text" class="form-control @error('nik_mengetahui') is-invalid @enderror" 
                       id="nik_mengetahui" name="nik_mengetahui" 
                       value="{{ old('nik_mengetahui', $data->nik_mengetahui) }}">
                @error('nik_mengetahui')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Update Berita Acara
            </button>
            <a href="{{ route('transaction.personal.beritaacara.show', $data->id) }}" class="btn btn-secondary">
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
.kegiatan-item {
    background-color: #f8f9fa;
    padding: 10px;
    border-radius: 5px;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const wrapper = document.getElementById("kegiatan-wrapper");
    const addBtn = document.getElementById("add-kegiatan");
    let kegiatanCount = {{ !empty(old('kegiatan', $data->kegiatan)) ? count(old('kegiatan', $data->kegiatan)) : 0 }};

    addBtn.addEventListener("click", function () {
        kegiatanCount++;
        const div = document.createElement("div");
        div.classList.add("kegiatan-item", "mb-2");
        div.innerHTML = `
            <div class="input-group">
                <span class="input-group-text">${kegiatanCount}.</span>
                <input type="text" name="kegiatan[]" class="form-control" required>
                <button type="button" class="btn btn-outline-danger remove-kegiatan">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        `;
        wrapper.appendChild(div);
        reindexKegiatan();
    });

    wrapper.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-kegiatan') || e.target.closest('.remove-kegiatan')) {
            const items = wrapper.querySelectorAll('.kegiatan-item');
            if (items.length > 1) {
                const kegiatanItem = e.target.closest('.kegiatan-item');
                kegiatanItem.remove();
                reindexKegiatan();
            } else {
                alert('Minimal harus ada 1 kegiatan!');
            }
        }
    });

    function reindexKegiatan() {
        const items = wrapper.querySelectorAll('.kegiatan-item');
        kegiatanCount = items.length;
        items.forEach((item, idx) => {
            item.querySelector('.input-group-text').textContent = `${idx + 1}.`;
        });
    }
});
</script>
@endpush