@extends('layout.dashboard-layout')

@push('style')
    <link rel="stylesheet" href="{{ asset('sneat/vendor/libs/apex-charts/apex-charts.css') }}" />
@endpush

@push('script')
    <script src="{{ asset('sneat/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script>
        // Chart untuk jenis surat
        const letterTypeOptions = {
            chart: {
                type: 'donut',
                height: 280
            },
            series: [
                {{ $perjanjianCount }}, 
                {{ $dinasCount }}, 
                {{ $keteranganCount }}, 
                {{ $perintahCount }},
                {{ $kuasaCount }},
                {{ $undanganCount }},
                {{ $panggilanCount }},
                {{ $memoCount }},
                {{ $pengumumanCount }},
                {{ $notulenCount }},
                {{ $beritaAcaraCount }},
                {{ $disposisiCount }},
                {{ $keputusanCount }},
                {{ $spoCount }}
            ],
            labels: [
                'Perjanjian', 
                'Surat Dinas', 
                'Keterangan', 
                'Perintah',
                'Kuasa',
                'Undangan',
                'Panggilan',
                'Memo',
                'Pengumuman',
                'Notulen',
                'Berita Acara',
                'Disposisi',
                'Keputusan',
                'SPO'
            ],
            colors: ['#696cff', '#03c3ec', '#71dd37', '#ffab00', '#ff3e1d', '#8e44ad', '#2ecc71', '#e74c3c', '#3498db', '#f39c12', '#9b59b6', '#1abc9c', '#e67e22', '#34495e'],
            legend: {
                position: 'bottom'
            },
            plotOptions: {
                pie: {
                    donut: {
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total Surat',
                                formatter: function () {
                                    return {{ $totalPersonalLetters }}
                                }
                            }
                        }
                    }
                }
            }
        }

        const letterTypeChart = new ApexCharts(document.querySelector("#letter-type-chart"), letterTypeOptions);
        letterTypeChart.render();

        // Chart untuk trend bulanan
        const monthlyTrendOptions = {
            chart: {
                type: 'line',
                height: 300,
                toolbar: {
                    show: false
                }
            },
            series: [{
                name: 'Surat Dibuat',
                data: @json($monthlyData)
            }],
            stroke: {
                curve: 'smooth',
                width: 3
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Oct', 'Nov', 'Des']
            },
            colors: ['#696cff'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.3,
                }
            }
        }

        const monthlyTrendChart = new ApexCharts(document.querySelector("#monthly-trend-chart"), monthlyTrendOptions);
        monthlyTrendChart.render();
    </script>
@endpush

