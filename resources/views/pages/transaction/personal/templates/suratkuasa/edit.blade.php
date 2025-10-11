@extends('layout.main')

@section('content')
<x-breadcrumb :values="[__('menu.transaction.menu'), 'Surat Pribadi', 'Surat Kuasa']" />

<div class="card mb-4">
    <form action="{{ route('transaction.personal.suratkuasa.update', $data->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="template_type" value="suratkuasa">

        <div class="card-header">
            <h5>Edit Surat Kuasa</h5>
        </div>

        <div class="card-body row">
            {{-- Informasi Dasar --}}
            <div class="col-12 mb-4">
                <h6 class="border-bottom pb-2">Informasi Dasar</h6>
            </div>

            <!-- Pilih Kop -->
            <div class="col-md-6 mb-3">
                <label for="kop_type" class="form-label">Pilih Kop Surat</label>
                <select class="form-select" id="kop_type" name="kop_type" required>
                    <option value="klinik" {{ old('kop_type', $data->kop_type) == 'klinik' ? 'selected' : '' }}>Klinik</option>
                    <option value="lab" {{ old('kop_type', $data->kop_type) == 'lab' ? 'selected' : '' }}>Laboratorium</option>
                    <option value="pt" {{ old('kop_type', $data->kop_type) == 'pt' ? 'selected' : '' }}>PT</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="nomor" label="Nomor Surat" 
                    placeholder="KUASA/001/I/2025"
                    :value="old('nomor', $data->nomor)" />
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="letter_date" type="date" label="Tanggal Surat"
                    :value="old('letter_date', $data->letter_date ? $data->letter_date->format('Y-m-d') : '')" />
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="tempat" label="Tempat Penandatanganan" placeholder="Surabaya"
                    :value="old('tempat', $data->tempat)" />
            </div>

            {{-- Pemberi Kuasa --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Pemberi Kuasa</h6>
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="nama_pemberi" label="Nama"
                    :value="old('nama_pemberi', $data->nama_pemberi)" />
            </div>
            <div class="col-md-6 mb-3">
                <x-input-form name="nip_pemberi" label="NIP"
                    :value="old('nip_pemberi', $data->nip_pemberi)" />
            </div>
            <div class="col-md-6 mb-3">
                <x-input-form name="jabatan_pemberi" label="Jabatan"
                    :value="old('jabatan_pemberi', $data->jabatan_pemberi)" />
            </div>
            <div class="col-md-6 mb-3">
                <x-input-form name="alamat_pemberi" label="Alamat"
                    :value="old('alamat_pemberi', $data->alamat_pemberi)" />
            </div>

            {{-- Penerima Kuasa --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Penerima Kuasa</h6>
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="nama_penerima" label="Nama"
                    :value="old('nama_penerima', $data->nama_penerima)" />
            </div>
            <div class="col-md-6 mb-3">
                <x-input-form name="nip_penerima" label="NIP"
                    :value="old('nip_penerima', $data->nip_penerima)" />
            </div>
            <div class="col-md-6 mb-3">
                <x-input-form name="jabatan_penerima" label="Jabatan"
                    :value="old('jabatan_penerima', $data->jabatan_penerima)" />
            </div>
            <div class="col-md-6 mb-3">
                <x-input-form name="alamat_penerima" label="Alamat"
                    :value="old('alamat_penerima', $data->alamat_penerima)" />
            </div>

            {{-- Keperluan --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Keperluan Kuasa</h6>
            </div>

            <div class="col-12 mb-3">
                <label for="isi" class="form-label">Untuk</label>
                <textarea class="form-control" id="isi" name="isi" rows="3" placeholder="Tuliskan keperluan kuasa...">{{ old('isi', $data->isi) }}</textarea>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Perbarui Surat
            </button>
                <a href="{{ route('transaction.personal.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
        </div>
    </form>
</div>
@endsection
