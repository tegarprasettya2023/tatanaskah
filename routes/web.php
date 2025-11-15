<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonalLetter\PerjanjianKerjasamaController;
use App\Http\Controllers\PersonalLetter\SuratDinasController;
use App\Http\Controllers\PersonalLetter\BasePersonalLetterController;
use App\Http\Controllers\PersonalLetter\SuratKeteranganController;
use App\Http\Controllers\PersonalLetter\SuratPerintahController;
use App\Http\Controllers\PersonalLetter\SuratKuasaController;
use App\Http\Controllers\PersonalLetter\SuratUndanganController;
use App\Http\Controllers\PersonalLetter\SuratMemoController;
use App\Http\Controllers\PersonalLetter\SuratPengumumanController;  
use App\Http\Controllers\PersonalLetter\SuratNotulenController;
use App\Http\Controllers\PersonalLetter\SuratBeritaAcaraController;
use App\Http\Controllers\PersonalLetter\SuratDisposisiController;
use App\Http\Controllers\PersonalLetter\SuratKeputusanController;
use App\Http\Controllers\PersonalLetter\SuratInstruksiKerjaController;
use App\Http\Controllers\PersonalLetter\SuratSpoController;
use App\Http\Controllers\PersonalLetter\SuratPanggilanController;

Route::middleware(['auth'])->group(function () {
    Route::get('/', [\App\Http\Controllers\PageController::class, 'index'])->name('home');

    Route::get('lang/{locale}', function ($locale) {
        if (in_array($locale, ['en', 'id'])) {
            session(['locale' => $locale]);
            app()->setLocale($locale);
        }
        return back();
    })->name('lang.switch');

    Route::resource('user', \App\Http\Controllers\UserController::class)
        ->except(['show', 'edit', 'create'])
        ->middleware(['role:admin']);

    Route::get('profile', [\App\Http\Controllers\PageController::class, 'profile'])
        ->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\PageController::class, 'profileUpdate'])
        ->name('profile.update');
    Route::put('profile/password', [\App\Http\Controllers\PageController::class, 'passwordUpdate'])
        ->name('profile.password.update');

    Route::put('profile/deactivate', [\App\Http\Controllers\PageController::class, 'deactivate'])
        ->name('profile.deactivate')
        ->middleware(['role:staff']);

    Route::get('settings', [\App\Http\Controllers\PageController::class, 'settings'])
        ->name('settings.show')
        ->middleware(['role:admin']);
    Route::put('settings', [\App\Http\Controllers\PageController::class, 'settingsUpdate'])
        ->name('settings.update')
        ->middleware(['role:admin']);

    Route::delete('attachment', [\App\Http\Controllers\PageController::class, 'removeAttachment'])
        ->name('attachment.destroy');

    Route::prefix('transaction')->as('transaction.')->group(function () {
        Route::resource('incoming', \App\Http\Controllers\IncomingLetterController::class);
        Route::resource('outgoing', \App\Http\Controllers\OutgoingLetterController::class);
        Route::resource('{letter}/disposition', \App\Http\Controllers\DispositionController::class)->except(['show']);
    });

    // ==================== PERSONAL LETTER ====================
    Route::prefix('transaction/personal')->name('transaction.personal.')->group(function () {
        // Index gabungan semua surat pribadi
        Route::get('/', [BasePersonalLetterController::class, 'index'])->name('index');

        // Halaman pilih template
        Route::get('templates', [BasePersonalLetterController::class, 'templates'])->name('templates');

        // Create berdasarkan template (untuk perjanjian kerjasama)
        Route::get('create/{template}', [PerjanjianKerjasamaController::class, 'create'])->name('create');

        // ==================== PERJANJIAN KERJASAMA ====================
        Route::get('perjanjian', [PerjanjianKerjasamaController::class, 'index'])->name('perjanjian.index');
        Route::post('perjanjian', [PerjanjianKerjasamaController::class, 'store'])->name('perjanjian.store');
        Route::get('perjanjian/{id}', [PerjanjianKerjasamaController::class, 'show'])->name('perjanjian.show');
        Route::get('perjanjian/{id}/edit', [PerjanjianKerjasamaController::class, 'edit'])->name('perjanjian.edit');
        Route::put('perjanjian/{id}', [PerjanjianKerjasamaController::class, 'update'])->name('perjanjian.update');
        Route::delete('perjanjian/{id}', [PerjanjianKerjasamaController::class, 'destroy'])->name('perjanjian.destroy');
        Route::get('perjanjian/{id}/preview', [PerjanjianKerjasamaController::class, 'preview'])->name('perjanjian.preview');
        Route::get('perjanjian/{id}/download', [PerjanjianKerjasamaController::class, 'download'])->name('perjanjian.download');

        // ==================== SURAT DINAS ====================
        Route::get('surat_dinas', [SuratDinasController::class, 'index'])->name('surat_dinas.index');
        Route::get('surat_dinas/create', [SuratDinasController::class, 'create'])->name('surat_dinas.create');
        Route::post('surat_dinas', [SuratDinasController::class, 'store'])->name('surat_dinas.store');
        Route::get('surat_dinas/{id}', [SuratDinasController::class, 'show'])->name('surat_dinas.show');
        Route::get('surat_dinas/{id}/edit', [SuratDinasController::class, 'edit'])->name('surat_dinas.edit');
        Route::put('surat_dinas/{id}', [SuratDinasController::class, 'update'])->name('surat_dinas.update');
        Route::delete('surat_dinas/{id}', [SuratDinasController::class, 'destroy'])->name('surat_dinas.destroy');
        Route::get('surat_dinas/{id}/preview', [SuratDinasController::class, 'preview'])->name('surat_dinas.preview');
        Route::get('surat_dinas/{id}/download', [SuratDinasController::class, 'download'])->name('surat_dinas.download');

        // ==================== SURAT KETERANGAN ====================
        Route::get('surat_keterangan', [SuratKeteranganController::class, 'index'])->name('surat_keterangan.index');
        Route::get('surat_keterangan/create', [SuratKeteranganController::class, 'create'])->name('surat_keterangan.create');
        Route::post('surat_keterangan', [SuratKeteranganController::class, 'store'])->name('surat_keterangan.store');
        Route::get('surat_keterangan/{id}', [SuratKeteranganController::class, 'show'])->name('surat_keterangan.show');
        Route::get('surat_keterangan/{id}/edit', [SuratKeteranganController::class, 'edit'])->name('surat_keterangan.edit');
        Route::put('surat_keterangan/{id}', [SuratKeteranganController::class, 'update'])->name('surat_keterangan.update');
        Route::delete('surat_keterangan/{id}', [SuratKeteranganController::class, 'destroy'])->name('surat_keterangan.destroy');
        Route::get('surat_keterangan/{id}/preview', [SuratKeteranganController::class, 'preview'])->name('surat_keterangan.preview');
        Route::get('surat_keterangan/{id}/download', [SuratKeteranganController::class, 'download'])->name('surat_keterangan.download');

        // ==================== SURAT PERINTAH ====================
        Route::get('surat_perintah', [SuratPerintahController::class, 'index'])->name('surat_perintah.index');
        Route::get('surat_perintah/create', [SuratPerintahController::class, 'create'])->name('surat_perintah.create');
        Route::post('surat_perintah', [SuratPerintahController::class, 'store'])->name('surat_perintah.store');
        Route::get('surat_perintah/{id}', [SuratPerintahController::class, 'show'])->name('surat_perintah.show');
        Route::get('surat_perintah/{id}/edit', [SuratPerintahController::class, 'edit'])->name('surat_perintah.edit');
        Route::put('surat_perintah/{id}', [SuratPerintahController::class, 'update'])->name('surat_perintah.update');
        Route::delete('surat_perintah/{id}', [SuratPerintahController::class, 'destroy'])->name('surat_perintah.destroy');
        Route::get('surat_perintah/{id}/preview', [SuratPerintahController::class, 'preview'])->name('surat_perintah.preview');
        Route::get('surat_perintah/{id}/download', [SuratPerintahController::class, 'download'])->name('surat_perintah.download');

        // ==================== SURAT KUASA ====================
        Route::get('suratkuasa', [SuratKuasaController::class, 'index'])->name('suratkuasa.index');
        Route::get('suratkuasa/create', [SuratKuasaController::class, 'create'])->name('suratkuasa.create');
        Route::post('suratkuasa', [SuratKuasaController::class, 'store'])->name('suratkuasa.store');
        Route::get('suratkuasa/{id}', [SuratKuasaController::class, 'show'])->name('suratkuasa.show');
        Route::get('suratkuasa/{id}/edit', [SuratKuasaController::class, 'edit'])->name('suratkuasa.edit');
        Route::put('suratkuasa/{id}', [SuratKuasaController::class, 'update'])->name('suratkuasa.update');
        Route::delete('suratkuasa/{id}', [SuratKuasaController::class, 'destroy'])->name('suratkuasa.destroy');
        Route::get('suratkuasa/{id}/preview', [SuratKuasaController::class, 'preview'])->name('suratkuasa.preview');
        Route::get('suratkuasa/{id}/download', [SuratKuasaController::class, 'download'])->name('suratkuasa.download');

        // ==================== SURAT UNDANGAN ====================
        Route::get('surat_undangan', [SuratUndanganController::class, 'index'])->name('surat_undangan.index');
        Route::get('surat_undangan/create', [SuratUndanganController::class, 'create'])->name('surat_undangan.create');
        Route::post('surat_undangan', [SuratUndanganController::class, 'store'])->name('surat_undangan.store');
        Route::get('surat_undangan/{id}', [SuratUndanganController::class, 'show'])->name('surat_undangan.show');
        Route::get('surat_undangan/{id}/edit', [SuratUndanganController::class, 'edit'])->name('surat_undangan.edit');
        Route::put('surat_undangan/{id}', [SuratUndanganController::class, 'update'])->name('surat_undangan.update');
        Route::delete('surat_undangan/{id}', [SuratUndanganController::class, 'destroy'])->name('surat_undangan.destroy');
        Route::get('surat_undangan/{id}/preview', [SuratUndanganController::class, 'preview'])->name('surat_undangan.preview');
        Route::get('surat_undangan/{id}/download', [SuratUndanganController::class, 'download'])->name('surat_undangan.download');
        
        // ==================== SURAT PANGGILAN ====================
        Route::get('surat_panggilan', [SuratPanggilanController::class, 'index'])->name('surat_panggilan.index');
        Route::get('surat_panggilan/create', [SuratPanggilanController::class, 'create'])->name('surat_panggilan.create');
        Route::post('surat_panggilan', [SuratPanggilanController::class, 'store'])->name('surat_panggilan.store');
        Route::get('surat_panggilan/{id}', [SuratPanggilanController::class, 'show'])->name('surat_panggilan.show');
        Route::get('surat_panggilan/{id}/edit', [SuratPanggilanController::class, 'edit'])->name('surat_panggilan.edit');
        Route::put('surat_panggilan/{id}', [SuratPanggilanController::class, 'update'])->name('surat_panggilan.update');
        Route::delete('surat_panggilan/{id}', [SuratPanggilanController::class, 'destroy'])->name('surat_panggilan.destroy');
        Route::get('surat_panggilan/{id}/preview', [SuratPanggilanController::class, 'preview'])->name('surat_panggilan.preview');
        Route::get('surat_panggilan/{id}/download', [SuratPanggilanController::class, 'download'])->name('surat_panggilan.download');

        // ==================== MEMO ====================
        Route::get('memo', [SuratMemoController::class, 'index'])->name('memo.index');
        Route::get('memo/create', [SuratMemoController::class, 'create'])->name('memo.create');
        Route::post('memo', [SuratMemoController::class, 'store'])->name('memo.store');
        Route::get('memo/{id}', [SuratMemoController::class, 'show'])->name('memo.show');
        Route::get('memo/{id}/edit', [SuratMemoController::class, 'edit'])->name('memo.edit');
        Route::put('memo/{id}', [SuratMemoController::class, 'update'])->name('memo.update');
        Route::delete('memo/{id}', [SuratMemoController::class, 'destroy'])->name('memo.destroy');
        Route::get('memo/{id}/preview', [SuratMemoController::class, 'preview'])->name('memo.preview');
        Route::get('memo/{id}/download', [SuratMemoController::class, 'download'])->name('memo.download');

        // ==================== PENGUMUMAN ====================
        Route::get('pengumuman', [SuratPengumumanController::class, 'index'])->name('pengumuman.index');
        Route::get('pengumuman/create', [SuratPengumumanController::class, 'create'])->name('pengumuman.create');
        Route::post('pengumuman', [SuratPengumumanController::class, 'store'])->name('pengumuman.store');
        Route::get('pengumuman/{id}', [SuratPengumumanController::class, 'show'])->name('pengumuman.show');
        Route::get('pengumuman/{id}/edit', [SuratPengumumanController::class, 'edit'])->name('pengumuman.edit');
        Route::put('pengumuman/{id}', [SuratPengumumanController::class, 'update'])->name('pengumuman.update');
        Route::delete('pengumuman/{id}', [SuratPengumumanController::class, 'destroy'])->name('pengumuman.destroy');
        Route::get('pengumuman/{id}/preview', [SuratPengumumanController::class, 'preview'])->name('pengumuman.preview');
        Route::get('pengumuman/{id}/download', [SuratPengumumanController::class, 'download'])->name('pengumuman.download');

        // ==================== NOTULEN ====================
        Route::get('notulen', [SuratNotulenController::class, 'index'])->name('notulen.index');
        Route::get('notulen/create', [SuratNotulenController::class, 'create'])->name('notulen.create');
        Route::post('notulen', [SuratNotulenController::class, 'store'])->name('notulen.store');
        Route::get('notulen/{id}', [SuratNotulenController::class, 'show'])->name('notulen.show');
        Route::get('notulen/{id}/edit', [SuratNotulenController::class, 'edit'])->name('notulen.edit');
        Route::put('notulen/{id}', [SuratNotulenController::class, 'update'])->name('notulen.update');
        Route::delete('notulen/{id}', [SuratNotulenController::class, 'destroy'])->name('notulen.destroy');
        Route::get('notulen/{id}/preview', [SuratNotulenController::class, 'preview'])->name('notulen.preview');
        Route::get('notulen/{id}/download', [SuratNotulenController::class, 'download'])->name('notulen.download');

        // ==================== BERITA ACARA ====================
        Route::get('beritaacara', [SuratBeritaAcaraController::class, 'index'])->name('beritaacara.index');
        Route::get('beritaacara/create', [SuratBeritaAcaraController::class, 'create'])->name('beritaacara.create');
        Route::post('beritaacara', [SuratBeritaAcaraController::class, 'store'])->name('beritaacara.store');
        Route::get('beritaacara/{id}', [SuratBeritaAcaraController::class, 'show'])->name('beritaacara.show');
        Route::get('beritaacara/{id}/edit', [SuratBeritaAcaraController::class, 'edit'])->name('beritaacara.edit');
        Route::put('beritaacara/{id}', [SuratBeritaAcaraController::class, 'update'])->name('beritaacara.update');
        Route::delete('beritaacara/{id}', [SuratBeritaAcaraController::class, 'destroy'])->name('beritaacara.destroy');
        Route::get('beritaacara/{id}/preview', [SuratBeritaAcaraController::class, 'preview'])->name('beritaacara.preview');
        Route::get('beritaacara/{id}/download', [SuratBeritaAcaraController::class, 'download'])->name('beritaacara.download');

        // ==================== FORMULIR DISPOSISI ====================
        Route::get('suratdisposisi', [SuratDisposisiController::class, 'index'])->name('suratdisposisi.index');
        Route::get('suratdisposisi/create', [SuratDisposisiController::class, 'create'])->name('suratdisposisi.create');
        Route::post('suratdisposisi', [SuratDisposisiController::class, 'store'])->name('suratdisposisi.store');
        Route::get('suratdisposisi/{id}', [SuratDisposisiController::class, 'show'])->name('suratdisposisi.show');
        Route::get('suratdisposisi/{id}/edit', [SuratDisposisiController::class, 'edit'])->name('suratdisposisi.edit');
        Route::put('suratdisposisi/{id}', [SuratDisposisiController::class, 'update'])->name('suratdisposisi.update');
        Route::delete('suratdisposisi/{id}', [SuratDisposisiController::class, 'destroy'])->name('suratdisposisi.destroy');
        Route::get('suratdisposisi/{id}/preview', [SuratDisposisiController::class, 'preview'])->name('suratdisposisi.preview');
        Route::get('suratdisposisi/{id}/download', [SuratDisposisiController::class, 'download'])->name('suratdisposisi.download');

        // ==================== SURAT KEPUTUSAN ====================
        Route::get('surat_keputusan', [SuratKeputusanController::class, 'index'])->name('surat_keputusan.index');
        Route::get('surat_keputusan/create', [SuratKeputusanController::class, 'create'])->name('surat_keputusan.create');
        Route::post('surat_keputusan', [SuratKeputusanController::class, 'store'])->name('surat_keputusan.store');
        Route::get('surat_keputusan/{id}', [SuratKeputusanController::class, 'show'])->name('surat_keputusan.show');
        Route::get('surat_keputusan/{id}/edit', [SuratKeputusanController::class, 'edit'])->name('surat_keputusan.edit');
        Route::put('surat_keputusan/{id}', [SuratKeputusanController::class, 'update'])->name('surat_keputusan.update');
        Route::delete('surat_keputusan/{id}', [SuratKeputusanController::class, 'destroy'])->name('surat_keputusan.destroy');
        Route::get('surat_keputusan/{id}/preview', [SuratKeputusanController::class, 'preview'])->name('surat_keputusan.preview');
        Route::get('surat_keputusan/{id}/download', [SuratKeputusanController::class, 'download'])->name('surat_keputusan.download');

        // ==================== SPO ====================
        Route::get('spo', [SuratSpoController::class, 'index'])->name('spo.index');
        Route::get('spo/create', [SuratSpoController::class, 'create'])->name('spo.create');
        Route::post('spo', [SuratSpoController::class, 'store'])->name('spo.store');
        Route::get('spo/{id}', [SuratSpoController::class, 'show'])->name('spo.show');
        Route::get('spo/{id}/edit', [SuratSpoController::class, 'edit'])->name('spo.edit');
        Route::put('spo/{id}', [SuratSpoController::class, 'update'])->name('spo.update');
        Route::delete('spo/{id}', [SuratSpoController::class, 'destroy'])->name('spo.destroy');
        Route::get('spo/{id}/preview', [SuratSpoController::class, 'preview'])->name('spo.preview');
        Route::get('spo/{id}/download', [SuratSpoController::class, 'download'])->name('spo.download');
    });

    Route::get('/test-image', function() {
        $paths = [
            'header_klinik' => public_path('kop/header_klinik.png'),
            'header_lab' => public_path('kop/header_lab.png'),
            'header_pt' => public_path('kop/header_pt 2.png'),
            'footer_klinik' => public_path('footer/footer_klinik.png'),
            'footer_lab' => public_path('footer/footer_lab.png'),
            'footer_pt' => public_path('footer/footer_pt.png'),
        ];
        
        foreach($paths as $name => $path) {
            echo "<h3>{$name}</h3>";
            echo "Path: {$path}<br>";
            echo "Exists: " . (file_exists($path) ? 'YES ✓' : 'NO ✗') . "<br>";
            
            if(file_exists($path)) {
                $imageData = base64_encode(file_get_contents($path));
                $mimeType = mime_content_type($path);
                echo "<img src='data:{$mimeType};base64,{$imageData}' style='max-width: 500px; border: 1px solid #ccc;'><br>";
            }
            echo "<hr>";
        }
    });
});