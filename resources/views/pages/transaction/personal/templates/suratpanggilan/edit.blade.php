@extends('layout.main')

@section('content')
<x-breadcrumb :values="[__('menu.transaction.menu'), 'Surat Pribadi', 'Edit Surat Panggilan']" />

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show">
        <strong>Terjadi Kesalahan!</strong>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card mb-4">
  <form action="{{ route('transaction.personal.surat_panggilan.update', $data->id) }}" method="POST">
    @csrf
    @method('PUT')

        <div class="card-header">
            <h5>Edit Surat Panggilan</h5>
        </div>

        <div class="card-body row">
            <div class="col-md-6 mb-3">
                <label>Kop Surat *</label>
                <select name="kop_type" class="form-select" required>
                    <option value="klinik" {{ $data->kop_type=='klinik'?'selected':'' }}>Klinik</option>
                    <option value="lab" {{ $data->kop_type=='lab'?'selected':'' }}>Laboratorium</option>
                    <option value="pt" {{ $data->kop_type=='pt'?'selected':'' }}>PT</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label>Tanggal Surat *</label>
                <input type="date" name="letter_date" class="form-control" 
                    value="{{ old('letter_date', \Carbon\Carbon::parse($data->letter_date)->format('Y-m-d')) }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label>Sifat</label>
                <input type="text" name="sifat" class="form-control" 
                       value="{{ old('sifat', $data->sifat) }}">
            </div>
            <div class="col-md-4 mb-3">
                <label>Lampiran</label>
                <input type="text" name="lampiran" class="form-control" 
                       value="{{ old('lampiran', $data->lampiran) }}">
            </div>
            <div class="col-md-4 mb-3">
                <label>Perihal *</label>
                <input type="text" name="perihal" class="form-control" 
                       value="{{ old('perihal', $data->perihal) }}" required>
            </div>

            <div class="col-12 mb-3">
                <label>Kepada *</label>
                <input type="text" name="kepada" class="form-control" 
                       value="{{ old('kepada', $data->kepada) }}" required>
            </div>

            <div class="col-12 mb-3">
                <label>Sehubungan dengan *</label>
                <textarea name="isi_pembuka" rows="3" class="form-control" required>{{ old('isi_pembuka', $data->isi_pembuka) }}</textarea>
            </div>

            
            <div class="col-md-6 mb-3">
                <label>Hari, Tanggal *</label>
                <input type="date" name="hari_tanggal" class="form-control" 
                    value="{{ old('hari_tanggal', \Carbon\Carbon::parse($data->hari_tanggal)->format('Y-m-d')) }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Waktu *</label>
                <input type="time" name="waktu" class="form-control" 
                       value="{{ old('waktu', $data->waktu) }}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Tempat *</label>
                <input type="text" name="tempat" class="form-control" 
                       value="{{ old('tempat', $data->tempat) }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Menghadap *</label>
                <input type="text" name="menghadap" class="form-control" 
                       value="{{ old('menghadap', $data->menghadap) }}" required>
            </div>

            <div class="col-12 mb-3">
                <label>Alamat Pemanggil *</label>
                <input type="text" name="alamat_pemanggil" class="form-control" 
                       value="{{ old('alamat_pemanggil', $data->alamat_pemanggil) }}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Jabatan *</label>
                <input type="text" name="jabatan" class="form-control" 
                       value="{{ old('jabatan', $data->jabatan) }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Nama Pejabat *</label>
                <input type="text" name="nama_pejabat" class="form-control" 
                       value="{{ old('nama_pejabat', $data->nama_pejabat) }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>NIK *</label>
                <input type="text" name="nik" class="form-control" 
                       value="{{ old('nik', $data->nik) }}" required>
            </div>

            <div class="col-12"><hr></div>
            <!-- TEMBUSAN DYNAMIC -->
            <div class="col-12 mb-4 mt-3">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2">
                    <h6 class="text-primary mb-0">Tembusan (Opsional)</h6>
                    <button type="button" id="add-tembusan" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-plus-circle"></i> Tambah Tembusan
                    </button>
                </div>
            </div>

            <div class="col-12">
                <div id="tembusan-wrapper">
                    @php
                        $tembusanData = old('tembusan', $data->tembusan ?? []);
                        $tembusanData = is_array($tembusanData) && count($tembusanData) > 0 ? $tembusanData : [''];
                    @endphp
                    @foreach($tembusanData as $index => $temb)
                    <div class="tembusan-item card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <strong>Tembusan {{ $index + 1 }}</strong>
                                @if($index > 0)
                                <button type="button" class="btn btn-sm btn-outline-danger remove-tembusan">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                                @endif
                            </div>
                            <input type="text" name="tembusan[]" class="form-control" 
                                   placeholder="Contoh: Kepala Bagian HRD" value="{{ $temb }}">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Perbarui</button>
            <a href="{{ route('transaction.personal.index') }}" class="btn btn-secondary">Kembali</a>
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
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const tembusanWrapper = document.getElementById("tembusan-wrapper");
    const addTembusan = document.getElementById("add-tembusan");
    let tembusanIndex = tembusanWrapper.querySelectorAll('.tembusan-item').length;

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