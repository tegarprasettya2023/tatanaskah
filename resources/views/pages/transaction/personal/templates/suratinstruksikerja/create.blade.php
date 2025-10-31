@extends('layout.main')

@section('content')
<x-breadcrumb :values="[__('menu.transaction.menu'), 'Surat Pribadi', 'Instruksi Kerja']" />

<div class="card mb-4">
    <form action="{{ route('transaction.personal.suratinstruksikerja.store') }}" method="POST">
        @csrf
        <input type="hidden" name="template_type" value="instruksi_kerja">

        <div class="card-header">
            <h5>Buat Instruksi Kerja</h5>
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
                    <option value="klinik" {{ old('logo_kiri') == 'klinik' ? 'selected' : '' }}>Tritunggal</option>
                    <option value="lab" {{ old('logo_kiri') == 'lab' ? 'selected' : '' }}>Laboratorium</option>
                    <option value="pt" {{ old('logo_kiri') == 'pt' ? 'selected' : '' }}>PT</option>
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
                    <option value="klinik" {{ old('logo_kanan') == 'klinik' ? 'selected' : '' }}>Tritunggal</option>
                    <option value="lab" {{ old('logo_kanan') == 'lab' ? 'selected' : '' }}>Laboratorium</option>
                    <option value="pt" {{ old('logo_kanan') == 'pt' ? 'selected' : '' }}>PT</option>
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
                    <option value="klinik" {{ old('kop_type') == 'klinik' ? 'selected' : '' }}>Kop Klinik</option>
                    <option value="lab" {{ old('kop_type') == 'lab' ? 'selected' : '' }}>Kop Laboratorium</option>
                    <option value="pt" {{ old('kop_type') == 'pt' ? 'selected' : '' }}>Kop PT</option>
                </select>
                @error('kop_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Header & Footer PDF</small>
            </div>

            <div class="col-12 mb-3">
                <x-input-form name="judul_ik" label="Judul Instruksi Kerja" 
                    placeholder="JUDUL IK"
                    :value="old('judul_ik')" 
                    :required="true" />
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="no_dokumen" label="No. Dokumen" 
                    placeholder="Contoh: IK/001/X/2025"
                    :value="old('no_dokumen')" 
                    :required="true" />
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="no_revisi" label="No. Revisi" 
                    placeholder="00"
                    :value="old('no_revisi', '00')" />
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="tanggal_terbit" type="date" label="Tanggal Terbit"
                    :value="old('tanggal_terbit', date('Y-m-d'))" 
                    :required="true" />
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="halaman" label="Halaman" 
                    placeholder="1/1"
                    :value="old('halaman', '1/1')" />
            </div>

            {{-- Ditetapkan Oleh --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Ditetapkan Oleh</h6>
            </div>

            <div class="col-md-4 mb-3">
                <x-input-form name="jabatan_menetapkan" label="Jabatan" 
                    placeholder="Kepala Laboratorium Utama Trisensa"
                    :value="old('jabatan_menetapkan')" />
            </div>

            <div class="col-md-4 mb-3">
                <x-input-form name="nama_menetapkan" label="Nama" 
                    placeholder="Dr. dr. Herni Suprapti, M. Kes"
                    :value="old('nama_menetapkan')" />
            </div>

            <div class="col-md-4 mb-3">
                <x-input-form name="nip_menetapkan" label="NIP" 
                    placeholder="208111505"
                    :value="old('nip_menetapkan')" />
            </div>

            {{-- Isi Tabel --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Isi Dokumen</h6>
            </div>

            <div class="col-12 mb-3">
                <label for="pengertian" class="form-label">1. Pengertian</label>
                <textarea class="form-control @error('pengertian') is-invalid @enderror" 
                    id="pengertian" name="pengertian" rows="3">{{ old('pengertian') }}</textarea>
                @error('pengertian')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12 mb-3">
                <label for="tujuan" class="form-label">2. Tujuan</label>
                <textarea class="form-control @error('tujuan') is-invalid @enderror" 
                    id="tujuan" name="tujuan" rows="3">{{ old('tujuan') }}</textarea>
                @error('tujuan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12 mb-3">
                <label for="kebijakan" class="form-label">3. Kebijakan</label>
                <textarea class="form-control @error('kebijakan') is-invalid @enderror" 
                    id="kebijakan" name="kebijakan" rows="3">{{ old('kebijakan') }}</textarea>
                @error('kebijakan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12 mb-3">
                <label for="pelaksana" class="form-label">4. Pelaksana</label>
                <textarea class="form-control @error('pelaksana') is-invalid @enderror" 
                    id="pelaksana" name="pelaksana" rows="3">{{ old('pelaksana') }}</textarea>
                @error('pelaksana')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Prosedur Kerja --}}
            <div class="col-12 mb-3">
                <label class="form-label">5. Prosedur Kerja/Langkah-langkah Kerja</label>
                <div id="prosedur-container">
                    <div class="input-group mb-2">
                        <span class="input-group-text">5.1 Prinsip</span>
                        <input type="text" class="form-control" name="prosedur_kerja[]" 
                            placeholder="Isi Prinsip" value="{{ old('prosedur_kerja.0') }}">
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text">5.2 Metode</span>
                        <input type="text" class="form-control" name="prosedur_kerja[]" 
                            placeholder="Isi Metode" value="{{ old('prosedur_kerja.1') }}">
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text">5.3 Sampel</span>
                        <input type="text" class="form-control" name="prosedur_kerja[]" 
                            placeholder="Isi Sampel" value="{{ old('prosedur_kerja.2') }}">
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text">5.4 Reagen</span>
                        <input type="text" class="form-control" name="prosedur_kerja[]" 
                            placeholder="Isi Reagen" value="{{ old('prosedur_kerja.3') }}">
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text">5.5 Bahan Kontrol</span>
                        <input type="text" class="form-control" name="prosedur_kerja[]" 
                            placeholder="Isi Bahan Kontrol" value="{{ old('prosedur_kerja.4') }}">
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text">5.6 Kalibrator</span>
                        <input type="text" class="form-control" name="prosedur_kerja[]" 
                            placeholder="Isi Kalibrator" value="{{ old('prosedur_kerja.5') }}">
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-outline-primary" id="add-prosedur">
                    <i class="bi bi-plus-circle"></i> Tambah Item
                </button>
            </div>

            <div class="col-12 mb-3">
                <label for="hal_hal_perlu_diperhatikan" class="form-label">6. Hal-Hal Yang Perlu Diperhatikan</label>
                <textarea class="form-control" 
                    id="hal_hal_perlu_diperhatikan" name="hal_hal_perlu_diperhatikan" rows="3">{{ old('hal_hal_perlu_diperhatikan') }}</textarea>
            </div>

            <div class="col-12 mb-3">
                <label for="unit_terkait" class="form-label">7. Unit terkait</label>
                <textarea class="form-control" 
                    id="unit_terkait" name="unit_terkait" rows="2">{{ old('unit_terkait') }}</textarea>
            </div>

            <div class="col-12 mb-3">
                <label for="dokumen_terkait" class="form-label">8. Dokumen terkait</label>
                <textarea class="form-control" 
                    id="dokumen_terkait" name="dokumen_terkait" rows="2">{{ old('dokumen_terkait') }}</textarea>
            </div>

            <div class="col-12 mb-3">
                <label for="referensi" class="form-label">9. Referensi</label>
                <textarea class="form-control" 
                    id="referensi" name="referensi" rows="2">{{ old('referensi') }}</textarea>
            </div>

            {{-- Rekaman Histori Perubahan --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">10. Rekaman Histori Perubahan</h6>
            </div>

            <div class="col-12 mb-3">
                <label class="form-label">Tabel Rekaman Histori</label>
                <div id="histori-container">
                    <div class="row mb-2 histori-row">
                        <div class="col-md-2">
                            <input type="text" class="form-control form-control-sm" 
                                name="rekaman_histori[0][no]" placeholder="No." 
                                value="{{ old('rekaman_histori.0.no') }}">
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control form-control-sm" 
                                name="rekaman_histori[0][yang_diubah]" placeholder="Yang Diubah" 
                                value="{{ old('rekaman_histori.0.yang_diubah') }}">
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control form-control-sm" 
                                name="rekaman_histori[0][isi_perubahan]" placeholder="Isi Perubahan" 
                                value="{{ old('rekaman_histori.0.isi_perubahan') }}">
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control form-control-sm" 
                                name="rekaman_histori[0][tanggal_berlaku]" placeholder="Tgl Berlaku" 
                                value="{{ old('rekaman_histori.0.tanggal_berlaku') }}">
                        </div>
                    </div>
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
                    :value="old('dibuat_jabatan')" />
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Direview oleh:</label>
                <x-input-form name="direview_jabatan" label="Jabatan" 
                    placeholder="Jabatan reviewer"
                    :value="old('direview_jabatan')" />
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="dibuat_nama" label="Nama" 
                    placeholder="Nama pembuat"
                    :value="old('dibuat_nama')" />
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="direview_nama" label="Nama" 
                    placeholder="Nama reviewer"
                    :value="old('direview_nama')" />
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="dibuat_tanggal" type="date" label="Tanggal" 
                    :value="old('dibuat_tanggal')" />
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="direview_tanggal" type="date" label="Tanggal" 
                    :value="old('direview_tanggal')" />
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Simpan Instruksi Kerja
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
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let prosedurCount = 6;
    
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
});
</script>
@endpush