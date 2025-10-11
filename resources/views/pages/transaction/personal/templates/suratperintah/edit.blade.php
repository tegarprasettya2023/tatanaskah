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
                <label for="kop_type" class="form-label">Pilih Kop Surat <span class="text-danger">*</span></label>
                <select class="form-select @error('kop_type') is-invalid @enderror" id="kop_type" name="kop_type" required>
                    <option value="klinik" {{ old('kop_type', $data->kop_type) == 'klinik' ? 'selected' : '' }}>Klinik</option>
                    <option value="lab" {{ old('kop_type', $data->kop_type) == 'lab' ? 'selected' : '' }}>Laboratorium</option>
                    <option value="pt" {{ old('kop_type', $data->kop_type) == 'pt' ? 'selected' : '' }}>PT</option>
                </select>
                @error('kop_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="nomor" class="form-label">Nomor Surat <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nomor') is-invalid @enderror" 
                       id="nomor" name="nomor" placeholder="ST/.../bulan/tahun" 
                       value="{{ old('nomor', $data->nomor) }}" required>
                @error('nomor')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="letter_date" class="form-label">Tanggal Surat <span class="text-danger">*</span></label>
                <input type="date" class="form-control @error('letter_date') is-invalid @enderror" 
                       id="letter_date" name="letter_date" 
                       value="{{ old('letter_date', $data->letter_date?->format('Y-m-d')) }}" required>
                @error('letter_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="tempat" class="form-label">Tempat <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('tempat') is-invalid @enderror" 
                       id="tempat" name="tempat" placeholder="Surabaya" 
                       value="{{ old('tempat', $data->tempat) }}" required>
                @error('tempat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Menimbang --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Menimbang</h6>
            </div>

            <div class="col-12 mb-3">
                <label for="menimbang_1" class="form-label">1. bahwa <span class="text-danger">*</span></label>
                <textarea class="form-control @error('menimbang_1') is-invalid @enderror" 
                          id="menimbang_1" name="menimbang_1" rows="3" required>{{ old('menimbang_1', $data->menimbang_1) }}</textarea>
                @error('menimbang_1')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12 mb-3">
                <label for="menimbang_2" class="form-label">2. bahwa <span class="text-danger">*</span></label>
                <textarea class="form-control @error('menimbang_2') is-invalid @enderror" 
                          id="menimbang_2" name="menimbang_2" rows="3" required>{{ old('menimbang_2', $data->menimbang_2) }}</textarea>
                @error('menimbang_2')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Dasar --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Dasar</h6>
            </div>

            <div class="col-12 mb-3">
                <label for="dasar_a" class="form-label">a. <span class="text-danger">*</span></label>
                <textarea class="form-control @error('dasar_a') is-invalid @enderror" 
                          id="dasar_a" name="dasar_a" rows="2" required>{{ old('dasar_a', $data->dasar_a) }}</textarea>
                @error('dasar_a')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12 mb-3">
                <label for="dasar_b" class="form-label">b. <span class="text-danger">*</span></label>
                <textarea class="form-control @error('dasar_b') is-invalid @enderror" 
                          id="dasar_b" name="dasar_b" rows="2" required>{{ old('dasar_b', $data->dasar_b) }}</textarea>
                @error('dasar_b')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Memberi Perintah Kepada --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Memberi Perintah Kepada</h6>
            </div>

            <div class="col-md-4 mb-3">
                <label for="nama_penerima" class="form-label">Nama <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nama_penerima" name="nama_penerima" 
                       value="{{ old('nama_penerima', $data->nama_penerima) }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label for="nik_penerima" class="form-label">NIK <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nik_penerima" name="nik_penerima" 
                       value="{{ old('nik_penerima', $data->nik_penerima) }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label for="jabatan_penerima" class="form-label">Jabatan <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="jabatan_penerima" name="jabatan_penerima" 
                       value="{{ old('jabatan_penerima', $data->jabatan_penerima) }}" required>
            </div>

            <div class="col-12 mb-3">
                <label for="nama_nama_terlampir" class="form-label">Atau nama-nama terlampir</label>
                <textarea class="form-control" id="nama_nama_terlampir" name="nama_nama_terlampir" rows="3">{{ old('nama_nama_terlampir', $data->nama_nama_terlampir) }}</textarea>
            </div>

            {{-- Untuk --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Untuk</h6>
            </div>

            <div class="col-12 mb-3">
                <label for="untuk_1" class="form-label">1.</label>
                <textarea class="form-control" id="untuk_1" name="untuk_1" rows="3" required>{{ old('untuk_1', $data->untuk_1) }}</textarea>
            </div>

            <div class="col-12 mb-3">
                <label for="untuk_2" class="form-label">2.</label>
                <textarea class="form-control" id="untuk_2" name="untuk_2" rows="3" required>{{ old('untuk_2', $data->untuk_2) }}</textarea>
            </div>

            {{-- Pembuat --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Pembuat Surat</h6>
            </div>

            <div class="col-md-4 mb-3">
                <label for="jabatan_pembuat" class="form-label">Jabatan</label>
                <input type="text" class="form-control" id="jabatan_pembuat" name="jabatan_pembuat" 
                       value="{{ old('jabatan_pembuat', $data->jabatan_pembuat) }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label for="nama_pembuat" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama_pembuat" name="nama_pembuat" 
                       value="{{ old('nama_pembuat', $data->nama_pembuat) }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label for="nik_pembuat" class="form-label">NIK</label>
                <input type="text" class="form-control" id="nik_pembuat" name="nik_pembuat" 
                       value="{{ old('nik_pembuat', $data->nik_pembuat) }}" required>
            </div>

            {{-- Tembusan --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Tembusan</h6>
            </div>

            <div class="col-12 mb-3">
                <label for="tembusan_1" class="form-label">1.</label>
                <input type="text" class="form-control" id="tembusan_1" name="tembusan_1" 
                       value="{{ old('tembusan_1', $data->tembusan_1) }}">
            </div>

            <div class="col-12 mb-3">
                <label for="tembusan_2" class="form-label">2.</label>
                <input type="text" class="form-control" id="tembusan_2" name="tembusan_2" 
                       value="{{ old('tembusan_2', $data->tembusan_2) }}">
            </div>

            {{-- Lampiran --}}
            <div class="col-12 mb-4 mt-3">
                <h6 class="border-bottom pb-2">Lampiran Daftar Nama</h6>
            </div>

            <div class="col-12 mb-3">
                <label class="form-label">Daftar Nama</label>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIK</th>
                            <th>Jabatan</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody id="lampiran-rows">
                        @php $lampiran = old('lampiran', $data->lampiran ?? []); @endphp
                        @foreach($lampiran as $i => $item)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td><input type="text" name="lampiran[{{ $i }}][nama]" class="form-control" value="{{ $item['nama'] ?? '' }}"></td>
                            <td><input type="text" name="lampiran[{{ $i }}][nik]" class="form-control" value="{{ $item['nik'] ?? '' }}"></td>
                            <td><input type="text" name="lampiran[{{ $i }}][jabatan]" class="form-control" value="{{ $item['jabatan'] ?? '' }}"></td>
                            <td><input type="text" name="lampiran[{{ $i }}][keterangan]" class="form-control" value="{{ $item['keterangan'] ?? '' }}"></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <button type="button" class="btn btn-sm btn-success" onclick="addLampiranRow()">+ Tambah</button>
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
@endsection

@push('scripts')
<script>
let rowIndex = {{ count($lampiran ?? []) }};
function addLampiranRow() {
    const tbody = document.getElementById('lampiran-rows');
    let row = `
    <tr>
        <td>${rowIndex+1}</td>
        <td><input type="text" name="lampiran[${rowIndex}][nama]" class="form-control"></td>
        <td><input type="text" name="lampiran[${rowIndex}][nik]" class="form-control"></td>
        <td><input type="text" name="lampiran[${rowIndex}][jabatan]" class="form-control"></td>
        <td><input type="text" name="lampiran[${rowIndex}][keterangan]" class="form-control"></td>
    </tr>`;
    tbody.insertAdjacentHTML('beforeend', row);
    rowIndex++;
}
</script>
@endpush
