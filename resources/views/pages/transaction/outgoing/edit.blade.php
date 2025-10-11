@extends('layout.main')

@section('content')
    <x-breadcrumb :values="[__('menu.transaction.menu'), __('menu.transaction.outgoing_letter'), __('menu.general.edit')]">
    </x-breadcrumb>

    <div class="card mb-4">
        <form action="{{ route('transaction.outgoing.update', $data) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body row">
                @php $user = auth()->user(); @endphp

                @if ($user->role === 'staff')
                    <div class="col-12 d-flex justify-content-end">
                        <div class="mb-3" style="min-width: 250px;">
                            <label for="validation" class="form-label text-end d-block">
                                @if ($data->validation === 'Disetujui')
                                    <span class="fs-6 badge bg-success">Persetujuan Surat</span>
                                @elseif ($data->validation === 'Belum Disetujui')
                                    <span class="fs-6 badge bg-danger">Persetujuan Surat</span>
                                @else
                                    <span class="fs-6 badge bg-secondary">Persetujuan Surat</span>
                                @endif
                            </label>
                            <select class="form-select" name="validation" id="validation">
                                <option value="Belum Disetujui" @selected($data->validation === 'Belum Disetujui')>Belum Disetujui</option>
                                <option value="Disetujui" @selected($data->validation === 'Disetujui')>Disetujui</option>
                            </select>
                        </div>
                    </div>
                @endif

                <input type="hidden" name="id" value="{{ $data->id }}">
                <input type="hidden" name="type" value="{{ $data->type }}">

                <!-- Basic Information -->
                <div class="col-sm-12 col-12 col-md-6 col-lg-4">
                    <x-input-form name="reference_number" :label="__('model.letter.reference_number')" :value="$data->reference_number" />
                </div>
                <div class="col-sm-12 col-12 col-md-6 col-lg-4">
                    <x-input-form name="to" :label="__('model.letter.to')" :value="$data->to" />
                </div>
                <div class="col-sm-12 col-12 col-md-6 col-lg-4">
                    <x-input-form name="agenda_number" :label="__('model.letter.agenda_number')" :value="$data->agenda_number" />
                </div>
                <div class="col-sm-12 col-12 col-md-6 col-lg-4">
                    <x-input-form name="letter_date" :label="__('model.letter.letter_date')" type="date" :value="date('Y-m-d', strtotime($data->letter_date))" />
                </div>
                <div class="col-sm-12 col-12 col-md-6 col-lg-4">
                    <div class="mb-3">
                        <label for="classification_code" class="form-label">{{ __('model.letter.classification_code') }}</label>
                        <select class="form-select" id="classification_code" name="classification_code">
                            @foreach ($classifications as $classification)
                                <option value="{{ $classification->code }}" @selected(old('classification_code', $data->classification_code) == $classification->code)>
                                    {{ $classification->type }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                

                <!-- Subject/Description -->
                <div class="col-sm-12 col-12 col-md-12 col-lg-12">
                    <x-input-textarea-form name="description" :label="__('model.letter.description')" rows="3" :value="$data->description" />
                </div>

                <!-- Letter Content -->
                <div class="col-sm-12 col-12 col-md-12 col-lg-12">
                    <div class="mb-3">
                        <label for="note" class="form-label">Isi Surat / Keterangan</label>
                        <textarea
                            class="form-control @error('note') is-invalid @enderror"
                            id="note"
                            name="note"
                            rows="15"
                            placeholder="Masukkan isi lengkap surat..."
                        >{{ old('note', $data->note) }}</textarea>
                        <span class="error invalid-feedback">{{ $errors->first('note') }}</span>
                    </div>
                </div>
            </div>
            <div class="card-footer pt-0">
                <button class="btn btn-primary" type="submit">{{ __('menu.general.update') }}</button>
            </div>
        </form>
    </div>

    <form action="{{ route('attachment.destroy') }}" method="post" id="form-to-remove-attachment">
        @csrf
        @method('DELETE')
        <input type="hidden" name="id" id="attachment-id-to-remove">
    </form>
@endsection

@push('script')
    <script>
        // Auto-resize textarea based on content
        document.getElementById('note').addEventListener('input', function () {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });

        $(document).on('click', '.btn-remove-attachment', function () {
            $('input#attachment-id-to-remove').val($(this).data('id'));
            Swal.fire({
                title: '{{ __('menu.general.delete_confirm') }}',
                text: "{{ __('menu.general.delete_warning') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '31318B',
                confirmButtonText: '{{ __('menu.general.delete') }}',
                cancelButtonText: '{{ __('menu.general.cancel') }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('form#form-to-remove-attachment').submit();
                }
            })
        });
    </script>
@endpush
