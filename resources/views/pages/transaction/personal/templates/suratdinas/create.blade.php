@extends('layout.main')

@section('content')
<x-breadcrumb :values="[__('menu.transaction.menu'), 'Surat Pribadi', 'Buat Surat Dinas']" />

{{-- Alert Error --}}
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
    <form action="{{ route('transaction.personal.surat_dinas.store') }}" method="POST">
        @csrf
        <input type="hidden" name="template_type" value="surat_dinas">

        <div class="card-header">
            <h5>Buat Surat Dinas</h5>
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
                       id="nomor" name="nomor" placeholder="SD/001/01/2025" 
                       value="{{ old('nomor') }}" required>
                @error('nomor')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="sifat" class="form-label">Sifat</label>
                <input type="text" class="form-control @error('sifat') is-invalid @enderror" 
                       id="sifat" name="sifat" placeholder="Segera/Biasa/Rahasia"
                       value="{{ old('sifat') }}">
                @error('sifat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="lampiran" class="form-label">Lampiran</label>
                <input type="text" class="form-control @error('lampiran') is-invalid @enderror" 
                       id="lampiran" name="lampiran" placeholder="1 berkas / -"
                       value="{{ old('lampiran') }}">
                @error('lampiran')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="perihal" class="form-label">Perihal <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('perihal') is-invalid @enderror" 
                       id="perihal" name="perihal" placeholder="Undangan Rapat" 
                       value="{{ old('perihal') }}" required>
                @error('perihal')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="letter_date" class="form-label">Tanggal Surat <span class="text-danger">*</span></label>
                <input type="date" class="form-control @error('letter_date') is-invalid @enderror" 
                       id="letter_date" name="letter_date" 
                       value="{{ old('letter_date') }}" required>
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

            {{-- Tujuan Surat --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Tujuan Surat</h6>
            </div>

            <div class="col-md-6 mb-3">
                <label for="kepada" class="form-label">Yth. <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('kepada') is-invalid @enderror" 
                       id="kepada" name="kepada" placeholder="Kepala Laboratorium" 
                       value="{{ old('kepada') }}" required>
                @error('kepada')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="kepada_tempat" class="form-label">di (Tempat) <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('kepada_tempat') is-invalid @enderror" 
                       id="kepada_tempat" name="kepada_tempat" placeholder="Tempat" 
                       value="{{ old('kepada_tempat') }}" required>
                @error('kepada_tempat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Isi Surat --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Isi Surat</h6>
            </div>

            <div class="col-12 mb-3">
                <label for="sehubungan_dengan" class="form-label">Sehubungan dengan <span class="text-danger">*</span></label>
                <textarea class="form-control @error('sehubungan_dengan') is-invalid @enderror" 
                          id="sehubungan_dengan" name="sehubungan_dengan" rows="2"
                          placeholder="rencana pelaksanaan kegiatan..." required>{{ old('sehubungan_dengan') }}</textarea>
                <small class="text-muted">Lanjutan dari kalimat "Sehubungan dengan..."</small>
                @error('sehubungan_dengan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12 mb-3">
                <label for="isi_surat" class="form-label">Isi Surat (Paragraf Berikutnya)</label>
                <textarea class="form-control @error('isi_surat') is-invalid @enderror" 
                          id="isi_surat" name="isi_surat" rows="8" 
                          placeholder="Tulis isi surat dinas di sini...">{{ old('isi_surat') }}</textarea>
                <small class="text-muted">Isi surat setelah paragraf "Sehubungan dengan..."</small>
                @error('isi_surat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Penandatangan --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Penandatangan</h6>
            </div>

            <div class="col-md-4 mb-3">
                <label for="jabatan1" class="form-label">Jabatan <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('jabatan1') is-invalid @enderror" 
                       id="jabatan1" name="jabatan1" placeholder="Direktur" 
                       value="{{ old('jabatan1') }}" required>
                @error('jabatan1')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="nama1" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nama1') is-invalid @enderror" 
                       id="nama1" name="nama1" placeholder="Dr. Ahmad Hidayat" 
                       value="{{ old('nama1') }}" required>
                @error('nama1')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="nip" class="form-label">NIP/NIK Kepegawaian</label>
                <input type="text" class="form-control @error('nip') is-invalid @enderror" 
                       id="nip" name="nip" placeholder="198501012010011001"
                       value="{{ old('nip') }}">
                @error('nip')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tembusan --}}
            <div class="col-12 mb-4 mt-3">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2">
                    <h6 class="mb-0">Tembusan</h6>
                    <button type="button" id="add-tembusan" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-plus-circle"></i> Tambah Tembusan
                    </button>
                </div>
            </div>

            <div class="col-12">
                <div id="tembusan-wrapper">
                    @if(old('tembusan'))
                        @foreach(old('tembusan') as $index => $tembusan)
                        <div class="tembusan-item mb-2">
                            <div class="input-group">
                                <span class="input-group-text">{{ $index + 1 }}.</span>
                                <input type="text" name="tembusan[]" class="form-control" 
                                       placeholder="Nama/Jabatan penerima tembusan"
                                       value="{{ $tembusan }}">
                                @if($index > 0)
                                <button type="button" class="btn btn-outline-danger remove-tembusan">
                                    <i class="bi bi-trash"></i>
                                </button>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="tembusan-item mb-2">
                            <div class="input-group">
                                <span class="input-group-text">1.</span>
                                <input type="text" name="tembusan[]" class="form-control" 
                                       placeholder="Nama/Jabatan penerima tembusan">
                            </div>
                        </div>
                    @endif
                </div>
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
.tembusan-item {
    background-color: #f8f9fa;
    padding: 10px;
    border-radius: 5px;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const wrapper = document.getElementById("tembusan-wrapper");
    const addBtn = document.getElementById("add-tembusan");

    function getTembusanCount() {
        return wrapper.querySelectorAll('.tembusan-item').length;
    }

    addBtn.addEventListener("click", function () {
        const count = getTembusanCount() + 1;
        const div = document.createElement("div");
        div.classList.add("tembusan-item", "mb-2");
        div.innerHTML = `
            <div class="input-group">
                <span class="input-group-text">${count}.</span>
                <input type="text" name="tembusan[]" class="form-control" 
                       placeholder="Nama/Jabatan penerima tembusan">
                <button type="button" class="btn btn-outline-danger remove-tembusan">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        `;
        wrapper.appendChild(div);
    });

    wrapper.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-tembusan') || e.target.closest('.remove-tembusan')) {
            const items = wrapper.querySelectorAll('.tembusan-item');
            if (items.length > 1) {
                const tembusanItem = e.target.closest('.tembusan-item');
                tembusanItem.remove();
                reindexTembusan();
            } else {
                alert('Minimal harus ada 1 tembusan!');
            }
        }
    });

    function reindexTembusan() {
        const items = wrapper.querySelectorAll('.tembusan-item');
        items.forEach((item, idx) => {
            item.querySelector('.input-group-text').textContent = `${idx + 1}.`;
        });
    }
});
</script>
@endpush
