@extends('layout.main')

@section('content')
    <x-breadcrumb :values="[__('menu.agenda.menu'), __('menu.agenda.incoming_letter')]">
    </x-breadcrumb>

    <div class="card mb-5">
        <div class="card-header">
            <form action="{{ url()->current() }}">
                <input type="hidden" name="search" value="{{ $search ?? '' }}">
                <div class="row">
                    <div class="col">
                        <x-input-form name="since" :label="__('menu.agenda.start_date')" type="date" :value="$since ? date('Y-m-d', strtotime($since)) : ''" />
                    </div>
                    <div class="col">
                        <x-input-form name="until" :label="__('menu.agenda.end_date')" type="date" :value="$until ? date('Y-m-d', strtotime($until)) : ''" />
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="filter" class="form-label">{{ __('menu.agenda.filter_by') }}</label>
                            <select class="form-select" id="filter" name="filter">
                                <option value="letter_date" @selected(old('filter', $filter) == 'letter_date')>
                                    {{ __('model.letter.letter_date') }}</option>
                                <option value="received_date" @selected(old('filter', $filter) == 'received_date')>
                                    {{ __('model.letter.received_date') }}</option>
                                <option value="created_at" @selected(old('filter', $filter) == 'created_at')>{{ __('model.general.created_at') }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label">{{ __('menu.general.action') }}</label>
                            <div class="row g-2">
                                <div class="col-auto">
                                    <button class="btn btn-primary" type="submit">
                                        {{ __('menu.general.filter') }}
                                    </button>
                                </div>
                                <div class="col-auto">
                                    <a href="{{ route('agenda.incoming.print') . '?' . $query }}" target="_blank"
                                        class="btn btn-primary">
                                        {{ __('menu.general.print') }}
                                    </a>
                                </div>
                                <div class="col-auto">
                                    <a href="{{ route('agenda.incoming') }}" class="btn btn-danger">
                                        {{ __('Reset') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            @if ($data)
                <div class="row mb-4">
                    <div class="col-md-4 col-sm-12">
                        <div class="card border-start border-info border-4 shadow-sm">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1 text-muted">Total Surat</h6>
                                    <h4 class="mb-0 fw-bold">{{ $data->count() }}</h4>
                                </div>
                                <i class="bx bx-file text-info fs-2"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-12">
                        <div class="card border-start border-success border-4 shadow-sm">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1 text-muted">Disetujui</h6>
                                    <h4 class="mb-0 fw-bold">
                                        {{ $totalDisetujui ?? $data->where('validation', 'Disetujui')->count() }}</h4>
                                </div>
                                <i class="bx bx-check-circle text-success fs-2"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-12">
                        <div class="card border-start border-danger border-4 shadow-sm">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1 text-muted">Belum Disetujui</h6>
                                    <h4 class="mb-0 fw-bold">{{ $data->where('validation', 'Belum Disetujui')->count() }}
                                    </h4>
                                </div>
                                <i class="bx bx-x-circle text-danger fs-2"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>{{ __('model.letter.agenda_number') }}</th>
                        <th>{{ __('model.letter.reference_number') }}</th>
                        <th>{{ __('model.letter.from') }}</th>
                        <th>{{ __('model.letter.letter_date') }}</th>
                    </tr>
                </thead>
                @if ($data)
                    <tbody>
                        @foreach ($data as $agenda)
                            @if ($agenda->validation === 'Disetujui')
                                <tr>
                                    <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                        <strong>{{ $agenda->agenda_number }}</strong>
                                    </td>
                                    <td>
                                        <a
                                            href="{{ route('transaction.incoming.show', $agenda) }}">{{ $agenda->reference_number }}</a>
                                    </td>
                                    <td>{{ $agenda->from }}</td>
                                    <td>{{ $agenda->formatted_letter_date }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                @else
                    <tbody>
                        <tr>
                            <td colspan="4" class="text-center">
                                {{ __('menu.general.empty') }}
                            </td>
                        </tr>
                    </tbody>
                @endif
                <tfoot class="table-border-bottom-0">
                    <tr>
                        <th>{{ __('model.letter.agenda_number') }}</th>
                        <th>{{ __('model.letter.reference_number') }}</th>
                        <th>{{ __('model.letter.from') }}</th>
                        <th>{{ __('model.letter.letter_date') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {!! $data->appends(['search' => $search, 'since' => $since, 'until' => $until, 'filter' => $filter])->links() !!}
@endsection
