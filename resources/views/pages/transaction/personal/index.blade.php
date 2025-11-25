@extends('layout.main')

@section('content')
<x-breadcrumb :values="[__('menu.transaction.menu'), 'Tata Naskah']" />



{{-- Main Table Card --}}
<div class="card mb-4">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col">
                <h5 class="mb-0">
                    <i class="bi bi-file-earmark-text text-primary"></i> 
                    Daftar Surat Terbaru
                </h5>
            </div>
            <div class="col-auto">
                <a href="{{ route('transaction.personal.templates') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Buat Surat Baru
                </a>
            </div>
        </div>
    </div>

    <div class="card-body p-0">
        @if($data->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Template</th>
                            <th width="10%">Kop</th>
                            <th width="15%">Nomor</th>
                            <th width="10%">Tanggal</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>
                                <span class="badge bg-primary">
                                    {{ ucwords(str_replace('_', ' ', $item->jenis)) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ ucfirst($item->kop_type) }}</span>
                            </td>
                            <td><strong>{{ $item->nomor ?: '-' }}</strong></td>
                            <td>
<small class="text-muted">
    {{ ($item->letter_date 
        ?? $item->tanggal_surat 
        ?? $item->tanggal_penetapan 
        ?? $item->tanggal_acara
        ?? $item->tanggal_ttd
        ?? $item->tanggal_pembuatan)
        ? \Carbon\Carbon::parse(
            $item->letter_date
            ?? $item->tanggal_surat
            ?? $item->tanggal_penetapan
            ?? $item->tanggal_acara
            ?? $item->tanggal_ttd
            ?? $item->tanggal_pembuatan
        )->format('d/m/Y')
        : '-' }}
</small>
 
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('transaction.personal.' . $item->route_prefix . '.show', $item->id) }}" 
                                       class="btn btn-outline-info me-2" title="Lihat Detail">
                                        <i class="bi bi-eye fs-5"></i>
                                    </a>
                                    <a href="{{ route('transaction.personal.' . $item->route_prefix . '.edit', $item->id) }}" 
                                       class="btn btn-outline-warning me-2" title="Edit">
                                        <i class="bi bi-pencil fs-5"></i>
                                    </a>
                                    @if($item->generated_file)
                                        <a href="{{ route('transaction.personal.' . $item->route_prefix . '.preview', $item->id) }}" 
                                           class="btn btn-outline-primary me-2" title="Preview PDF" target="_blank">
                                            <i class="bi bi-file-pdf fs-5"></i>
                                        </a>
                                        <a href="{{ route('transaction.personal.' . $item->route_prefix . '.download', $item->id) }}" 
                                           class="btn btn-outline-success me-2" title="Download PDF" target="_blank">
                                            <i class="bi bi-download fs-5"></i>
                                        </a>
                                    @endif
                                    <form action="{{ route('transaction.personal.' . $item->route_prefix . '.destroy', $item->id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger" 
                                                onclick="return confirm('Hapus surat ini?')"
                                                title="Hapus">
                                            <i class="bi bi-trash fs-5"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer">
                {{ $data->links() }}
            </div>
        @else
            <div class="card-body text-center py-5">
                <i class="bi bi-file-earmark-text text-muted" style="font-size: 4rem;"></i>
                <h5 class="mt-3 text-muted">Belum Ada Surat</h5>
                <p class="text-muted mb-4">Anda belum membuat surat apapun.</p>
                <a href="{{ route('transaction.personal.templates') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Buat Surat Pertama
                </a>
            </div>
        @endif
    </div>
</div>
@endsection