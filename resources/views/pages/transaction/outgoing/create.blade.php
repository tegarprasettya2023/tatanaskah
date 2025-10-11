@extends('layout.main')

@section('content')
    <x-breadcrumb :values="[__('menu.transaction.menu'), __('menu.transaction.outgoing_letter'), __('menu.general.create')]">
    </x-breadcrumb>

    <div class="card mb-4">
        <form action="{{ route('transaction.outgoing.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body row">
                <input type="hidden" name="type" value="outgoing">

                <!-- Basic Information -->
                <div class="col-sm-12 col-12 col-md-6 col-lg-4">
                    <x-input-form name="reference_number" :label="__('model.letter.reference_number')" :value="old('reference_number', $referenceNumber)" />
                </div>
                <div class="col-sm-12 col-12 col-md-6 col-lg-4">
                    <x-input-form name="to" :label="__('model.letter.to')" />
                </div>
                <div class="col-sm-12 col-12 col-md-6 col-lg-4">
                    <x-input-form name="agenda_number" :label="__('model.letter.agenda_number')" />
                </div>
                <div class="col-sm-12 col-12 col-md-6 col-lg-4">
                    <x-input-form name="letter_date" :label="__('model.letter.letter_date')" type="date" />
                </div>
                <div class="col-sm-12 col-12 col-md-6 col-lg-4">
                    <div class="mb-3">
                        <label for="classification_code"
                            class="form-label">{{ __('model.letter.classification_code') }}</label>
                        <select class="form-select" id="classification_code" name="classification_code">
                            @foreach ($classifications as $classification)
                                <option value="{{ $classification->code }}" @selected(old('classification_code') == $classification->code)>
                                    {{ $classification->type }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- <div class="col-sm-12 col-12 col-md-6 col-lg-4">
                    <div class="mb-3">
                        <label for="attachments" class="form-label">{{ __('model.letter.attachment') }}</label>
                        <input type="file" class="form-control @error('attachments') is-invalid @enderror"
                            id="attachments" name="attachments[]" multiple />
                        <span class="error invalid-feedback">{{ $errors->first('attachments') }}</span>
                    </div>
                </div> -->

                <!-- Subject/Description -->
                <div class="col-sm-12 col-12 col-md-12 col-lg-12">
                    <x-input-textarea-form name="description" :label="__('model.letter.description')" rows="3" />
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
                        >{{ old('note') }}</textarea>
                        <span class="error invalid-feedback">{{ $errors->first('note') }}</span>
                    </div>
                </div>
            </div>
            <div class="card-footer pt-0">
                <button class="btn btn-primary" type="submit">{{ __('menu.general.save') }}</button>
            </div>
        </form>
    </div>

    <script>
        // Auto-resize textarea based on content
        document.getElementById('note').addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    </script>
@endsection