@extends('layout.main')

@section('content')
<x-breadcrumb :values="[__('menu.transaction.menu'), 'Surat Pribadi', 'Surat Kuasa']" />

<div class="card mb-4">
    <form action="{{ route('transaction.personal.suratkuasa.store') }}" method="POST">
        @csrf
        <input type="hidden" name="template_type" value="suratkuasa">

        <div class="card-header">
            <h5>Buat Surat Kuasa</h5>
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
                    <option value="klinik">Klinik</option>
                    <option value="lab">Laboratorium</option>
                    <option value="pt">PT</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="nomor" label="Nomor Surat" placeholder="KUASA/001/I/2025" />
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="letter_date" type="date" label="Tanggal Surat" />
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="tempat" label="Tempat Penandatanganan" placeholder="Surabaya" />
            </div>

            {{-- Pemberi Kuasa --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Pemberi Kuasa</h6>
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="nama_pemberi" label="Nama" />
            </div>
            <div class="col-md-6 mb-3">
                <x-input-form name="nip_pemberi" label="NIP" />
            </div>
            <div class="col-md-6 mb-3">
                <x-input-form name="jabatan_pemberi" label="Jabatan" />
            </div>
            <div class="col-md-6 mb-3">
                <x-input-form name="alamat_pemberi" label="Alamat" />
            </div>

            {{-- Penerima Kuasa --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Penerima Kuasa</h6>
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="nama_penerima" label="Nama" />
            </div>
            <div class="col-md-6 mb-3">
                <x-input-form name="nip_penerima" label="NIP" />
            </div>
            <div class="col-md-6 mb-3">
                <x-input-form name="jabatan_penerima" label="Jabatan" />
            </div>
            <div class="col-md-6 mb-3">
                <x-input-form name="alamat_penerima" label="Alamat" />
            </div>

            {{-- Keperluan --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Keperluan Kuasa</h6>
            </div>

            <div class="col-12 mb-3">
                <label for="keperluan" class="form-label">Untuk</label>
<textarea class="form-control" id="isi" name="isi" rows="3" placeholder="Tuliskan keperluan kuasa...">{{ old('isi') }}</textarea>
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

@push('styles')
<style>
.border-bottom {
    border-bottom: 2px solid #dee2e6 !important;
}
</style>
@endpush
