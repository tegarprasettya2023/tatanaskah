@extends('layout.main')

@section('content')
<x-breadcrumb :values="[__('menu.transaction.menu'), 'Surat Pribadi', 'Instruksi Kerja', 'Edit']" />

<div class="card mb-4">
    <form action="{{ route('transaction.personal.suratinstruksikerja.update', $data->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="template_type" value="instruksi_kerja">

        <div class="card-header">
            <h5>Edit Instruksi Kerja</h5>
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
                    <option value="klinik" {{ old('logo_kiri', $data->logo_kiri) == 'klinik' ? 'selected' : '' }}>Tritunggal</option>
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
                    <option value="klinik" {{ old('logo_kanan', $data->logo_kanan) == 'klinik' ? 'selected' : '' }}>Tritunggal</option>
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
                <x-input-form name="judul_ik" label="Judul Instruksi Kerja" 
                    placeholder="JUDUL IK"
                    :value="old('judul_ik', $data->judul_ik)" 
                    :required="true" />
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="no_dokumen" label="No. Dokumen" 
                    placeholder="Contoh: IK/001/X/2025"
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
                    placeholder="1/1"
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

            {{-- Isi Tabel --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Isi Dokumen</h6>
            </div>

            <div class="col-12 mb-3">
                <label for="pengertian" class="form-label">1. Pengertian</label>
                <textarea class="form-control @error('pengertian') is-invalid @enderror" 
                    id="pengertian" name="pengertian" rows="3">{{ old('pengertian', $data->pengertian) }}</textarea>
                @error('pengertian')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12 mb-3">
                <label for="tujuan" class="form-label">2. Tujuan</label>
                <textarea class="form-control @error('tujuan') is-invalid @enderror" 
                    id="tujuan" name="tujuan" rows="3">{{ old('tujuan', $data->tujuan) }}</textarea>
                @error('tujuan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12 mb-3">
                <label for="kebijakan" class="form-label">3. Kebijakan</label>
                <textarea class="form-control @error('kebijakan') is-invalid @enderror" 
                    id="kebijakan" name="kebijakan" rows="3">{{ old('kebijakan', $data->kebijakan) }}</textarea>
                @error('kebijakan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12 mb-3">
                <label for="pelaksana" class="form-label">4. Pelaksana</label>
                <textarea class="form-control @error('pelaksana') is-invalid @enderror" 
                    id="pelaksana" name="pelaksana" rows="3">{{ old('pelaksana', $data->pelaksana) }}</textarea>
                @error('pelaksana')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Prosedur Kerja --}}
            <div class="col-12 mb-3">
                <label class="form-label">5. Prosedur Kerja/Langkah-langkah Kerja</label>
                <div id="prosedur-container">
                    @php
                        $prosedurList = old('prosedur_kerja', $data->prosedur_kerja ?? []);
                        if (empty($prosedurList)) {
                            $prosedurList = ['Prinsip', 'Metode', 'Sampel', 'Reagen', 'Bahan Kontrol', 'Kalibrator'];
                        }
                    @endphp
                    @foreach($prosedurList as $index => $item)
                        <div class="input-group mb-2">
                            <span class="input-group-text">5.{{ $index + 1 }}</span>
                            <input type="text" class="form-control" name="prosedur_kerja[]" 
                                placeholder="Isi item" value="{{ $item }}">
                            @if($index >= 6)
                                <button type="button" class="btn btn-outline-danger remove-prosedur">
                                    <i class="bi bi-x"></i>
                                </button>
                            @endif
                        </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-sm btn-outline-primary" id="add-prosedur">
                    <i class="bi bi-plus-circle"></i> Tambah Item
                </button>
            </div>

            <div class="col-12 mb-3">
                <label for="hal_hal_perlu_diperhatikan" class="form-label">6. Hal-Hal Yang Perlu Diperhatikan</label>
                <textarea class="form-control" 
                    id="hal_hal_perlu_diperhatikan" name="hal_hal_perlu_diperhatikan" rows="3">{{ old('hal_hal_perlu_diperhatikan', $data->hal_hal_perlu_diperhatikan) }}</textarea>
            </div>

            <div class="col-12 mb-3">
                <label for="unit_terkait" class="form-label">7. Unit terkait</label>
                <textarea class="form-control" 
                    id="unit_terkait" name="unit_terkait" rows="2">{{ old('unit_terkait', $data->unit_terkait) }}</textarea>
            </div>

            <div class="col-12 mb-3">
                <label for="dokumen_terkait" class="form-label">8. Dokumen terkait</label>
                <textarea class="form-control" 
                    id="dokumen_terkait" name="dokumen_terkait" rows="2">{{ old('dokumen_terkait', $data->dokumen_terkait) }}</textarea>
            </div>

            <div class="col-12 mb-3">
                <label for="referensi" class="form-label">9. Referensi</label>
                <textarea class="form-control" 
                    id="referensi" name="referensi" rows="2">{{ old('referensi', $data->referensi) }}</textarea>
            </div>

            {{-- Rekaman Histori Perubahan --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">10. Rekaman Histori Perubahan</h6>
            </div>

            <div class="col-12 mb-3">
                <label class="form-label">Tabel Rekaman Histori</label>
                <div id="histori-container">
                    @php
                        $historiList = old('rekaman_histori', $data->rekaman_histori ?? []);
                        if (empty($historiList)) {
                            $historiList = [['no' => '', 'yang_diubah' => '', 'isi_perubahan' => '', 'tanggal_berlaku' => '']];
                        }
                    @endphp
                    @foreach($historiList as $index => $histori)
                        <div class="row mb-2 histori-row">
                            <div class="col-md-2">
                                <input type="text" class="form-control form-control-sm" 
                                    name="rekaman_histori[{{ $index }}][no]" placeholder="No." 
                                    value="{{ $histori['no'] ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control form-control-sm" 
                                    name="rekaman_histori[{{ $index }}][yang_diubah]" placeholder="Yang Diubah" 
                                    value="{{ $histori['yang_diubah'] ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control form-control-sm" 
                                    name="rekaman_histori[{{ $index }}][isi_perubahan]" placeholder="Isi Perubahan" 
                                    value="{{ $histori['isi_perubahan'] ?? '' }}">
                            </div>
                            <div class="col-md-2">
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" 
                                        name="rekaman_histori[{{ $index }}][tanggal_berlaku]" placeholder="Tgl Berlaku" 
                                        value="{{ $histori['tanggal_berlaku'] ?? '' }}">
                                    @if($index > 0)
                                        <button type="button" class="btn btn-outline-danger btn-sm remove-histori">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-sm btn-outline-primary" id="add-histori">
                    <i class="bi bi-plus-circle"></i> Tambah Baris
                </button>
            </div>

            {{-- Dibuat Oleh & Direview Oleh --}}
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
                <i class="bi bi-save"></i> Perbarui Instruksi Kerja
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
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let prosedurCount = document.querySelectorAll('#prosedur-container .input-group').length;
    let historiCount = document.querySelectorAll('#histori-container .histori-row').length;
    
    // Add Prosedur Kerja
    document.getElementById('add-prosedur').addEventListener('click', function() {
        prosedurCount++;
        const container = document.getElementById('prosedur-container');
        const newInput = document.createElement('div');
        newInput.className = 'input-group mb-2';
        newInput.innerHTML = `
            <span class="input-group-text">5.${prosedurCount}</span>
            <input type="text" class="form-control" name="prosedur_kerja[]" 
                placeholder="Isi item ${prosedurCount}">
            <button type="button" class="btn btn-outline-danger remove-prosedur">
                <i class="bi bi-x"></i>
            </button>
        `;
        container.appendChild(newInput);
    });
    
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-prosedur') || e.target.parentElement.classList.contains('remove-prosedur')) {
            e.target.closest('.input-group').remove();
            updateProsedurNumbering();
        }
    });
    
    function updateProsedurNumbering() {
        const inputs = document.querySelectorAll('#prosedur-container .input-group');
        inputs.forEach((input, index) => {
            input.querySelector('.input-group-text').textContent = `5.${index + 1}`;
        });
        prosedurCount = inputs.length;
    }

    // Add Rekaman Histori
    document.getElementById('add-histori').addEventListener('click', function() {
        const container = document.getElementById('histori-container');
        const newRow = document.createElement('div');
        newRow.className = 'row mb-2 histori-row';
        newRow.innerHTML = `
            <div class="col-md-2">
                <input type="text" class="form-control form-control-sm" 
                    name="rekaman_histori[${historiCount}][no]" placeholder="No.">
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control form-control-sm" 
                    name="rekaman_histori[${historiCount}][yang_diubah]" placeholder="Yang Diubah">
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control form-control-sm" 
                    name="rekaman_histori[${historiCount}][isi_perubahan]" placeholder="Isi Perubahan">
            </div>
            <div class="col-md-2">
                <div class="input-group input-group-sm">
                    <input type="text" class="form-control" 
                        name="rekaman_histori[${historiCount}][tanggal_berlaku]" placeholder="Tgl Berlaku">
                    <button type="button" class="btn btn-outline-danger btn-sm remove-histori">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            </div>
        `;
        container.appendChild(newRow);
        historiCount++;
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-histori') || e.target.parentElement.classList.contains('remove-histori')) {
            e.target.closest('.histori-row').remove();
        }
    });
});
</script>
@endpush