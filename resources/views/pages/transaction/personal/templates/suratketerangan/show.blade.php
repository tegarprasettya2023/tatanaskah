@extends('layout.main')

@section('content')
<x-breadcrumb :values="[__('menu.transaction.menu'), 'Surat Pribadi', 'Surat Keterangan', 'Detail']" />

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5><i class="bi bi-file-earmark-text"></i> Detail Surat Keterangan</h5>
                <div class="btn-group">
                     <a href="{{ route('transaction.personal.surat_keterangan.preview', $data->id) }}" 
                        class="btn btn-success btn-sm" target="_blank">
                        <i class="bi bi-eye"></i> Preview PDF
                    </a>
                    <a href="{{ route('transaction.personal.surat_keterangan.download', $data->id) }}" 
                       class="btn btn-primary btn-sm" target="_blank">
                       <i class="bi bi-download"></i> Download PDF
                    </a>
                    <a href="{{ route('transaction.personal.surat_keterangan.edit', $data->id) }}" 
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
                        <span class="text-muted">{{ $data->nomor ?? '-' }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Kop Surat:</strong><br>
                        <span class="badge bg-info">{{ ucfirst($data->kop_type ?? '-') }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Tanggal:</strong><br>
                        <span class="text-muted">{{ $data->formatted_letter_date ?? '-' }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Tempat:</strong><br>
                        <span class="text-muted">{{ $data->tempat ?? '-' }}</span>
                    </div>
                </div>

                {{-- Yang Menerangkan --}}
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-person-badge"></i> Yang Bertanda Tangan
                        </h6>
                    </div>
                    <div class="col-md-4 mb-2">
                        <strong>Nama:</strong><br>
                        <span class="text-muted">{{ $data->nama_yang_menerangkan ?? '-' }}</span>
                    </div>
                    <div class="col-md-4 mb-2">
                        <strong>NIK:</strong><br>
                        <span class="text-muted">{{ $data->nik_yang_menerangkan ?? '-' }}</span>
                    </div>
                    <div class="col-md-4 mb-2">
                        <strong>Jabatan:</strong><br>
                        <span class="text-muted">{{ $data->jabatan_yang_menerangkan ?? '-' }}</span>
                    </div>
                </div>

                {{-- Yang Diterangkan --}}
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-person"></i> Yang Diterangkan
                        </h6>
                    </div>
                    <div class="col-md-4 mb-2">
                        <strong>Nama:</strong><br>
                        <span class="text-muted">{{ $data->nama_yang_diterangkan ?? '-' }}</span>
                    </div>
                    <div class="col-md-4 mb-2">
                        <strong>NIP:</strong><br>
                        <span class="text-muted">{{ $data->nip_yang_diterangkan ?? '-' }}</span>
                    </div>
                    <div class="col-md-4 mb-2">
                        <strong>Jabatan:</strong><br>
                        <span class="text-muted">{{ $data->jabatan_yang_diterangkan ?? '-' }}</span>
                    </div>
                </div>

                {{-- Pembuat --}}
              
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
.text-justify {
    text-align: justify;
}
.border-bottom {
    border-bottom: 2px solid #dee2e6 !important;
}
</style>
@endpush
