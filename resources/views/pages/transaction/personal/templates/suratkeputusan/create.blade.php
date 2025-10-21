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
    <form action="{{ route('transaction.personal.suratkeputusan.store') }}" method="POST">
        @csrf

        <div class="card-header">
            <h5>Buat Surat Keputusan</h5>
        </div>

        <div class="card-body row">
            {{-- Informasi Dasar --}}
            <div class="col-12 mb-4">
                <h6 class="border-bottom pb-2">Informasi Dasar</h6>
            </div>

            <div class="col-md-4 mb-3">
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

            <div class="col-md-8 mb-3">
                <label for="judul_setelah_sk" class="form-label">Judul Setelah "SURAT KEPUTUSAN"</label>
                <input type="text" class="form-control" id="judul_setelah_sk" name="judul_setelah_sk" 
                       placeholder="LABORATORIUM MEDIS KHUSUS PATOLOGI KLINIK UTAMA TRISENSA" 
                       value="{{ old('judul_setelah_sk') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label for="nomor_sk" class="form-label">Nomor SK <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nomor_sk') is-invalid @enderror" 
                       id="nomor_sk" name="nomor_sk" 
                       placeholder="001" 
                       value="{{ old('nomor_sk', '001') }}" required>
                <small class="text-muted">Format akhir: SK/001/bulan romawi/tahun</small>
                @error('nomor_sk')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="tanggal_sk" class="form-label">Tanggal SK <span class="text-danger">*</span></label>
                <input type="date" class="form-control @error('tanggal_sk') is-invalid @enderror" 
                       id="tanggal_sk" name="tanggal_sk" 
                       value="{{ old('tanggal_sk', date('Y-m-d')) }}" required>
                <small class="text-muted">Untuk generate bulan romawi & tahun</small>
                @error('tanggal_sk')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- TENTANG --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">TENTANG</h6>
            </div>

            <div class="col-12 mb-3">
                <label for="tentang" class="form-label">TENTANG <span class="text-danger">*</span></label>
                <textarea class="form-control @error('tentang') is-invalid @enderror" 
                          id="tentang" name="tentang" rows="2" 
                          placeholder="Contoh: DENGAN RAHMAT TUHAN YANG MAHA KUASA" required>{{ old('tentang') }}</textarea>
                @error('tentang')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12 mb-3">
                <label for="jabatan_pembuat" class="form-label">Jabatan Pembuat Keputusan</label>
                <input type="text" class="form-control" id="jabatan_pembuat" name="jabatan_pembuat" 
                       placeholder="KEPALA LABORATORIUM MEDIS KHUSUS PATOLOGI KLINIK UTAMA TRISENSA" 
                       value="{{ old('jabatan_pembuat') }}">
                <small class="text-muted">Opsional, jika kosong akan menggunakan default</small>
            </div>

            {{-- MENIMBANG --}}
            <div class="col-12 mb-4 mt-3">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2">
                    <h6 class="mb-0">Menimbang</h6>
                    <button type="button" id="add-menimbang" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-plus-circle"></i> Tambah
                    </button>
                </div>
            </div>

            <div class="col-12">
                <div id="menimbang-wrapper">
                    <div class="menimbang-item card mb-2">
                        <div class="card-body py-2">
                            <label class="form-label">a. bahwa ...</label>
                            <textarea name="menimbang[]" class="form-control" rows="2" 
                                      placeholder="Isi pertimbangan"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- MENGINGAT --}}
            <div class="col-12 mb-4 mt-3">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2">
                    <h6 class="mb-0">Mengingat</h6>
                    <button type="button" id="add-mengingat" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-plus-circle"></i> Tambah
                    </button>
                </div>
            </div>

            <div class="col-12">
                <div id="mengingat-wrapper">
                    <div class="mengingat-item card mb-2">
                        <div class="card-body py-2">
                            <label class="form-label">a. Undang-undang ...</label>
                            <textarea name="mengingat[]" class="form-control" rows="2" 
                                      placeholder="Nomor dan tahun undang-undang"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- MENETAPKAN --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">MEMUTUSKAN - Menetapkan</h6>
            </div>

            <div class="col-12 mb-3">
                <label for="menetapkan" class="form-label">Menetapkan</label>
                <textarea class="form-control" id="menetapkan" name="menetapkan" rows="2" 
                          placeholder="KEPUTUSAN KEPALA LABORATORIUM ...">{{ old('menetapkan') }}</textarea>
                <small class="text-muted">Opsional, jika kosong akan menggunakan default + TENTANG</small>
            </div>

            {{-- KEPUTUSAN (Kesatu, Kedua, dst) --}}
            <div class="col-12 mb-4 mt-3">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2">
                    <h6 class="mb-0">Keputusan (Kesatu, Kedua, dst)</h6>
                    <button type="button" id="add-keputusan" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-plus-circle"></i> Tambah
                    </button>
                </div>
            </div>

            <div class="col-12">
                <div id="keputusan-wrapper">
                    <div class="keputusan-item card mb-2">
                        <div class="card-body py-2">
                            <label class="form-label">Kesatu</label>
                            <textarea name="keputusan[]" class="form-control" rows="2" 
                                      placeholder="Isi keputusan pertama"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- PENUTUP --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Penutup & Penandatangan</h6>
            </div>

            <div class="col-md-6 mb-3">
                <label for="ditetapkan_di" class="form-label">Ditetapkan di</label>
                <input type="text" class="form-control" id="ditetapkan_di" name="ditetapkan_di" 
                       placeholder="Surabaya" value="{{ old('ditetapkan_di', 'Surabaya') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label for="tanggal_ditetapkan" class="form-label">Pada Tanggal <span class="text-danger">*</span></label>
                <input type="date" class="form-control @error('tanggal_ditetapkan') is-invalid @enderror" 
                       id="tanggal_ditetapkan" name="tanggal_ditetapkan" 
                       value="{{ old('tanggal_ditetapkan', date('Y-m-d')) }}" required>
                @error('tanggal_ditetapkan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="nama_jabatan" class="form-label">Nama Jabatan</label>
                <input type="text" class="form-control" id="nama_jabatan" name="nama_jabatan" 
                       placeholder="Kepala Laboratorium" value="{{ old('nama_jabatan') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" 
                       id="nama_lengkap" name="nama_lengkap" 
                       placeholder="Nama Lengkap Penandatangan" 
                       value="{{ old('nama_lengkap') }}" required>
                @error('nama_lengkap')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-12 mb-3">
                <label for="nik_kepegawaian" class="form-label">NIK Kepegawaian</label>
                <input type="text" class="form-control" id="nik_kepegawaian" name="nik_kepegawaian" 
                       placeholder="NIK" value="{{ old('nik_kepegawaian') }}">
            </div>

            {{-- TEMBUSAN --}}
            <div class="col-12 mb-4 mt-3">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2">
                    <h6 class="mb-0">Tembusan</h6>
                    <button type="button" id="add-tembusan" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-plus-circle"></i> Tambah
                    </button>
                </div>
            </div>

            <div class="col-12">
                <div id="tembusan-wrapper">
                    <div class="tembusan-item card mb-2">
                        <div class="card-body py-2">
                            <input type="text" name="tembusan[]" class="form-control" 
                                   placeholder="Penerima tembusan 1">
                        </div>
                    </div>
                </div>
            </div>

            {{-- LAMPIRAN (Halaman 2) --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Lampiran (Halaman 2)</h6>
            </div>

            <div class="col-12 mb-3">
                <label for="keputusan_dari" class="form-label">Keputusan Dari</label>
                <input type="text" class="form-control" id="keputusan_dari" name="keputusan_dari" 
                       placeholder="Keputusan Kepala Laboratorium Medis Khusus Patologi Klinik Utama Trisensa" 
                       value="{{ old('keputusan_dari') }}">
            </div>

            <div class="col-12 mb-3">
                <label for="lampiran_tentang" class="form-label">Lampiran Tentang</label>
                <input type="text" class="form-control" id="lampiran_tentang" name="lampiran_tentang" 
                       placeholder="Tentang (akan otomatis sama dengan TENTANG jika kosong)" 
                       value="{{ old('lampiran_tentang') }}">
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
.menimbang-item, .mengingat-item, .keputusan-item, .tembusan-item {
    background-color: #f8f9fa;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    // MENIMBANG
    const menimbangWrapper = document.getElementById("menimbang-wrapper");
    const addMenimbangBtn = document.getElementById("add-menimbang");
    let menimbangIndex = 1;

    addMenimbangBtn.addEventListener("click", function () {
        const huruf = String.fromCharCode(97 + menimbangIndex); // a, b, c, ...
        const div = document.createElement("div");
        div.classList.add("menimbang-item", "card", "mb-2");
        div.innerHTML = `
            <div class="card-body py-2">
                <div class="d-flex justify-content-between mb-1">
                    <label class="form-label">${huruf}. bahwa ...</label>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-menimbang">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
                <textarea name="menimbang[]" class="form-control" rows="2" placeholder="Isi pertimbangan"></textarea>
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
            const huruf = String.fromCharCode(97 + idx);
            item.querySelector('label').textContent = `${huruf}. bahwa ...`;
        });
    }

    // MENGINGAT
    const mengingatWrapper = document.getElementById("mengingat-wrapper");
    const addMengingatBtn = document.getElementById("add-mengingat");
    let mengingatIndex = 1;

    addMengingatBtn.addEventListener("click", function () {
        const huruf = String.fromCharCode(97 + mengingatIndex);
        const div = document.createElement("div");
        div.classList.add("mengingat-item", "card", "mb-2");
        div.innerHTML = `
            <div class="card-body py-2">
                <div class="d-flex justify-content-between mb-1">
                    <label class="form-label">${huruf}. Undang-undang ...</label>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-mengingat">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
                <textarea name="mengingat[]" class="form-control" rows="2" placeholder="Nomor dan tahun undang-undang"></textarea>
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
            const huruf = String.fromCharCode(97 + idx);
            item.querySelector('label').textContent = `${huruf}. Undang-undang ...`;
        });
    }

    // KEPUTUSAN
    const keputusanWrapper = document.getElementById("keputusan-wrapper");
    const addKeputusanBtn = document.getElementById("add-keputusan");
    let keputusanIndex = 1;
    const angkaTerbilang = ['', 'Kesatu', 'Kedua', 'Ketiga', 'Keempat', 'Kelima', 'Keenam', 'Ketujuh', 'Kedelapan', 'Kesembilan', 'Kesepuluh'];

    addKeputusanBtn.addEventListener("click", function () {
        const terbilang = angkaTerbilang[keputusanIndex + 1] || (keputusanIndex + 1);
        const div = document.createElement("div");
        div.classList.add("keputusan-item", "card", "mb-2");
        div.innerHTML = `
            <div class="card-body py-2">
                <div class="d-flex justify-content-between mb-1">
                    <label class="form-label">${terbilang}</label>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-keputusan">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
                <textarea name="keputusan[]" class="form-control" rows="2" placeholder="Isi keputusan"></textarea>
            </div>
        `;
        keputusanWrapper.appendChild(div);
        keputusanIndex++;
    });

    keputusanWrapper.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-keputusan') || e.target.closest('.remove-keputusan')) {
            e.target.closest('.keputusan-item').remove();
            reindexKeputusan();
        }
    });

    function reindexKeputusan() {
        const items = keputusanWrapper.querySelectorAll('.keputusan-item');
        keputusanIndex = items.length;
        items.forEach((item, idx) => {
            const terbilang = angkaTerbilang[idx + 1] || (idx + 1);
            item.querySelector('label').textContent = terbilang;
        });
    }

    // TEMBUSAN
    const tembusanWrapper = document.getElementById("tembusan-wrapper");
    const addTembusanBtn = document.getElementById("add-tembusan");
    let tembusanIndex = 1;

    addTembusanBtn.addEventListener("click", function () {
        tembusanIndex++;
        const div = document.createElement("div");
        div.classList.add("tembusan-item", "card", "mb-2");
        div.innerHTML = `
            <div class="card-body py-2">
                <div class="d-flex gap-2">
                    <input type="text" name="tembusan[]" class="form-control" placeholder="Penerima tembusan ${tembusanIndex}">
                    <button type="button" class="btn btn-sm btn-outline-danger remove-tembusan">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        `;
        tembusanWrapper.appendChild(div);
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
            const input = item.querySelector('input');
            input.placeholder = `Penerima tembusan ${idx + 1}`;
        });
    }
});
</script>
@endpush