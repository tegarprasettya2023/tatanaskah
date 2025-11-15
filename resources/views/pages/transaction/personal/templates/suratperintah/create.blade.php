@extends('layout.main')

@section('content')
<x-breadcrumb :values="[__('menu.transaction.menu'), 'Surat Pribadi', 'Buat Surat Perintah']" />

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
    <form action="{{ route('transaction.personal.surat_perintah.store') }}" method="POST">
        @csrf
        <input type="hidden" name="template_type" value="surat_perintah">

        <div class="card-header">
            <h5>Buat Surat Perintah/Tugas</h5>
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
                       id="nomor" name="nomor" placeholder="ST/.../bulan/tahun" 
                       value="{{ old('nomor') }}" required>
                @error('nomor')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="letter_date" class="form-label">Tanggal Surat <span class="text-danger">*</span></label>
                <input type="date" class="form-control @error('letter_date') is-invalid @enderror" 
                       id="letter_date" name="letter_date" value="{{ old('letter_date') }}" required>
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

            {{-- MENIMBANG (Dynamic) --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">
                    Menimbang
                    <button type="button" class="btn btn-sm btn-success float-end" onclick="addMenimbangRow()">
                        <i class="bi bi-plus-circle"></i> Tambah
                    </button>
                </h6>
            </div>

            <div class="col-12" id="menimbang-container">
                <div class="mb-3 menimbang-row">
                    <label class="form-label">1. bahwa <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <textarea class="form-control @error('menimbang.0') is-invalid @enderror" 
                                  name="menimbang[]" rows="3" 
                                  placeholder="Isi pertimbangan..." required>{{ old('menimbang.0') }}</textarea>
                        <button type="button" class="btn btn-danger" onclick="removeMenimbangRow(this)" style="display: none;">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                    @error('menimbang.0')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- DASAR (Dynamic) --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">
                    Dasar
                    <button type="button" class="btn btn-sm btn-success float-end" onclick="addDasarRow()">
                        <i class="bi bi-plus-circle"></i> Tambah
                    </button>
                </h6>
            </div>

            <div class="col-12" id="dasar-container">
                <div class="mb-3 dasar-row">
                    <label class="form-label">a. <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <textarea class="form-control @error('dasar.0') is-invalid @enderror" 
                                  name="dasar[]" rows="2" 
                                  placeholder="Dasar hukum atau peraturan..." required>{{ old('dasar.0') }}</textarea>
                        <button type="button" class="btn btn-danger" onclick="removeDasarRow(this)" style="display: none;">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                    @error('dasar.0')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- MEMBERI PERINTAH KEPADA (Opsional) --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Memberi Perintah Kepada <small class="text-muted">(Opsional)</small></h6>
            </div>

            <div class="col-md-4 mb-3">
                <label for="nama_penerima" class="form-label">Nama</label>
                <input type="text" class="form-control @error('nama_penerima') is-invalid @enderror" 
                       id="nama_penerima" name="nama_penerima" 
                       value="{{ old('nama_penerima') }}">
                @error('nama_penerima')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="nik_penerima" class="form-label">NIKepegawaian</label>
                <input type="text" class="form-control @error('nik_penerima') is-invalid @enderror" 
                       id="nik_penerima" name="nik_penerima" 
                       value="{{ old('nik_penerima') }}">
                @error('nik_penerima')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="jabatan_penerima" class="form-label">Jabatan</label>
                <input type="text" class="form-control @error('jabatan_penerima') is-invalid @enderror" 
                       id="jabatan_penerima" name="jabatan_penerima" 
                       value="{{ old('jabatan_penerima') }}">
                @error('jabatan_penerima')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12 mb-3">
                <label for="nama_nama_terlampir" class="form-label">Atau nama-nama terlampir</label>
                <textarea class="form-control @error('nama_nama_terlampir') is-invalid @enderror" 
                          id="nama_nama_terlampir" name="nama_nama_terlampir" rows="3" 
                          placeholder="Tulis nama-nama lain yang terlampir (jika ada)...">{{ old('nama_nama_terlampir') }}</textarea>
                <small class="text-muted">Kosongkan jika hanya satu penerima perintah</small>
                @error('nama_nama_terlampir')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- UNTUK (Dynamic) --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">
                    Untuk (Tujuan/Keperluan)
                    <button type="button" class="btn btn-sm btn-success float-end" onclick="addUntukRow()">
                        <i class="bi bi-plus-circle"></i> Tambah
                    </button>
                </h6>
            </div>

            <div class="col-12" id="untuk-container">
                <div class="mb-3 untuk-row">
                    <label class="form-label">1. <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <textarea class="form-control @error('untuk.0') is-invalid @enderror" 
                                  name="untuk[]" rows="3" 
                                  placeholder="Tujuan/keperluan..." required>{{ old('untuk.0') }}</textarea>
                        <button type="button" class="btn btn-danger" onclick="removeUntukRow(this)" style="display: none;">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                    @error('untuk.0')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- PEMBUAT (PENANDATANGAN) --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Pembuat Surat (Penandatangan)</h6>
            </div>

            <div class="col-md-4 mb-3">
                <label for="jabatan_pembuat" class="form-label">Jabatan <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('jabatan_pembuat') is-invalid @enderror" 
                       id="jabatan_pembuat" name="jabatan_pembuat" 
                       placeholder="Nama jabatan"
                       value="{{ old('jabatan_pembuat') }}" required>
                @error('jabatan_pembuat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="nama_pembuat" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nama_pembuat') is-invalid @enderror" 
                       id="nama_pembuat" name="nama_pembuat" 
                       placeholder="Nama lengkap pejabat"
                       value="{{ old('nama_pembuat') }}" required>
                @error('nama_pembuat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="nik_pembuat" class="form-label">NIKepegawaian <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nik_pembuat') is-invalid @enderror" 
                       id="nik_pembuat" name="nik_pembuat" 
                       placeholder="NIK Kepegawaian"
                       value="{{ old('nik_pembuat') }}" required>
                @error('nik_pembuat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- TEMBUSAN (Dynamic, Opsional) --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">
                    Tembusan <small class="text-muted">(Opsional)</small>
                    <button type="button" class="btn btn-sm btn-success float-end" onclick="addTembusanRow()">
                        <i class="bi bi-plus-circle"></i> Tambah
                    </button>
                </h6>
            </div>

            <div class="col-12" id="tembusan-container">
                <div class="mb-3 tembusan-row">
                    <label class="form-label">1.</label>
                    <div class="input-group">
                        <input type="text" class="form-control @error('tembusan.0') is-invalid @enderror" 
                               name="tembusan[]" 
                               placeholder="Nama/Jabatan penerima tembusan"
                               value="{{ old('tembusan.0') }}">
                        <button type="button" class="btn btn-danger" onclick="removeTembusanRow(this)" style="display: none;">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                    @error('tembusan.0')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- LAMPIRAN DAFTAR NAMA (Opsional) --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Lampiran Daftar Nama yang Diberikan Tugas <small class="text-muted">(Opsional)</small></h6>
            </div>

            <div class="col-12 mb-3">
                <label class="form-label">Daftar Nama</label>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="25%">Nama</th>
                            <th width="20%">NIK</th>
                            <th width="20%">Jabatan</th>
                            <th width="25%">Keterangan</th>
                            <th width="5%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="lampiran-rows">
                        <tr>
                            <td>1</td>
                            <td><input type="text" name="lampiran[0][nama]" class="form-control"></td>
                            <td><input type="text" name="lampiran[0][nik]" class="form-control"></td>
                            <td><input type="text" name="lampiran[0][jabatan]" class="form-control"></td>
                            <td><input type="text" name="lampiran[0][keterangan]" class="form-control"></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger" onclick="removeLampiranRow(this)" style="display: none;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" class="btn btn-sm btn-success" onclick="addLampiranRow()">
                    <i class="bi bi-plus-circle"></i> Tambah
                </button>
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
</style>
@endpush

@push('scripts')
<script>
// Menimbang Functions
let menimbangIndex = 1;
const menimbangLabels = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];

function addMenimbangRow() {
    const container = document.getElementById('menimbang-container');
    const newRow = document.createElement('div');
    newRow.className = 'mb-3 menimbang-row';
    newRow.innerHTML = `
        <label class="form-label">${menimbangIndex + 1}. bahwa <span class="text-danger">*</span></label>
        <div class="input-group">
            <textarea class="form-control" name="menimbang[]" rows="3" 
                      placeholder="Isi pertimbangan..." required></textarea>
            <button type="button" class="btn btn-danger" onclick="removeMenimbangRow(this)">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    `;
    container.appendChild(newRow);
    menimbangIndex++;
    updateRemoveButtons('menimbang-row');
}

function removeMenimbangRow(button) {
    const container = document.getElementById('menimbang-container');
    button.closest('.menimbang-row').remove();
    updateMenimbangNumbers();
    updateRemoveButtons('menimbang-row');
}

function updateMenimbangNumbers() {
    const rows = document.querySelectorAll('.menimbang-row');
    rows.forEach((row, index) => {
        const label = row.querySelector('label');
        label.innerHTML = `${index + 1}. bahwa <span class="text-danger">*</span>`;
    });
    menimbangIndex = rows.length;
}

// Dasar Functions
let dasarIndex = 1;

function addDasarRow() {
    const container = document.getElementById('dasar-container');
    const newRow = document.createElement('div');
    newRow.className = 'mb-3 dasar-row';
    const label = dasarIndex < menimbangLabels.length ? menimbangLabels[dasarIndex] : dasarIndex + 1;
    newRow.innerHTML = `
        <label class="form-label">${label}. <span class="text-danger">*</span></label>
        <div class="input-group">
            <textarea class="form-control" name="dasar[]" rows="2" 
                      placeholder="Dasar hukum atau peraturan..." required></textarea>
            <button type="button" class="btn btn-danger" onclick="removeDasarRow(this)">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    `;
    container.appendChild(newRow);
    dasarIndex++;
    updateRemoveButtons('dasar-row');
}

function removeDasarRow(button) {
    button.closest('.dasar-row').remove();
    updateDasarNumbers();
    updateRemoveButtons('dasar-row');
}

function updateDasarNumbers() {
    const rows = document.querySelectorAll('.dasar-row');
    rows.forEach((row, index) => {
        const label = row.querySelector('label');
        const labelText = index < menimbangLabels.length ? menimbangLabels[index] : index + 1;
        label.innerHTML = `${labelText}. <span class="text-danger">*</span>`;
    });
    dasarIndex = rows.length;
}

// Untuk Functions
let untukIndex = 1;

function addUntukRow() {
    const container = document.getElementById('untuk-container');
    const newRow = document.createElement('div');
    newRow.className = 'mb-3 untuk-row';
    newRow.innerHTML = `
        <label class="form-label">${untukIndex + 1}. <span class="text-danger">*</span></label>
        <div class="input-group">
            <textarea class="form-control" name="untuk[]" rows="3" 
                      placeholder="Tujuan/keperluan..." required></textarea>
            <button type="button" class="btn btn-danger" onclick="removeUntukRow(this)">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    `;
    container.appendChild(newRow);
    untukIndex++;
    updateRemoveButtons('untuk-row');
}

function removeUntukRow(button) {
    button.closest('.untuk-row').remove();
    updateUntukNumbers();
    updateRemoveButtons('untuk-row');
}

function updateUntukNumbers() {
    const rows = document.querySelectorAll('.untuk-row');
    rows.forEach((row, index) => {
        const label = row.querySelector('label');
        label.innerHTML = `${index + 1}. <span class="text-danger">*</span>`;
    });
    untukIndex = rows.length;
}

// Tembusan Functions
let tembusanIndex = 1;

function addTembusanRow() {
    const container = document.getElementById('tembusan-container');
    const newRow = document.createElement('div');
    newRow.className = 'mb-3 tembusan-row';
    newRow.innerHTML = `
        <label class="form-label">${tembusanIndex + 1}.</label>
        <div class="input-group">
            <input type="text" class="form-control" name="tembusan[]" 
                   placeholder="Nama/Jabatan penerima tembusan">
            <button type="button" class="btn btn-danger" onclick="removeTembusanRow(this)">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    `;
    container.appendChild(newRow);
    tembusanIndex++;
    updateRemoveButtons('tembusan-row');
}

function removeTembusanRow(button) {
    button.closest('.tembusan-row').remove();
    updateTembusanNumbers();
    updateRemoveButtons('tembusan-row');
}

function updateTembusanNumbers() {
    const rows = document.querySelectorAll('.tembusan-row');
    rows.forEach((row, index) => {
        const label = row.querySelector('label');
        label.textContent = `${index + 1}.`;
    });
    tembusanIndex = rows.length;
}

// Lampiran Functions
let lampiranRowIndex = 1;

function addLampiranRow() {
    const tbody = document.getElementById('lampiran-rows');
    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td>${lampiranRowIndex + 1}</td>
        <td><input type="text" name="lampiran[${lampiranRowIndex}][nama]" class="form-control"></td>
        <td><input type="text" name="lampiran[${lampiranRowIndex}][nik]" class="form-control"></td>
        <td><input type="text" name="lampiran[${lampiranRowIndex}][jabatan]" class="form-control"></td>
        <td><input type="text" name="lampiran[${lampiranRowIndex}][keterangan]" class="form-control"></td>
        <td>
            <button type="button" class="btn btn-sm btn-danger" onclick="removeLampiranRow(this)">
                <i class="bi bi-trash"></i>
            </button>
        </td>
    `;
    tbody.appendChild(newRow);
    lampiranRowIndex++;
    updateLampiranNumbers();
}

function removeLampiranRow(button) {
    const row = button.closest('tr');
    row.remove();
    updateLampiranNumbers();
}

function updateLampiranNumbers() {
    const rows = document.querySelectorAll('#lampiran-rows tr');
    rows.forEach((row, index) => {
        row.cells[0].textContent = index + 1;
        // Update name attributes
        const inputs = row.querySelectorAll('input');
        inputs.forEach(input => {
            const name = input.getAttribute('name');
            if (name) {
                input.setAttribute('name', name.replace(/\[\d+\]/, `[${index}]`));
            }
        });
    });
    lampiranRowIndex = rows.length;
    
    // Show/hide delete buttons
    rows.forEach((row, index) => {
        const deleteBtn = row.querySelector('.btn-danger');
        if (deleteBtn) {
            deleteBtn.style.display = rows.length > 1 ? 'inline-block' : 'none';
        }
    });
}

// Generic function to update remove buttons visibility
function updateRemoveButtons(className) {
    const rows = document.querySelectorAll('.' + className);
    rows.forEach((row, index) => {
        const deleteBtn = row.querySelector('.btn-danger');
        if (deleteBtn) {
            deleteBtn.style.display = rows.length > 1 ? 'inline-block' : 'none';
        }
    });
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updateRemoveButtons('menimbang-row');
    updateRemoveButtons('dasar-row');
    updateRemoveButtons('untuk-row');
    updateRemoveButtons('tembusan-row');
    updateLampiranNumbers();
});
</script>
@endpush