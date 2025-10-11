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

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within the "web" middleware group.
|
*/

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

        // Create berdasarkan template
        Route::get('create/{template}', [PerjanjianKerjasamaController::class, 'create'])->name('create');

        // Preview surat
        Route::get('{personal}/preview', [PerjanjianKerjasamaController::class, 'preview'])->name('preview');

        // Download PDF
        Route::get('{personal}/download', [PerjanjianKerjasamaController::class, 'download'])->name('download');

        // ==================== PERJANJIAN ====================
        Route::resource('perjanjian', PerjanjianKerjasamaController::class)
            ->parameters(['perjanjian' => 'personal'])
            ->except(['create']);

        // ==================== SURAT DINAS ====================
        Route::resource('surat_dinas', SuratDinasController::class)
            ->parameters(['surat_dinas' => 'personal']);
        Route::get('surat_dinas/{id}/preview', [SuratDinasController::class, 'preview'])->name('surat_dinas.preview');
        Route::get('surat_dinas/{id}/download', [SuratDinasController::class, 'download'])->name('surat_dinas.download');

        // ==================== SURAT KETERANGAN ====================
        Route::resource('surat_keterangan', SuratKeteranganController::class)
            ->parameters(['surat_keterangan' => 'personal']);
        Route::get('surat_keterangan/{id}/preview', [SuratKeteranganController::class, 'preview'])->name('surat_keterangan.preview');
        Route::get('surat_keterangan/{id}/download', [SuratKeteranganController::class, 'download'])->name('surat_keterangan.download');

        // ==================== SURAT PERINTAH ====================
        Route::resource('surat_perintah', SuratPerintahController::class)
            ->parameters(['surat_perintah' => 'personal']);
        Route::get('surat_perintah/{id}/preview', [SuratPerintahController::class, 'preview'])->name('surat_perintah.preview');
        Route::get('surat_perintah/{id}/download', [SuratPerintahController::class, 'download'])->name('surat_perintah.download');

        // ==================== SURAT KUASA ====================
        Route::resource('suratkuasa', SuratKuasaController::class)
            ->parameters(['suratkuasa' => 'personal']);
        Route::get('suratkuasa/{id}/preview', [SuratKuasaController::class, 'preview'])->name('suratkuasa.preview');
        Route::get('suratkuasa/{id}/download', [SuratKuasaController::class, 'download'])->name('suratkuasa.download');

        // ==================== SURAT UNDANGAN ====================
        Route::resource('surat_undangan', SuratUndanganController::class)
            ->parameters(['surat_undangan' => 'personal']);
        Route::get('surat_undangan/{id}/preview', [SuratUndanganController::class, 'preview'])->name('surat_undangan.preview');
        Route::get('surat_undangan/{id}/download', [SuratUndanganController::class, 'download'])->name('surat_undangan.download');
        
        // ==================== SURAT PANGGILAN ====================
        Route::resource('surat_panggilan', \App\Http\Controllers\PersonalLetter\SuratPanggilanController::class)
            ->parameters(['surat_panggilan' => 'personal']);
        Route::get('surat_panggilan/{id}/preview', [\App\Http\Controllers\PersonalLetter\SuratPanggilanController::class, 'preview'])->name('surat_panggilan.preview');
        Route::get('surat_panggilan/{id}/download', [\App\Http\Controllers\PersonalLetter\SuratPanggilanController::class, 'download'])->name('surat_panggilan.download');

        // ==================== Memo ====================
        Route::resource('memo', SuratMemoController::class)->parameters(['memo' => 'personal']);
        Route::get('memo/{id}/preview', [SuratMemoController::class, 'preview'])->name('memo.preview');
        Route::get('memo/{id}/download', [SuratMemoController::class, 'download'])->name('memo.download');

        // ==================== PENGUMUMAN ====================
        Route::resource('pengumuman', SuratPengumumanController::class)->parameters(['pengumuman' => 'personal']);
        Route::get('pengumuman/{id}/preview', [SuratPengumumanController::class, 'preview'])->name('pengumuman.preview');
        Route::get('pengumuman/{id}/download', [SuratPengumumanController::class, 'download'])->name('pengumuman.download');

        // ==================== NOTULEN ====================
        Route::resource('notulen', SuratNotulenController::class)->parameters(['notulen' => 'personal']);
        Route::get('notulen/{id}/preview', [SuratNotulenController::class, 'preview'])->name('notulen.preview');
        Route::get('notulen/{id}/download', [SuratNotulenController::class, 'download'])->name('notulen.download');

        // ==================== BERITA ACARA ====================
        Route::resource('beritaacara', SuratBeritaAcaraController::class)->parameters(['beritaacara' => 'personal']);
        Route::get('beritaacara/{id}/preview', [SuratBeritaAcaraController::class, 'preview'])->name('beritaacara.preview');
        Route::get('beritaacara/{id}/download', [SuratBeritaAcaraController::class, 'download'])->name('beritaacara.download');

    });
    // ==========================================================

    Route::prefix('agenda')->as('agenda.')->group(function () {
        Route::get('incoming', [\App\Http\Controllers\IncomingLetterController::class, 'agenda'])->name('incoming');
        Route::get('incoming/print', [\App\Http\Controllers\IncomingLetterController::class, 'print'])->name('incoming.print');
        Route::get('outgoing', [\App\Http\Controllers\OutgoingLetterController::class, 'agenda'])->name('outgoing');
        Route::get('outgoing/print', [\App\Http\Controllers\OutgoingLetterController::class, 'print'])->name('outgoing.print');
    });

    Route::prefix('gallery')->as('gallery.')->group(function () {
        Route::get('incoming', [\App\Http\Controllers\LetterGalleryController::class, 'incoming'])->name('incoming');
        Route::get('outgoing', [\App\Http\Controllers\LetterGalleryController::class, 'outgoing'])->name('outgoing');
    });

    Route::prefix('reference')->as('reference.')->middleware(['role:admin'])->group(function () {
        Route::resource('classification', \App\Http\Controllers\ClassificationController::class)->except(['show', 'create', 'edit']);
        Route::resource('status', \App\Http\Controllers\LetterStatusController::class)->except(['show', 'create', 'edit']);
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
