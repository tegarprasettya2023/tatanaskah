@extends('layout.main')

@section('content')
<x-breadcrumb :values="[__('menu.transaction.menu'), 'Surat Pribadi', 'Edit Surat Pengumuman']" />

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
  <form action="{{ route('transaction.personal.pengumuman.update', $data->id) }}" method="POST">
    @csrf
    @method('PUT')

        <div class="card-header">
            <h5><i class="bi bi-megaphone"></i> Edit Surat Pengumuman</h5>
        </div>

        <div class="card-body row">
            <div class="col-md-6 mb-3">
                <label>Kop Surat *</label>
                <select name="kop_type" class="form-select" required>
                    <option value="klinik" {{ $data->kop_type=='klinik'?'selected':'' }}>Klinik</option>
                    <option value="lab" {{ $data->kop_type=='lab'?'selected':'' }}>Laboratorium</option>
                    <option value="pt" {{ $data->kop_type=='pt'?'selected':'' }}>PT</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label>Tanggal Surat *</label>
                <input type="date" name="tanggal_surat" class="form-control" 
                    value="{{ old('tanggal_surat', \Carbon\Carbon::parse($data->tanggal_surat)->format('Y-m-d')) }}" required>
            </div>

            <div class="col-12 mb-3">
                <label>Tentang *</label>
                <input type="text" name="tentang" class="form-control"
                       value="{{ old('tentang', $data->tentang) }}" required>
            </div>

            <div class="col-12 mb-3">
                <label>Isi Pengumuman *</label>
                <textarea name="isi_pembuka" rows="6" class="form-control" required>{{ old('isi_pembuka', $data->isi_pembuka) }}</textarea>
            </div>

            <div class="col-12 mb-3">
                <label>Isi Penutup</label>
                <textarea name="isi_penutup" rows="4" class="form-control">{{ old('isi_penutup', $data->isi_penutup) }}</textarea>
            </div>

            <div class="col-12"><hr></div>

            <div class="col-md-6 mb-3">
                <label>Tempat Dikeluarkan *</label>
                <input type="text" name="tempat_ttd" class="form-control"
                       value="{{ old('tempat_ttd', $data->tempat_ttd) }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Tanggal Dikeluarkan *</label>
                <input type="date" name="tanggal_ttd" class="form-control"
                       value="{{ old('tanggal_ttd', \Carbon\Carbon::parse($data->tanggal_ttd)->format('Y-m-d')) }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label>Jabatan *</label>
                <input type="text" name="jabatan_pembuat" class="form-control"
                       value="{{ old('jabatan_pembuat', $data->jabatan_pembuat) }}" required>
            </div>
            <div class="col-md-4 mb-3">
                <label>Nama Lengkap *</label>
                <input type="text" name="nama_pembuat" class="form-control"
                       value="{{ old('nama_pembuat', $data->nama_pembuat) }}" required>
            </div>
            <div class="col-md-4 mb-3">
                <label>NIK Pegawai *</label>
                <input type="text" name="nik_pegawai" class="form-control"
                       value="{{ old('nik_pegawai', $data->nik_pegawai) }}" required>
            </div>
        </div>

        <div class="card-footer d-flex gap-2">
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Perbarui</button>
            <a href="{{ route('transaction.personal.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </form>
</div>
@endsection
