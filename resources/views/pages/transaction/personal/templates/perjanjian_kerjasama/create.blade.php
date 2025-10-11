@extends('layout.main')

@section('content')
<x-breadcrumb :values="[__('menu.transaction.menu'), 'Surat Pribadi', 'Perjanjian Kerja Sama']" />

<div class="card mb-4">
    <form action="{{ route('transaction.personal.perjanjian.store') }}" method="POST">
        @csrf
        <input type="hidden" name="template_type" value="perjanjian_kerjasama">

        <div class="card-header">
            <h5>Buat Surat Perjanjian Kerja Sama</h5>
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
                <x-input-form name="nomor" label="Nomor SPK" placeholder="SPK/001/01/2025" />
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="letter_date" type="date" label="Tanggal Surat" />
            </div>

            <div class="col-md-6 mb-3">
                <x-input-form name="tempat" label="Tempat Penandatanganan" placeholder="Surabaya" />
            </div>

            {{-- Informasi Pihak --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Informasi Para Pihak</h6>
            </div>

            <div class="col-md-6">
                <h6 class="text-primary">Pihak I</h6>
                <x-input-form name="pihak1" label="Nama Pihak I" />
                <x-input-form name="institusi1" label="Nama Institusi" />
                <x-input-form name="jabatan1" label="Jabatan" />
                <x-input-form name="nama1" label="Nama Lengkap" />
            </div>

            <div class="col-md-6">
                <h6 class="text-primary">Pihak II</h6>
                <x-input-form name="pihak2" label="Nama Pihak II" />
                <x-input-form name="institusi2" label="Nama Institusi" />
                <x-input-form name="jabatan2" label="Jabatan" />
                <x-input-form name="nama2" label="Nama Lengkap" />
            </div>

            {{-- Tentang Kerja Sama --}}
            <div class="col-12 mb-3 mt-3">
                <h6 class="border-bottom pb-2">Objek Kerja Sama</h6>
                <x-input-form name="tentang" label="Tentang Kerja Sama" placeholder="Bidang kerja sama yang akan dilakukan" />
            </div>

            {{-- Pasal Dinamis --}}
        <div id="pasal-wrapper">
    @php $oldPasal = old('pasal', [['title' => '', 'content' => '']]); @endphp
    @foreach ($oldPasal as $i => $p)
        <div class="pasal-item mb-3">
            <label class="form-label fw-bold">Pasal {{ $i + 1 }}</label>
            <input type="text" name="pasal[{{ $i }}][title]" class="form-control mb-2"
                   placeholder="Judul Pasal (opsional)" value="{{ $p['title'] }}">
            <textarea name="pasal[{{ $i }}][content]" rows="4" class="form-control"
                      placeholder="Isi pasal {{ $i + 1 }}...">{{ $p['content'] }}</textarea>
        </div>
    @endforeach
</div>


            <button type="button" id="add-pasal" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-plus-circle"></i> Tambah Pasal
            </button>
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
.text-primary {
    color: #0d6efd !important;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    let index = 1;
    const wrapper = document.getElementById("pasal-wrapper");
    const addBtn = document.getElementById("add-pasal");

    addBtn.addEventListener("click", function () {
        index++;
        const div = document.createElement("div");
        div.classList.add("pasal-item", "mb-3");
        div.innerHTML = `
            <label class="form-label fw-bold">Pasal ${index}</label>
            <input type="text" name="pasal[${index - 1}][title]" class="form-control mb-2" placeholder="Judul Pasal (opsional)">
            <textarea name="pasal[${index - 1}][content]" rows="4" class="form-control"
                      placeholder="Isi pasal ${index}..."></textarea>
        `;
        wrapper.appendChild(div);
    });
});
</script>
@endpush
