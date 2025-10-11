<div class="card mb-4">
    <div class="card-header pb-0">
        <div class="d-flex justify-content-between flex-column flex-sm-row">
            <div class="card-title">
                <!-- Judul surat -->
                <h5 class="fw-bold mb-1">{{ $letter->description }}</h5>

                <small class="text-black">
                    {{ $letter->type == 'incoming' ? $letter->from : $letter->to }} |
                    <span class="text-secondary">{{ __('model.letter.agenda_number') }}:</span>
                    {{ $letter->agenda_number }}
                    |
                    <span class="text-secondary">{{ __('model.letter.reference_number') }}:</span>
                    {{ $letter->reference_number }}
                    |
                    <span class="badge bg-{{ match($letter->validation) {
                        'Belum Disetujui' => 'danger',
                        'Disetujui' => 'success',
                        default => 'secondary',
                    } }}">
                        <!-- {{ $letter->validation }} -->
                    </span>
                </small>
            </div>

            <div class="card-title d-flex flex-row">
                <div class="d-inline-block mx-2 text-end text-black">
                    <small class="d-block text-secondary">{{ __('model.letter.letter_date') }}</small>
                    {{ $letter->formatted_letter_date }}
                </div>

                @if (Auth::user()->role === 'staff' && $letter->type == 'incoming' && $letter->validation === 'Disetujui')
                    <div class="mx-3">
                        <a href="{{ route('transaction.disposition.index', $letter) }}" class="btn btn-primary btn">
                            {{ __('model.letter.dispose') }} <span>({{ $letter->dispositions->count() }})</span>
                        </a>
                    </div>
                @endif

                @php
                    $isStaffPengawas = auth()->user()->role === \App\Enums\Role::STAFF_PENGAWAS->status();
                @endphp

                <div class="dropdown d-inline-block">
                    <button class="btn p-0" type="button" id="dropdown-{{ $letter->type }}-{{ $letter->id }}"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end"
                        aria-labelledby="dropdown-{{ $letter->type }}-{{ $letter->id }}">
                        @if (!\Illuminate\Support\Facades\Route::is('*.show'))
                            <a class="dropdown-item"
                                href="{{ route('transaction.' . $letter->type . '.show', $letter) }}">{{ __('menu.general.view') }}</a>
                        @endif

                        @unless ($isStaffPengawas)
                            <a class="dropdown-item"
                                href="{{ route('transaction.' . $letter->type . '.edit', $letter) }}">{{ __('menu.general.edit') }}</a>
                            <form action="{{ route('transaction.' . $letter->type . '.destroy', $letter) }}" class="d-inline" method="post">
                                @csrf
                                @method('DELETE')
                                <span class="dropdown-item cursor-pointer btn-delete">{{ __('menu.general.delete') }}</span>
                            </form>
                        @endunless
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body">
        <hr>

        <!-- Kode Klasifikasi -->
        <p class="mb-2"><strong>{{ __('model.letter.classification_code') }}:</strong> {{ $letter->classification?->type }}</p>

        <!-- Lampiran -->
        <div class="d-flex justify-content-between flex-column flex-sm-row">
            <small class="text-secondary"></small>
            @if (count($letter->attachments))
                <div>
                    @foreach ($letter->attachments as $attachment)
                        <a href="{{ $attachment->path_url }}" target="_blank">
                            @if ($attachment->extension == 'pdf')
                                <i class="bx bxs-file-pdf display-6 cursor-pointer text-primary"></i>
                            @elseif(in_array($attachment->extension, ['jpg', 'jpeg']))
                                <i class="bx bxs-file-jpg display-6 cursor-pointer text-primary"></i>
                            @elseif($attachment->extension == 'png')
                                <i class="bx bxs-file-png display-6 cursor-pointer text-primary"></i>
                            @endif
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
        {{ $slot }}
    </div>
</div>
