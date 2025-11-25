@extends('layout.dashboard-layout')

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">
                    <i class="bx {{ $icon }} me-2"></i>{{ $title }}
                </h4>
                <!-- <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('transaction.personal.index') }}">Surat Personal</a>
                        </li>
                        <li class="breadcrumb-item active">{{ $title }}</li>
                    </ol>
                </nav> -->
            </div>
            <div>
<a href="{{ url()->previous() }}" class="btn btn-outline-secondary me-2">
    <i class="bx bx-arrow-back me-1"></i>Kembali
</a>

                <a href="{{ $createRoute }}" class="btn btn-primary">
                    <i class="bx bx-plus me-1"></i>Buat {{ $title }}
                </a>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="d-block mb-1 text-muted">Total</span>
                                <h3 class="card-title mb-0">{{ $totalCount }}</h3>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="bx bx-file bx-md"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="d-block mb-1 text-muted">Bulan Ini</span>
                                <h3 class="card-title mb-0">{{ $monthlyCount }}</h3>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-success">
                                    <i class="bx bx-calendar bx-md"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="d-block mb-1 text-muted">Minggu Ini</span>
                                <h3 class="card-title mb-0">{{ $weeklyCount }}</h3>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-info">
                                    <i class="bx bx-time bx-md"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="d-block mb-1 text-muted">Hari Ini</span>
                                <h3 class="card-title mb-0">{{ $todayCount }}</h3>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-warning">
                                    <i class="bx bx-trending-up bx-md"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Search Card -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="" method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Pencarian</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bx bx-search"></i></span>
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Cari nomor surat, perihal..." 
                                   value="{{ request('search') }}">
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Dari</label>
                        <input type="date" name="date_from" class="form-control" 
                               value="{{ request('date_from') }}">
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Sampai</label>
                        <input type="date" name="date_to" class="form-control" 
                               value="{{ request('date_to') }}">
                    </div>
                    
                    <div class="col-md-2">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-fill">
                                <i class="bx bx-filter-alt me-1"></i>Filter
                            </button>
                            <a href="{{ request()->url() }}" class="btn btn-outline-secondary">
                                <i class="bx bx-reset"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Data Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar {{ $title }}</h5>
                <span class="badge bg-primary">{{ $data->total() }} Surat</span>
            </div>
            <div class="card-body">
                @if($data->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="15%">Nomor Surat</th>
                                    <th width="30%">Perihal</th>
                                    <th width="15%">Tanggal</th>
                                    <th width="20%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $index => $item)
                                    <tr>
                                        <td>{{ $data->firstItem() + $index }}</td>
                                        <td>
                                            <span class="badge bg-label-primary">
                                                {{ $item->nomor ?? '-' }}
                                            </span>
                                        </td>
<td>
    <div class="text-truncate" style="max-width: 300px;"
         title="{{ $item->perihal ?? $item->judul ?? $item->tentang ?? $item->hal ?? $item->isi_notulen ?? $item->judul_spo ?? '-' }}">
        {{ $item->perihal ?? $item->judul ?? $item->tentang ?? $item->hal ?? $item->isi_notulen ?? $item->judul_spo ?? '-' }}
    </div>
</td>

                                        <td>
                                            <i class="bx bx-calendar me-1"></i>
                                            {{ \Carbon\Carbon::parse($item->letter_date ?? $item->tanggal_surat ?? $item->created_at)->format('d M Y') }}
                                        </td>

                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route($previewRoute, $item->id) }}" 
                                                   class="btn btn-sm btn-outline-info" 
                                                   title="Preview">
                                                    <i class="bx bx-show"></i>
                                                </a>
                                                <a href="{{ route($downloadRoute, $item->id) }}" 
                                                   class="btn btn-sm btn-outline-success" 
                                                   title="Download PDF">
                                                    <i class="bx bx-download"></i>
                                                </a>
                                                <a href="{{ route($editRoute, $item->id) }}" 
                                                   class="btn btn-sm btn-outline-warning" 
                                                   title="Edit">
                                                    <i class="bx bx-edit"></i>
                                                </a>
                                                <form action="{{ route($deleteRoute, $item->id) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" 
                                                            class="btn btn-sm btn-outline-danger btn-delete" 
                                                            title="Hapus">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            Menampilkan {{ $data->firstItem() }} sampai {{ $data->lastItem() }} 
                            dari {{ $data->total() }} data
                        </div>
                        <div>
                            {{ $data->links() }}
                        </div>
                    </div>
                @else
                    <div class="text-center py-1">
                        <img src="{{ asset('sneat/img/error.png') }}" 
                             alt="No Data" 
                             height="200" 
                             class="mb-3">
                        <h5 class="mb-2">Tidak Ada Data</h5>
                        <p class="text-muted mb-4">
                            @if(request()->has('search') || request()->has('date_from'))
                                Tidak ada data yang sesuai dengan filter Anda.
                            @else
                                Belum ada {{ $title }} yang dibuat.
                            @endif
                        </p>
                        <a href="{{ $createRoute }}" class="btn btn-primary">
                            <i class="bx bx-plus me-1"></i>Buat {{ $title }} Baru
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection