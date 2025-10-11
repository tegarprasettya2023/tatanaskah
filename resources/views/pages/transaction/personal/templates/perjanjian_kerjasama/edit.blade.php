@extends('layout.main')

@section('content')
<x-breadcrumb :values="[__('menu.transaction.menu'), 'Surat Pribadi', 'Edit Perjanjian Kerja Sama']" />

<div class="card mb-4">
    <form action="{{ route('transaction.personal.perjanjian.update', $data->id) }}" method="POST" id="letterForm">
        @csrf
        @method('PUT')
        <input type="hidden" name="template_type" value="perjanjian_kerjasama">

        <div class="card-header">
            <h5>Edit Surat Perjanjian Kerja Sama</h5>
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
                    <option value="klinik" {{ ($data->kop_type ?? 'klinik') === 'klinik' ? 'selected' : '' }}>Klinik</option>
                    <option value="lab" {{ ($data->kop_type ?? '') === 'lab' ? 'selected' : '' }}>Laboratorium</option>
                    <option value="pt" {{ ($data->kop_type ?? '') === 'pt' ? 'selected' : '' }}>PT</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label for="nomor" class="form-label">Nomor SPK</label>
                <input type="text" class="form-control" id="nomor" name="nomor" 
                       value="{{ $data->nomor }}" placeholder="SPK/001/01/2025" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="letter_date" class="form-label">Tanggal Surat</label>
                <input type="date" class="form-control" id="letter_date" name="letter_date" 
                value="{{ \Carbon\Carbon::parse($data->letter_date)->format('Y-m-d') }}" required>

            </div>

            <div class="col-md-6 mb-3">
                <label for="tempat" class="form-label">Tempat Penandatanganan</label>
                <input type="text" class="form-control" id="tempat" name="tempat" 
                       value="{{ $data->tempat }}" placeholder="Surabaya" required>
            </div>

            {{-- Informasi Pihak --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Informasi Para Pihak</h6>
            </div>

            <div class="col-md-6">
                <h6 class="text-primary">Pihak I</h6>
                <div class="mb-3">
                    <label class="form-label">Nama Pihak I</label>
                    <input type="text" class="form-control" name="pihak1" value="{{ $data->pihak1 }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Institusi</label>
                    <input type="text" class="form-control" name="institusi1" value="{{ $data->institusi1 }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jabatan</label>
                    <input type="text" class="form-control" name="jabatan1" value="{{ $data->jabatan1 }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" name="nama1" value="{{ $data->nama1 }}" required>
                </div>
            </div>

            <div class="col-md-6">
                <h6 class="text-primary">Pihak II</h6>
                <div class="mb-3">
                    <label class="form-label">Nama Pihak II</label>
                    <input type="text" class="form-control" name="pihak2" value="{{ $data->pihak2 }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Institusi</label>
                    <input type="text" class="form-control" name="institusi2" value="{{ $data->institusi2 }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jabatan</label>
                    <input type="text" class="form-control" name="jabatan2" value="{{ $data->jabatan2 }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" name="nama2" value="{{ $data->nama2 }}" required>
                </div>
            </div>

            {{-- Tentang Kerja Sama --}}
            <div class="col-12 mb-3 mt-3">
                <h6 class="border-bottom pb-2">Objek Kerja Sama</h6>
                <label class="form-label">Tentang Kerja Sama</label>
                <input type="text" class="form-control" name="tentang" 
                       value="{{ $data->tentang }}" placeholder="Bidang kerja sama yang akan dilakukan" required>
            </div>

            {{-- Pasal Dinamis --}}
            <div class="col-12 mb-3 mt-3">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2">
                    <h6 class="mb-0">Isi Perjanjian (Pasal)</h6>
                    <button type="button" id="add-pasal" class="btn btn-sm btn-success">
                        <i class="bi bi-plus-circle"></i> Tambah Pasal
                    </button>
                </div>
            </div>

            <div class="col-12">
                <div id="pasal-wrapper">
                    {{-- Pasal akan dimuat dari database --}}
                    @if(!empty($data->pasal_data))
                        @foreach($data->pasal_data as $index => $pasal)
                        <div class="pasal-item mb-3" data-index="{{ $index }}">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label fw-bold mb-0">Pasal {{ $index + 1 }}</label>
                                @if($index > 0)
                                <button type="button" class="btn btn-sm btn-danger remove-pasal">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                                @endif
                            </div>
                            <input type="text" name="pasal[{{ $index }}][title]" 
                                   class="form-control mb-2" 
                                   placeholder="Judul Pasal (opsional)"
                                   value="{{ $pasal['title'] ?? '' }}">
                            <textarea name="pasal[{{ $index }}][content]" rows="4" 
                                      class="form-control" 
                                      placeholder="Isi pasal {{ $index + 1 }}..." 
                                      required>{{ $pasal['content'] ?? '' }}</textarea>
                        </div>
                        @endforeach
                    @else
                        {{-- Default 1 pasal jika kosong --}}
                        <div class="pasal-item mb-3" data-index="0">
                            <label class="form-label fw-bold">Pasal 1</label>
                            <input type="text" name="pasal[0][title]" class="form-control mb-2" placeholder="Judul Pasal (opsional)">
                            <textarea name="pasal[0][content]" rows="4" class="form-control" placeholder="Isi pasal 1..." required></textarea>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Update Surat
            </button>
            <a href="{{ route('transaction.personal.perjanjian.show', $data->id) }}" class="btn btn-secondary">
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
.text-primary {
    color: #0d6efd !important;
}
.pasal-item {
    background-color: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    border: 1px solid #dee2e6;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const wrapper = document.getElementById("pasal-wrapper");
    const addBtn = document.getElementById("add-pasal");

    // Fungsi untuk mendapatkan index tertinggi
    function getMaxIndex() {
        const items = wrapper.querySelectorAll('.pasal-item');
        let maxIndex = -1;
        items.forEach(item => {
            const idx = parseInt(item.getAttribute('data-index'));
            if (idx > maxIndex) maxIndex = idx;
        });
        return maxIndex;
    }

    // Fungsi untuk reindex semua pasal
    function reindexPasal() {
        const items = wrapper.querySelectorAll('.pasal-item');
        items.forEach((item, idx) => {
            item.setAttribute('data-index', idx);
            item.querySelector('label').textContent = `Pasal ${idx + 1}`;
            
            const titleInput = item.querySelector('input[name*="[title]"]');
            const contentTextarea = item.querySelector('textarea[name*="[content]"]');
            
            titleInput.name = `pasal[${idx}][title]`;
            contentTextarea.name = `pasal[${idx}][content]`;
            contentTextarea.placeholder = `Isi pasal ${idx + 1}...`;
            
            // Show/hide remove button
            const removeBtn = item.querySelector('.remove-pasal');
            if (idx === 0 && removeBtn) {
                removeBtn.remove();
            } else if (idx > 0 && !removeBtn) {
                const btnDiv = item.querySelector('.d-flex');
                const newBtn = document.createElement('button');
                newBtn.type = 'button';
                newBtn.className = 'btn btn-sm btn-danger remove-pasal';
                newBtn.innerHTML = '<i class="bi bi-trash"></i> Hapus';
                btnDiv.appendChild(newBtn);
            }
        });
    }

    // Tambah pasal baru
    addBtn.addEventListener("click", function () {
        const newIndex = getMaxIndex() + 1;
        const div = document.createElement("div");
        div.classList.add("pasal-item", "mb-3");
        div.setAttribute('data-index', newIndex);
        div.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-2">
                <label class="form-label fw-bold mb-0">Pasal ${newIndex + 1}</label>
                <button type="button" class="btn btn-sm btn-danger remove-pasal">
                    <i class="bi bi-trash"></i> Hapus
                </button>
            </div>
            <input type="text" name="pasal[${newIndex}][title]" class="form-control mb-2" placeholder="Judul Pasal (opsional)">
            <textarea name="pasal[${newIndex}][content]" rows="4" class="form-control" placeholder="Isi pasal ${newIndex + 1}..." required></textarea>
        `;
        wrapper.appendChild(div);
    });

    // Hapus pasal
    wrapper.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-pasal') || e.target.closest('.remove-pasal')) {
            const items = wrapper.querySelectorAll('.pasal-item');
            if (items.length > 1) {
                const pasalItem = e.target.closest('.pasal-item');
                pasalItem.remove();
                reindexPasal();
            } else {
                alert('Minimal harus ada 1 pasal!');
            }
        }
    });
});
</script>
@endpush