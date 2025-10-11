@extends('layout.main')

@section('content')
<x-breadcrumb :values="[__('menu.transaction.menu'), 'Surat Pribadi', 'Buat Internal Memo']" />

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
    <form action="{{ route('transaction.personal.memo.store') }}" method="POST">
        @csrf
        <input type="hidden" name="template_type" value="internal_memo">

        <div class="card-header">
            <h5>Buat Internal Memo</h5>
            <small class="text-muted">Nomor akan di-generate otomatis: IM/001/bulan/tahun</small>
        </div>

        <div class="card-body row">
            {{-- Informasi Dasar --}}
            <div class="col-12 mb-4">
                <h6 class="border-bottom pb-2">Informasi Dasar</h6>
            </div>

            <div class="col-md-4 mb-3">
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

            <div class="col-md-4 mb-3">
                <label for="tempat_ttd" class="form-label">Tempat <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('tempat_ttd') is-invalid @enderror" 
                       id="tempat_ttd" name="tempat_ttd" value="{{ old('tempat_ttd', 'Surabaya') }}" required>
                @error('tempat_ttd')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="letter_date" class="form-label">Tanggal <span class="text-danger">*</span></label>
                <input type="date" class="form-control @error('letter_date') is-invalid @enderror" 
                       id="letter_date" name="letter_date" value="{{ old('letter_date', date('Y-m-d')) }}" required>
                <small class="text-muted">Untuk nomor & tanggal di surat</small>
                @error('letter_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Penerima --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Penerima Memo</h6>
            </div>

            <div class="col-md-6 mb-3">
                <label for="yth_nama" class="form-label">Yth. <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('yth_nama') is-invalid @enderror" 
                       id="yth_nama" name="yth_nama" value="{{ old('yth_nama') }}" required>
                @error('yth_nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="hal" class="form-label">Hal <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('hal') is-invalid @enderror" 
                       id="hal" name="hal" value="{{ old('hal') }}" required>
                @error('hal')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Isi Memo --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Isi Memo</h6>
            </div>

            <div class="col-12 mb-3">
                <label for="sehubungan_dengan" class="form-label">Sehubungan dengan <span class="text-danger">*</span></label>
                <textarea class="form-control @error('sehubungan_dengan') is-invalid @enderror" 
                          id="sehubungan_dengan" name="sehubungan_dengan" rows="3" 
                          placeholder="Isi melanjutkan kalimat 'Sehubungan dengan...'" required>{{ old('sehubungan_dengan') }}</textarea>
                <small class="text-muted">Akan otomatis ada spasi di awal paragraf</small>
                @error('sehubungan_dengan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12 mb-3">
                <label for="alinea_isi" class="form-label">Alinea Isi <span class="text-danger">*</span></label>
                <textarea class="form-control @error('alinea_isi') is-invalid @enderror" 
                          id="alinea_isi" name="alinea_isi" rows="5" 
                          placeholder="Isi alinea" required>{{ old('alinea_isi') }}</textarea>
                <small class="text-muted">Akan otomatis ada spasi di awal paragraf</small>
                @error('alinea_isi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Penandatangan --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Penandatangan</h6>
            </div>

            <div class="col-md-4 mb-3">
                <label for="jabatan_pembuat" class="form-label">Jabatan <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('jabatan_pembuat') is-invalid @enderror" 
                       id="jabatan_pembuat" name="jabatan_pembuat" value="{{ old('jabatan_pembuat') }}" required>
                @error('jabatan_pembuat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="nama_pembuat" class="form-label">Nama <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nama_pembuat') is-invalid @enderror" 
                       id="nama_pembuat" name="nama_pembuat" value="{{ old('nama_pembuat') }}" required>
                @error('nama_pembuat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="nik_pembuat" class="form-label">NIKepegawaian <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nik_pembuat') is-invalid @enderror" 
                       id="nik_pembuat" name="nik_pembuat" value="{{ old('nik_pembuat') }}" required>
                @error('nik_pembuat')
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