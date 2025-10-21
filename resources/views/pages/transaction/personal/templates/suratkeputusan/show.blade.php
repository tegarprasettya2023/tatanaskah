@extends('layout.main')

@section('content')
<x-breadcrumb :values="[__('menu.transaction.menu'), 'Surat Pribadi', 'Surat Keputusan', 'Detail']" />

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5><i class="bi bi-file-earmark-text"></i> Detail Surat Keputusan</h5>
                <div class="btn-group">
                    <a href="{{ route('transaction.personal.suratkeputusan.preview', $data->id) }}" 
                       class="btn btn-success btn-sm" target="_blank">
                        <i class="bi bi-eye"></i> Preview PDF
                    </a>
                    <a href="{{ route('transaction.personal.suratkeputusan.download', $data->id) }}" 
                       class="btn btn-primary btn-sm" target="_blank">
                        <i class="bi bi-download"></i> Download PDF
                    </a>
                    <a href="{{ route('transaction.personal.suratkeputusan.edit', $data->id) }}" 
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
                        <strong>Nomor SK:</strong><br>
                        <span class="text-muted">{{ $data->generateNomorSK() }}</span>
                    </div>
                    <div class="col-md-12 mb-2">
                        <strong>Judul Setelah SK:</strong><br>
                        <span class="text-muted">{{ $data->judul_setelah_sk ?? 'Default' }}</span>
                    </div>
                </div>

                {{-- TENTANG --}}
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-file-text"></i> TENTANG
                        </h6>
                    </div>
                    <div class="col-12 mb-2">
                        <strong>TENTANG:</strong><br>
                        <p class="text-muted">{{ $data->tentang ?? '-' }}</p>
                    </div>
                    <div class="col-12 mb-2">
                        <strong>Jabatan Pembuat:</strong><br>
                        <span class="text-muted">{{ $data->jabatan_pembuat ?? 'Default' }}</span>
                    </div>
                </div>

                {{-- MENIMBANG --}}
                @if(!empty($data->menimbang))
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-list-ol"></i> Menimbang
                        </h6>
                    </div>
                    <div class="col-12">
                        @foreach($data->menimbang as $i => $item)
                            @if(!empty($item))
                            <div class="mb-2">
                                <strong>{{ chr(97 + $i) }}.</strong> bahwa {{ $item }}
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- MENGINGAT --}}
                @if(!empty($data->mengingat))
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-list-ol"></i> Mengingat
                        </h6>
                    </div>
                    <div class="col-12">
                        @foreach($data->mengingat as $i => $item)
                            @if(!empty($item))
                            <div class="mb-2">
                                <strong>{{ chr(97 + $i) }}.</strong> Undang-undang {{ $item }}
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- MENETAPKAN --}}
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-check-circle"></i> Menetapkan
                        </h6>
                    </div>
                    <div class="col-12 mb-2">
                        <p class="text-muted">{{ $data->menetapkan ?? 'Default + TENTANG' }}</p>
                    </div>
                </div>

                {{-- KEPUTUSAN --}}
                @if(!empty($data->keputusan))
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-list-check"></i> Keputusan
                        </h6>
                    </div>
                    <div class="col-12">
                        @php
                            $angkaTerbilang = ['', 'Kesatu', 'Kedua', 'Ketiga', 'Keempat', 'Kelima', 'Keenam', 'Ketujuh', 'Kedelapan', 'Kesembilan', 'Kesepuluh'];
                        @endphp
                        @foreach($data->keputusan as $i => $item)
                            @if(!empty($item))
                            <div class="mb-2">
                                <strong>{{ $angkaTerbilang[$i + 1] ?? ($i + 1) }}:</strong> {{ $item }}
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- PENUTUP --}}
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-pencil-square"></i> Penutup & Penandatangan
                        </h6>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Ditetapkan di:</strong><br>
                        <span class="text-muted">{{ $data->ditetapkan_di ?? '-' }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Pada Tanggal:</strong><br>
                        <span class="text-muted">{{ $data->tanggal_ditetapkan ? $data->tanggal_ditetapkan->format('d/m/Y') : '-' }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Nama Jabatan:</strong><br>
                        <span class="text-muted">{{ $data->nama_jabatan ?? '-' }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Nama Lengkap:</strong><br>
                        <span class="text-muted">{{ $data->nama_lengkap ?? '-' }}</span>
                    </div>
                    <div class="col-md-12 mb-2">
                        <strong>NIK Kepegawaian:</strong><br>
                        <span class="text-muted">{{ $data->nik_kepegawaian ?? '-' }}</span>
                    </div>
                </div>

                {{-- TEMBUSAN --}}
                @if(!empty($data->tembusan))
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-send"></i> Tembusan
                        </h6>
                    </div>
                    <div class="col-12">
                        <ol>
                            @foreach($data->tembusan as $item)
                                @if(!empty($item))
                                <li>{{ $item }}</li>
                                @endif
                            @endforeach
                        </ol>
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
</style>
@endpush