@extends('layout.main')

@section('content')
<x-breadcrumb :values="[__('menu.transaction.menu'), 'Surat Pribadi', 'Notulen', 'Detail']" />

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5><i class="bi bi-journal-text"></i> Detail Surat Notulen</h5>
                <div class="btn-group">
                    <a href="{{ route('transaction.personal.notulen.preview', $data->id) }}" 
                       class="btn btn-success btn-sm" target="_blank">
                        <i class="bi bi-eye"></i> Preview PDF
                    </a>
                    <a href="{{ route('transaction.personal.notulen.download', $data->id) }}" 
                       class="btn btn-primary btn-sm" target="_blank">
                        <i class="bi bi-download"></i> Download PDF
                    </a>
                    <a href="{{ route('transaction.personal.notulen.edit', $data->id) }}" 
                       class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                </div>
            </div>

            <div class="card-body">
                {{-- Informasi Dasar --}}
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-info-circle"></i> Informasi Dasar
                        </h6>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Kop Surat:</strong><br>
                        <span class="badge bg-info">{{ ucfirst($data->kop_type ?? '-') }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Tanggal Rapat:</strong><br>
                        <span class="text-muted">{{ $data->tanggal_rapat ? $data->tanggal_rapat->translatedFormat('d F Y') : '-' }}</span>
                    </div>
                    <div class="col-md-12 mt-2">
                        <strong>Tempat:</strong><br>
                        <span class="text-muted">{{ $data->tempat ?? '-' }}</span>
                    </div>
                    <div class="col-md-12 mt-2">
                        <strong>Isi Notulen:</strong><br>
                        <p class="text-muted mt-1">{{ $data->isi_notulen ?? '-' }}</p>
                    </div>
                </div>

                {{-- Peserta & Pimpinan --}}
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-people"></i> Peserta & Pimpinan Rapat
                        </h6>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Pimpinan Rapat:</strong><br>
                        <span class="text-muted">{{ $data->pimpinan_rapat ?? '-' }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Peserta Rapat:</strong><br>
                        <span class="text-muted">{{ $data->peserta_rapat ?? '-' }}</span>
                    </div>
                </div>

                {{-- Penandatanganan --}}
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-pencil-square"></i> Penandatanganan
                        </h6>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Kepala Lab:</strong><br>
                        <span class="text-muted">{{ $data->kepala_lab ?? '-' }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>NIK Kepala Lab:</strong><br>
                        <span class="text-muted">{{ $data->nik_kepala_lab ?? '-' }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Notulis:</strong><br>
                        <span class="text-muted">{{ $data->notulis ?? '-' }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>NIK Notulis:</strong><br>
                        <span class="text-muted">{{ $data->nik_notulis ?? '-' }}</span>
                    </div>
                </div>

                {{-- Dokumentasi --}}
                @if($data->dokumentasi && count($data->dokumentasi) > 0)
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-camera"></i> Dokumentasi
                        </h6>
                    </div>
                    <div class="col-md-12">
                        <p><strong>Judul:</strong> {{ $data->judul_dokumentasi ?? '-' }}</p>
                        <div class="row">
                            @foreach($data->dokumentasi as $path)
                            <div class="col-md-4 mb-3">
                                <img src="{{ asset('storage/' . $path) }}" 
                                     class="img-fluid rounded shadow-sm border" 
                                     alt="Dokumentasi">
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Sidebar --}}
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header">
                <h6><i class="bi bi-file-earmark-pdf"></i> Informasi File</h6>
            </div>
            <div class="card-body">
                @if($data->generated_file)
                    <div class="alert alert-success mb-3">
                        <i class="bi bi-check-circle"></i> PDF telah dibuat
                    </div>
                @else
                    <div class="alert alert-warning mb-3">
                        <i class="bi bi-exclamation-triangle"></i> PDF belum dibuat
                    </div>
                @endif

                <hr>
                <div class="row text-center">
                    <div class="col-6">
                        <small class="text-muted">Dibuat:</small><br>
                        <small>{{ $data->created_at->format('d/m/Y H:i') }}</small>
                    </div>
                    <div class="col-6">
                        <small class="text-muted">Diupdate:</small><br>
                        <small>{{ $data->updated_at->format('d/m/Y H:i') }}</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tombol Back --}}
        <div class="card">
            <div class="card-body text-center">
                <a href="{{ route('transaction.personal.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
<style>
.border-bottom {
    border-bottom: 2px solid #dee2e6 !important;
}
.table th, .table td {
    vertical-align: middle !important;
}
</style>
@endpush
