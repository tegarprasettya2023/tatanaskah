@extends('layout.main')

@section('content')
<x-breadcrumb :values="[__('menu.transaction.menu'), 'Surat Pribadi', 'Edit Notulen']" />

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
    <form action="{{ route('transaction.personal.notulen.update', $data->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card-header">
            <h5>Edit Notulen Rapat</h5>
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
                <label for="isi_notulen" class="form-label">Isi Notulen <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('isi_notulen') is-invalid @enderror" 
                       id="isi_notulen" name="isi_notulen" 
                       value="{{ old('isi_notulen', $data->isi_notulen) }}" required>
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
                       value="{{ old('tanggal_rapat', $data->tanggal_rapat?->format('Y-m-d')) }}" required>
                @error('tanggal_rapat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="waktu" class="form-label">Waktu <span class="text-danger">*</span></label>
                <input type="time" class="form-control @error('waktu') is-invalid @enderror" 
                       id="waktu" name="waktu" 
                       value="{{ old('waktu', $data->waktu) }}" required>
                @error('waktu')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="tempat" class="form-label">Tempat <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('tempat') is-invalid @enderror" 
                       id="tempat" name="tempat" 
                       value="{{ old('tempat', $data->tempat) }}" required>
                @error('tempat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="pimpinan_rapat" class="form-label">Pimpinan Rapat <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('pimpinan_rapat') is-invalid @enderror" 
                       id="pimpinan_rapat" name="pimpinan_rapat" 
                       value="{{ old('pimpinan_rapat', $data->pimpinan_rapat) }}" required>
                @error('pimpinan_rapat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="peserta_rapat" class="form-label">Peserta Rapat <span class="text-danger">*</span></label>
                <textarea class="form-control @error('peserta_rapat') is-invalid @enderror" 
                          id="peserta_rapat" name="peserta_rapat" rows="3" required>{{ old('peserta_rapat', $data->peserta_rapat) }}</textarea>
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
                    @php
                        $kegiatanData = old('kegiatan_rapat', $data->kegiatan_rapat);
                        $kegiatanArray = is_array($kegiatanData) ? $kegiatanData : [];
                    @endphp
                    
                    @if(!empty($kegiatanArray))
                        @foreach($kegiatanArray as $i => $kegiatan)
                        <div class="kegiatan-item card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <strong>Kegiatan {{ $i + 1 }}</strong>
                                    @if($i > 0)
                                    <button type="button" class="btn btn-sm btn-outline-danger remove-kegiatan">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Pembicara/Uraian Materi <span class="text-danger">*</span></label>
                                        <input type="text" name="kegiatan_rapat[{{ $i }}][pembicara]" 
                                               class="form-control" value="{{ $kegiatan['pembicara'] ?? '' }}" required>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Tanggapan/Pemberi Tanggapan</label>
                                        <input type="text" name="kegiatan_rapat[{{ $i }}][tanggapan]" 
                                               class="form-control" value="{{ $kegiatan['tanggapan'] ?? '' }}">
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label class="form-label">Materi <span class="text-danger">*</span></label>
                                        <textarea name="kegiatan_rapat[{{ $i }}][materi]" 
                                                  class="form-control" rows="2" required>{{ $kegiatan['materi'] ?? '' }}</textarea>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Keputusan Pimpinan</label>
                                        <textarea name="kegiatan_rapat[{{ $i }}][keputusan]" 
                                                  class="form-control" rows="2">{{ $kegiatan['keputusan'] ?? '' }}</textarea>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Keterangan</label>
                                        <textarea name="kegiatan_rapat[{{ $i }}][keterangan]" 
                                                  class="form-control" rows="2">{{ $kegiatan['keterangan'] ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        {{-- Default 1 kegiatan jika tidak ada data --}}
                        <div class="kegiatan-item card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <strong>Kegiatan 1</strong>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Pembicara/Uraian Materi <span class="text-danger">*</span></label>
                                        <input type="text" name="kegiatan_rapat[0][pembicara]" 
                                               class="form-control" required>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Tanggapan/Pemberi Tanggapan</label>
                                        <input type="text" name="kegiatan_rapat[0][tanggapan]" 
                                               class="form-control">
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label class="form-label">Materi <span class="text-danger">*</span></label>
                                        <textarea name="kegiatan_rapat[0][materi]" 
                                                  class="form-control" rows="2" required></textarea>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Keputusan Pimpinan</label>
                                        <textarea name="kegiatan_rapat[0][keputusan]" 
                                                  class="form-control" rows="2"></textarea>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Keterangan</label>
                                        <textarea name="kegiatan_rapat[0][keterangan]" 
                                                  class="form-control" rows="2"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
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
                       value="{{ old('kepala_lab', $data->kepala_lab) }}" required>
                @error('kepala_lab')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="nik_kepala_lab" class="form-label">NIK Kepegawaian</label>
                <input type="text" class="form-control @error('nik_kepala_lab') is-invalid @enderror" 
                       id="nik_kepala_lab" name="nik_kepala_lab" 
                       value="{{ old('nik_kepala_lab', $data->nik_kepala_lab) }}">
                @error('nik_kepala_lab')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="notulis" class="form-label">Notulis <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('notulis') is-invalid @enderror" 
                       id="notulis" name="notulis" 
                       value="{{ old('notulis', $data->notulis) }}" required>
                @error('notulis')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="nik_notulis" class="form-label">NIK Kepegawaian</label>
                <input type="text" class="form-control @error('nik_notulis') is-invalid @enderror" 
                       id="nik_notulis" name="nik_notulis" 
                       value="{{ old('nik_notulis', $data->nik_notulis) }}">
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
                       value="{{ old('judul_dokumentasi', $data->judul_dokumentasi) }}">
                @error('judul_dokumentasi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- FIX: Dokumentasi dengan icon sampah yang berfungsi --}}
            @php
                // Decode dokumentasi dengan benar
                $dokumentasiRaw = $data->dokumentasi;
                
                if (is_string($dokumentasiRaw)) {
                    $dokumentasiArray = json_decode($dokumentasiRaw, true) ?: [];
                } elseif (is_array($dokumentasiRaw)) {
                    $dokumentasiArray = $dokumentasiRaw;
                } else {
                    $dokumentasiArray = [];
                }
                
                // Filter hanya yang valid
                $dokumentasiArray = array_filter($dokumentasiArray, function($item) {
                    return !empty($item) && is_string($item) && strlen($item) > 0;
                });
            @endphp

            @if(!empty($dokumentasiArray))
            <div class="col-12 mb-3">
                <label class="form-label">Dokumentasi Tersimpan</label>
                <div class="row" id="existing-images">
                    @foreach($dokumentasiArray as $index => $doc)
                    <div class="col-md-3 mb-3" data-image-index="{{ $index }}">
                        <div class="position-relative image-container">
                            @if(Storage::disk('public')->exists($doc))
                                <img src="{{ asset('storage/' . $doc) }}" 
                                     class="img-thumbnail" 
                                     style="width: 100%; height: 150px; object-fit: cover;"
                                     alt="Foto {{ $index + 1 }}">
                            @else
                                <div class="img-thumbnail d-flex align-items-center justify-content-center bg-secondary" 
                                     style="width: 100%; height: 150px;">
                                    <i class="bi bi-image text-white" style="font-size: 2rem;"></i>
                                </div>
                            @endif
                            {{-- Tombol hapus dengan icon sampah --}}
                            <button type="button" 
                                    class="btn btn-danger btn-sm position-absolute delete-existing-image" 
                                    style="top: 5px; right: 5px; padding: 4px 8px; z-index: 10;"
                                    data-index="{{ $index }}"
                                    title="Hapus gambar">
                                <i class="bi bi-trash"></i>
                            </button>
                            {{-- Hidden input untuk tandai yang akan dihapus --}}
                            <input type="hidden" class="mark-delete" name="hapus_dokumentasi[]" value="{{ $index }}" disabled>
                        </div>
                        <small class="text-muted d-block text-center mt-1">Foto {{ $index + 1 }}</small>
                    </div>
                    @endforeach
                </div>
            </div>
            @else
            <div class="col-12 mb-3">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> Belum ada dokumentasi yang tersimpan.
                </div>
            </div>
            @endif

            <div class="col-12 mb-3">
                <label for="dokumentasi" class="form-label">Upload Gambar Dokumentasi Baru</label>
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
                <i class="bi bi-save"></i> Update Notulen
            </button>
            <a href="{{ route('transaction.personal.notulen.show', $data->id) }}" class="btn btn-secondary">
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
.image-container {
    position: relative;
    overflow: hidden;
    border-radius: 0.375rem;
}
.image-container.marked-delete {
    opacity: 0.5;
    filter: grayscale(100%);
}
.image-container.marked-delete::after {
    content: "Akan Dihapus";
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: rgba(220, 53, 69, 0.9);
    color: white;
    padding: 8px 16px;
    border-radius: 4px;
    font-weight: bold;
    z-index: 5;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    // ===== KEGIATAN RAPAT =====
    const wrapper = document.getElementById("kegiatan-wrapper");
    const addBtn = document.getElementById("add-kegiatan");
    let kegiatanIndex = {{ !empty($kegiatanArray) ? count($kegiatanArray) : 1 }};

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
                               class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Tanggapan/Pemberi Tanggapan</label>
                        <input type="text" name="kegiatan_rapat[${kegiatanIndex}][tanggapan]" 
                               class="form-control">
                    </div>
                    <div class="col-md-12 mb-2">
                        <label class="form-label">Materi <span class="text-danger">*</span></label>
                        <textarea name="kegiatan_rapat[${kegiatanIndex}][materi]" 
                                  class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Keputusan Pimpinan</label>
                        <textarea name="kegiatan_rapat[${kegiatanIndex}][keputusan]" 
                                  class="form-control" rows="2"></textarea>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Keterangan</label>
                        <textarea name="kegiatan_rapat[${kegiatanIndex}][keterangan]" 
                                  class="form-control" rows="2"></textarea>
                    </div>
                </div>
            </div>
        `;
        wrapper.appendChild(div);
        kegiatanIndex++;
        reindexKegiatan();
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

    // ===== HAPUS DOKUMENTASI EXISTING =====
    const existingImagesContainer = document.getElementById('existing-images');
    
    if (existingImagesContainer) {
        existingImagesContainer.addEventListener('click', function(e) {
            // Cari tombol delete yang diklik
            const deleteBtn = e.target.closest('.delete-existing-image');
            
            if (deleteBtn) {
                e.preventDefault();
                
                const imageContainer = deleteBtn.closest('[data-image-index]');
                const container = deleteBtn.closest('.image-container');
                const hiddenInput = container.querySelector('.mark-delete');
                
                // Toggle status hapus
                if (container.classList.contains('marked-delete')) {
                    // Batalkan hapus
                    container.classList.remove('marked-delete');
                    hiddenInput.disabled = true;
                    deleteBtn.classList.remove('btn-warning');
                    deleteBtn.classList.add('btn-danger');
                    deleteBtn.setAttribute('title', 'Hapus gambar');
                } else {
                    // Tandai untuk dihapus
                    container.classList.add('marked-delete');
                    hiddenInput.disabled = false;
                    deleteBtn.classList.remove('btn-danger');
                    deleteBtn.classList.add('btn-warning');
                    deleteBtn.setAttribute('title', 'Batalkan hapus');
                }
            }
        });
    }

    // ===== PREVIEW GAMBAR BARU =====
    document.getElementById('dokumentasi').addEventListener('change', function(e) {
        const preview = document.getElementById('preview-images');
        preview.innerHTML = '';
        
        if (e.target.files.length > 0) {
            const previewLabel = document.createElement('div');
            previewLabel.className = 'col-12 mb-2';
            previewLabel.innerHTML = '<label class="form-label"><strong>Preview Gambar Baru:</strong></label>';
            preview.appendChild(previewLabel);
            
            const previewRow = document.createElement('div');
            previewRow.className = 'row';
            
            Array.from(e.target.files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'col-md-3 mb-3';
                    div.innerHTML = `
                        <div class="position-relative">
                            <img src="${e.target.result}" 
                                 style="width: 100%; height: 150px; object-fit: cover;" 
                                 class="img-thumbnail">
                            <small class="text-muted d-block text-center mt-1">Gambar Baru ${index + 1}</small>
                        </div>
                    `;
                    previewRow.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
            
            preview.appendChild(previewRow);
        }
    });
});
</script>
@endpush