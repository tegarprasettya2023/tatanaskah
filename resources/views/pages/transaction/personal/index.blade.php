    @extends('layout.main')

    @section('content')
    <x-breadcrumb :values="[__('menu.transaction.menu'), 'Surat Pribadi']" />

    {{-- Statistics Cards --}}
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="bi bi-file-earmark-text fs-1"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-0 text-white">{{ $data->total() ?? 0 }}</h5>
                            <small>Total Surat</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="bi bi-file-earmark-pdf fs-1"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-0 text-white">{{ $data->where('generated_file', '!=', null)->count() }}</h5>
                            <small>PDF Tersedia</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="bi bi-calendar-month fs-1"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-0 text-white">{{ $data->where('created_at', '>=', now()->startOfMonth())->count() }}</h5>
                            <small>Bulan Ini</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="bi bi-file-earmark-plus fs-1"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-0 text-white">{{ $totalTemplates }}</h5>
                            <small>Template</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Table Card --}}
    <div class="card mb-4">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0">
                        <i class="bi bi-file-earmark-text text-primary"></i> 
                        Daftar Surat Pribadi
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
                                        {{ $item->letter_date ? \Carbon\Carbon::parse($item->letter_date)->format('d/m/Y') : '-' }}
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        @if($item->jenis === 'perjanjian')
                                            <a href="{{ route('transaction.personal.perjanjian.show', $item->id) }}" 
                                            class="btn btn-outline-info me-2" title="Lihat Detail">
                                            <i class="bi bi-eye fs-5"></i>
                                            </a>
                                            <a href="{{ route('transaction.personal.perjanjian.edit', $item->id) }}" 
                                            class="btn btn-outline-warning me-2" title="Edit">
                                            <i class="bi bi-pencil fs-5"></i>
                                            </a>
                                            @if($item->generated_file)
                                                <a href="{{ route('transaction.personal.preview', $item->id) }}" 
                                                class="btn btn-outline-primary me-2" title="Preview PDF" target="_blank">
                                                    <i class="bi bi-file-pdf fs-5"></i>
                                                </a>
                                                <a href="{{ route('transaction.personal.download', $item->id) }}" 
                                                class="btn btn-outline-success me-2" title="Download PDF" target="_blank">
                                                    <i class="bi bi-download fs-5"></i>
                                                </a>
                                            @endif
                                            <form action="{{ route('transaction.personal.perjanjian.destroy', $item->id) }}" 
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-outline-danger" 
                                                        onclick="return confirm('Hapus surat ini?')"
                                                        title="Hapus">
                                                    <i class="bi bi-trash fs-5"></i>
                                                </button>
                                            </form>
                                        @elseif($item->jenis === 'surat_dinas')
                                            <a href="{{ route('transaction.personal.surat_dinas.show', $item->id) }}" 
                                            class="btn btn-outline-info me-2" title="Lihat Detail">
                                            <i class="bi bi-eye fs-5"></i>
                                            </a>
                                            <a href="{{ route('transaction.personal.surat_dinas.edit', $item->id) }}" 
                                            class="btn btn-outline-warning me-2" title="Edit">
                                            <i class="bi bi-pencil fs-5"></i>
                                            </a>
                                            @if($item->generated_file)
                                                <a href="{{ route('transaction.personal.surat_dinas.preview', $item->id) }}" 
                                                class="btn btn-outline-primary me-2" title="Preview PDF" target="_blank">
                                                    <i class="bi bi-file-pdf fs-5"></i>
                                                </a>
                                                <a href="{{ route('transaction.personal.surat_dinas.download', $item->id) }}" 
                                                class="btn btn-outline-success me-2" title="Download PDF" target="_blank">
                                                    <i class="bi bi-download fs-5"></i>
                                                </a>
                                            @endif
                                            <form action="{{ route('transaction.personal.surat_dinas.destroy', $item->id) }}" 
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-outline-danger" 
                                                        onclick="return confirm('Hapus surat ini?')"
                                                        title="Hapus">
                                                    <i class="bi bi-trash fs-5"></i>
                                                </button>
                                            </form>
                                        @elseif($item->jenis === 'surat_keterangan')
                                            <a href="{{ route('transaction.personal.surat_keterangan.show', $item->id) }}" 
                                            class="btn btn-outline-info me-2" title="Lihat Detail">
                                            <i class="bi bi-eye fs-5"></i>
                                            </a>
                                            <a href="{{ route('transaction.personal.surat_keterangan.edit', $item->id) }}" 
                                            class="btn btn-outline-warning me-2" title="Edit">
                                            <i class="bi bi-pencil fs-5"></i>
                                            </a>
                                            @if($item->generated_file)
                                                <a href="{{ route('transaction.personal.surat_keterangan.preview', $item->id) }}" 
                                                class="btn btn-outline-primary me-2" title="Preview PDF" target="_blank">
                                                    <i class="bi bi-file-pdf fs-5"></i>
                                                </a>
                                                <a href="{{ route('transaction.personal.surat_keterangan.download', $item->id) }}" 
                                                class="btn btn-outline-success me-2" title="Download PDF" target="_blank">
                                                    <i class="bi bi-download fs-5"></i>
                                                </a>
                                            @endif
                                            <form action="{{ route('transaction.personal.surat_keterangan.destroy', $item->id) }}" 
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-outline-danger" 
                                                        onclick="return confirm('Hapus surat ini?')"
                                                        title="Hapus">
                                                    <i class="bi bi-trash fs-5"></i>
                                                </button>
                                            </form>
                                        @elseif($item->jenis === 'surat_perintah')
                                            <a href="{{ route('transaction.personal.surat_perintah.show', $item->id) }}" 
                                            class="btn btn-outline-info me-2" title="Lihat Detail">
                                            <i class="bi bi-eye fs-5"></i>
                                            </a>
                                            <a href="{{ route('transaction.personal.surat_perintah.edit', $item->id) }}" 
                                            class="btn btn-outline-warning me-2" title="Edit">
                                            <i class="bi bi-pencil fs-5"></i>
                                            </a>
                                            @if($item->generated_file)
                                                <a href="{{ route('transaction.personal.surat_perintah.preview', $item->id) }}" 
                                                class="btn btn-outline-primary me-2" title="Preview PDF" target="_blank">
                                                    <i class="bi bi-file-pdf fs-5"></i>
                                                </a>
                                                <a href="{{ route('transaction.personal.surat_perintah.download', $item->id) }}" 
                                                class="btn btn-outline-success me-2" title="Download PDF" target="_blank">
                                                    <i class="bi bi-download fs-5"></i>
                                                </a>
                                            @endif
                                            <form action="{{ route('transaction.personal.surat_perintah.destroy', $item->id) }}" 
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-outline-danger" 
                                                        onclick="return confirm('Hapus surat ini?')"
                                                        title="Hapus">
                                                    <i class="bi bi-trash fs-5"></i>
                                                </button>
                                            </form>
                                            @elseif($item->jenis === 'surat_kuasa')
                                            <a href="{{ route('transaction.personal.suratkuasa.show', $item->id) }}" 
                                            class="btn btn-outline-info me-2" title="Lihat Detail">
                                            <i class="bi bi-eye fs-5"></i>
                                            </a>
                                            <a href="{{ route('transaction.personal.suratkuasa.edit', $item->id) }}" 
                                            class="btn btn-outline-warning me-2" title="Edit">
                                            <i class="bi bi-pencil fs-5"></i>
                                            </a>
                                            @if($item->generated_file)
                                                <a href="{{ route('transaction.personal.suratkuasa.preview', $item->id) }}" 
                                                class="btn btn-outline-primary me-2" title="Preview PDF" target="_blank">
                                                    <i class="bi bi-file-pdf fs-5"></i>
                                                </a>
                                                <a href="{{ route('transaction.personal.suratkuasa.download', $item->id) }}" 
                                                class="btn btn-outline-success me-2" title="Download PDF" target="_blank">
                                                    <i class="bi bi-download fs-5"></i>
                                                </a>
                                            @endif
                                            <form action="{{ route('transaction.personal.suratkuasa.destroy', $item->id) }}" 
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-outline-danger" 
                                                        onclick="return confirm('Hapus surat ini?')"
                                                        title="Hapus">
                                                    <i class="bi bi-trash fs-5"></i>
                                                </button>
                                            </form>
                                            @elseif($item->jenis === 'surat_undangan')
                                            <a href="{{ route('transaction.personal.surat_undangan.show', $item->id) }}" 
                                            class="btn btn-outline-info me-2" title="Lihat Detail">
                                            <i class="bi bi-eye fs-5"></i>
                                            </a>
                                            <a href="{{ route('transaction.personal.surat_undangan.edit', $item->id) }}" 
                                            class="btn btn-outline-warning me-2" title="Edit">
                                            <i class="bi bi-pencil fs-5"></i>
                                            </a>
                                            @if($item->generated_file)
                                                <a href="{{ route('transaction.personal.surat_undangan.preview', $item->id) }}" 
                                                class="btn btn-outline-primary me-2" title="Preview PDF" target="_blank">
                                                    <i class="bi bi-file-pdf fs-5"></i>
                                                </a>
                                                <a href="{{ route('transaction.personal.surat_undangan.download', $item->id) }}" 
                                                class="btn btn-outline-success me-2" title="Download PDF" target="_blank">
                                                    <i class="bi bi-download fs-5"></i>
                                                </a>
                                            @endif
                                            <form action="{{ route('transaction.personal.surat_undangan.destroy', $item->id) }}" 
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-outline-danger" 
                                                        onclick="return confirm('Hapus surat ini?')"
                                                        title="Hapus">
                                                    <i class="bi bi-trash fs-5"></i>
                                                </button>
                                            </form>
                                            @elseif($item->jenis === 'surat_panggilan')
                                            <a href="{{ route('transaction.personal.surat_panggilan.show', $item->id) }}" 
                                            class="btn btn-outline-info me-2" title="Lihat Detail">
                                            <i class="bi bi-eye fs-5"></i>
                                            </a>
                                            <a href="{{ route('transaction.personal.surat_panggilan.edit', $item->id) }}" 
                                            class="btn btn-outline-warning me-2" title="Edit">
                                            <i class="bi bi-pencil fs-5"></i>
                                            </a>
                                            @if($item->generated_file)
                                                <a href="{{ route('transaction.personal.surat_panggilan.preview', $item->id) }}" 
                                                class="btn btn-outline-primary me-2" title="Preview PDF" target="_blank">
                                                    <i class="bi bi-file-pdf fs-5"></i>
                                                </a>
                                                <a href="{{ route('transaction.personal.surat_panggilan.download', $item->id) }}" 
                                                class="btn btn-outline-success me-2" title="Download PDF" target="_blank">
                                                    <i class="bi bi-download fs-5"></i>
                                                </a>
                                            @endif
                                            <form action="{{ route('transaction.personal.surat_panggilan.destroy', $item->id) }}" 
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-outline-danger" 
                                                        onclick="return confirm('Hapus surat ini?')"
                                                        title="Hapus">
                                                    <i class="bi bi-trash fs-5"></i>
                                                </button>
                                            </form>
                                            @elseif(in_array($item->jenis, ['memo', 'internal_memo']))
                                                <a href="{{ route('transaction.personal.memo.show', $item->id) }}" 
                                                class="btn btn-outline-info me-2" title="Lihat Detail">
                                                <i class="bi bi-eye fs-5"></i>
                                                </a>
                                                <a href="{{ route('transaction.personal.memo.edit', $item->id) }}" 
                                                class="btn btn-outline-warning me-2" title="Edit">
                                                <i class="bi bi-pencil fs-5"></i>
                                                </a>
                                                @if($item->generated_file)
                                                    <a href="{{ route('transaction.personal.memo.preview', $item->id) }}" 
                                                    class="btn btn-outline-primary me-2" title="Preview PDF" target="_blank">
                                                        <i class="bi bi-file-pdf fs-5"></i>
                                                    </a>
                                                    <a href="{{ route('transaction.personal.memo.download', $item->id) }}" 
                                                    class="btn btn-outline-success me-2" title="Download PDF" target="_blank">
                                                        <i class="bi bi-download fs-5"></i>
                                                    </a>
                                                @endif
                                                <form action="{{ route('transaction.personal.memo.destroy', $item->id) }}" 
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-outline-danger" 
                                                            onclick="return confirm('Hapus surat ini?')"
                                                            title="Hapus">
                                                        <i class="bi bi-trash fs-5"></i>
                                                    </button>
                                                </form>
                                                @elseif($item->jenis === 'pengumuman')
                                            <a href="{{ route('transaction.personal.pengumuman.show', $item->id) }}" 
                                            class="btn btn-outline-info me-2" title="Lihat Detail">
                                            <i class="bi bi-eye fs-5"></i>
                                            </a>
                                            <a href="{{ route('transaction.personal.pengumuman.edit', $item->id) }}" 
                                            class="btn btn-outline-warning me-2" title="Edit">
                                            <i class="bi bi-pencil fs-5"></i>
                                            </a>
                                            @if($item->generated_file)
                                                <a href="{{ route('transaction.personal.pengumuman.preview', $item->id) }}" 
                                                class="btn btn-outline-primary me-2" title="Preview PDF" target="_blank">
                                                    <i class="bi bi-file-pdf fs-5"></i>
                                                </a>
                                                <a href="{{ route('transaction.personal.pengumuman.download', $item->id) }}" 
                                                class="btn btn-outline-success me-2" title="Download PDF" target="_blank">
                                                    <i class="bi bi-download fs-5"></i>
                                                </a>
                                            @endif
                                            <form action="{{ route('transaction.personal.pengumuman.destroy', $item->id) }}" 
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-outline-danger" 
                                                        onclick="return confirm('Hapus surat ini?')"
                                                        title="Hapus">
                                                    <i class="bi bi-trash fs-5"></i>
                                                </button>
                                            </form>
                                            @elseif($item->jenis === 'notulen')
                                            <a href="{{ route('transaction.personal.notulen.show', $item->id) }}" 
                                            class="btn btn-outline-info me-2" title="Lihat Detail">
                                            <i class="bi bi-eye fs-5"></i>
                                            </a>
                                            <a href="{{ route('transaction.personal.notulen.edit', $item->id) }}" 
                                            class="btn btn-outline-warning me-2" title="Edit">
                                            <i class="bi bi-pencil fs-5"></i>
                                            </a>
                                            @if($item->generated_file)
                                                <a href="{{ route('transaction.personal.notulen.preview', $item->id) }}" 
                                                class="btn btn-outline-primary me-2" title="Preview PDF" target="_blank">
                                                    <i class="bi bi-file-pdf fs-5"></i>
                                                </a>
                                                <a href="{{ route('transaction.personal.notulen.download', $item->id) }}" 
                                                class="btn btn-outline-success me-2" title="Download PDF" target="_blank">
                                                    <i class="bi bi-download fs-5"></i>
                                                </a>
                                            @endif
                                            <form action="{{ route('transaction.personal.notulen.destroy', $item->id) }}" 
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-outline-danger" 
                                                        onclick="return confirm('Hapus notulen ini?')"
                                                        title="Hapus">
                                                    <i class="bi bi-trash fs-5"></i>
                                                </button>
                                            </form>
                                       @elseif($item->jenis === 'notulen')
                                            <a href="{{ route('transaction.personal.notulen.show', $item->id) }}" 
                                            class="btn btn-outline-info me-2" title="Lihat Detail">
                                            <i class="bi bi-eye fs-5"></i>
                                            </a>
                                            <a href="{{ route('transaction.personal.notulen.edit', $item->id) }}" 
                                            class="btn btn-outline-warning me-2" title="Edit">
                                            <i class="bi bi-pencil fs-5"></i>
                                            </a>
                                            @if($item->generated_file)
                                                <a href="{{ route('transaction.personal.notulen.preview', $item->id) }}" 
                                                class="btn btn-outline-primary me-2" title="Preview PDF" target="_blank">
                                                    <i class="bi bi-file-pdf fs-5"></i>
                                                </a>
                                                <a href="{{ route('transaction.personal.notulen.download', $item->id) }}" 
                                                class="btn btn-outline-success me-2" title="Download PDF" target="_blank">
                                                    <i class="bi bi-download fs-5"></i>
                                                </a>
                                            @endif
                                            <form action="{{ route('transaction.personal.notulen.destroy', $item->id) }}" 
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-outline-danger" 
                                                        onclick="return confirm('Hapus notulen ini?')"
                                                        title="Hapus">
                                                    <i class="bi bi-trash fs-5"></i>
                                                </button>
                                            </form>
                                            @elseif($item->jenis === 'berita_acara')
                                            <a href="{{ route('transaction.personal.beritaacara.show', $item->id) }}" 
                                            class="btn btn-outline-info me-2" title="Lihat Detail">
                                            <i class="bi bi-eye fs-5"></i>
                                            </a>
                                            <a href="{{ route('transaction.personal.beritaacara.edit', $item->id) }}" 
                                            class="btn btn-outline-warning me-2" title="Edit">
                                            <i class="bi bi-pencil fs-5"></i>
                                            </a>
                                            @if($item->generated_file)
                                                <a href="{{ route('transaction.personal.beritaacara.preview', $item->id) }}" 
                                                class="btn btn-outline-primary me-2" title="Preview PDF" target="_blank">
                                                    <i class="bi bi-file-pdf fs-5"></i>
                                                </a>
                                                <a href="{{ route('transaction.personal.beritaacara.download', $item->id) }}" 
                                                class="btn btn-outline-success me-2" title="Download PDF" target="_blank">
                                                    <i class="bi bi-download fs-5"></i>
                                                </a>
                                            @endif
                                            <form action="{{ route('transaction.personal.beritaacara.destroy', $item->id) }}" 
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-outline-danger" 
                                                        onclick="return confirm('Hapus berita acara ini?')"
                                                        title="Hapus">
                                                    <i class="bi bi-trash fs-5"></i>
                                                </button>
                                            </form>
                                            @elseif($item->jenis === 'disposisi')
                                            <a href="{{ route('transaction.personal.disposisi.show', $item->id) }}" 
                                            class="btn btn-outline-info me-2" title="Lihat Detail">
                                            <i class="bi bi-eye fs-5"></i>
                                            </a>
                                            <a href="{{ route('transaction.personal.disposisi.edit', $item->id) }}" 
                                            class="btn btn-outline-warning me-2" title="Edit">
                                            <i class="bi bi-pencil fs-5"></i>
                                            </a>
                                            @if($item->generated_file)
                                                <a href="{{ route('transaction.personal.disposisi.preview', $item->id) }}" 
                                                class="btn btn-outline-primary me-2" title="Preview PDF" target="_blank">
                                                    <i class="bi bi-file-pdf fs-5"></i>
                                                </a>
                                                <a href="{{ route('transaction.personal.disposisi.download', $item->id) }}" 
                                                class="btn btn-outline-success me-2" title="Download PDF" target="_blank">
                                                    <i class="bi bi-download fs-5"></i>
                                                </a>
                                            @endif
                                            <form action="{{ route('transaction.personal.disposisi.destroy', $item->id) }}" 
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-outline-danger" 
                                                        onclick="return confirm('Hapus disposisi ini?')"
                                                        title="Hapus">
                                                    <i class="bi bi-trash fs-5"></i>
                                                </button>
                                            </form>
                                            @elseif($item->jenis === 'surat_keputusan')
                                            <a href="{{ route('transaction.personal.suratkeputusan.show', $item->id) }}" 
                                            class="btn btn-outline-info me-2" title="Lihat Detail">
                                            <i class="bi bi-eye fs-5"></i>
                                            </a>
                                            <a href="{{ route('transaction.personal.suratkeputusan.edit', $item->id) }}" 
                                            class="btn btn-outline-warning me-2" title="Edit">
                                            <i class="bi bi-pencil fs-5"></i>
                                            </a>
                                            @if($item->generated_file)
                                                <a href="{{ route('transaction.personal.suratkeputusan.preview', $item->id) }}" 
                                                class="btn btn-outline-primary me-2" title="Preview PDF" target="_blank">
                                                    <i class="bi bi-file-pdf fs-5"></i>
                                                </a>
                                                <a href="{{ route('transaction.personal.suratkeputusan.download', $item->id) }}" 
                                                class="btn btn-outline-success me-2" title="Download PDF" target="_blank">
                                                    <i class="bi bi-download fs-5"></i>
                                                </a>
                                            @endif
                                            <form action="{{ route('transaction.personal.suratkeputusan.destroy', $item->id) }}" 
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-outline-danger" 
                                                        onclick="return confirm('Hapus surat keputusan ini?')"
                                                        title="Hapus">
                                                    <i class="bi bi-trash fs-5"></i>
                                                </button>
                                            </form>
                                            @endif
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
                    <p class="text-muted mb-4">Anda belum membuat surat pribadi apapun.</p>
                    <a href="{{ route('transaction.personal.templates') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Buat Surat Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
    @endsection