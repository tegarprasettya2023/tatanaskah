@extends('layout.dashboard-layout')

@push('style')
    <link rel="stylesheet" href="{{ asset('sneat/vendor/libs/apex-charts/apex-charts.css') }}" />
@endpush

@push('script')
    <script src="{{ asset('sneat/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script>
        const options = {
            chart: {
                type: 'bar'
            },
            series: [{
                name: '{{ __('dashboard.letter_transaction') }}',
                data: [{{ $todayIncomingLetter }}, {{ $todayOutgoingLetter }}, {{ $todayDispositionLetter }}]
            }],
            stroke: {
                curve: 'smooth',
            },
            xaxis: {
                categories: [
                    '{{ __('dashboard.incoming_letter') }}',
                    '{{ __('dashboard.outgoing_letter') }}',
                    '{{ __('dashboard.disposition_letter') }}',
                ],
            }
        }

        const chart = new ApexCharts(document.querySelector("#today-graphic"), options);

        chart.render();
    </script>
@endpush

@section('content')
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <!-- {{-- Kiri: Greeting & Info --}} -->
                <div class="col-lg-6 d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h4 class="card-title text-primary">{{ $greeting }}</h4>
                        <p class="mb-2">{{ $currentDate }}</p>
                        <p class="text-muted small mb-0">*) {{ __('dashboard.today_report') }}</p>
                    </div>
                    <div class="text-end ms-3">
                        <img src="{{ asset('sneat/img/man-with-laptop-light.png') }}" height="100" alt="Greeting"
                            data-app-dark-img="illustrations/man-with-laptop-dark.png"
                            data-app-light-img="illustrations/man-with-laptop-light.png">
                    </div>
                </div>

                <!-- {{-- Kanan: Grafik Hari Ini --}} -->
                <div class="col-lg-6 mt-4 mt-lg-0">
                    <h5 class="card-title mb-1">{{ __('dashboard.today_graphic') }}</h5>
                    <span class="badge bg-label-warning mb-3">{{ __('dashboard.today') }}</span>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            @if ($percentageLetterTransaction > 0)
                                <small class="text-success fw-semibold"><i class="bx bx-chevron-up"></i>
                                    {{ $percentageLetterTransaction }}%</small>
                            @elseif($percentageLetterTransaction < 0)
                                <small class="text-danger fw-semibold"><i class="bx bx-chevron-down"></i>
                                    {{ $percentageLetterTransaction }}%</small>
                            @endif
                            <h3 class="mb-0">{{ $todayLetterTransaction }}</h3>
                        </div>
                    </div>
                    <div id="profileReportChart" style="width: 100%;">
                        <div id="today-graphic"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- {{-- Grid Cards --}} -->
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <x-dashboard-card-simple :label="__('dashboard.incoming_letter')" :value="$todayIncomingLetter" :daily="true" color="success"
                icon="bx-envelope" :percentage="$percentageIncomingLetter" />
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <x-dashboard-card-simple :label="__('dashboard.outgoing_letter')" :value="$todayOutgoingLetter" :daily="true" color="danger" icon="bx-envelope"
                :percentage="$percentageOutgoingLetter" />
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <x-dashboard-card-simple :label="__('dashboard.disposition_letter')" :value="$todayDispositionLetter" :daily="true" color="primary"
                icon="bx-envelope" :percentage="$percentageDispositionLetter" />
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <x-dashboard-card-simple :label="__('Disetujui')" :value="$todayApprovedLetters" :daily="true" color="success"
                icon="bx-check-circle" :percentage="0" />
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <x-dashboard-card-simple :label="__('Belum Disetujui')" :value="$todayPendingLetters" :daily="true" color="warning"
                icon="bx-hourglass" :percentage="0" />
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <x-dashboard-card-simple :label="__('dashboard.active_user')" :value="$activeUser" :daily="false" color="info"
                icon="bx-user-check" :percentage="0" />
        </div>
    </div>
@endsection
