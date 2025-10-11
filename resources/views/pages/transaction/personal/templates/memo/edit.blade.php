@extends('layout.main')

@section('content')
<x-breadcrumb :values="[__('menu.transaction.menu'), 'Surat Pribadi', 'Internal Memo']" />

<div class="card mb-4">
    <form action="{{ route('transaction.personal.memo.update', $data->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="template_type" value="internal_memo">

        <div class="card-header">
            <h5>Edit Internal Memo</h5>
        </div>

        <div class="card-body row">
            {{-- Informasi Dasar --}}
            <div class="col-12 mb-4">
                <h6 class="border-bottom pb-2">Informasi Dasar</h6>
            </div>

            <div class="col-md-6 mb-3">
                <label for="kop_type" class="form-label">Pilih Kop Surat</label>
                <select class="form-select" id="kop_type" name="kop_type" required>
                    <option value="klinik" {{ old('kop_type', $data->kop_type) == 'klinik' ? 'selected' : '' }}>Klinik</option>
                    <option value="lab" {{ old('kop_type', $data->kop_type) == 'lab' ? 'selected' : '' }}>Laboratorium</option>
                    <option value="pt" {{ old('kop_type', $data->kop_type) == 'pt' ? 'selected' : '' }}>PT</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="letter_date" type="date" label="Tanggal Surat"
                    :value="old('letter_date', $data->letter_date ? $data->letter_date->format('Y-m-d') : '')" />
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="tempat_ttd" label="Tempat Penandatanganan"
                    :value="old('tempat_ttd', $data->tempat_ttd)" />
            </div>

            {{-- Penerima Memo --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Penerima Memo</h6>
            </div>
            <div class="col-md-6 mb-3">
                <x-input-form name="yth_nama" label="Yth."
                    :value="old('yth_nama', $data->yth_nama)" />
            </div>
            <div class="col-md-6 mb-3">
                <x-input-form name="hal" label="Hal"
                    :value="old('hal', $data->hal)" />
            </div>

            {{-- Isi Memo --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Isi Memo</h6>
            </div>
            <div class="col-12 mb-3">
                <label for="sehubungan_dengan" class="form-label">Sehubungan dengan</label>
                <textarea class="form-control" id="sehubungan_dengan" name="sehubungan_dengan" rows="3">{{ old('sehubungan_dengan', $data->sehubungan_dengan) }}</textarea>
            </div>
            <div class="col-12 mb-3">
                <label for="alinea_isi" class="form-label">Alinea Isi</label>
                <textarea class="form-control" id="alinea_isi" name="alinea_isi" rows="4">{{ old('alinea_isi', $data->alinea_isi) }}</textarea>
            </div>
            <div class="col-12 mb-3">
                <label for="isi_penutup" class="form-label">Isi Penutup</label>
                <textarea class="form-control" id="isi_penutup" name="isi_penutup" rows="2">{{ old('isi_penutup', $data->isi_penutup) }}</textarea>
            </div>

            {{-- Penandatangan --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Penandatangan</h6>
            </div>
            <div class="col-md-4 mb-3">
                <x-input-form name="jabatan_pembuat" label="Jabatan"
                    :value="old('jabatan_pembuat', $data->jabatan_pembuat)" />
            </div>
            <div class="col-md-4 mb-3">
                <x-input-form name="nama_pembuat" label="Nama"
                    :value="old('nama_pembuat', $data->nama_pembuat)" />
            </div>
            <div class="col-md-4 mb-3">
                <x-input-form name="nik_pembuat" label="NIK Pegawai"
                    :value="old('nik_pembuat', $data->nik_pembuat)" />
            </div>

            {{-- Tembusan --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Tembusan</h6>
            </div>
            <div class="col-md-6 mb-3">
                <x-input-form name="tembusan_1" label="1."
                    :value="old('tembusan_1', $data->tembusan_1)" />
            </div>
            <div class="col-md-6 mb-3">
                <x-input-form name="tembusan_2" label="2."
                    :value="old('tembusan_2', $data->tembusan_2)" />
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Perbarui Memo
            </button>
            <a href="{{ route('transaction.personal.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </form>
</div>
@endsection
