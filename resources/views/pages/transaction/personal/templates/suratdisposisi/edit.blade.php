@extends('layout.main')

@section('content')
<x-breadcrumb :values="[__('menu.transaction.menu'), 'Surat Pribadi', 'Formulir Disposisi', 'Edit']" />

<div class="card mb-4">
    <form action="{{ route('transaction.personal.suratdisposisi.update', $data->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="template_type" value="suratdisposisi">

        <div class="card-header">
            <h5>Edit Formulir Disposisi</h5>
        </div>

        <div class="card-body row">
            {{-- Informasi Header --}}
            <div class="col-12 mb-4">
                <h6 class="border-bottom pb-2">Informasi Dasar</h6>
            </div>

            <div class="col-md-4 mb-3">
                <label for="logo_type" class="form-label">Pilih Logo</label>
                <select class="form-select" id="logo_type" name="logo_type" required>
                    <option value="klinik" {{ old('logo_type', $data->logo_type) == 'klinik' ? 'selected' : '' }}>Klinik</option>
                    <option value="lab" {{ old('logo_type', $data->logo_type) == 'lab' ? 'selected' : '' }}>Laboratorium</option>
                    <option value="pt" {{ old('logo_type', $data->logo_type) == 'pt' ? 'selected' : '' }}>PT</option>
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label for="kop_type" class="form-label">Pilih Kop Surat</label>
                <select class="form-select" id="kop_type" name="kop_type" required>
                    <option value="klinik" {{ old('kop_type', $data->kop_type) == 'klinik' ? 'selected' : '' }}>Klinik</option>
                    <option value="lab" {{ old('kop_type', $data->kop_type) == 'lab' ? 'selected' : '' }}>Laboratorium</option>
                    <option value="pt" {{ old('kop_type', $data->kop_type) == 'pt' ? 'selected' : '' }}>PT</option>
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <x-input-form name="nomor_dokumen" label="No. Dokumen" 
                    placeholder="LD/001/X/2025" :value="old('nomor_dokumen', $data->nomor_dokumen)" />
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="no_revisi" label="No. Revisi" 
                    placeholder="00" :value="old('no_revisi', $data->no_revisi)" />
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="halaman_dari" type="number" label="Halaman dari" 
                    :value="old('halaman_dari', $data->halaman_dari)" />
            </div>

            {{-- Tabel Kiri --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Informasi Pembuat (Tabel Kiri)</h6>
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="bagian_pembuat" label="Dari (Bagian Pembuat)" 
                    :value="old('bagian_pembuat', $data->bagian_pembuat)" />
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="nomor_tanggal" label="Nomor/Tanggal" 
                    placeholder="001/2025" :value="old('nomor_tanggal', $data->nomor_tanggal)" />
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="perihal" label="Perihal" 
                    :value="old('perihal', $data->perihal)" />
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="kepada" label="Kepada" 
                    :value="old('kepada', $data->kepada)" />
            </div>

            <div class="col-12 mb-3">
                <label for="ringkasan_isi" class="form-label">Ringkasan Isi</label>
                <textarea class="form-control" id="ringkasan_isi" name="ringkasan_isi" rows="3">{{ old('ringkasan_isi', $data->ringkasan_isi) }}</textarea>
            </div>

            <div class="col-12 mb-3">
                <label for="instruksi_1" class="form-label">Instruksi (Tabel Kiri)</label>
                <textarea class="form-control" id="instruksi_1" name="instruksi_1" rows="3">{{ old('instruksi_1', $data->instruksi_1) }}</textarea>
            </div>

            {{-- Tabel Kanan --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Informasi Disposisi (Tabel Kanan)</h6>
            </div>

            <div class="col-md-4 mb-3">
                <x-input-form name="tanggal_pembuatan" type="date" label="Tanggal (Pembuatan)" 
                    :value="old('tanggal_pembuatan', $data->tanggal_pembuatan ? $data->tanggal_pembuatan->format('Y-m-d') : '')" />
            </div>

            <div class="col-md-4 mb-3">
                <x-input-form name="no_agenda" label="No. Agenda" 
                    :value="old('no_agenda', $data->no_agenda)" />
            </div>

            <div class="col-md-4 mb-3">
                <x-input-form name="paraf" label="Paraf" 
                    :value="old('paraf', $data->paraf)" />
            </div>

            <div class="col-12 mb-3">
                <label class="form-label">Diteruskan Kepada</label>
                <div id="diteruskan-container">
                    @if(old('diteruskan_kepada', $data->diteruskan_kepada))
                        @foreach(old('diteruskan_kepada', $data->diteruskan_kepada ?? []) as $item)
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" name="diteruskan_kepada[]" value="{{ $item }}" placeholder="Nama/Jabatan">
                            <button type="button" class="btn btn-danger" onclick="this.parentElement.remove()">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                        @endforeach
                    @else
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" name="diteruskan_kepada[]" placeholder="Nama/Jabatan">
                            <button type="button" class="btn btn-success" onclick="addDiteruskan()">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                    @endif
                </div>
                <button type="button" class="btn btn-sm btn-success mt-2" onclick="addDiteruskan()">
                    <i class="bi bi-plus"></i> Tambah Baris
                </button>
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="tanggal_diserahkan" type="date" label="Tanggal Diserahkan" 
                    :value="old('tanggal_diserahkan', $data->tanggal_diserahkan ? $data->tanggal_diserahkan->format('Y-m-d') : '')" />
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="tanggal_kembali" type="date" label="Tanggal Kembali" 
                    :value="old('tanggal_kembali', $data->tanggal_kembali ? $data->tanggal_kembali->format('Y-m-d') : '')" />
            </div>

            <div class="col-12 mb-3">
                <label for="instruksi_2" class="form-label">Instruksi (Tabel Kanan)</label>
                <textarea class="form-control" id="instruksi_2" name="instruksi_2" rows="3">{{ old('instruksi_2', $data->instruksi_2) }}</textarea>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Perbarui Formulir
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