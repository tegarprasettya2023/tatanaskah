@extends('layout.main')

@section('content')
<x-breadcrumb :values="[__('menu.transaction.menu'), 'Surat Pribadi', 'Formulir Disposisi', 'Detail']" />

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5><i class="bi bi-file-earmark-text"></i> Detail Formulir Disposisi</h5>
                <div class="btn-group">
                    <a href="{{ route('transaction.personal.suratdisposisi.preview', $data->id) }}" 
                       class="btn btn-success btn-sm" target="_blank">
                        <i class="bi bi-eye"></i> Preview PDF
                    </a>
                    <a href="{{ route('transaction.personal.suratdisposisi.download', $data->id) }}" 
                       class="btn btn-primary btn-sm" target="_blank">
                        <i class="bi bi-download"></i> Download PDF
                    </a>
                    <a href="{{ route('transaction.personal.suratdisposisi.edit', $data->id) }}" 
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
                        <strong>No. Dokumen:</strong><br>
                        <span class="text-muted">{{ $data->nomor_dokumen ?? '-' }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>No. Revisi:</strong><br>
                        <span class="text-muted">{{ $data->no_revisi ?? '-' }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Logo:</strong><br>
                        <span class="badge bg-info">{{ ucfirst($data->logo_type ?? '-') }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Kop Surat:</strong><br>
                        <span class="badge bg-info">{{ ucfirst($data->kop_type ?? '-') }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Halaman:</strong><br>
                        <span class="text-muted">{{ $data->halaman_dari ?? '1' }}</span>
                    </div>
                </div>
                
                {{-- Tabel Kiri --}}
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-person"></i> Informasi Pembuat (Tabel Kiri)
                        </h6>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Dari (Bagian Pembuat):</strong><br>
                        <span class="text-muted">{{ $data->bagian_pembuat ?? '-' }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Nomor/Tanggal:</strong><br>
                        <span class="text-muted">{{ $data->nomor_tanggal ?? '-' }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Perihal:</strong><br>
                        <span class="text-muted">{{ $data->perihal ?? '-' }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Kepada:</strong><br>
                        <span class="text-muted">{{ $data->kepada ?? '-' }}</span>
                    </div>
                    <div class="col-12 mb-2">
                        <strong>Ringkasan Isi:</strong><br>
                        <span class="text-muted">{{ $data->ringkasan_isi ?? '-' }}</span>
                    </div>
                    <div class="col-12 mb-2">
                        <strong>Instruksi (Kiri):</strong><br>
                        <span class="text-muted">{{ $data->instruksi_1 ?? '-' }}</span>
                    </div>
                </div>

                {{-- Tabel Kanan --}}
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-clipboard-check"></i> Informasi Disposisi (Tabel Kanan)
                        </h6>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Tanggal Pembuatan:</strong><br>
                        <span class="text-muted">{{ $data->formatted_tanggal_pembuatan ?? '-' }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>No. Agenda:</strong><br>
                        <span class="text-muted">{{ $data->no_agenda ?? '-' }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Paraf:</strong><br>
                        <span class="text-muted">{{ $data->paraf ?? '-' }}</span>
                    </div>
                    <div class="col-12 mb-2">
                        <strong>Diteruskan Kepada:</strong><br>
                        @if($data->diteruskan_kepada && count($data->diteruskan_kepada) > 0)
                            <ul class="mb-0">
                                @foreach($data->diteruskan_kepada as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Tanggal Diserahkan:</strong><br>
                        <span class="text-muted">{{ $data->formatted_tanggal_diserahkan ?? '-' }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Tanggal Kembali:</strong><br>
                        <span class="text-muted">{{ $data->formatted_tanggal_kembali ?? '-' }}</span>
                    </div>
                    <div class="col-12 mb-2">
                        <strong>Instruksi (Kanan):</strong><br>
                        <span class="text-muted">{{ $data->instruksi_2 ?? '-' }}</span>
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