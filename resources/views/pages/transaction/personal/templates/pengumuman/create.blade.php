@extends('layout.main')

@section('content')
<x-breadcrumb :values="[__('menu.transaction.menu'), 'Surat Pribadi', 'Buat Surat Pengumuman']" />

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show">
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
    <form action="{{ route('transaction.personal.pengumuman.store') }}" method="POST">
        @csrf
        <input type="hidden" name="template_type" value="pengumuman">

        <div class="card-header">
            <h5><i class="bi bi-megaphone"></i> Buat Surat Pengumuman</h5>
        </div>

        <div class="card-body row">
            {{-- Kop & Tanggal --}}
            <div class="col-md-6 mb-3">
                <label>Kop Surat <span class="text-danger">*</span></label>
                <select name="kop_type" class="form-select" required>
                    <option value="">-- Pilih Kop --</option>
                    <option value="klinik">Klinik</option>
                    <option value="lab">Laboratorium</option>
                    <option value="pt">PT</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label>Tanggal Surat <span class="text-danger">*</span></label>
                <input type="date" name="tanggal_surat" class="form-control" 
                       value="{{ old('tanggal_surat', date('Y-m-d')) }}" required>
            </div>

            {{-- Tentang --}}
            <div class="col-12 mb-3">
                <label>Tentang <span class="text-danger">*</span></label>
                <input type="text" name="tentang" class="form-control" 
                       placeholder="Tuliskan pokok pengumuman" value="{{ old('tentang') }}" required>
            </div>

            {{-- Isi Pembuka --}}
            <div class="col-12 mb-3">
                <label>Isi Pengumuman <span class="text-danger">*</span></label>
                <textarea name="isi_pembuka" rows="6" class="form-control" 
                          placeholder="Tuliskan isi utama pengumuman..." required>{{ old('isi_pembuka') }}</textarea>
            </div>

            {{-- Isi Penutup --}}
            <div class="col-12 mb-3">
                <label>Isi Penutup</label>
                <textarea name="isi_penutup" rows="4" class="form-control" 
                          placeholder="Tuliskan penutup pengumuman (opsional)...">{{ old('isi_penutup') }}</textarea>
            </div>

            <div class="col-12"><hr></div>

            {{-- Tempat & Tanggal --}}
            <div class="col-md-6 mb-3">
                <label>Tempat Dikeluarkan <span class="text-danger">*</span></label>
                <input type="text" name="tempat_ttd" class="form-control" 
                       value="{{ old('tempat_ttd', 'Surabaya') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Tanggal Dikeluarkan <span class="text-danger">*</span></label>
                <input type="date" name="tanggal_ttd" class="form-control" 
                       value="{{ old('tanggal_ttd', date('Y-m-d')) }}" required>
            </div>

            {{-- Jabatan, Nama, dan NIK --}}
            <div class="col-md-4 mb-3">
                <label>Jabatan <span class="text-danger">*</span></label>
                <input type="text" name="jabatan_pembuat" class="form-control" 
                       value="{{ old('jabatan_pembuat') }}" required>
            </div>
            <div class="col-md-4 mb-3">
                <label>Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" name="nama_pembuat" class="form-control" 
                       value="{{ old('nama_pembuat') }}" required>
            </div>
            <div class="col-md-4 mb-3">
                <label>NIK Pegawai <span class="text-danger">*</span></label>
                <input type="text" name="nik_pegawai" class="form-control" 
                       value="{{ old('nik_pegawai') }}" required>
            </div>
        </div>

        <div class="card-footer d-flex gap-2">
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
