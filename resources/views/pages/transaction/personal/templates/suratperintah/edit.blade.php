@extends('layout.main')

@section('content')
<x-breadcrumb :values="[__('menu.transaction.menu'), 'Surat Pribadi', 'Edit Surat Perintah']" />

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
    <form action="{{ route('transaction.personal.surat_perintah.update', $data->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="template_type" value="surat_perintah">

        <div class="card-header">
            <h5>Edit Surat Perintah/Tugas</h5>
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
                <label for="nomor" class="form-label">Nomor Surat <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nomor" name="nomor" 
                       value="{{ old('nomor', $data->nomor) }}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="letter_date" class="form-label">Tanggal Surat <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="letter_date" name="letter_date" 
                       value="{{ old('letter_date', $data->letter_date?->format('Y-m-d')) }}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="tempat" class="form-label">Tempat <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="tempat" name="tempat" 
                       value="{{ old('tempat', $data->tempat) }}" required>
            </div>

            {{-- MENIMBANG --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">
                    Menimbang
                    <button type="button" class="btn btn-sm btn-success float-end" onclick="addMenimbangRow()">
                        <i class="bi bi-plus-circle"></i> Tambah
                    </button>
                </h6>
            </div>

            <div class="col-12" id="menimbang-container">
                @php $menimbang = old('menimbang', $data->menimbang ?? []); @endphp
                @foreach($menimbang as $i => $item)
                <div class="mb-3 menimbang-row">
                    <label class="form-label">{{ $i + 1 }}. bahwa <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <textarea class="form-control" name="menimbang[]" rows="3" required>{{ $item }}</textarea>
                        <button type="button" class="btn btn-danger" onclick="removeMenimbangRow(this)">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- DASAR --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">
                    Dasar
                    <button type="button" class="btn btn-sm btn-success float-end" onclick="addDasarRow()">
                        <i class="bi bi-plus-circle"></i> Tambah
                    </button>
                </h6>
            </div>

            <div class="col-12" id="dasar-container">
                @php 
                    $dasar = old('dasar', $data->dasar ?? []); 
                    $dasarLabels = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
                @endphp
                @foreach($dasar as $i => $item)
                <div class="mb-3 dasar-row">
                    <label class="form-label">{{ $dasarLabels[$i] ?? ($i + 1) }}. <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <textarea class="form-control" name="dasar[]" rows="2" required>{{ $item }}</textarea>
                        <button type="button" class="btn btn-danger" onclick="removeDasarRow(this)">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- MEMBERI PERINTAH KEPADA --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Memberi Perintah Kepada <small class="text-muted">(Opsional)</small></h6>
            </div>

            <div class="col-md-4 mb-3">
                <label for="nama_penerima" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama_penerima" name="nama_penerima" 
                       value="{{ old('nama_penerima', $data->nama_penerima) }}">
            </div>

            <div class="col-md-4 mb-3">
                <label for="nik_penerima" class="form-label">NIKepegawaian</label>
                <input type="text" class="form-control" id="nik_penerima" name="nik_penerima" 
                       value="{{ old('nik_penerima', $data->nik_penerima) }}">
            </div>

            <div class="col-md-4 mb-3">
                <label for="jabatan_penerima" class="form-label">Jabatan</label>
                <input type="text" class="form-control" id="jabatan_penerima" name="jabatan_penerima" 
                       value="{{ old('jabatan_penerima', $data->jabatan_penerima) }}">
            </div>

            <div class="col-12 mb-3">
                <label for="nama_nama_terlampir" class="form-label">Atau nama-nama terlampir</label>
                <textarea class="form-control" id="nama_nama_terlampir" name="nama_nama_terlampir" rows="3">{{ old('nama_nama_terlampir', $data->nama_nama_terlampir) }}</textarea>
            </div>

            {{-- UNTUK --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">
                    Untuk (Tujuan/Keperluan)
                    <button type="button" class="btn btn-sm btn-success float-end" onclick="addUntukRow()">
                        <i class="bi bi-plus-circle"></i> Tambah
                    </button>
                </h6>
            </div>

            <div class="col-12" id="untuk-container">
                @php $untuk = old('untuk', $data->untuk ?? []); @endphp
                @foreach($untuk as $i => $item)
                <div class="mb-3 untuk-row">
                    <label class="form-label">{{ $i + 1 }}. <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <textarea class="form-control" name="untuk[]" rows="3" required>{{ $item }}</textarea>
                        <button type="button" class="btn btn-danger" onclick="removeUntukRow(this)">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- PEMBUAT --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Pembuat Surat (Penandatangan)</h6>
            </div>

            <div class="col-md-4 mb-3">
                <label for="jabatan_pembuat" class="form-label">Jabatan <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="jabatan_pembuat" name="jabatan_pembuat" 
                       value="{{ old('jabatan_pembuat', $data->jabatan_pembuat) }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label for="nama_pembuat" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nama_pembuat" name="nama_pembuat" 
                       value="{{ old('nama_pembuat', $data->nama_pembuat) }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label for="nik_pembuat" class="form-label">NIKepegawaian <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nik_pembuat" name="nik_pembuat" 
                       value="{{ old('nik_pembuat', $data->nik_pembuat) }}" required>
            </div>

            {{-- TEMBUSAN --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">
                    Tembusan <small class="text-muted">(Opsional)</small>
                    <button type="button" class="btn btn-sm btn-success float-end" onclick="addTembusanRow()">
                        <i class="bi bi-plus-circle"></i> Tambah
                    </button>
                </h6>
            </div>

            <div class="col-12" id="tembusan-container">
                @php $tembusan = old('tembusan', $data->tembusan ?? []); @endphp
                @if(count($tembusan) > 0)
                    @foreach($tembusan as $i => $item)
                    <div class="mb-3 tembusan-row">
                        <label class="form-label">{{ $i + 1 }}.</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="tembusan[]" value="{{ $item }}">
                            <button type="button" class="btn btn-danger" onclick="removeTembusanRow(this)">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="mb-3 tembusan-row">
                        <label class="form-label">1.</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="tembusan[]" placeholder="Nama/Jabatan penerima tembusan">
                            <button type="button" class="btn btn-danger" onclick="removeTembusanRow(this)" style="display: none;">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                @endif
            </div>

            {{-- LAMPIRAN --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Lampiran Daftar Nama <small class="text-muted">(Opsional)</small></h6>
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
                        @php $lampiran = old('lampiran', $data->lampiran ?? []); @endphp
                        @if(count($lampiran) > 0)
                            @foreach($lampiran as $i => $item)
                            <tr>
                                <td>{{ $i+1 }}</td>
                                <td><input type="text" name="lampiran[{{ $i }}][nama]" class="form-control" value="{{ $item['nama'] ?? '' }}"></td>
                                <td><input type="text" name="lampiran[{{ $i }}][nik]" class="form-control" value="{{ $item['nik'] ?? '' }}"></td>
                                <td><input type="text" name="lampiran[{{ $i }}][jabatan]" class="form-control" value="{{ $item['jabatan'] ?? '' }}"></td>
                                <td><input type="text" name="lampiran[{{ $i }}][keterangan]" class="form-control" value="{{ $item['keterangan'] ?? '' }}"></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="removeLampiranRow(this)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        @else
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
                        @endif
                    </tbody>
                </table>
                <button type="button" class="btn btn-sm btn-success" onclick="addLampiranRow()">
                    <i class="bi bi-plus-circle"></i> Tambah
                </button>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Update Surat
            </button>
            <a href="{{ route('transaction.personal.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
// Copy all JavaScript functions from create view
const menimbangLabels = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];

// Menimbang
let menimbangIndex = {{ count(old('menimbang', $data->menimbang ?? [])) }};

function addMenimbangRow() {
    const container = document.getElementById('menimbang-container');
    const newRow = document.createElement('div');
    newRow.className = 'mb-3 menimbang-row';
    newRow.innerHTML = `
        <label class="form-label">${menimbangIndex + 1}. bahwa <span class="text-danger">*</span></label>
        <div class="input-group">
            <textarea class="form-control" name="menimbang[]" rows="3" required></textarea>
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
    button.closest('.menimbang-row').remove();
    updateMenimbangNumbers();
    updateRemoveButtons('menimbang-row');
}

function updateMenimbangNumbers() {
    const rows = document.querySelectorAll('.menimbang-row');
    rows.forEach((row, index) => {
        row.querySelector('label').innerHTML = `${index + 1}. bahwa <span class="text-danger">*</span>`;
    });
    menimbangIndex = rows.length;
}

// Dasar
let dasarIndex = {{ count(old('dasar', $data->dasar ?? [])) }};

function addDasarRow() {
    const container = document.getElementById('dasar-container');
    const newRow = document.createElement('div');
    newRow.className = 'mb-3 dasar-row';
    const label = dasarIndex < menimbangLabels.length ? menimbangLabels[dasarIndex] : dasarIndex + 1;
    newRow.innerHTML = `
        <label class="form-label">${label}. <span class="text-danger">*</span></label>
        <div class="input-group">
            <textarea class="form-control" name="dasar[]" rows="2" required></textarea>
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
        const labelText = index < menimbangLabels.length ? menimbangLabels[index] : index + 1;
        row.querySelector('label').innerHTML = `${labelText}. <span class="text-danger">*</span>`;
    });
    dasarIndex = rows.length;
}

// Untuk
let untukIndex = {{ count(old('untuk', $data->untuk ?? [])) }};

function addUntukRow() {
    const container = document.getElementById('untuk-container');
    const newRow = document.createElement('div');
    newRow.className = 'mb-3 untuk-row';
    newRow.innerHTML = `
        <label class="form-label">${untukIndex + 1}. <span class="text-danger">*</span></label>
        <div class="input-group">
            <textarea class="form-control" name="untuk[]" rows="3" required></textarea>
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
        row.querySelector('label').innerHTML = `${index + 1}. <span class="text-danger">*</span>`;
    });
    untukIndex = rows.length;
}

// Tembusan
let tembusanIndex = {{ count(old('tembusan', $data->tembusan ?? [])) ?: 1 }};

function addTembusanRow() {
    const container = document.getElementById('tembusan-container');
    const newRow = document.createElement('div');
    newRow.className = 'mb-3 tembusan-row';
    newRow.innerHTML = `
        <label class="form-label">${tembusanIndex + 1}.</label>
        <div class="input-group">
            <input type="text" class="form-control" name="tembusan[]">
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
        row.querySelector('label').textContent = `${index + 1}.`;
    });
    tembusanIndex = rows.length;
}

// Lampiran
let lampiranRowIndex = {{ count(old('lampiran', $data->lampiran ?? [])) ?: 1 }};

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
    button.closest('tr').remove();
    updateLampiranNumbers();
}

function updateLampiranNumbers() {
    const rows = document.querySelectorAll('#lampiran-rows tr');
    rows.forEach((row, index) => {
        row.cells[0].textContent = index + 1;
        const inputs = row.querySelectorAll('input');
        inputs.forEach(input => {
            const name = input.getAttribute('name');
            if (name) {
                input.setAttribute('name', name.replace(/\[\d+\]/, `[${index}]`));
            }
        });
    });
    lampiranRowIndex = rows.length;
    
    rows.forEach((row) => {
        const deleteBtn = row.querySelector('.btn-danger');
        if (deleteBtn) {
            deleteBtn.style.display = rows.length > 1 ? 'inline-block' : 'none';
        }
    });
}

function updateRemoveButtons(className) {
    const rows = document.querySelectorAll('.' + className);
    rows.forEach((row) => {
        const deleteBtn = row.querySelector('.btn-danger');
        if (deleteBtn) {
            deleteBtn.style.display = rows.length > 1 ? 'inline-block' : 'none';
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    updateRemoveButtons('menimbang-row');
    updateRemoveButtons('dasar-row');
    updateRemoveButtons('untuk-row');
    updateRemoveButtons('tembusan-row');
    updateLampiranNumbers();
});
</script>
@endpush
@endsection