@extends('layout.main')

@section('content')
<x-breadcrumb :values="[__('menu.transaction.menu'), 'Surat Pribadi', 'Buat Surat Undangan']" />

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
    <form action="{{ route('transaction.personal.surat_undangan.store') }}" method="POST">
        @csrf
        <input type="hidden" name="template_type" value="surat_undangan">

        <div class="card-header">
            <h5>Buat Surat Undangan</h5>
        </div>

        <div class="card-body row">
            {{-- Informasi Dasar --}}
            <div class="col-12 mb-4">
                <h6 class="border-bottom pb-2">Informasi Dasar</h6>
            </div>

            <div class="col-md-6 mb-3">
                <label for="kop_type" class="form-label">Pilih Kop Surat <span class="text-danger">*</span></label>
                <select class="form-select @error('kop_type') is-invalid @enderror" id="kop_type" name="kop_type" required>
                    <option value="klinik" {{ old('kop_type') == 'klinik' ? 'selected' : '' }}>Klinik</option>
                    <option value="lab" {{ old('kop_type') == 'lab' ? 'selected' : '' }}>Laboratorium</option>
                    <option value="pt" {{ old('kop_type') == 'pt' ? 'selected' : '' }}>PT</option>
                </select>
                @error('kop_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="nomor" class="form-label">Nomor Surat <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nomor') is-invalid @enderror" 
                       id="nomor" name="nomor" placeholder="UND/nomor/bulan/tahun" 
                       value="{{ old('nomor') }}" required>
                @error('nomor')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="sifat" class="form-label">Sifat</label>
                <input type="text" class="form-control @error('sifat') is-invalid @enderror" 
                       id="sifat" name="sifat" value="{{ old('sifat') }}">
                @error('sifat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="lampiran" class="form-label">Lampiran</label>
                <input type="text" class="form-control @error('lampiran') is-invalid @enderror" 
                       id="lampiran" name="lampiran" value="{{ old('lampiran') }}">
                @error('lampiran')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="perihal" class="form-label">Perihal <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('perihal') is-invalid @enderror" 
                       id="perihal" name="perihal" value="{{ old('perihal') }}" required>
                @error('perihal')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Penerima --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Kepada Yth.</h6>
            </div>

            <div class="col-12 mb-3">
                <label for="yth_nama" class="form-label">Nama <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('yth_nama') is-invalid @enderror" 
                       id="yth_nama" name="yth_nama" value="{{ old('yth_nama') }}" required>
                @error('yth_nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12 mb-3">
                <label for="yth_alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                <textarea class="form-control @error('yth_alamat') is-invalid @enderror" 
                          id="yth_alamat" name="yth_alamat" rows="3" required>{{ old('yth_alamat') }}</textarea>
                @error('yth_alamat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Isi Surat --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Isi Undangan</h6>
            </div>

            <div class="col-12 mb-3">
                <label for="isi_pembuka" class="form-label">Pembuka (Sehubungan dengan...) <span class="text-danger">*</span></label>
                <textarea class="form-control @error('isi_pembuka') is-invalid @enderror" 
                          id="isi_pembuka" name="isi_pembuka" rows="4" required>{{ old('isi_pembuka') }}</textarea>
                @error('isi_pembuka')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="hari_tanggal" class="form-label">Hari, Tanggal <span class="text-danger">*</span></label>
                <input type="date" class="form-control @error('hari_tanggal') is-invalid @enderror" 
                    id="hari_tanggal" name="hari_tanggal" value="{{ old('hari_tanggal') }}" required>
                @error('hari_tanggal')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="pukul" class="form-label">Pukul <span class="text-danger">*</span></label>
                <input type="time" class="form-control @error('pukul') is-invalid @enderror" 
                    id="pukul" name="pukul" value="{{ old('pukul') }}" required>
                @error('pukul')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="tempat_acara" class="form-label">Tempat Acara <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('tempat_acara') is-invalid @enderror" 
                    id="tempat_acara" name="tempat_acara" value="{{ old('tempat_acara') }}" required>
                @error('tempat_acara')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="acara" class="form-label">Acara <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('acara') is-invalid @enderror" 
                    id="acara" name="acara" value="{{ old('acara') }}" required>
                @error('acara')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Penandatangan --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Penandatangan</h6>
            </div>

           <div class="col-md-6 mb-3">
    <label for="tempat_ttd" class="form-label">Tempat TTD <span class="text-danger">*</span></label>
    <input type="text" class="form-control @error('tempat_ttd') is-invalid @enderror" 
        id="tempat_ttd" name="tempat_ttd" value="{{ old('tempat_ttd') }}" required>
    @error('tempat_ttd')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="col-md-6 mb-3">
    <label for="tanggal_ttd" class="form-label">Tanggal TTD <span class="text-danger">*</span></label>
    <input type="date" class="form-control @error('tanggal_ttd') is-invalid @enderror" 
        id="tanggal_ttd" name="tanggal_ttd" 
        value="{{ old('tanggal_ttd') }}" required>
    @error('tanggal_ttd')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

            <div class="col-md-6 mb-3">
                <label for="jabatan_pembuat" class="form-label">Jabatan <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('jabatan_pembuat') is-invalid @enderror" 
                    id="jabatan_pembuat" name="jabatan_pembuat" value="{{ old('jabatan_pembuat') }}" required>
                @error('jabatan_pembuat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="nama_pembuat" class="form-label">Nama <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nama_pembuat') is-invalid @enderror" 
                    id="nama_pembuat" name="nama_pembuat" value="{{ old('nama_pembuat') }}" required>
                @error('nama_pembuat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


            {{-- Tembusan --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Tembusan <small class="text-muted">(Opsional)</small></h6>
            </div>

            <div class="col-12 mb-3">
                <label for="tembusan_1" class="form-label">1.</label>
                <input type="text" class="form-control @error('tembusan_1') is-invalid @enderror" 
                       id="tembusan_1" name="tembusan_1" value="{{ old('tembusan_1') }}">
                @error('tembusan_1')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12 mb-3">
                <label for="tembusan_2" class="form-label">2.</label>
                <input type="text" class="form-control @error('tembusan_2') is-invalid @enderror" 
                       id="tembusan_2" name="tembusan_2" value="{{ old('tembusan_2') }}">
                @error('tembusan_2')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Daftar Undangan (Dynamic) --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Lampiran Daftar Yang Diundang <small class="text-muted">(Opsional)</small></h6>
            </div>

            <div class="col-12 mb-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="35%">Nama</th>
                            <th width="30%">Jabatan</th>
                            <th width="30%">Unit Kerja</th>
                        </tr>
                    </thead>
                    <tbody id="daftar-rows">
                        <tr>
                            <td class="text-center">1</td>
                            <td><input type="text" name="daftar_undangan[0][nama]" class="form-control"></td>
                            <td><input type="text" name="daftar_undangan[0][jabatan]" class="form-control"></td>
                            <td><input type="text" name="daftar_undangan[0][unit_kerja]" class="form-control"></td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" class="btn btn-sm btn-success" onclick="addDaftarRow()">
                    <i class="bi bi-plus-circle"></i> Tambah Baris
                </button>
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
</style>
@endpush

@push('scripts')
<script>
let rowIndex = 1;
function addDaftarRow() {
    const tbody = document.getElementById('daftar-rows');
    let row = `
    <tr>
        <td class="text-center">${rowIndex + 1}</td>
        <td><input type="text" name="daftar_undangan[${rowIndex}][nama]" class="form-control"></td>
        <td><input type="text" name="daftar_undangan[${rowIndex}][jabatan]" class="form-control"></td>
        <td><input type="text" name="daftar_undangan[${rowIndex}][unit_kerja]" class="form-control"></td>
    </tr>`;
    tbody.insertAdjacentHTML('beforeend', row);
    rowIndex++;
}
</script>
@endpush