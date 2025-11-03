@extends('layout.main')

@section('content')
<x-breadcrumb :values="[__('menu.transaction.menu'), 'Surat Pribadi', 'Surat Keputusan', 'Detail']" />

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5><i class="bi bi-file-earmark-check"></i> Detail Surat Keputusan</h5>
                <div class="btn-group">
                    <a href="{{ route('transaction.personal.surat_keputusan.preview', $data->id) }}" 
                       class="btn btn-success btn-sm" target="_blank">
                        <i class="bi bi-eye"></i> Preview PDF
                    </a>
                    <a href="{{ route('transaction.personal.surat_keputusan.download', $data->id) }}" 
                       class="btn btn-primary btn-sm" target="_blank">
                        <i class="bi bi-download"></i> Download PDF
                    </a>
                    <a href="{{ route('transaction.personal.surat_keputusan.edit', $data->id) }}" 
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
                    <div class="col-md-4 mb-2">
                        <strong>Kop Surat:</strong><br>
                        <span class="badge bg-info">{{ ucfirst($data->kop_type ?? '-') }}</span>
                    </div>
                    <div class="col-md-8 mb-2">
                        <strong>Nomor SK:</strong><br>
                        <span class="text-muted">{{ $data->nomor ?? '-' }}</span>
                    </div>
                    <div class="col-md-12 mt-2">
                        <strong>Tentang:</strong><br>
                        <p class="text-muted mt-1">{{ $data->tentang ?? '-' }}</p>
                    </div>
                </div>

                {{-- Menimbang --}}
                @if(!empty($data->menimbang) && count($data->menimbang) > 0)
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-list-check"></i> Menimbang
                        </h6>
                    </div>
                    <div class="col-12">
                        <ol type="a">
                            @foreach($data->menimbang as $item)
                            <li class="mb-2">{{ $item }}</li>
                            @endforeach
                        </ol>
                    </div>
                </div>
                @endif

                {{-- Mengingat --}}
                @if(!empty($data->mengingat) && count($data->mengingat) > 0)
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-list-check"></i> Mengingat
                        </h6>
                    </div>
                    <div class="col-12">
                        <ol type="a">
                            @foreach($data->mengingat as $item)
                            <li class="mb-2">{{ $item }}</li>
                            @endforeach
                        </ol>
                    </div>
                </div>
                @endif

                {{-- Menetapkan --}}
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-check-circle"></i> Menetapkan
                        </h6>
                    </div>
                    <div class="col-12">
                        <p class="text-muted">{{ $data->menetapkan ?? '-' }}</p>
                    </div>
                </div>

                {{-- Isi Keputusan --}}
                @if(!empty($data->isi_keputusan) && count($data->isi_keputusan) > 0)
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-file-text"></i> Isi Keputusan
                        </h6>
                    </div>
                    <div class="col-12">
                        @foreach($data->isi_keputusan as $keputusan)
                        <div class="mb-3">
                            <strong>{{ $keputusan['label'] ?? '' }} :</strong>
                            <p class="text-muted ms-3 mb-2">{{ $keputusan['isi'] ?? '' }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Penandatanganan --}}
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-pencil-square"></i> Penandatanganan
                        </h6>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Tanggal Penetapan:</strong><br>
                        <span class="text-muted">{{ $data->tanggal_penetapan ? $data->tanggal_penetapan->translatedFormat('d F Y') : '-' }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Tempat Penetapan:</strong><br>
                        <span class="text-muted">{{ $data->tempat_penetapan ?? '-' }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Jabatan:</strong><br>
                        <span class="text-muted">{{ $data->jabatan_pejabat ?? '-' }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Nama Pejabat:</strong><br>
                        <span class="text-muted">{{ $data->nama_pejabat ?? '-' }}</span>
                    </div>
                    @if($data->nik_pejabat)
                    <div class="col-md-12 mb-2">
                        <strong>NIK Kepegawaian:</strong><br>
                        <span class="text-muted">{{ $data->nik_pejabat }}</span>
                    </div>
                    @endif
                </div>

                {{-- Tembusan --}}
                @if(!empty($data->tembusan) && count($data->tembusan) > 0)
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-send"></i> Tembusan
                        </h6>
                    </div>
                    <div class="col-12">
                        <ol>
                            @foreach($data->tembusan as $item)
                            <li class="mb-1">{{ $item }}</li>
                            @endforeach
                        </ol>
                    </div>
                </div>
                @endif

                {{-- Lampiran --}}
                @if($data->lampiran)
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-paperclip"></i> Lampiran
                        </h6>
                    </div>
                    <div class="col-12">
@if(!empty($data->lampiran))
    @if(is_array($data->lampiran))
        @foreach($data->lampiran as $index => $item)
            @if(!empty($item))
                <div class="mb-3">
                    <h6 class="bi bi-paperclip"></h6> Lampiran {{ $index + 1 }}
                    <p class="text-muted" style="white-space: pre-line;">{{ $item }}</p>
                </div>
            @endif
        @endforeach
    @else
        <p class="text-muted" style="white-space: pre-line;">{{ $data->lampiran }}</p>
    @endif
@else
    <p class="text-muted">Tidak ada lampiran</p>
@endif                    </div>
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