@extends('layout.main')

@section('content')
<x-breadcrumb :values="[__('menu.transaction.menu'), 'Surat Pribadi', 'Perjanjian Kerja Sama', 'Detail']" />

<div class="row">
    <!-- Detail Surat -->
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5><i class="bi bi-file-earmark-text"></i> Detail Surat Perjanjian Kerja Sama</h5>
                <div class="btn-group">
                   <a href="{{ route('transaction.personal.perjanjian.preview', $data->id) }}" 
                        class="btn btn-success btn-sm" target="_blank">
                        <i class="bi bi-eye"></i> Preview PDF
                    </a>
                    <a href="{{ route('transaction.personal.perjanjian.download', $data->id) }}" 
                       class="btn btn-primary btn-sm" target="_blank">
                       <i class="bi bi-download"></i> Download PDF
                    </a>
                    <a href="{{ route('transaction.personal.perjanjian.edit', $data->id) }}" 
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
                        <strong>Nomor SPK:</strong><br>
                        <span class="text-muted">{{ $data->nomor ?? '-' }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Kop Surat:</strong><br>
                        <span class="badge bg-info">{{ ucfirst($data->kop_type ?? '-') }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Tanggal Surat:</strong><br>
                        <span class="text-muted">
                            {{ $data->letter_date ? \Carbon\Carbon::parse($data->letter_date)->translatedFormat('l, d F Y') : '-' }}
                        </span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Tempat:</strong><br>
                        <span class="text-muted">{{ $data->tempat ?? '-' }}</span>
                    </div>
                </div>

                {{-- Informasi Para Pihak --}}
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-people"></i> Para Pihak
                        </h6>
                    </div>
                    
                    {{-- Pihak I --}}
                    <div class="col-md-6">
                        <div class="card border-start border-primary border-3">
                            <div class="card-body">
                                <h6 class="card-title text-primary">Pihak I</h6>
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td width="30%"><strong>Nama:</strong></td>
                                        <td>{{ $data->pihak1 ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Institusi:</strong></td>
                                        <td>{{ $data->institusi1 ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Jabatan:</strong></td>
                                        <td>{{ $data->jabatan1 ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Nama Lengkap:</strong></td>
                                        <td>{{ $data->nama1 ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Pihak II --}}
                    <div class="col-md-6">
                        <div class="card border-start border-success border-3">
                            <div class="card-body">
                                <h6 class="card-title text-success">Pihak II</h6>
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td width="30%"><strong>Nama:</strong></td>
                                        <td>{{ $data->pihak2 ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Institusi:</strong></td>
                                        <td>{{ $data->institusi2 ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Jabatan:</strong></td>
                                        <td>{{ $data->jabatan2 ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Nama Lengkap:</strong></td>
                                        <td>{{ $data->nama2 ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        {{-- File Information --}}
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