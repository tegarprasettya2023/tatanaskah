@extends('layout.main')

@section('content')
<x-breadcrumb :values="[__('menu.transaction.menu'), 'Surat Pribadi', 'Buat Surat Keputusan']" />

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
    <form action="{{ route('transaction.personal.surat_keputusan.store') }}" method="POST">
        @csrf

        <div class="card-header">
            <h5>Buat Surat Keputusan</h5>
        </div>

        <div class="card-body row">
            {{-- Informasi Dasar --}}
            <div class="col-12 mb-4">
                <h6 class="border-bottom pb-2">Informasi Dasar</h6>
            </div>

            <div class="col-md-6 mb-3">
                <label for="kop_type" class="form-label">Pilih Kop Surat <span class="text-danger">*</span></label>
                <select class="form-select @error('kop_type') is-invalid @enderror" id="kop_type" name="kop_type" required>
                    <option value="">-- Pilih Kop --</option>
                    <option value="klinik" {{ old('kop_type') == 'klinik' ? 'selected' : '' }}>Klinik</option>
                    <option value="lab" {{ old('kop_type', 'lab') == 'lab' ? 'selected' : '' }}>Laboratorium</option>
                    <option value="pt" {{ old('kop_type') == 'pt' ? 'selected' : '' }}>PT</option>
                </select>
                @error('kop_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="judul" class="form-label">Judul Surat</label>
                <input type="text" name="judul" id="judul" class="form-control"
                    value="{{ old('judul', $keputusan->judul ?? '') }}" placeholder="Masukkan judul surat">
            </div>

            <div class="col-md-6 mb-3">
                <label for="nomor" class="form-label">Nomor SK <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nomor') is-invalid @enderror" 
                       id="nomor" name="nomor" 
                       placeholder="SK/001/XII/2024" 
                       value="{{ old('nomor') }}" required>
                @error('nomor')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-12 mb-3">
                <label for="tentang" class="form-label">Tentang <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('tentang') is-invalid @enderror" 
                       id="tentang" name="tentang" 
                       placeholder="Contoh: Pembentukan Tim Audit Internal" 
                       value="{{ old('tentang') }}" required>
                @error('tentang')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Menimbang --}}
            <div class="col-12 mb-4 mt-3">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2">
                    <h6 class="mb-0">Menimbang</h6>
                    <button type="button" id="add-menimbang" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-plus-circle"></i> Tambah Item
                    </button>
                </div>
            </div>

            <div class="col-12">
                <div id="menimbang-wrapper">
                    <div class="menimbang-item card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <strong>Item 1</strong>
                            </div>
                            <textarea name="menimbang[]" class="form-control" rows="2" 
                                      placeholder="bahwa ...">{{ old('menimbang.0') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Mengingat --}}
            <div class="col-12 mb-4 mt-3">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2">
                    <h6 class="mb-0">Mengingat</h6>
                    <button type="button" id="add-mengingat" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-plus-circle"></i> Tambah Item
                    </button>
                </div>
            </div>

            <div class="col-12">
                <div id="mengingat-wrapper">
                    <div class="mengingat-item card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <strong>Item 1</strong>
                            </div>
                            <textarea name="mengingat[]" class="form-control" rows="2" 
                                      placeholder="Undang-undang ...">{{ old('mengingat.0') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Menetapkan --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Menetapkan</h6>
            </div>

            <div class="col-md-12 mb-3">
                <label for="menetapkan" class="form-label">Menetapkan <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('menetapkan') is-invalid @enderror" 
                       id="menetapkan" name="menetapkan" 
                       placeholder="KEPUTUSAN KEPALA LABORATORIUM MEDIS KHUSUS PATOLOGI KLINIK UTAMA TRISENSA TENTANG ..." 
                       value="{{ old('menetapkan') }}" required>
                @error('menetapkan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Isi Keputusan --}}
            <div class="col-12 mb-4 mt-3">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2">
                    <h6 class="mb-0">Isi Keputusan</h6>
                    <button type="button" id="add-isi" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-plus-circle"></i> Tambah Isi
                    </button>
                </div>
            </div>

            <div class="col-12">
                <div id="isi-wrapper">
                    <div class="isi-item card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <strong>Kesatu</strong>
                            </div>
                            <div class="row">
                                <div class="col-md-3 mb-2">
                                    <label class="form-label">Label <span class="text-danger">*</span></label>
                                    <input type="text" name="isi_keputusan[0][label]" 
                                           class="form-control" value="Kesatu" required readonly>
                                </div>
                                <div class="col-md-9 mb-2">
                                    <label class="form-label">Isi <span class="text-danger">*</span></label>
                                    <textarea name="isi_keputusan[0][isi]" 
                                              class="form-control" rows="2" 
                                              placeholder="Isi keputusan pertama..." required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Penandatanganan --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Penandatanganan</h6>
            </div>

            <div class="col-md-4 mb-3">
                <label for="tanggal_penetapan" class="form-label">Tanggal Penetapan <span class="text-danger">*</span></label>
                <input type="date" class="form-control @error('tanggal_penetapan') is-invalid @enderror" 
                       id="tanggal_penetapan" name="tanggal_penetapan" 
                       value="{{ old('tanggal_penetapan', date('Y-m-d')) }}" required>
                @error('tanggal_penetapan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="tempat_penetapan" class="form-label">Tempat Penetapan <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('tempat_penetapan') is-invalid @enderror" 
                       id="tempat_penetapan" name="tempat_penetapan" 
                       value="{{ old('tempat_penetapan', 'Surabaya') }}" required>
                @error('tempat_penetapan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="jabatan_pejabat" class="form-label">Jabatan Pejabat <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('jabatan_pejabat') is-invalid @enderror" 
                       id="jabatan_pejabat" name="jabatan_pejabat" 
                       placeholder="Kepala Laboratorium" 
                       value="{{ old('jabatan_pejabat') }}" required>
                @error('jabatan_pejabat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="nama_pejabat" class="form-label">Nama Pejabat <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nama_pejabat') is-invalid @enderror" 
                       id="nama_pejabat" name="nama_pejabat" 
                       placeholder="Nama Lengkap" 
                       value="{{ old('nama_pejabat') }}" required>
                @error('nama_pejabat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="nik_pejabat" class="form-label">NIK Kepegawaian</label>
                <input type="text" class="form-control @error('nik_pejabat') is-invalid @enderror" 
                       id="nik_pejabat" name="nik_pejabat" 
                       placeholder="NIK" 
                       value="{{ old('nik_pejabat') }}">
                @error('nik_pejabat')
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
                    <div class="tembusan-item card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <strong>Tembusan 1</strong>
                            </div>
                            <input type="text" name="tembusan[]" class="form-control" 
                                   placeholder="Contoh: Kepala Divisi HR" value="{{ old('tembusan.0') }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Lampiran --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Lampiran (Opsional)</h6>
            </div>

            <div class="col-12 mb-3">
                <label for="lampiran" class="form-label">Isi Lampiran</label>
                <textarea class="form-control @error('lampiran') is-invalid @enderror" 
                          id="lampiran" name="lampiran" rows="5" 
                          placeholder="Ketik isi lampiran di sini (jika ada)...">{{ old('lampiran') }}</textarea>
                <small class="text-muted">Jika diisi, lampiran akan ditampilkan di PDF. Jika tidak, lampiran tidak akan muncul.</small>
                @error('lampiran')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Simpan Surat Keputusan
            </button>
            <a href="{{ route('transaction.personal.index') }}" class="btn btn-secondary">
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
.menimbang-item, .mengingat-item, .isi-item, .tembusan-item {
    background-color: #f8f9fa;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const labelMap = ['Kesatu', 'Kedua', 'Ketiga', 'Keempat', 'Kelima', 'Keenam', 'Ketujuh', 'Kedelapan', 'Kesembilan', 'Kesepuluh'];

    // Menimbang
    const menimbangWrapper = document.getElementById("menimbang-wrapper");
    const addMenimbang = document.getElementById("add-menimbang");
    let menimbangIndex = 1;

    addMenimbang.addEventListener("click", function () {
        const div = document.createElement("div");
        div.classList.add("menimbang-item", "card", "mb-3");
        div.innerHTML = `
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <strong>Item ${menimbangIndex + 1}</strong>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-menimbang">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </div>
                <textarea name="menimbang[]" class="form-control" rows="2" placeholder="bahwa ..."></textarea>
            </div>
        `;
        menimbangWrapper.appendChild(div);
        menimbangIndex++;
    });

    menimbangWrapper.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-menimbang') || e.target.closest('.remove-menimbang')) {
            e.target.closest('.menimbang-item').remove();
            reindexMenimbang();
        }
    });

    function reindexMenimbang() {
        const items = menimbangWrapper.querySelectorAll('.menimbang-item');
        menimbangIndex = items.length;
        items.forEach((item, idx) => {
            item.querySelector('strong').textContent = `Item ${idx + 1}`;
        });
    }

    // Mengingat
    const mengingatWrapper = document.getElementById("mengingat-wrapper");
    const addMengingat = document.getElementById("add-mengingat");
    let mengingatIndex = 1;

    addMengingat.addEventListener("click", function () {
        const div = document.createElement("div");
        div.classList.add("mengingat-item", "card", "mb-3");
        div.innerHTML = `
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <strong>Item ${mengingatIndex + 1}</strong>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-mengingat">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </div>
                <textarea name="mengingat[]" class="form-control" rows="2" placeholder="Undang-undang ..."></textarea>
            </div>
        `;
        mengingatWrapper.appendChild(div);
        mengingatIndex++;
    });

    mengingatWrapper.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-mengingat') || e.target.closest('.remove-mengingat')) {
            e.target.closest('.mengingat-item').remove();
            reindexMengingat();
        }
    });

    function reindexMengingat() {
        const items = mengingatWrapper.querySelectorAll('.mengingat-item');
        mengingatIndex = items.length;
        items.forEach((item, idx) => {
            item.querySelector('strong').textContent = `Item ${idx + 1}`;
        });
    }

    // Isi Keputusan
    const isiWrapper = document.getElementById("isi-wrapper");
    const addIsi = document.getElementById("add-isi");
    let isiIndex = 1;

    addIsi.addEventListener("click", function () {
        const label = labelMap[isiIndex] || `Item ${isiIndex + 1}`;
        const div = document.createElement("div");
        div.classList.add("isi-item", "card", "mb-3");
        div.innerHTML = `
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <strong>${label}</strong>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-isi">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <label class="form-label">Label <span class="text-danger">*</span></label>
                        <input type="text" name="isi_keputusan[${isiIndex}][label]" 
                               class="form-control" value="${label}" required readonly>
                    </div>
                    <div class="col-md-9 mb-2">
                        <label class="form-label">Isi <span class="text-danger">*</span></label>
                        <textarea name="isi_keputusan[${isiIndex}][isi]" 
                                  class="form-control" rows="2" 
                                  placeholder="Isi keputusan..." required></textarea>
                    </div>
                </div>
            </div>
        `;
        isiWrapper.appendChild(div);
        isiIndex++;
    });

    isiWrapper.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-isi') || e.target.closest('.remove-isi')) {
            e.target.closest('.isi-item').remove();
            reindexIsi();
        }
    });

    function reindexIsi() {
        const items = isiWrapper.querySelectorAll('.isi-item');
        isiIndex = items.length;
        items.forEach((item, idx) => {
            const label = labelMap[idx] || `Item ${idx + 1}`;
            item.querySelector('strong').textContent = label;
            item.querySelector('input[type="text"]').value = label;
        });
    }

    // Tembusan
    const tembusanWrapper = document.getElementById("tembusan-wrapper");
    const addTembusan = document.getElementById("add-tembusan");
    let tembusanIndex = 1;

    addTembusan.addEventListener("click", function () {
        const div = document.createElement("div");
        div.classList.add("tembusan-item", "card", "mb-3");
        div.innerHTML = `
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <strong>Tembusan ${tembusanIndex + 1}</strong>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-tembusan">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </div>
                <input type="text" name="tembusan[]" class="form-control" placeholder="Contoh: Kepala Divisi ...">
            </div>
        `;
        tembusanWrapper.appendChild(div);
        tembusanIndex++;
    });

    tembusanWrapper.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-tembusan') || e.target.closest('.remove-tembusan')) {
            e.target.closest('.tembusan-item').remove();
            reindexTembusan();
        }
    });

    function reindexTembusan() {
        const items = tembusanWrapper.querySelectorAll('.tembusan-item');
        tembusanIndex = items.length;
        items.forEach((item, idx) => {
            item.querySelector('strong').textContent = `Tembusan ${idx + 1}`;
        });
    }
});
</script>
@endpush