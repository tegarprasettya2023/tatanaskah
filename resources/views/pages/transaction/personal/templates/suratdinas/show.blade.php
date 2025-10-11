@extends('layout.main')

@section('content')
<x-breadcrumb :values="[__('menu.transaction.menu'), 'Surat Pribadi', 'Surat Dinas', 'Detail']" />

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5><i class="bi bi-file-earmark-text"></i> Detail Surat Dinas</h5>
                <div class="btn-group">
                    <a href="{{ route('transaction.personal.surat_dinas.preview', $letter->id) }}" 
                        class="btn btn-success btn-sm" target="_blank">
                        <i class="bi bi-eye"></i> Preview PDF
                    </a>
                    <a href="{{ route('transaction.personal.surat_dinas.download', $letter->id) }}" 
                       class="btn btn-primary btn-sm" target="_blank">
                       <i class="bi bi-download"></i> Download PDF
                    </a>
                    <a href="{{ route('transaction.personal.surat_dinas.edit', $letter->id) }}" 
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
                        <strong>Nomor Surat:</strong><br>
                        <span class="text-muted">{{ $letter->nomor ?? '-' }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Kop Surat:</strong><br>
                        <span class="badge bg-info">{{ ucfirst($letter->kop_type ?? '-') }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Tanggal:</strong><br>
                        <span class="text-muted">
                            {{ $letter->letter_date ? \Carbon\Carbon::parse($letter->letter_date)->translatedFormat('l, d F Y') : '-' }}
                        </span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Tempat:</strong><br>
                        <span class="text-muted">{{ $letter->tempat ?? '-' }}</span>
                    </div>
                </div>

                {{-- Tujuan Surat --}}
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-envelope"></i> Tujuan Surat
                        </h6>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Kepada:</strong><br>
                        <span class="text-muted">{{ $letter->kepada ?? '-' }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>di:</strong><br>
                        <span class="text-muted">{{ $letter->kepada_tempat ?? '-' }}</span>
                    </div>
                </div>

                {{-- Penandatangan --}}
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-person-check"></i> Penandatangan
                        </h6>
                    </div>
                    <div class="col-md-4 mb-2">
                        <strong>Jabatan:</strong><br>
                        <span class="text-muted">{{ $letter->jabatan1 ?? '-' }}</span>
                    </div>
                    <div class="col-md-4 mb-2">
                        <strong>Nama:</strong><br>
                        <span class="text-muted">{{ $letter->nama1 ?? '-' }}</span>
                    </div>
                    <div class="col-md-4 mb-2">
                        <strong>NIP/NIK:</strong><br>
                        <span class="text-muted">{{ $letter->nip ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Sidebar (hanya informasi file + kembali) --}}
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header">
                <h6><i class="bi bi-file-earmark-pdf"></i> Informasi File</h6>
            </div>
            <div class="card-body">
                @if($letter->generated_file)
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle"></i> PDF tersedia
                    </div>
                    
                @else
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i> PDF belum dibuat
                    </div>
                @endif

                <hr>
                <div class="row text-center">
                    <div class="col-6">
                        <small class="text-muted">Dibuat:</small><br>
                        <small>{{ $letter->created_at->format('d/m/Y H:i') }}</small>
                    </div>
                    <div class="col-6">
                        <small class="text-muted">Diupdate:</small><br>
                        <small>{{ $letter->updated_at->format('d/m/Y H:i') }}</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body text-center">
                <a href="{{ route('transaction.personal.surat_dinas.index') }}" 
                   class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
<style>
.text-justify {
    text-align: justify;
}
.border-bottom {
    border-bottom: 2px solid #dee2e6 !important;
}
</style>
@endpush
