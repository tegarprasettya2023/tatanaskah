@extends('layout.main')

@section('content')
<x-breadcrumb :values="[__('menu.transaction.menu'), 'Surat Pribadi', 'Pengumuman', 'Detail']" />

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5><i class="bi bi-file-earmark-text"></i> Detail Surat Pengumuman</h5>
                <div class="btn-group">
                    <a href="{{ route('transaction.personal.pengumuman.preview', $letter->id) }}" 
                       class="btn btn-success btn-sm" target="_blank">
                        <i class="bi bi-eye"></i> Preview PDF
                    </a>
                    <a href="{{ route('transaction.personal.pengumuman.download', $letter->id) }}" 
                       class="btn btn-primary btn-sm" target="_blank">
                        <i class="bi bi-download"></i> Download PDF
                    </a>
                    <a href="{{ route('transaction.personal.pengumuman.edit', $letter->id) }}" 
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
                        <strong>Nomor:</strong><br>
                        <span class="text-muted">{{ $letter->nomor ?? '-' }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Kop Surat:</strong><br>
                        <span class="badge bg-info">{{ ucfirst($letter->kop_type ?? '-') }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Tanggal Surat:</strong><br>
                        <span class="text-muted">{{ \Carbon\Carbon::parse($letter->tanggal_surat)->translatedFormat('d F Y') }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Tentang:</strong><br>
                        <span class="text-muted">{{ $letter->tentang ?? '-' }}</span>
                    </div>
                </div>

                {{-- TTD --}}
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-pencil-square"></i> Penandatanganan
                        </h6>
                    </div>
                    <div class="col-md-4 mb-2">
                        <strong>Jabatan:</strong><br>
                        <span class="text-muted">{{ $letter->jabatan_pembuat }}</span>
                    </div>
                    <div class="col-md-4 mb-2">
                        <strong>Nama:</strong><br>
                        <span class="text-muted">{{ $letter->nama_pembuat }}</span>
                    </div>
                    <div class="col-md-4 mb-2">
                        <strong>NIK Pegawai:</strong><br>
                        <span class="text-muted">{{ $letter->nik_pegawai }}</span>
                    </div>
                </div>
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
                @if($letter->generated_file)
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle"></i> PDF telah dibuat
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
</style>
@endpush
