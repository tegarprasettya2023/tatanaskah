@extends('layout.main')

@push('style')
    <style>
        /* Profile Page Styling */
        .profile-card {
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .avatar-profile img {
            border: 4px solid rgba(105, 108, 255, 0.1);
            box-shadow: 0 4px 12px rgba(105, 108, 255, 0.2);
            transition: transform 0.3s ease;
        }

        .avatar-profile img:hover {
            transform: scale(1.05);
        }

        /* Dark themes text contrast */
        html.dark-style .profile-card,
        html.dark-style .card,
        html.blue-style .profile-card,
        html.blue-style .card,
        html.green-style .profile-card,
        html.green-style .card,
        html.purple-style .profile-card,
        html.purple-style .card,
        html.red-style .profile-card,
        html.red-style .card {
            color: #ffffff !important;
        }

        html.dark-style .card-body label,
        html.dark-style .card-header h5,
        html.blue-style .card-body label,
        html.blue-style .card-header h5,
        html.green-style .card-body label,
        html.green-style .card-header h5,
        html.purple-style .card-body label,
        html.purple-style .card-header h5,
        html.red-style .card-body label,
        html.red-style .card-header h5 {
            color: #ffffff !important;
        }

        /* Footer sticky at bottom */
        .content-wrapper {
            min-height: calc(100vh - 70px);
            display: flex;
            flex-direction: column;
        }

        .container-xxl.flex-grow-1 {
            flex: 1;
        }

        .content-footer {
            margin-top: auto;
        }

        /* Profile avatar center alignment */
        .avatar-profile {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Password toggle eye icon */
        .password-toggle {
            cursor: pointer;
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #697a8d;
            transition: color 0.2s ease;
            z-index: 10;
            padding: 5px;
        }

        .password-toggle:hover {
            color: #696cff;
        }

        .password-toggle i {
            font-size: 18px;
        }

        .password-field-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .password-field-wrapper input {
            padding-right: 45px !important;
        }

        /* Password Match Indicators */
        .password-match-indicator {
            display: none;
            font-size: 12px;
            margin-top: 5px;
            animation: slideIn 0.3s ease;
        }

        .password-match-indicator.show {
            display: block;
        }

        .password-match-indicator i {
            font-size: 14px;
            margin-right: 4px;
        }

        .match-success {
            color: #28a745;
        }

        .match-error {
            color: #dc3545;
        }

        input.is-valid {
            border-color: #28a745 !important;
        }

        input.is-invalid {
            border-color: #dc3545 !important;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Dark theme compatibility */
        html.dark-style .password-toggle,
        html.blue-style .password-toggle,
        html.green-style .password-toggle,
        html.purple-style .password-toggle,
        html.red-style .password-toggle {
            color: rgba(255, 255, 255, 0.7);
        }

        html.dark-style .password-toggle:hover,
        html.blue-style .password-toggle:hover,
        html.green-style .password-toggle:hover,
        html.purple-style .password-toggle:hover,
        html.red-style .password-toggle:hover {
            color: #ffffff;
        }

        /* ==================== IMAGE CROPPER MODAL ==================== */
        .crop-container {
            position: relative;
            width: 100%;
            max-width: 500px;
            height: 500px;
            margin: 0 auto;
            background: #2a2a2a;
            overflow: hidden;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .crop-container canvas {
            max-width: 100%;
            max-height: 100%;
            display: block;
        }

        .zoom-slider {
            width: 100%;
            margin-top: 20px;
        }

        .preview-circle {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            overflow: hidden;
            margin: 15px auto;
            border: 4px solid #696cff;
            box-shadow: 0 4px 12px rgba(105, 108, 255, 0.3);
        }

        .preview-circle canvas {
            width: 100%;
            height: 100%;
        }

        .zoom-info {
            text-align: center;
            font-size: 14px;
            color: #666;
            margin-top: 8px;
        }

        @media (max-width: 767px) {
            .avatar-profile {
                margin-bottom: 20px;
            }
            .crop-container {
                height: 300px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('🔐 Profile page initialized');
       // ==================== 👇 TAMBAHKAN BAGIAN INI DI ATAS 👇 ====================
    // NOTIFIKASI ERROR/SUCCESS
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session("error") }}',
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'OK'
        });
    @endif

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session("success") }}',
            confirmButtonColor: '#28a745',
            confirmButtonText: 'OK',
            timer: 3000
        });
    @endif

    // Notifikasi khusus jika ada error password lama
    @error('current_password')
        Swal.fire({
            icon: 'error',
            title: 'Password Salah! 🔒',
            html: '<p class="mb-0"><strong>{{ $message }}</strong></p><p class="text-muted small mt-2">Pastikan Anda memasukkan password lama yang benar</p>',
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'Coba Lagi'
        });
    @enderror

    // ==================== PASSWORD TOGGLE ====================
    document.querySelectorAll('.password-toggle').forEach(toggle => {
        toggle.addEventListener('click', function() {
            const wrapper = this.closest('.password-field-wrapper');
            const input = wrapper.querySelector('input');
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bx-hide');
                icon.classList.add('bx-show');
            } else {
                input.type = 'password';
                icon.classList.remove('bx-show');
                icon.classList.add('bx-hide');
            }
        });
    });

    // ==================== PASSWORD MATCH VALIDATION ====================
    const newPassword = document.querySelector('input[name="new_password"]');
    const confirmPassword = document.querySelector('input[name="new_password_confirmation"]');
    const matchIndicator = document.getElementById('passwordMatchIndicator');
    const submitBtn = document.getElementById('passwordSubmitBtn');

    function validatePasswordMatch() {
        const newPass = newPassword.value;
        const confirmPass = confirmPassword.value;

        // Hanya validasi jika confirm password tidak kosong
        if (confirmPass.length === 0) {
            matchIndicator.classList.remove('show');
            confirmPassword.classList.remove('is-valid', 'is-invalid');
            return;
        }

        matchIndicator.classList.add('show');

        if (newPass === confirmPass && newPass.length >= 8) {
            // Password cocok
            confirmPassword.classList.remove('is-invalid');
            confirmPassword.classList.add('is-valid');
            matchIndicator.className = 'password-match-indicator show match-success';
            matchIndicator.innerHTML = '<i class="bx bx-check-circle"></i>Password cocok!';
            submitBtn.disabled = false;
        } else if (newPass !== confirmPass) {
            // Password tidak cocok
            confirmPassword.classList.remove('is-valid');
            confirmPassword.classList.add('is-invalid');
            matchIndicator.className = 'password-match-indicator show match-error';
            matchIndicator.innerHTML = '<i class="bx bx-x-circle"></i>Password tidak cocok!';
            submitBtn.disabled = true;
        } else {
            // Password kurang dari 8 karakter
            confirmPassword.classList.remove('is-valid');
            confirmPassword.classList.add('is-invalid');
            matchIndicator.className = 'password-match-indicator show match-error';
            matchIndicator.innerHTML = '<i class="bx bx-error-circle"></i>Password minimal 8 karakter!';
            submitBtn.disabled = true;
        }
    }

    // Real-time validation
    if (newPassword && confirmPassword) {
        newPassword.addEventListener('input', validatePasswordMatch);
        confirmPassword.addEventListener('input', validatePasswordMatch);
        
        // Validasi saat blur (keluar dari input)
        confirmPassword.addEventListener('blur', validatePasswordMatch);
    }

    // ==================== IMAGE CROPPER WITH DRAG & ZOOM ====================
    let cropper = null;
    const fileInput = document.getElementById('upload');
    const cropModal = new bootstrap.Modal(document.getElementById('cropModal'));
    const mainCanvas = document.getElementById('mainCanvas');
    const previewCanvas = document.getElementById('previewCanvas');
    const zoomSlider = document.getElementById('zoomSlider');
    const zoomValue = document.getElementById('zoomValue');
    const cropBtn = document.getElementById('cropBtn');
    const avatarImage = document.getElementById('uploadedAvatar');

    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        // Validasi
        if (!file.type.match('image/(jpeg|jpg|png)')) {
            Swal.fire({
                icon: 'error',
                title: 'Format Tidak Valid',
                text: 'Hanya JPG, JPEG, dan PNG!'
            });
            return;
        }

        const maxSize = 5 * 1024 * 1024;
        if (file.size > maxSize) {
            Swal.fire({
                icon: 'error',
                title: 'File Terlalu Besar',
                text: 'Maksimal 5MB!'
            });
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            const img = new Image();
            img.onload = function() {
                cropper = new ImageCropper(mainCanvas, previewCanvas, img);
                zoomSlider.value = 100;
                zoomValue.textContent = '100%';
                cropModal.show();
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    });

    zoomSlider.addEventListener('input', function() {
        if (cropper) {
            const scale = this.value / 100;
            cropper.setScale(scale);
            zoomValue.textContent = this.value + '%';
        }
    });

    cropBtn.addEventListener('click', function() {
        if (!cropper) return;

        cropper.getCroppedImage(function(blob) {
            const url = URL.createObjectURL(blob);
            avatarImage.src = url;

            const croppedFile = new File([blob], 'profile.jpg', { type: 'image/jpeg' });
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(croppedFile);
            
            const realInput = document.querySelector('input[name="profile_picture"]');
            realInput.files = dataTransfer.files;

            cropModal.hide();
            Toast.fire({ icon: 'success', title: 'Foto siap diupload!' });
        });
    });

    // ==================== IMAGE CROPPER CLASS ====================
    class ImageCropper {
        constructor(canvas, previewCanvas, image) {
            this.canvas = canvas;
            this.ctx = canvas.getContext('2d');
            this.previewCanvas = previewCanvas;
            this.previewCtx = previewCanvas.getContext('2d');
            this.image = image;
            
            this.scale = 1;
            this.offsetX = 0;
            this.offsetY = 0;
            this.isDragging = false;
            this.lastX = 0;
            this.lastY = 0;

            this.init();
        }

        init() {
            this.canvas.width = 500;
            this.canvas.height = 500;
            this.previewCanvas.width = 150;
            this.previewCanvas.height = 150;

            this.fitImage();
            this.setupEvents();
            this.draw();
        }

        fitImage() {
            const canvasRatio = this.canvas.width / this.canvas.height;
            const imageRatio = this.image.width / this.image.height;

            if (imageRatio > canvasRatio) {
                this.scale = this.canvas.height / this.image.height;
            } else {
                this.scale = this.canvas.width / this.image.width;
            }

            this.offsetX = (this.canvas.width - this.image.width * this.scale) / 2;
            this.offsetY = (this.canvas.height - this.image.height * this.scale) / 2;
        }

        setupEvents() {
            this.canvas.addEventListener('mousedown', (e) => this.startDrag(e));
            this.canvas.addEventListener('mousemove', (e) => this.drag(e));
            this.canvas.addEventListener('mouseup', () => this.endDrag());
            this.canvas.addEventListener('mouseleave', () => this.endDrag());

            // Touch events
            this.canvas.addEventListener('touchstart', (e) => this.startDrag(e.touches[0]));
            this.canvas.addEventListener('touchmove', (e) => {
                e.preventDefault();
                this.drag(e.touches[0]);
            });
            this.canvas.addEventListener('touchend', () => this.endDrag());
        }

        startDrag(e) {
            this.isDragging = true;
            const rect = this.canvas.getBoundingClientRect();
            this.lastX = e.clientX - rect.left;
            this.lastY = e.clientY - rect.top;
            this.canvas.style.cursor = 'grabbing';
        }

        drag(e) {
            if (!this.isDragging) return;

            const rect = this.canvas.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            this.offsetX += x - this.lastX;
            this.offsetY += y - this.lastY;

            this.lastX = x;
            this.lastY = y;

            this.draw();
        }

        endDrag() {
            this.isDragging = false;
            this.canvas.style.cursor = 'grab';
        }

        setScale(scale) {
            const centerX = this.canvas.width / 2;
            const centerY = this.canvas.height / 2;

            const oldScale = this.scale;
            this.scale = scale;

            this.offsetX = centerX - (centerX - this.offsetX) * (scale / oldScale);
            this.offsetY = centerY - (centerY - this.offsetY) * (scale / oldScale);

            this.draw();
        }

        draw() {
            // Main canvas
            this.ctx.fillStyle = '#2a2a2a';
            this.ctx.fillRect(0, 0, this.canvas.width, this.canvas.height);

            this.ctx.save();
            this.ctx.translate(this.offsetX, this.offsetY);
            this.ctx.scale(this.scale, this.scale);
            this.ctx.drawImage(this.image, 0, 0);
            this.ctx.restore();

            // Overlay
            this.ctx.save();
            this.ctx.fillStyle = 'rgba(0, 0, 0, 0.5)';
            this.ctx.fillRect(0, 0, this.canvas.width, this.canvas.height);
            
            this.ctx.globalCompositeOperation = 'destination-out';
            this.ctx.beginPath();
            this.ctx.arc(250, 250, 200, 0, Math.PI * 2);
            this.ctx.fill();
            
            this.ctx.globalCompositeOperation = 'source-over';
            this.ctx.strokeStyle = '#696cff';
            this.ctx.lineWidth = 3;
            this.ctx.beginPath();
            this.ctx.arc(250, 250, 200, 0, Math.PI * 2);
            this.ctx.stroke();
            this.ctx.restore();

            this.drawPreview();
        }

        drawPreview() {
            // Draw clean preview without overlay
            const centerX = 250;
            const centerY = 250;
            const radius = 200;
            
            this.previewCtx.clearRect(0, 0, this.previewCanvas.width, this.previewCanvas.height);
            
            // Create circular clip
            this.previewCtx.save();
            this.previewCtx.beginPath();
            this.previewCtx.arc(75, 75, 75, 0, Math.PI * 2);
            this.previewCtx.clip();
            
            // Calculate scale to fit preview
            const scale = 150 / (radius * 2);
            this.previewCtx.drawImage(
                this.canvas,
                centerX - radius, centerY - radius, radius * 2, radius * 2,
                0, 0, 150, 150
            );
            this.previewCtx.restore();
        }

        getCroppedImage(callback) {
            const size = 400;
            const cropCanvas = document.createElement('canvas');
            cropCanvas.width = size;
            cropCanvas.height = size;
            const cropCtx = cropCanvas.getContext('2d');

            // Clear canvas
            cropCtx.fillStyle = 'white';
            cropCtx.fillRect(0, 0, size, size);

            // Draw only the image (without overlay)
            const centerX = 250;
            const centerY = 250;
            const radius = 200;

            cropCtx.save();
            cropCtx.translate(this.offsetX, this.offsetY);
            cropCtx.scale(this.scale, this.scale);
            cropCtx.drawImage(this.image, 0, 0);
            cropCtx.restore();

            // Create final cropped canvas with circular mask
            const finalCanvas = document.createElement('canvas');
            finalCanvas.width = size;
            finalCanvas.height = size;
            const finalCtx = finalCanvas.getContext('2d');

            // White background
            finalCtx.fillStyle = 'white';
            finalCtx.fillRect(0, 0, size, size);

            // Circular clip and draw
            finalCtx.save();
            finalCtx.beginPath();
            finalCtx.arc(size / 2, size / 2, size / 2, 0, Math.PI * 2);
            finalCtx.clip();
            
            finalCtx.drawImage(
                cropCanvas,
                centerX - radius, centerY - radius, radius * 2, radius * 2,
                0, 0, size, size
            );
            finalCtx.restore();

            finalCanvas.toBlob(callback, 'image/jpeg', 0.92);
        }
    }
});
    </script>
