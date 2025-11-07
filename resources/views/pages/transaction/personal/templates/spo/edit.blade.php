@extends('layout.main')

@section('content')
<x-breadcrumb :values="[__('menu.transaction.menu'), 'Surat Pribadi', 'SPO', 'Edit']" />

<div class="card mb-4">
    <form action="{{ route('transaction.personal.spo.update', $data->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card-header">
            <h5>Edit Standar Prosedur Operasional (SPO)</h5>
        </div>

        <div class="card-body row">
            {{-- Header Informasi --}}
            <div class="col-12 mb-4">
                <h6 class="border-bottom pb-2">Informasi Header</h6>
            </div>

            <!-- Logo Kiri -->
            <div class="col-md-4 mb-3">
                <label for="logo_kiri" class="form-label">Logo Kiri <span class="text-danger">*</span></label>
                <select class="form-select @error('logo_kiri') is-invalid @enderror" id="logo_kiri" name="logo_kiri" required>
                    <option value="">-- Pilih Logo Kiri --</option>
                    <option value="klinik" {{ old('logo_kiri', $data->logo_kiri) == 'klinik' ? 'selected' : '' }}>Klinik</option>
                    <option value="lab" {{ old('logo_kiri', $data->logo_kiri) == 'lab' ? 'selected' : '' }}>Laboratorium</option>
                    <option value="pt" {{ old('logo_kiri', $data->logo_kiri) == 'pt' ? 'selected' : '' }}>PT</option>
                </select>
                @error('logo_kiri')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Logo Kanan -->
            <div class="col-md-4 mb-3">
                <label for="logo_kanan" class="form-label">Logo Kanan <span class="text-danger">*</span></label>
                <select class="form-select @error('logo_kanan') is-invalid @enderror" id="logo_kanan" name="logo_kanan" required>
                    <option value="">-- Pilih Logo Kanan --</option>
                    <option value="klinik" {{ old('logo_kanan', $data->logo_kanan) == 'klinik' ? 'selected' : '' }}>Klinik</option>
                    <option value="lab" {{ old('logo_kanan', $data->logo_kanan) == 'lab' ? 'selected' : '' }}>Laboratorium</option>
                    <option value="pt" {{ old('logo_kanan', $data->logo_kanan) == 'pt' ? 'selected' : '' }}>PT</option>
                </select>
                @error('logo_kanan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Kop Surat -->
            <div class="col-md-4 mb-3">
                <label for="kop_type" class="form-label">Kop Surat <span class="text-danger">*</span></label>
                <select class="form-select @error('kop_type') is-invalid @enderror" id="kop_type" name="kop_type" required>
                    <option value="">-- Pilih Kop --</option>
                    <option value="klinik" {{ old('kop_type', $data->kop_type) == 'klinik' ? 'selected' : '' }}>Kop Klinik</option>
                    <option value="lab" {{ old('kop_type', $data->kop_type) == 'lab' ? 'selected' : '' }}>Kop Laboratorium</option>
                    <option value="pt" {{ old('kop_type', $data->kop_type) == 'pt' ? 'selected' : '' }}>Kop PT</option>
                </select>
                @error('kop_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Header & Footer PDF</small>
            </div>

            <div class="col-12 mb-3">
                <x-input-form name="judul_spo" label="Judul SPO" 
                    placeholder="JUDUL SPO"
                    :value="old('judul_spo', $data->judul_spo)" 
                    :required="true" />
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="no_dokumen" label="No. Dokumen" 
                    placeholder="Contoh: SPO/001/X/2025"
                    :value="old('no_dokumen', $data->no_dokumen)" 
                    :required="true" />
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="no_revisi" label="No. Revisi" 
                    placeholder="00"
                    :value="old('no_revisi', $data->no_revisi)" />
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="tanggal_terbit" type="date" label="Tanggal Terbit"
                    :value="old('tanggal_terbit', $data->tanggal_terbit ? $data->tanggal_terbit->format('Y-m-d') : '')" 
                    :required="true" />
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="halaman" label="Halaman" 
                    placeholder="58/75"
                    :value="old('halaman', $data->halaman)" />
            </div>

            {{-- Ditetapkan Oleh --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Ditetapkan Oleh</h6>
            </div>

            <div class="col-md-4 mb-3">
                <x-input-form name="jabatan_menetapkan" label="Jabatan" 
                    placeholder="Kepala Laboratorium Utama Trisensa"
                    :value="old('jabatan_menetapkan', $data->jabatan_menetapkan)" />
            </div>

            <div class="col-md-4 mb-3">
                <x-input-form name="nama_menetapkan" label="Nama" 
                    placeholder="Dr. dr. Herni Suprapti, M. Kes"
                    :value="old('nama_menetapkan', $data->nama_menetapkan)" />
            </div>

            <div class="col-md-4 mb-3">
                <x-input-form name="nip_menetapkan" label="NIP" 
                    placeholder="208111505"
                    :value="old('nip_menetapkan', $data->nip_menetapkan)" />
            </div>

            {{-- Isi Dokumen (1-10) dengan Label yang bisa diedit --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Isi Dokumen</h6>
            </div>

            @for($i = 1; $i <= 10; $i++)
                @if($i == 5)
                    {{-- Item 5: Bagan Alir dengan Upload Image --}}
                    <div class="col-12 mb-3">
                        <label for="label_{{ $i }}" class="form-label">{{ $i }}. Label</label>
                        <input type="text" class="form-control mb-2" id="label_{{ $i }}" name="label_{{ $i }}" 
                            value="{{ old('label_' . $i, $data->{'label_' . $i}) }}" placeholder="Ubah label jika perlu">
                        
                        <label for="bagan_alir_image" class="form-label">Upload Gambar Bagan Alir</label>
                        @if($data->bagan_alir_image)
                            <div class="mb-2">
                                <img src="{{ asset($data->bagan_alir_image) }}" alt="Current Image" style="max-width: 300px; border: 1px solid #ddd; padding: 5px;">
                                <small class="d-block text-muted">Gambar saat ini</small>
                            </div>
                        @endif
                        <input type="file" class="form-control @error('bagan_alir_image') is-invalid @enderror" 
                            id="bagan_alir_image" name="bagan_alir_image" accept="image/*">
                        <small class="text-muted">Format: JPG, PNG, GIF, SVG, WEBP. Maks: 2MB. Kosongkan jika tidak ingin mengubah.</small>
                        @error('bagan_alir_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                        <div id="image-preview" class="mt-2"></div>
                    </div>
                @elseif($i == 10)
                    {{-- Item 10: Rekaman Historis dengan tabel dinamis --}}
                    <div class="col-12 mb-3">
                        <label for="label_{{ $i }}" class="form-label">{{ $i }}. Label</label>
                        <input type="text" class="form-control mb-2" id="label_{{ $i }}" name="label_{{ $i }}" 
                            value="{{ old('label_' . $i, $data->{'label_' . $i}) }}" placeholder="Ubah label jika perlu">
                        
                        <label class="form-label">Tabel Rekaman Historis</label>
                        <div id="historis-container">
                            @php
                                $historisList = old('rekaman_historis', $data->rekaman_historis ?? []);
                                if (empty($historisList)) {
                                    $historisList = [['no' => '', 'yang_diubah' => '', 'isi_perubahan' => '', 'tanggal_berlaku' => '']];
                                }
                            @endphp
                            @foreach($historisList as $index => $histori)
                                <div class="row mb-2 historis-row">
                                    <div class="col-md-2">
                                        <input type="text" class="form-control form-control-sm" 
                                            name="rekaman_historis[{{ $index }}][no]" placeholder="No." 
                                            value="{{ $histori['no'] ?? '' }}">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control form-control-sm" 
                                            name="rekaman_historis[{{ $index }}][yang_diubah]" placeholder="Yang Diubah" 
                                            value="{{ $histori['yang_diubah'] ?? '' }}">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control form-control-sm" 
                                            name="rekaman_historis[{{ $index }}][isi_perubahan]" placeholder="Isi Perubahan" 
                                            value="{{ $histori['isi_perubahan'] ?? '' }}">
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control" 
                                                name="rekaman_historis[{{ $index }}][tanggal_berlaku]" placeholder="Tgl Berlaku" 
                                                value="{{ $histori['tanggal_berlaku'] ?? '' }}">
                                            @if($index > 0)
                                                <button type="button" class="btn btn-outline-danger btn-sm remove-historis">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="add-historis">
                            <i class="bi bi-plus-circle"></i> Tambah Baris
                        </button>
                    </div>
                @else
                    {{-- Item 1-4, 6-9: Text input biasa --}}
                    <div class="col-12 mb-3">
                        <label for="label_{{ $i }}" class="form-label">{{ $i }}. Label</label>
                        <input type="text" class="form-control mb-2" id="label_{{ $i }}" name="label_{{ $i }}" 
                            value="{{ old('label_' . $i, $data->{'label_' . $i}) }}" 
                            placeholder="Ubah label jika perlu">
                        
                        <label for="content_{{ $i }}" class="form-label">Isi</label>
                        <textarea class="form-control @error('content_' . $i) is-invalid @enderror" 
                            id="content_{{ $i }}" name="content_{{ $i }}" rows="3" 
                            placeholder="Masukkan isi konten...">{{ old('content_' . $i, $data->{'content_' . $i}) }}</textarea>
                        @error('content_' . $i)
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                @endif
            @endfor

            {{-- Persetujuan Dokumen --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Persetujuan Dokumen</h6>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Dibuat oleh:</label>
                <x-input-form name="dibuat_jabatan" label="Jabatan" 
                    placeholder="Jabatan pembuat"
                    :value="old('dibuat_jabatan', $data->dibuat_jabatan)" />
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Direview oleh:</label>
                <x-input-form name="direview_jabatan" label="Jabatan" 
                    placeholder="Jabatan reviewer"
                    :value="old('direview_jabatan', $data->direview_jabatan)" />
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="dibuat_nama" label="Nama" 
                    placeholder="Nama pembuat"
                    :value="old('dibuat_nama', $data->dibuat_nama)" />
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="direview_nama" label="Nama" 
                    placeholder="Nama reviewer"
                    :value="old('direview_nama', $data->direview_nama)" />
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="dibuat_tanggal" type="date" label="Tanggal" 
                    :value="old('dibuat_tanggal', $data->dibuat_tanggal ? $data->dibuat_tanggal->format('Y-m-d') : '')" />
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="direview_tanggal" type="date" label="Tanggal" 
                    :value="old('direview_tanggal', $data->direview_tanggal ? $data->direview_tanggal->format('Y-m-d') : '')" />
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Perbarui SPO
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
#image-preview img {
    max-width: 100%;
    height: auto;
    border: 1px solid #ddd;
    padding: 5px;
    margin-top: 10px;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let historisCount = document.querySelectorAll('#historis-container .historis-row').length;
    
    // Add Rekaman Historis Row
    document.getElementById('add-historis').addEventListener('click', function() {
        const container = document.getElementById('historis-container');
        const newRow = document.createElement('div');
        newRow.className = 'row mb-2 historis-row';
        newRow.innerHTML = `
            <div class="col-md-2">
                <input type="text" class="form-control form-control-sm" 
                    name="rekaman_historis[${historisCount}][no]" placeholder="No.">
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control form-control-sm" 
                    name="rekaman_historis[${historisCount}][yang_diubah]" placeholder="Yang Diubah">
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control form-control-sm" 
                    name="rekaman_historis[${historisCount}][isi_perubahan]" placeholder="Isi Perubahan">
            </div>
            <div class="col-md-2">
                <div class="input-group input-group-sm">
                    <input type="text" class="form-control" 
                        name="rekaman_historis[${historisCount}][tanggal_berlaku]" placeholder="Tgl Berlaku">
                    <button type="button" class="btn btn-outline-danger btn-sm remove-historis">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            </div>
        `;
        container.appendChild(newRow);
        historisCount++;
    });

    // Remove Rekaman Historis Row
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-historis') || e.target.parentElement.classList.contains('remove-historis')) {
            e.target.closest('.historis-row').remove();
        }
    });

    // Image Preview
    document.getElementById('bagan_alir_image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('image-preview');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
            };
            reader.readAsDataURL(file);
        } else {
            preview.innerHTML = '';
        }
    });
});
</script>
@endpush