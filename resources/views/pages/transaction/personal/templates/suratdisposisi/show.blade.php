@extends('layout.main')

@section('content')
<x-breadcrumb :values="[__('menu.transaction.menu'), 'Surat Pribadi', 'Disposisi', 'Detail']" />

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5><i class="bi bi-file-earmark-ruled"></i> Detail Formulir Disposisi</h5>
                <div class="btn-group">
                    <a href="{{ route('transaction.personal.disposisi.preview', $data->id) }}" 
                       class="btn btn-success btn-sm" target="_blank">
                        <i class="bi bi-eye"></i> Preview PDF
                    </a>
                    <a href="{{ route('transaction.personal.disposisi.download', $data->id) }}" 
                       class="btn btn-primary btn-sm" target="_blank">
                        <i class="bi bi-download"></i> Download PDF
                    </a>
                    <a href="{{ route('transaction.personal.disposisi.edit', $data->id) }}" 
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
                    <div class="col-md-6 mb-2">
                        <strong>Logo/Kop:</strong><br>
                        <span class="badge bg-info">{{ ucfirst($data->kop_type ?? '-') }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>No. Dokumen:</strong><br>
                        <span class="text-muted">{{ $data->nomor_membaca ?? '-' }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Nomor LD:</strong><br>
                        <span class="text-muted">{{ $data->nomor_ld ?? '-' }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Tanggal Dokumen:</strong><br>
                        <span class="text-muted">{{ $data->tanggal_dokumen ? $data->tanggal_dokumen->format('d/m/Y') : '-' }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>No. Revisi:</strong><br>
                        <span class="badge bg-secondary">{{ $data->no_revisi ?? '-' }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Tanggal Pembuatan:</strong><br>
                        <span class="text-muted">{{ $data->tanggal_pembuatan ? $data->tanggal_pembuatan->format('d/m/Y') : '-' }}</span>
                    </div>
                </div>

                {{-- Nomor/Tanggal Membaca --}}
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-book"></i> Nomor/Tanggal Membaca
                        </h6>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Nomor Membaca:</strong><br>
                        <span class="text-muted">{{ $data->nomor_membaca ?? '-' }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Tanggal Membaca:</strong><br>
                        <span class="text-muted">{{ $data->tanggal_membaca ? $data->tanggal_membaca->format('d/m/Y') : '-' }}</span>
                    </div>
                </div>

                {{-- Perihal & Paraf --}}
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-chat-left-text"></i> Perihal & Paraf
                        </h6>
                    </div>
                    <div class="col-md-12 mb-2">
                        <strong>Perihal:</strong><br>
                        <p class="text-muted mt-1">{{ $data->perihal ?? '-' }}</p>
                    </div>
                    <div class="col-md-12 mb-2">
                        <strong>Paraf:</strong><br>
                        <span class="text-muted">{{ $data->paraf ?? '-' }}</span>
                    </div>
                </div>

                {{-- Diteruskan Kepada --}}
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-people"></i> Diteruskan Kepada
                        </h6>
                    </div>
                    <div class="col-12">
                        @if(!empty($data->diteruskan_kepada))
                            <ol class="mb-0">
                                @foreach($data->diteruskan_kepada as $penerima)
                                    <li>{{ $penerima }}</li>
                                @endforeach
                            </ol>
                        @else
                            <p class="text-muted">-</p>
                        @endif
                    </div>
                </div>

                {{-- Tanggal Diserahkan & Kembali --}}
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-calendar-check"></i> Tanggal Diserahkan & Kembali
                        </h6>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Tanggal Diserahkan:</strong><br>
                        <span class="text-muted">{{ $data->tanggal_diserahkan ? $data->tanggal_diserahkan->format('d/m/Y') : '-' }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Tanggal Kembali:</strong><br>
                        <span class="text-muted">{{ $data->tanggal_kembali ? $data->tanggal_kembali->format('d/m/Y') : '-' }}</span>
                    </div>
                </div>

                {{-- Catatan --}}
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-sticky"></i> Catatan
                        </h6>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Catatan Kolom 1:</strong><br>
                        <p class="text-muted mt-1">{{ $data->catatan_1 ?? '-' }}</p>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Catatan Kolom 2:</strong><br>
                        <p class="text-muted mt-1">{{ $data->catatan_2 ?? '-' }}</p>
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
</style>
@endpush