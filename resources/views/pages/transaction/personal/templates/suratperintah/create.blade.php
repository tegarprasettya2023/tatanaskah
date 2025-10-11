@extends('layout.main')

@section('content')
<x-breadcrumb :values="[__('menu.transaction.menu'), 'Surat Pribadi', 'Buat Surat Perintah']" />

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
    <form action="{{ route('transaction.personal.surat_perintah.store') }}" method="POST">
        @csrf
        <input type="hidden" name="template_type" value="surat_perintah">

        <div class="card-header">
            <h5>Buat Surat Perintah/Tugas</h5>
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
                       id="nomor" name="nomor" placeholder="ST/.../bulan/tahun" 
                       value="{{ old('nomor') }}" required>
                @error('nomor')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="letter_date" class="form-label">Tanggal Surat <span class="text-danger">*</span></label>
                <input type="date" class="form-control @error('letter_date') is-invalid @enderror" 
                       id="letter_date" name="letter_date" value="{{ old('letter_date') }}" required>
                @error('letter_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="tempat" class="form-label">Tempat <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('tempat') is-invalid @enderror" 
                       id="tempat" name="tempat" placeholder="Surabaya" 
                       value="{{ old('tempat') }}" required>
                @error('tempat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- MENIMBANG --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Menimbang</h6>
            </div>

            <div class="col-12 mb-3">
                <label for="menimbang_1" class="form-label">1. bahwa <span class="text-danger">*</span></label>
                <textarea class="form-control @error('menimbang_1') is-invalid @enderror" 
                          id="menimbang_1" name="menimbang_1" rows="3" 
                          placeholder="Isi pertimbangan pertama..." required>{{ old('menimbang_1') }}</textarea>
                @error('menimbang_1')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12 mb-3">
                <label for="menimbang_2" class="form-label">2. bahwa <span class="text-danger">*</span></label>
                <textarea class="form-control @error('menimbang_2') is-invalid @enderror" 
                          id="menimbang_2" name="menimbang_2" rows="3" 
                          placeholder="Isi pertimbangan kedua..." required>{{ old('menimbang_2') }}</textarea>
                @error('menimbang_2')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- DASAR --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Dasar</h6>
            </div>

            <div class="col-12 mb-3">
                <label for="dasar_a" class="form-label">a. <span class="text-danger">*</span></label>
                <textarea class="form-control @error('dasar_a') is-invalid @enderror" 
                          id="dasar_a" name="dasar_a" rows="2" 
                          placeholder="Dasar hukum atau peraturan pertama..." required>{{ old('dasar_a') }}</textarea>
                @error('dasar_a')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12 mb-3">
                <label for="dasar_b" class="form-label">b. <span class="text-danger">*</span></label>
                <textarea class="form-control @error('dasar_b') is-invalid @enderror" 
                          id="dasar_b" name="dasar_b" rows="2" 
                          placeholder="Dasar hukum atau peraturan kedua..." required>{{ old('dasar_b') }}</textarea>
                @error('dasar_b')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- MEMBERI PERINTAH KEPADA --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Memberi Perintah Kepada</h6>
            </div>

            <div class="col-md-4 mb-3">
                <label for="nama_penerima" class="form-label">Nama <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nama_penerima') is-invalid @enderror" 
                       id="nama_penerima" name="nama_penerima" 
                       value="{{ old('nama_penerima') }}" required>
                @error('nama_penerima')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="nik_penerima" class="form-label">NIKepegawaian <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nik_penerima') is-invalid @enderror" 
                       id="nik_penerima" name="nik_penerima" 
                       value="{{ old('nik_penerima') }}" required>
                @error('nik_penerima')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="jabatan_penerima" class="form-label">Jabatan <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('jabatan_penerima') is-invalid @enderror" 
                       id="jabatan_penerima" name="jabatan_penerima" 
                       value="{{ old('jabatan_penerima') }}" required>
                @error('jabatan_penerima')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12 mb-3">
                <label for="nama_nama_terlampir" class="form-label">Atau nama-nama terlampir <small class="text-muted">(Opsional)</small></label>
                <textarea class="form-control @error('nama_nama_terlampir') is-invalid @enderror" 
                          id="nama_nama_terlampir" name="nama_nama_terlampir" rows="3" 
                          placeholder="Tulis nama-nama lain yang terlampir (jika ada)...">{{ old('nama_nama_terlampir') }}</textarea>
                <small class="text-muted">Kosongkan jika hanya satu penerima perintah</small>
                @error('nama_nama_terlampir')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- UNTUK --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Untuk (Tujuan/Keperluan)</h6>
            </div>

            <div class="col-12 mb-3">
                <label for="untuk_1" class="form-label">1. <span class="text-danger">*</span></label>
                <textarea class="form-control @error('untuk_1') is-invalid @enderror" 
                          id="untuk_1" name="untuk_1" rows="3" 
                          placeholder="Tujuan/keperluan pertama..." required>{{ old('untuk_1') }}</textarea>
                @error('untuk_1')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12 mb-3">
                <label for="untuk_2" class="form-label">2. <span class="text-danger">*</span></label>
                <textarea class="form-control @error('untuk_2') is-invalid @enderror" 
                          id="untuk_2" name="untuk_2" rows="3" 
                          placeholder="Tujuan/keperluan kedua..." required>{{ old('untuk_2') }}</textarea>
                @error('untuk_2')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- PEMBUAT (PENANDATANGAN) --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Pembuat Surat (Penandatangan)</h6>
            </div>

            <div class="col-md-4 mb-3">
                <label for="jabatan_pembuat" class="form-label">Jabatan <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('jabatan_pembuat') is-invalid @enderror" 
                       id="jabatan_pembuat" name="jabatan_pembuat" 
                       placeholder="Nama jabatan"
                       value="{{ old('jabatan_pembuat') }}" required>
                @error('jabatan_pembuat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="nama_pembuat" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nama_pembuat') is-invalid @enderror" 
                       id="nama_pembuat" name="nama_pembuat" 
                       placeholder="Nama lengkap pejabat"
                       value="{{ old('nama_pembuat') }}" required>
                @error('nama_pembuat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="nik_pembuat" class="form-label">NIKepegawaian <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nik_pembuat') is-invalid @enderror" 
                       id="nik_pembuat" name="nik_pembuat" 
                       placeholder="NIK Kepegawaian"
                       value="{{ old('nik_pembuat') }}" required>
                @error('nik_pembuat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- TEMBUSAN --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Tembusan <small class="text-muted">(Opsional)</small></h6>
            </div>

            <div class="col-12 mb-3">
                <label for="tembusan_1" class="form-label">1.</label>
                <input type="text" class="form-control @error('tembusan_1') is-invalid @enderror" 
                       id="tembusan_1" name="tembusan_1" 
                       placeholder="Nama/Jabatan penerima tembusan pertama"
                       value="{{ old('tembusan_1') }}">
                @error('tembusan_1')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12 mb-3">
                <label for="tembusan_2" class="form-label">2.</label>
                <input type="text" class="form-control @error('tembusan_2') is-invalid @enderror" 
                       id="tembusan_2" name="tembusan_2" 
                       placeholder="Nama/Jabatan penerima tembusan kedua"
                       value="{{ old('tembusan_2') }}">
                @error('tembusan_2')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            {{-- LAMPIRAN DAFTAR NAMA --}}
<div class="col-12 mb-4 mt-3">
    <h6 class="border-bottom pb-2">Lampiran Daftar Nama yang Diberikan Tugas</h6>
</div>

<div class="col-12 mb-3">
    <label for="lampiran_nomor" class="form-label">Nomor Surat Tugas</label>
    <input type="text" class="form-control @error('lampiran_nomor') is-invalid @enderror" 
           id="lampiran_nomor" name="lampiran_nomor" 
           value="{{ old('lampiran_nomor') }}">
    @error('lampiran_nomor')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="col-12 mb-3">
    <label for="lampiran_tanggal" class="form-label">Tanggal</label>
    <input type="date" class="form-control @error('lampiran_tanggal') is-invalid @enderror" 
           id="lampiran_tanggal" name="lampiran_tanggal" 
           value="{{ old('lampiran_tanggal') }}">
    @error('lampiran_tanggal')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


{{-- Dynamic Input Daftar Nama --}}
<div class="col-12 mb-3">
    <label class="form-label">Daftar Nama</label>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NIK</th>
                <th>Jabatan</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody id="lampiran-rows">
            <tr>
                <td>1</td>
                <td><input type="text" name="lampiran[0][nama]" class="form-control"></td>
                <td><input type="text" name="lampiran[0][nik]" class="form-control"></td>
                <td><input type="text" name="lampiran[0][jabatan]" class="form-control"></td>
                <td><input type="text" name="lampiran[0][keterangan]" class="form-control"></td>
            </tr>
        </tbody>
    </table>
    <button type="button" class="btn btn-sm btn-success" onclick="addLampiranRow()">+ Tambah</button>
</div>

@push('scripts')
<script>
let rowIndex = 1;
function addLampiranRow() {
    const tbody = document.getElementById('lampiran-rows');
    let row = `
    <tr>
        <td>${rowIndex+1}</td>
        <td><input type="text" name="lampiran[${rowIndex}][nama]" class="form-control"></td>
        <td><input type="text" name="lampiran[${rowIndex}][nik]" class="form-control"></td>
        <td><input type="text" name="lampiran[${rowIndex}][jabatan]" class="form-control"></td>
        <td><input type="text" name="lampiran[${rowIndex}][keterangan]" class="form-control"></td>
    </tr>`;
    tbody.insertAdjacentHTML('beforeend', row);
    rowIndex++;
}
</script>
@endpush

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