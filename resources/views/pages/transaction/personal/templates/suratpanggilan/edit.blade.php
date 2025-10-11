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

            <div class="col-12 mb-3">
                <label>Tembusan 1</label>
                <input type="text" name="tembusan_1" class="form-control" 
                       value="{{ old('tembusan_1', $data->tembusan_1) }}">
            </div>
            <div class="col-12 mb-3">
                <label>Tembusan 2</label>
                <input type="text" name="tembusan_2" class="form-control" 
                       value="{{ old('tembusan_2', $data->tembusan_2) }}">
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Perbarui</button>
            <a href="{{ route('transaction.personal.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>
@endsection
