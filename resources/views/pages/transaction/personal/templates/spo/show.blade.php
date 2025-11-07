@extends('layout.main')

@section('content')
<x-breadcrumb :values="[__('menu.transaction.menu'), 'Surat Pribadi', 'SPO', 'Detail']" />

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5><i class="bi bi-file-earmark-text"></i> Detail SPO</h5>
                <div class="btn-group">
                    <a href="{{ route('transaction.personal.spo.preview', $data->id) }}" 
                       class="btn btn-success btn-sm" target="_blank">
                        <i class="bi bi-eye"></i> Preview PDF
                    </a>
                    <a href="{{ route('transaction.personal.spo.download', $data->id) }}" 
                       class="btn btn-primary btn-sm" target="_blank">
                        <i class="bi bi-download"></i> Download PDF
                    </a>
                    <a href="{{ route('transaction.personal.spo.edit', $data->id) }}" 
                       class="btn btn-warning btn-sm">
                       <i class="bi bi-pencil"></i> Edit
                    </a>
                </div>
            </div>

            <div class="card-body">
                {{-- Informasi Header --}}
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-info-circle"></i> Informasi Header
                        </h6>
                    </div>
                    <div class="col-md-4 mb-2">
                        <strong>Logo Kiri:</strong><br>
                        <span class="badge bg-info">{{ ucfirst($data->logo_kiri ?? '-') }}</span>
                    </div>
                    <div class="col-md-4 mb-2">
                        <strong>Logo Kanan:</strong><br>
                        <span class="badge bg-info">{{ ucfirst($data->logo_kanan ?? '-') }}</span>
                    </div>
                    <div class="col-md-4 mb-2">
                        <strong>Kop Surat:</strong><br>
                        <span class="badge bg-success">{{ ucfirst($data->kop_type ?? '-') }}</span>
                    </div>
                    <div class="col-12 mb-2 mt-2">
                        <strong>Judul SPO:</strong><br>
                        <span class="text-muted">{{ $data->judul_spo ?? '-' }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>No. Dokumen:</strong><br>
                        <span class="text-muted">{{ $data->no_dokumen ?? '-' }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>No. Revisi:</strong><br>
                        <span class="text-muted">{{ $data->no_revisi ?? '-' }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Tanggal Terbit:</strong><br>
                        <span class="text-muted">{{ $data->formatted_tanggal_terbit ?? '-' }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Halaman:</strong><br>
                        <span class="text-muted">{{ $data->halaman ?? '-' }}</span>
                    </div>
                </div>

                {{-- Persetujuan --}}
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-check2-square"></i> Persetujuan Dokumen
                        </h6>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Dibuat oleh:</strong><br>
                        <span class="text-muted">Jabatan: {{ $data->dibuat_jabatan ?? '-' }}</span><br>
                        <span class="text-muted">Nama: {{ $data->dibuat_nama ?? '-' }}</span><br>
                        <span class="text-muted">Tanggal: {{ $data->dibuat_tanggal ? $data->dibuat_tanggal->format('d/m/Y') : '-' }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Direview oleh:</strong><br>
                        <span class="text-muted">Jabatan: {{ $data->direview_jabatan ?? '-' }}</span><br>
                        <span class="text-muted">Nama: {{ $data->direview_nama ?? '-' }}</span><br>
                        <span class="text-muted">Tanggal: {{ $data->direview_tanggal ? $data->direview_tanggal->format('d/m/Y') : '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        {{-- Informasi File --}}
        <div class="card mb-4">
            <div class="card-header">
                <h6><i class="bi bi-file-earmark-pdf"></i> Informasi File</h6>
            </div>
            <div class="card-body">
                @if($data->generated_file)
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
                <a href="{{ route('transaction.personal.index') }}" 
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
.border-bottom {
    border-bottom: 2px solid #dee2e6 !important;
}
</style>
@endpush