@endpush

@section('content')
    <x-breadcrumb :values="[__('navbar.profile.profile')]">
    </x-breadcrumb>

    <div class="row">
        <div class="col-12">
            <!-- Profile Card -->
            <div class="card profile-card mb-4">
                <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="card-body">
                        <div class="row">
                            <!-- Avatar Section -->
                            <div class="col-md-3 avatar-profile">
                                <div class="text-center">
                                    <img src="{{ $data->profile_picture }}" alt="user-avatar"
                                        class="rounded-circle mb-3" height="120" width="120"
                                        id="uploadedAvatar">
                                    <h5 class="mb-0">{{ $data->name }}</h5>
                                    <p class="text-muted small">{{ $data->email }}</p>
                                    
                                    <!-- Upload Button -->
                                    <div class="mt-3">
                                        <label for="upload" class="btn btn-primary btn-sm" style="cursor: pointer;">
                                            <i class="bx bx-upload"></i> Ganti Foto
                                        </label>
                                        <input type="file" id="upload" hidden accept="image/jpeg,image/jpg,image/png">
                                        <input type="file" name="profile_picture" id="croppedImageInput" hidden>
                                        <p class="text-muted small mt-2">Max 5MB (JPG, PNG)</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Section -->
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <x-input-form name="name" :label="__('model.user.name')" :value="$data->name" required />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <x-input-form name="email" :label="__('model.user.email')" :value="$data->email" required />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <x-input-form name="phone" :label="__('model.user.phone')" :value="$data->phone ?? ''" />
                                    </div>
                                </div>

                                <div class="d-flex gap-2 mt-3">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bx bx-save me-1"></i>Perbarui Profil
                                    </button>
                                    <button type="button" onclick="window.history.back();" class="btn btn-outline-secondary">
                                        <i class="bx bx-x me-1"></i>{{ __('menu.general.cancel') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Password Change Section -->
            <div class="card profile-card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bx bx-key me-2"></i>Ubah Password
                    </h5>
                </div>
                
                <form action="{{ route('profile.password.update') }}" method="post">
                    @csrf
                    @method('PUT')
                    
                    <div class="card-body">
                        <div class="row">
                           <!-- Password Lama -->
<div class="col-md-4 mb-3">
    <label class="form-label">Password Lama</label>
    <div class="password-field-wrapper">
        <input type="password" name="current_password" 
               class="form-control @error('current_password') is-invalid @enderror" required>
        <span class="password-toggle">
            <i class="bx bx-hide"></i>
        </span>
    </div>
    @error('current_password')
        <small class="text-danger">
            <i class="bx bx-error-circle"></i> {{ $message }}
        </small>
    @enderror
</div>

<!-- Password Baru -->
<div class="col-md-4 mb-3">
    <label class="form-label">Password Baru</label>
    <div class="password-field-wrapper">
        <input type="password" name="new_password" 
               class="form-control @error('new_password') is-invalid @enderror" 
               required minlength="8">
        <span class="password-toggle">
            <i class="bx bx-hide"></i>
        </span>
    </div>
    <small class="text-muted">Minimal 8 karakter</small>
    @error('new_password')
        <small class="text-danger d-block">
            <i class="bx bx-error-circle"></i> {{ $message }}
        </small>
    @enderror
</div>

<!-- Konfirmasi Password -->
<div class="col-md-4 mb-3">
    <label class="form-label">Konfirmasi Password Baru</label>
    <div class="password-field-wrapper">
        <input type="password" name="new_password_confirmation" 
               class="form-control @error('new_password_confirmation') is-invalid @enderror" 
               required minlength="8">
        <span class="password-toggle">
            <i class="bx bx-hide"></i>
        </span>
    </div>
    <div id="passwordMatchIndicator" class="password-match-indicator"></div>
    @error('new_password_confirmation')
        <small class="text-danger">
            <i class="bx bx-error-circle"></i> {{ $message }}
        </small>
    @enderror
</div>
                        </div>
                        <button type="submit" class="btn btn-warning" id="passwordSubmitBtn">
                            <i class="bx bx-save me-1"></i>Perbarui Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Crop Modal -->
    <div class="modal fade" id="cropModal" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bx bx-crop me-2"></i>Atur Foto Profil
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="crop-container">
                                <canvas id="mainCanvas" style="cursor: grab;"></canvas>
                            </div>
                            
                            <div class="mt-3">
                                <label class="form-label d-flex justify-content-between">
                                    <span><i class="bx bx-zoom-in me-1"></i>Zoom</span>
                                    <span class="zoom-info" id="zoomValue">100%</span>
                                </label>
                                <input type="range" class="form-range zoom-slider" id="zoomSlider" 
                                       min="50" max="300" value="100">
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="text-center">
                                <p class="text-muted mb-3">
                                    <i class="bx bx-info-circle me-1"></i>Preview
                                </p>
                                <div class="preview-circle">
                                    <canvas id="previewCanvas"></canvas>
                                </div>
                                <small class="text-muted d-block mt-3">
                                    <i class="bx bx-move me-1"></i>Geser untuk mengatur posisi<br>
                                    <i class="bx bx-slider me-1"></i>Zoom untuk perbesar/kecilkan
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x me-1"></i>Batal
                    </button>
                    <button type="button" class="btn btn-primary" id="cropBtn">
                        <i class="bx bx-check me-1"></i>Gunakan Foto Ini
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection