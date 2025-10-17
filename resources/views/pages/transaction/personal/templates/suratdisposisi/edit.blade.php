@extends('layout.main')

@section('content')
<x-breadcrumb :values="[__('menu.transaction.menu'), 'Surat Pribadi', 'Edit Formulir Disposisi']" />

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
    <form action="{{ route('transaction.personal.disposisi.update', $data->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card-header">
            <h5>Edit Formulir Disposisi</h5>
        </div>

        <div class="card-body row">
            {{-- Informasi Header --}}
            <div class="col-12 mb-4">
                <h6 class="border-bottom pb-2">Informasi Header</h6>
            </div>

            <div class="col-md-4 mb-3">
                <label for="kop_type" class="form-label">Pilih Logo/Kop <span class="text-danger">*</span></label>
                <select class="form-select @error('kop_type') is-invalid @enderror" id="kop_type" name="kop_type" required>
                    <option value="">-- Pilih Logo --</option>
                    <option value="klinik" {{ old('kop_type', $data->kop_type) == 'klinik' ? 'selected' : '' }}>Klinik</option>
                    <option value="lab" {{ old('kop_type', $data->kop_type) == 'lab' ? 'selected' : '' }}>Laboratorium</option>
                    <option value="pt" {{ old('kop_type', $data->kop_type) == 'pt' ? 'selected' : '' }}>PT</option>
                </select>
                @error('kop_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Upload Logo --}}
            <div class="col-md-4 mb-3">
                <label for="logo_klinik" class="form-label">Logo Klinik</label>
                <input type="file" class="form-control @error('logo_klinik') is-invalid @enderror" id="logo_klinik" name="logo_klinik">
                @if($data->logo_klinik)
                    <small class="d-block mt-1 text-muted">Logo saat ini:</small>
                    <img src="{{ asset('storage/' . $data->logo_klinik) }}" alt="Logo Klinik" width="100">
                @endif
                @error('logo_klinik')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="logo_lab" class="form-label">Logo Laboratorium</label>
                <input type="file" class="form-control @error('logo_lab') is-invalid @enderror" id="logo_lab" name="logo_lab">
                @if($data->logo_lab)
                    <small class="d-block mt-1 text-muted">Logo saat ini:</small>
                    <img src="{{ asset('storage/' . $data->logo_lab) }}" alt="Logo Lab" width="100">
                @endif
                @error('logo_lab')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="logo_pt" class="form-label">Logo PT</label>
                <input type="file" class="form-control @error('logo_pt') is-invalid @enderror" id="logo_pt" name="logo_pt">
                @if($data->logo_pt)
                    <small class="d-block mt-1 text-muted">Logo saat ini:</small>
                    <img src="{{ asset('storage/' . $data->logo_pt) }}" alt="Logo PT" width="100">
                @endif
                @error('logo_pt')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Nomor LD --}}
            <div class="col-md-4 mb-3">
                <label for="nomor_ld" class="form-label">Nomor LD <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nomor_ld') is-invalid @enderror"
                       id="nomor_ld" name="nomor_ld"
                       value="{{ old('nomor_ld', $data->nomor_ld) }}" required>
                <small class="text-muted">Format: 001, 002, dst</small>
                @error('nomor_ld')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tanggal Dokumen --}}
            <div class="col-md-4 mb-3">
                <label for="tanggal_dokumen" class="form-label">Tanggal Dokumen <span class="text-danger">*</span></label>
                <input type="date" class="form-control @error('tanggal_dokumen') is-invalid @enderror"
                       id="tanggal_dokumen" name="tanggal_dokumen"
                       value="{{ old('tanggal_dokumen', $data->tanggal_dokumen?->format('Y-m-d')) }}" required>
                <small class="text-muted">Untuk No. Dokumen LD/bulan/tahun</small>
                @error('tanggal_dokumen')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- No Revisi --}}
            <div class="col-md-6 mb-3">
                <label for="no_revisi" class="form-label">No. Revisi <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('no_revisi') is-invalid @enderror"
                       id="no_revisi" name="no_revisi"
                       value="{{ old('no_revisi', $data->no_revisi) }}" required>
                @error('no_revisi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tanggal Pembuatan --}}
            <div class="col-md-6 mb-3">
                <label for="tanggal_pembuatan" class="form-label">Tanggal Pembuatan <span class="text-danger">*</span></label>
                <input type="date" class="form-control @error('tanggal_pembuatan') is-invalid @enderror"
                       id="tanggal_pembuatan" name="tanggal_pembuatan"
                       value="{{ old('tanggal_pembuatan', $data->tanggal_pembuatan?->format('Y-m-d')) }}" required>
                @error('tanggal_pembuatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Perihal & Paraf --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Perihal & Paraf</h6>
            </div>

            <div class="col-md-8 mb-3">
                <label for="perihal" class="form-label">Perihal <span class="text-danger">*</span></label>
                <textarea class="form-control @error('perihal') is-invalid @enderror"
                          id="perihal" name="perihal" rows="3"
                          required>{{ old('perihal', $data->perihal) }}</textarea>
                @error('perihal')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="paraf" class="form-label">Paraf</label>
                <input type="text" class="form-control @error('paraf') is-invalid @enderror"
                       id="paraf" name="paraf"
                       value="{{ old('paraf', $data->paraf) }}">
                @error('paraf')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Catatan --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Catatan</h6>
            </div>

            <div class="col-md-6 mb-3">
                <label for="catatan_1" class="form-label">Catatan Kolom 1</label>
                <textarea class="form-control @error('catatan_1') is-invalid @enderror"
                          id="catatan_1" name="catatan_1" rows="4">{{ old('catatan_1', $data->catatan_1) }}</textarea>
                @error('catatan_1')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="catatan_2" class="form-label">Catatan Kolom 2</label>
                <textarea class="form-control @error('catatan_2') is-invalid @enderror"
                          id="catatan_2" name="catatan_2" rows="4">{{ old('catatan_2', $data->catatan_2) }}</textarea>
                @error('catatan_2')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Perbarui Disposisi
            </button>
            <a href="{{ route('transaction.personal.templates') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </form>
</div>
@endsection