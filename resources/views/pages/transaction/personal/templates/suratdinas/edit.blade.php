@extends('layout.main')

@section('content')
<x-breadcrumb :values="[__('menu.transaction.menu'), 'Surat Pribadi', 'Edit Surat Dinas']" />

<div class="card mb-4">
<form action="{{ route('transaction.personal.surat_dinas.update', $data->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="template_type" value="surat_dinas">

        <div class="card-header">
            <h5>Edit Surat Dinas</h5>
        </div>

        <div class="card-body row">
            {{-- Informasi Dasar --}}
            <div class="col-12 mb-4">
                <h6 class="border-bottom pb-2">Informasi Dasar</h6>
            </div>

            <div class="col-md-6 mb-3">
                <label for="kop_type" class="form-label">Pilih Kop Surat</label>
                <select class="form-select" id="kop_type" name="kop_type" required>
                    <option value="klinik" {{ ($data->kop_type ?? '') === 'klinik' ? 'selected' : '' }}>Klinik</option>
                    <option value="lab" {{ ($data->kop_type ?? '') === 'lab' ? 'selected' : '' }}>Laboratorium</option>
                    <option value="pt" {{ ($data->kop_type ?? '') === 'pt' ? 'selected' : '' }}>PT</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label for="nomor" class="form-label">Nomor Surat</label>
                <input type="text" class="form-control" id="nomor" name="nomor" 
                       value="{{ $data->nomor }}" placeholder="SD/001/01/2025" required>
            </div>

            <div class="col-md-4 mb-3">
                <label for="sifat" class="form-label">Sifat</label>
                <input type="text" class="form-control" id="sifat" name="sifat" 
                       value="{{ $data->sifat }}" placeholder="Segera/Biasa/Rahasia">
            </div>

            <div class="col-md-4 mb-3">
                <label for="lampiran" class="form-label">Lampiran</label>
                <input type="text" class="form-control" id="lampiran" name="lampiran" 
                       value="{{ $data->lampiran }}" placeholder="1 berkas / -">
            </div>

            <div class="col-md-4 mb-3">
                <label for="perihal" class="form-label">Perihal</label>
                <input type="text" class="form-control" id="perihal" name="perihal" 
                       value="{{ $data->perihal }}" placeholder="Undangan Rapat" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="letter_date" class="form-label">Tanggal Surat</label>
               <input type="date" class="form-control" id="letter_date" name="letter_date" 
                    value="{{ $data->letter_date ? $data->letter_date->format('Y-m-d') : '' }}" required>

            </div>

            <div class="col-md-6 mb-3">
                <label for="tempat" class="form-label">Tempat</label>
                <input type="text" class="form-control" id="tempat" name="tempat" 
                       value="{{ $data->tempat }}" placeholder="Surabaya" required>
            </div>

            {{-- Tujuan Surat --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Tujuan Surat</h6>
            </div>

            <div class="col-md-6 mb-3">
                <label for="kepada" class="form-label">Yth.</label>
                <input type="text" class="form-control" id="kepada" name="kepada" 
                       value="{{ $data->kepada }}" placeholder="Kepala Bagian SDM" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="kepada_tempat" class="form-label">di (Tempat)</label>
                <input type="text" class="form-control" id="kepada_tempat" name="kepada_tempat" 
                       value="{{ $data->kepada_tempat }}" placeholder="Tempat" required>
            </div>

            {{-- Isi Surat --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Isi Surat</h6>
            </div>

            <div class="col-12 mb-3">
                <label for="sehubungan_dengan" class="form-label">Sehubungan dengan</label>
                <textarea class="form-control" id="sehubungan_dengan" name="sehubungan_dengan" rows="2" required>{{ $data->sehubungan_dengan }}</textarea>
                <small class="text-muted">Lanjutan dari kalimat "Sehubungan dengan..."</small>
            </div>

            <div class="col-12 mb-3">
                <label for="isi_surat" class="form-label">Isi Surat (Paragraf Berikutnya)</label>
                <textarea class="form-control" id="isi_surat" name="isi_surat" rows="8">{{ $data->isi_surat }}</textarea>
                <small class="text-muted">Isi surat setelah paragraf "Sehubungan dengan..."</small>
            </div>

            {{-- Penandatangan --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Penandatangan</h6>
            </div>

            <div class="col-md-4 mb-3">
                <label for="jabatan1" class="form-label">Jabatan</label>
                <input type="text" class="form-control" id="jabatan1" name="jabatan1" 
                       value="{{ $data->jabatan1 }}" placeholder="Direktur" required>
            </div>

            <div class="col-md-4 mb-3">
                <label for="nama1" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama1" name="nama1" 
                       value="{{ $data->nama1 }}" placeholder="Dr. Ahmad Hidayat" required>
            </div>

            <div class="col-md-4 mb-3">
                <label for="nip" class="form-label">NIP/NIK Kepegawaian</label>
                <input type="text" class="form-control" id="nip" name="nip" 
                       value="{{ $data->nip }}" placeholder="198501012010011001">
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
                    @if(!empty($data->tembusan_data))
                        @foreach($data->tembusan_data as $index => $tembusan)
                        <div class="tembusan-item mb-2">
                            <div class="input-group">
                                <span class="input-group-text">{{ $index + 1 }}.</span>
                                <input type="text" name="tembusan[]" class="form-control" 
                                       value="{{ $tembusan }}" placeholder="Nama/Jabatan penerima tembusan">
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
                                <input type="text" name="tembusan[]" class="form-control" placeholder="Nama/Jabatan penerima tembusan">
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Update Surat
            </button>
            <a href="{{ route('transaction.personal.surat_dinas.show', $data->id) }}" class="btn btn-secondary">
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
                <input type="text" name="tembusan[]" class="form-control" placeholder="Nama/Jabatan penerima tembusan">
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