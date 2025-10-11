@extends('layout.main')

@section('content')
<x-breadcrumb :values="[__('menu.transaction.menu'), 'Surat Pribadi', 'Buat Surat Keterangan']" />

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
    <form action="{{ route('transaction.personal.surat_keterangan.store') }}" method="POST">
        @csrf
        <input type="hidden" name="template_type" value="surat_keterangan">

        <div class="card-header">
            <h5>Buat Surat Keterangan</h5>
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
                       id="nomor" name="nomor" placeholder="KET/.../Bulan/Tahun" 
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

            {{-- Yang Bertanda Tangan (Yang Menerangkan) --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Yang Bertanda Tangan Di Bawah Ini</h6>
            </div>

            <div class="col-md-4 mb-3">
                <label for="nama_yang_menerangkan" class="form-label">Nama <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nama_yang_menerangkan') is-invalid @enderror" 
                       id="nama_yang_menerangkan" name="nama_yang_menerangkan" 
                       value="{{ old('nama_yang_menerangkan') }}" required>
                @error('nama_yang_menerangkan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="nik_yang_menerangkan" class="form-label">NIK <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nik_yang_menerangkan') is-invalid @enderror" 
                       id="nik_yang_menerangkan" name="nik_yang_menerangkan" 
                       value="{{ old('nik_yang_menerangkan') }}" required>
                @error('nik_yang_menerangkan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="jabatan_yang_menerangkan" class="form-label">Jabatan <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('jabatan_yang_menerangkan') is-invalid @enderror" 
                       id="jabatan_yang_menerangkan" name="jabatan_yang_menerangkan" 
                       value="{{ old('jabatan_yang_menerangkan') }}" required>
                @error('jabatan_yang_menerangkan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Dengan Ini Menerangkan Bahwa --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Dengan Ini Menerangkan Bahwa</h6>
            </div>

            <div class="col-md-4 mb-3">
                <label for="nama_yang_diterangkan" class="form-label">Nama <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nama_yang_diterangkan') is-invalid @enderror" 
                       id="nama_yang_diterangkan" name="nama_yang_diterangkan" 
                       value="{{ old('nama_yang_diterangkan') }}" required>
                @error('nama_yang_diterangkan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="nip_yang_diterangkan" class="form-label">NIP <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nip_yang_diterangkan') is-invalid @enderror" 
                       id="nip_yang_diterangkan" name="nip_yang_diterangkan" 
                       value="{{ old('nip_yang_diterangkan') }}" required>
                @error('nip_yang_diterangkan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="jabatan_yang_diterangkan" class="form-label">Jabatan <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('jabatan_yang_diterangkan') is-invalid @enderror" 
                       id="jabatan_yang_diterangkan" name="jabatan_yang_diterangkan" 
                       value="{{ old('jabatan_yang_diterangkan') }}" required>
                @error('jabatan_yang_diterangkan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Isi Keterangan --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Isi Keterangan</h6>
            </div>

            <div class="col-12 mb-3">
                <label for="isi_keterangan" class="form-label">Isi Keterangan <span class="text-danger">*</span></label>
                <textarea class="form-control @error('isi_keterangan') is-invalid @enderror" 
                          id="isi_keterangan" name="isi_keterangan" rows="8" required>{{ old('isi_keterangan') }}</textarea>
                <small class="text-muted">Tulis isi keterangan yang ingin disampaikan</small>
                @error('isi_keterangan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Pembuat Keterangan --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Pembuat Keterangan (Penandatangan)</h6>
            </div>

            <div class="col-md-4 mb-3">
                <label for="jabatan_pembuat" class="form-label">Jabatan <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('jabatan_pembuat') is-invalid @enderror" 
                       id="jabatan_pembuat" name="jabatan_pembuat" 
                       placeholder="Jabatan Pembuat Keterangan"
                       value="{{ old('jabatan_pembuat') }}" required>
                @error('jabatan_pembuat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="nama_pembuat" class="form-label">Nama Pejabat <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nama_pembuat') is-invalid @enderror" 
                       id="nama_pembuat" name="nama_pembuat" 
                       placeholder="Nama Pejabat"
                       value="{{ old('nama_pembuat') }}" required>
                @error('nama_pembuat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="nik_pembuat" class="form-label">NIK Kepegawaian <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nik_pembuat') is-invalid @enderror" 
                       id="nik_pembuat" name="nik_pembuat" 
                       placeholder="NIK Kepegawaian"
                       value="{{ old('nik_pembuat') }}" required>
                @error('nik_pembuat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
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