@section('content')
    <!-- Welcome Card -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-lg-8 d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h4 class="card-title text-primary mb-2">{{ $greeting }}</h4>
                        <p class="mb-2"><i class="bx bx-calendar me-2"></i>{{ $currentDate }}</p>
                    </div>
                </div>
                <div class="col-lg-4 text-center mt-3 mt-lg-0">
                    <img src="{{ asset('sneat/img/man-with-laptop-light.png') }}" height="120" alt="Welcome"
                        data-app-dark-img="illustrations/man-with-laptop-dark.png"
                        data-app-light-img="illustrations/man-with-laptop-light.png">
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <!-- Total Surat -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="d-block mb-1 text-muted">Total Surat</span>
                            <h3 class="card-title mb-0">{{ $totalPersonalLetters }}</h3>
                        </div>
                        <div class="avatar flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="bx bx-envelope bx-md"></i>
                            </span>
                        </div>
                    </div>
                    <small class="text-muted mt-2">Semua jenis surat</small>
                </div>
            </div>
        </div>

        <!-- Surat Bulan Ini -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="d-block mb-1 text-muted">Bulan Ini</span>
                            <h3 class="card-title mb-0">{{ $monthlyLetters }}</h3>
                        </div>
                        <div class="avatar flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-success">
                                <i class="bx bx-calendar-check bx-md"></i>
                            </span>
                        </div>
                    </div>
                    @if($percentageMonthly > 0)
                        <small class="text-success fw-semibold">
                            <i class="bx bx-up-arrow-alt"></i> +{{ number_format($percentageMonthly, 1) }}%
                        </small>
                    @elseif($percentageMonthly < 0)
                        <small class="text-danger fw-semibold">
                            <i class="bx bx-down-arrow-alt"></i> {{ number_format($percentageMonthly, 1) }}%
                        </small>
                    @else
                        <small class="text-muted">Surat yang dibuat pada bulan ini</small>
                    @endif
                </div>
            </div>
        </div>

        <!-- Surat Hari Ini -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="d-block mb-1 text-muted">Hari Ini</span>
                            <h3 class="card-title mb-0">{{ $todayLetters }}</h3>
                        </div>
                        <div class="avatar flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-info">
                                <i class="bx bx-time-five bx-md"></i>
                            </span>
                        </div>
                    </div>
                    <small class="text-muted">Surat dibuat hari ini</small>
                </div>
            </div>
        </div>

        <!-- Template Tersedia -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="d-block mb-1 text-muted">Template</span>
                            <h3 class="card-title mb-0">14</h3>
                        </div>
                        <div class="avatar flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-warning">
                                <i class="bx bx-file bx-md"></i>
                            </span>
                        </div>
                    </div>
                    <small class="text-muted">Template tersedia</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <!-- Distribusi Jenis Surat -->
        <div class="col-xl-6 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Grafik Distribusi Jenis Surat</h5>
                    <span class="badge bg-label-primary">Total: {{ $totalPersonalLetters }}</span>
                </div>
                <div class="card-body">
                    <div id="letter-type-chart"></div>
                </div>
            </div>
        </div>

        <!-- Trend Bulanan -->
        <div class="col-xl-6 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Grafik Pembuatan Surat</h5>
                    <span class="badge bg-label-success">Tahun {{ date('Y') }}</span>
                </div>
                <div class="card-body">
                    <div id="monthly-trend-chart"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail per Jenis Surat -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Rincian Per Jenis Surat</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Jenis Surat</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $letterTypes = [
                                        ['name' => 'Perjanjian Kerjasama', 'count' => $perjanjianCount, 'route' => 'transaction.personal.perjanjian.index'],
                                        ['name' => 'Surat Dinas', 'count' => $dinasCount, 'route' => 'transaction.personal.surat_dinas.index'],
                                        ['name' => 'Surat Keterangan', 'count' => $keteranganCount, 'route' => 'transaction.personal.surat_keterangan.index'],
                                        ['name' => 'Surat Perintah', 'count' => $perintahCount, 'route' => 'transaction.personal.surat_perintah.index'],
                                        ['name' => 'Surat Kuasa', 'count' => $kuasaCount, 'route' => 'transaction.personal.suratkuasa.index'],
                                        ['name' => 'Surat Undangan', 'count' => $undanganCount, 'route' => 'transaction.personal.surat_undangan.index'],
                                        ['name' => 'Surat Panggilan', 'count' => $panggilanCount, 'route' => 'transaction.personal.surat_panggilan.index'],
                                        ['name' => 'Internal Memo', 'count' => $memoCount, 'route' => 'transaction.personal.memo.index'],
                                        ['name' => 'Pengumuman', 'count' => $pengumumanCount, 'route' => 'transaction.personal.pengumuman.index'],
                                        ['name' => 'Notulen', 'count' => $notulenCount, 'route' => 'transaction.personal.notulen.index'],
                                        ['name' => 'Berita Acara', 'count' => $beritaAcaraCount, 'route' => 'transaction.personal.beritaacara.index'],
                                        ['name' => 'Formulir Disposisi', 'count' => $disposisiCount, 'route' => 'transaction.personal.suratdisposisi.index'],
                                        ['name' => 'Surat Keputusan', 'count' => $keputusanCount, 'route' => 'transaction.personal.surat_keputusan.index'],
                                        ['name' => 'SPO', 'count' => $spoCount, 'route' => 'transaction.personal.spo.index'],
                                    ];
                                @endphp
                                
                                @foreach($letterTypes as $type)
                                    <tr>
                                        <td>
                                            <i class="bx bx-file me-2"></i>{{ $type['name'] }}
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-label-primary">{{ $type['count'] }}</span>
                                        </td>

                                        <td class="text-center">
                                            <a href="{{ route($type['route']) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bx bx-show"></i> Lihat
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <!-- <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Aksi Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('transaction.personal.templates') }}" class="btn btn-primary w-100">
                                <i class="bx bx-plus-circle me-2"></i>Buat Surat Baru
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('transaction.personal.index') }}" class="btn btn-outline-primary w-100">
                                <i class="bx bx-list-ul me-2"></i>Lihat Semua Surat
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('transaction.personal.templates') }}" class="btn btn-outline-secondary w-100">
                                <i class="bx bx-file me-2"></i>Template Surat
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
@endsection