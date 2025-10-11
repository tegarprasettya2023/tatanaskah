@extends('layout.main')

@push('script')
    <script>
        $('input#accountActivation').on('change', function() {
            $('button.deactivate-account').attr('disabled', !$(this).is(':checked'));
        });

        document.addEventListener('DOMContentLoaded', function(e) {
            (function() {
                // Update/reset user image of account page
                let accountUserImage = document.getElementById('uploadedAvatar');
                const fileInput = document.querySelector('.account-file-input'),
                    resetFileInput = document.querySelector('.account-image-reset');

                if (accountUserImage) {
                    const resetImage = accountUserImage.src;
                    fileInput.onchange = () => {
                        if (fileInput.files[0]) {
                            accountUserImage.src = window.URL.createObjectURL(fileInput.files[0]);
                        }
                    };
                    resetFileInput.onclick = () => {
                        fileInput.value = '';
                        accountUserImage.src = resetImage;
                    };
                }
            })();
        });
    </script>
@endpush

@section('content')
    <x-breadcrumb :values="[__('navbar.profile.profile')]">
    </x-breadcrumb>

    <div class="row">
        <div class="col">

            <div class="card mb-4">
                <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <!-- Bagian kiri:  Foto -->
                        <div class="col-md-4 avatar-profile">
                            <div class="card m-4">
                                <div class="card-body text-center">
                                    <img src="{{ $data->profile_picture }}" alt="user-avatar"
                                        class="d-block rounded-circle mx-auto mb-3" height="100" width="100"
                                        id="uploadedAvatar">
                                </div>
                            </div>
                        </div>

                        <!-- Bagian kanan: Form Profil -->
                        <div class="col-md-8">

                            <input type="hidden" name="id" value="{{ $data->id }}">
                            <div class="card m-4">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <x-input-form name="name" :label="__('model.user.name')" :value="$data->name" />
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <x-input-form name="email" :label="__('model.user.email')" :value="$data->email" />
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <x-input-form name="phone" :label="__('model.user.phone')" :value="$data->phone ?? ''" />
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <button type="submit"
                                            class="btn btn-primary me-2">{{ __('menu.general.update') }}</button>
                                        <button type="button" onclick="window.history.back();"
                                            class="btn btn-outline-secondary">{{ __('menu.general.cancel') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Toggle untuk Ganti Password -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class=" d-flex justify-content-center p-3">
                            <button class="btn btn-warning" id="togglePasswordForm">{{ __('Ubah Password') }}</button>
                        </div>
                        <form action="{{ route('profile.password.update') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <!-- Form Ganti Password yang disembunyikan awalnya -->
                            <div id="passwordForm" style="display: none;">

                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h5 class="mb-0">{{ __('Ubah Password') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <x-input-form type="password" name="current_password"
                                                    label="Password Lama" />
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <x-input-form type="password" name="new_password" label="Password Baru" />
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <x-input-form type="password" name="new_password_confirmation"
                                                    label="Konfirmasi Password Baru" />
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-warning">{{ __('menu.general.update') }}
                                            Password</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

    <script>
        // Menambahkan toggle pada form ganti password
        document.getElementById('togglePasswordForm').addEventListener('click', function() {
            const passwordForm = document.getElementById('passwordForm');
            if (passwordForm.style.display === 'none') {
                passwordForm.style.display = 'block';
            } else {
                passwordForm.style.display = 'none';
            }
        });
    </script>
@endsection
