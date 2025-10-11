@extends('layout.main')

@section('content')
<x-breadcrumb :values="[__('menu.transaction.menu'), 'Surat Pribadi', 'Buat Notulen']" />

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
    <form action="{{ route('transaction.personal.notulen.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card-header">
            <h5>Buat Notulen Rapat</h5>
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
                    <option value="klinik" {{ old('kop_type') == 'klinik' ? 'selected' : '' }}>Klinik</option>
                    <option value="lab" {{ old('kop_type', 'lab') == 'lab' ? 'selected' : '' }}>Laboratorium</option>
                    <option value="pt" {{ old('kop_type') == 'pt' ? 'selected' : '' }}>PT</option>
                </select>
                @error('kop_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="isi_notulen" class="form-label">Isi Notulen <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('isi_notulen') is-invalid @enderror" 
                       id="isi_notulen" name="isi_notulen" 
                       placeholder="Contoh: Rapat Evaluasi Kinerja" 
                       value="{{ old('isi_notulen') }}" required>
                @error('isi_notulen')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Detail Rapat --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Detail Rapat</h6>
            </div>

            <div class="col-md-4 mb-3">
                <label for="tanggal_rapat" class="form-label">Hari, Tanggal <span class="text-danger">*</span></label>
                <input type="date" class="form-control @error('tanggal_rapat') is-invalid @enderror" 
                       id="tanggal_rapat" name="tanggal_rapat" 
                       value="{{ old('tanggal_rapat', date('Y-m-d')) }}" required>
                @error('tanggal_rapat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="waktu" class="form-label">Waktu <span class="text-danger">*</span></label>
                <input type="time" class="form-control @error('waktu') is-invalid @enderror" 
                       id="waktu" name="waktu" 
                       value="{{ old('waktu') }}" required>
                @error('waktu')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="tempat" class="form-label">Tempat <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('tempat') is-invalid @enderror" 
                       id="tempat" name="tempat" 
                       placeholder="Ruang Meeting Lt. 2" 
                       value="{{ old('tempat') }}" required>
                @error('tempat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="pimpinan_rapat" class="form-label">Pimpinan Rapat <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('pimpinan_rapat') is-invalid @enderror" 
                       id="pimpinan_rapat" name="pimpinan_rapat" 
                       placeholder="Nama Pimpinan Rapat" 
                       value="{{ old('pimpinan_rapat') }}" required>
                @error('pimpinan_rapat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="peserta_rapat" class="form-label">Peserta Rapat <span class="text-danger">*</span></label>
                <textarea class="form-control @error('peserta_rapat') is-invalid @enderror" 
                          id="peserta_rapat" name="peserta_rapat" rows="3" 
                          placeholder="Tuliskan nama-nama peserta rapat" required>{{ old('peserta_rapat') }}</textarea>
                @error('peserta_rapat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Kegiatan Rapat --}}
            <div class="col-12 mb-4 mt-3">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2">
                    <h6 class="mb-0">Kegiatan Rapat</h6>
                    <button type="button" id="add-kegiatan" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-plus-circle"></i> Tambah Kegiatan
                    </button>
                </div>
            </div>

            <div class="col-12">
                <div id="kegiatan-wrapper">
                    <div class="kegiatan-item card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <strong>Kegiatan 1</strong>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Pembicara/Uraian Materi <span class="text-danger">*</span></label>
                                    <input type="text" name="kegiatan_rapat[0][pembicara]" 
                                           class="form-control" placeholder="Nama Pembicara" required>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Tanggapan/Pemberi Tanggapan</label>
                                    <input type="text" name="kegiatan_rapat[0][tanggapan]" 
                                           class="form-control" placeholder="Nama Pemberi Tanggapan">
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label class="form-label">Materi <span class="text-danger">*</span></label>
                                    <textarea name="kegiatan_rapat[0][materi]" 
                                              class="form-control" rows="2" placeholder="Isi materi" required></textarea>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Keputusan Pimpinan</label>
                                    <textarea name="kegiatan_rapat[0][keputusan]" 
                                              class="form-control" rows="2" placeholder="Keputusan"></textarea>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Keterangan</label>
                                    <textarea name="kegiatan_rapat[0][keterangan]" 
                                              class="form-control" rows="2" placeholder="Keterangan tambahan"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Penandatangan --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Penandatangan</h6>
            </div>

            <div class="col-md-6 mb-3">
                <label for="kepala_lab" class="form-label">Kepala Laboratorium <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('kepala_lab') is-invalid @enderror" 
                       id="kepala_lab" name="kepala_lab" 
                       placeholder="Nama Kepala Lab" 
                       value="{{ old('kepala_lab') }}" required>
                @error('kepala_lab')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="nik_kepala_lab" class="form-label">NIK Kepegawaian</label>
                <input type="text" class="form-control @error('nik_kepala_lab') is-invalid @enderror" 
                       id="nik_kepala_lab" name="nik_kepala_lab" 
                       placeholder="NIK" 
                       value="{{ old('nik_kepala_lab') }}">
                @error('nik_kepala_lab')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="notulis" class="form-label">Notulis <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('notulis') is-invalid @enderror" 
                       id="notulis" name="notulis" 
                       placeholder="Nama Notulis" 
                       value="{{ old('notulis') }}" required>
                @error('notulis')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="nik_notulis" class="form-label">NIK Kepegawaian</label>
                <input type="text" class="form-control @error('nik_notulis') is-invalid @enderror" 
                       id="nik_notulis" name="nik_notulis" 
                       placeholder="NIK" 
                       value="{{ old('nik_notulis') }}">
                @error('nik_notulis')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Dokumentasi --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Dokumentasi (Halaman 2)</h6>
            </div>

            <div class="col-12 mb-3">
                <label for="judul_dokumentasi" class="form-label">Judul Dokumentasi</label>
                <input type="text" class="form-control @error('judul_dokumentasi') is-invalid @enderror" 
                       id="judul_dokumentasi" name="judul_dokumentasi" 
                       placeholder="Contoh: Rapat Evaluasi Kinerja Q1 2025" 
                       value="{{ old('judul_dokumentasi') }}">
                @error('judul_dokumentasi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12 mb-3">
                <label for="dokumentasi" class="form-label">Upload Gambar Dokumentasi</label>
                <input type="file" class="form-control @error('dokumentasi.*') is-invalid @enderror" 
                       id="dokumentasi" name="dokumentasi[]" multiple accept="image/*">
                <small class="text-muted">Bisa upload lebih dari 1 gambar. Format: JPG, JPEG, PNG. Max: 2MB per file.</small>
                @error('dokumentasi.*')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12" id="preview-images"></div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Simpan Notulen
            </button>
            <a href="{{ route('transaction.personal.index') }}" class="btn btn-secondary">
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
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const wrapper = document.getElementById("kegiatan-wrapper");
    const addBtn = document.getElementById("add-kegiatan");
    let kegiatanIndex = 1;

    addBtn.addEventListener("click", function () {
        const div = document.createElement("div");
        div.classList.add("kegiatan-item", "card", "mb-3");
        div.innerHTML = `
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <strong>Kegiatan ${kegiatanIndex + 1}</strong>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-kegiatan">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Pembicara/Uraian Materi <span class="text-danger">*</span></label>
                        <input type="text" name="kegiatan_rapat[${kegiatanIndex}][pembicara]" 
                               class="form-control" placeholder="Nama Pembicara" required>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Tanggapan/Pemberi Tanggapan</label>
                        <input type="text" name="kegiatan_rapat[${kegiatanIndex}][tanggapan]" 
                               class="form-control" placeholder="Nama Pemberi Tanggapan">
                    </div>
                    <div class="col-md-12 mb-2">
                        <label class="form-label">Materi <span class="text-danger">*</span></label>
                        <textarea name="kegiatan_rapat[${kegiatanIndex}][materi]" 
                                  class="form-control" rows="2" placeholder="Isi materi" required></textarea>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Keputusan Pimpinan</label>
                        <textarea name="kegiatan_rapat[${kegiatanIndex}][keputusan]" 
                                  class="form-control" rows="2" placeholder="Keputusan"></textarea>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Keterangan</label>
                        <textarea name="kegiatan_rapat[${kegiatanIndex}][keterangan]" 
                                  class="form-control" rows="2" placeholder="Keterangan tambahan"></textarea>
                    </div>
                </div>
            </div>
        `;
        wrapper.appendChild(div);
        kegiatanIndex++;
    });

    wrapper.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-kegiatan') || e.target.closest('.remove-kegiatan')) {
            e.target.closest('.kegiatan-item').remove();
            reindexKegiatan();
        }
    });

    function reindexKegiatan() {
        const items = wrapper.querySelectorAll('.kegiatan-item');
        kegiatanIndex = items.length;
        items.forEach((item, idx) => {
            item.querySelector('strong').textContent = `Kegiatan ${idx + 1}`;
        });
    }

    // Preview images
    document.getElementById('dokumentasi').addEventListener('change', function(e) {
        const preview = document.getElementById('preview-images');
        preview.innerHTML = '';
        
        Array.from(e.target.files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'd-inline-block m-2';
                div.innerHTML = `<img src="${e.target.result}" style="width: 150px; height: 150px; object-fit: cover;" class="border rounded">`;
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    });
});
</script>
@endpush