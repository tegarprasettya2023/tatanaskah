<?php

namespace App\Http\Controllers;

use App\Enums\LetterType;
use App\Helpers\GeneralHelper;
use App\Http\Requests\UpdateConfigRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Attachment;
use App\Models\Config;
use App\Models\Disposition;
use App\Models\Letter;
use App\Models\User;
use App\Models\PersonalLetter;
use App\Models\PersonalLetterDinas;
use App\Models\PersonalLetterKeterangan;
use App\Models\PersonalLetterPerintah;
use App\Models\PersonalLetterKuasa;
use App\Models\PersonalLetterUndangan;
use App\Models\PersonalLetterPanggilan;
use App\Models\PersonalLetterMemo;
use App\Models\PersonalLetterPengumuman;
use App\Models\PersonalLetterNotulen;
use App\Models\PersonalLetterBeritaAcara;
use App\Models\PersonalLetterDisposisi;
use App\Models\PersonalLetterKeputusan;
use App\Models\PersonalLetterSPO;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use JetBrains\PhpStorm\NoReturn;

class PageController extends Controller
{
    /**
     * Dashboard - menampilkan statistik surat masuk/keluar DAN personal letters
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        // Set locale untuk Indonesia
        Carbon::setLocale('id');
        
        // Greeting berdasarkan waktu
        $hour = date('H');
        if ($hour < 12) {
            $greeting = 'Selamat Pagi! 🌅';
        } elseif ($hour < 15) {
            $greeting = 'Selamat Siang! ☀️';
        } elseif ($hour < 18) {
            $greeting = 'Selamat Sore! 🌤️';
        } else {
            $greeting = 'Selamat Malam! 🌙';
        }
        
        // Tanggal saat ini
        $currentDate = Carbon::now()->translatedFormat('l, d F Y');
        
        // ========== DATA PERSONAL LETTERS ==========
        // Hitung jumlah setiap jenis surat
        $perjanjianCount = PersonalLetter::count();
        $dinasCount = PersonalLetterDinas::count();
        $keteranganCount = PersonalLetterKeterangan::count();
        $perintahCount = PersonalLetterPerintah::count();
        $kuasaCount = PersonalLetterKuasa::count();
        $undanganCount = PersonalLetterUndangan::count();
        $panggilanCount = PersonalLetterPanggilan::count();
        $memoCount = PersonalLetterMemo::count();
        $pengumumanCount = PersonalLetterPengumuman::count();
        $notulenCount = PersonalLetterNotulen::count();
        $beritaAcaraCount = PersonalLetterBeritaAcara::count();
        $disposisiCount = PersonalLetterDisposisi::count();
        $keputusanCount = PersonalLetterKeputusan::count();
        $spoCount = PersonalLetterSPO::count();
        
        // Total semua surat personal
        $totalPersonalLetters = $perjanjianCount + $dinasCount + $keteranganCount + 
                               $perintahCount + $kuasaCount + $undanganCount + 
                               $panggilanCount + $memoCount + $pengumumanCount + 
                               $notulenCount + $beritaAcaraCount + $disposisiCount + 
                               $keputusanCount + $spoCount;
        
        // Surat bulan ini
        $monthlyLetters = PersonalLetter::whereMonth('created_at', date('m'))->count() +
                         PersonalLetterDinas::whereMonth('created_at', date('m'))->count() +
                         PersonalLetterKeterangan::whereMonth('created_at', date('m'))->count() +
                         PersonalLetterPerintah::whereMonth('created_at', date('m'))->count() +
                         PersonalLetterKuasa::whereMonth('created_at', date('m'))->count() +
                         PersonalLetterUndangan::whereMonth('created_at', date('m'))->count() +
                         PersonalLetterPanggilan::whereMonth('created_at', date('m'))->count() +
                         PersonalLetterMemo::whereMonth('created_at', date('m'))->count() +
                         PersonalLetterPengumuman::whereMonth('created_at', date('m'))->count() +
                         PersonalLetterNotulen::whereMonth('created_at', date('m'))->count() +
                         PersonalLetterBeritaAcara::whereMonth('created_at', date('m'))->count() +
                         PersonalLetterDisposisi::whereMonth('created_at', date('m'))->count() +
                         PersonalLetterKeputusan::whereMonth('created_at', date('m'))->count() +
                         PersonalLetterSPO::whereMonth('created_at', date('m'))->count();
        
        // Surat bulan lalu untuk perbandingan
        $lastMonthLetters = PersonalLetter::whereMonth('created_at', date('m', strtotime('-1 month')))->count() +
                           PersonalLetterDinas::whereMonth('created_at', date('m', strtotime('-1 month')))->count() +
                           PersonalLetterKeterangan::whereMonth('created_at', date('m', strtotime('-1 month')))->count() +
                           PersonalLetterPerintah::whereMonth('created_at', date('m', strtotime('-1 month')))->count() +
                           PersonalLetterKuasa::whereMonth('created_at', date('m', strtotime('-1 month')))->count() +
                           PersonalLetterUndangan::whereMonth('created_at', date('m', strtotime('-1 month')))->count() +
                           PersonalLetterPanggilan::whereMonth('created_at', date('m', strtotime('-1 month')))->count() +
                           PersonalLetterMemo::whereMonth('created_at', date('m', strtotime('-1 month')))->count() +
                           PersonalLetterPengumuman::whereMonth('created_at', date('m', strtotime('-1 month')))->count() +
                           PersonalLetterNotulen::whereMonth('created_at', date('m', strtotime('-1 month')))->count() +
                           PersonalLetterBeritaAcara::whereMonth('created_at', date('m', strtotime('-1 month')))->count() +
                           PersonalLetterDisposisi::whereMonth('created_at', date('m', strtotime('-1 month')))->count() +
                           PersonalLetterKeputusan::whereMonth('created_at', date('m', strtotime('-1 month')))->count() +
                           PersonalLetterSPO::whereMonth('created_at', date('m', strtotime('-1 month')))->count();
        
        // Hitung persentase perubahan
        $percentageMonthly = $lastMonthLetters > 0 
            ? (($monthlyLetters - $lastMonthLetters) / $lastMonthLetters * 100) 
            : 0;
        
        // Surat hari ini
        $todayLetters = PersonalLetter::whereDate('created_at', today())->count() +
                       PersonalLetterDinas::whereDate('created_at', today())->count() +
                       PersonalLetterKeterangan::whereDate('created_at', today())->count() +
                       PersonalLetterPerintah::whereDate('created_at', today())->count() +
                       PersonalLetterKuasa::whereDate('created_at', today())->count() +
                       PersonalLetterUndangan::whereDate('created_at', today())->count() +
                       PersonalLetterPanggilan::whereDate('created_at', today())->count() +
                       PersonalLetterMemo::whereDate('created_at', today())->count() +
                       PersonalLetterPengumuman::whereDate('created_at', today())->count() +
                       PersonalLetterNotulen::whereDate('created_at', today())->count() +
                       PersonalLetterBeritaAcara::whereDate('created_at', today())->count() +
                       PersonalLetterDisposisi::whereDate('created_at', today())->count() +
                       PersonalLetterKeputusan::whereDate('created_at', today())->count() +
                       PersonalLetterSPO::whereDate('created_at', today())->count();
        
        // Data untuk chart trend bulanan (12 bulan terakhir)
        $monthlyData = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = date('m', strtotime("-{$i} months"));
            $year = date('Y', strtotime("-{$i} months"));
            
            $count = PersonalLetter::whereMonth('created_at', $month)->whereYear('created_at', $year)->count() +
                    PersonalLetterDinas::whereMonth('created_at', $month)->whereYear('created_at', $year)->count() +
                    PersonalLetterKeterangan::whereMonth('created_at', $month)->whereYear('created_at', $year)->count() +
                    PersonalLetterPerintah::whereMonth('created_at', $month)->whereYear('created_at', $year)->count() +
                    PersonalLetterKuasa::whereMonth('created_at', $month)->whereYear('created_at', $year)->count() +
                    PersonalLetterUndangan::whereMonth('created_at', $month)->whereYear('created_at', $year)->count() +
                    PersonalLetterPanggilan::whereMonth('created_at', $month)->whereYear('created_at', $year)->count() +
                    PersonalLetterMemo::whereMonth('created_at', $month)->whereYear('created_at', $year)->count() +
                    PersonalLetterPengumuman::whereMonth('created_at', $month)->whereYear('created_at', $year)->count() +
                    PersonalLetterNotulen::whereMonth('created_at', $month)->whereYear('created_at', $year)->count() +
                    PersonalLetterBeritaAcara::whereMonth('created_at', $month)->whereYear('created_at', $year)->count() +
                    PersonalLetterDisposisi::whereMonth('created_at', $month)->whereYear('created_at', $year)->count() +
                    PersonalLetterKeputusan::whereMonth('created_at', $month)->whereYear('created_at', $year)->count() +
                    PersonalLetterSPO::whereMonth('created_at', $month)->whereYear('created_at', $year)->count();
            
            $monthlyData[] = $count;
        }

        return view('pages.dashboard', compact(
            'greeting',
            'currentDate',
            'perjanjianCount',
            'dinasCount',
            'keteranganCount',
            'perintahCount',
            'kuasaCount',
            'undanganCount',
            'panggilanCount',
            'memoCount',
            'pengumumanCount',
            'notulenCount',
            'beritaAcaraCount',
            'disposisiCount',
            'keputusanCount',
            'spoCount',
            'totalPersonalLetters',
            'monthlyLetters',
            'percentageMonthly',
            'todayLetters',
            'monthlyData'
        ));
    }

    /**
     * @param Request $request
     * @return View
     */
    public function profile(Request $request): View
    {
        return view('pages.profile', [
            'data' => auth()->user(),
        ]);
    }

/**
 * Update profile dengan upload/ganti gambar
 * @param UpdateUserRequest $request
 * @return RedirectResponse
 */
public function profileUpdate(UpdateUserRequest $request): RedirectResponse
{
    try {
        $user = auth()->user();
        $newProfile = $request->validated();

        // Hapus profile_picture dari array dulu
        unset($newProfile['profile_picture']);

        // Proses upload foto baru
        if ($request->hasFile('profile_picture')) {
            // Hapus foto lama jika ada
            $oldValue = $user->getAttributes()['profile_picture'] ?? null;
            if (!empty($oldValue)) {
                $filename = basename($oldValue);
                Storage::delete('public/avatars/' . $filename);
            }

            // Upload foto baru
            $file = $request->file('profile_picture');
            $filename = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/avatars', $filename);

            // Simpan FULL URL ke database
            $newProfile['profile_picture'] = asset('storage/avatars/' . $filename);
        }

        // Update user
        $user->update($newProfile);

        return back()->with('success', 'Profil berhasil diperbarui!');
    } catch (\Throwable $exception) {
        return back()->with('error', $exception->getMessage());
    }
}

 public function passwordUpdate(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'current_password' => ['required', 'current_password'],
                'new_password' => ['required', 'confirmed', 'min:8'],
            ], [
                // 👇 TAMBAHKAN CUSTOM MESSAGES INI
                'current_password.current_password' => 'Password lama yang Anda masukkan salah!',
                'new_password.required' => 'Password baru wajib diisi!',
                'new_password.min' => 'Password baru minimal 8 karakter!',
                'new_password.confirmed' => 'Konfirmasi password tidak cocok!',
            ]);

            $user = auth()->user();

            $user->update([
                'password' => Hash::make($request->new_password),
            ]);

            return back()->with('success', 'Password berhasil diperbarui! 🔒');
            
        } catch (\Illuminate\Validation\ValidationException $exception) {
            // 👇 TAMBAHKAN CATCH BLOCK INI
            return back()
                ->withErrors($exception->validator)
                ->withInput()
                ->with('error', 'Gagal memperbarui password. Periksa kembali input Anda.');
        } catch (\Throwable $exception) {
            return back()->with('error', 'Terjadi kesalahan: ' . $exception->getMessage());
        }
    }

    /**
     * @return RedirectResponse
     */
    public function deactivate(): RedirectResponse
    {
        try {
            auth()->user()->update(['is_active' => false]);
            Auth::logout();
            return back()->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return View
     */
    public function settings(Request $request): View
    {
        return view('pages.setting', [
            'configs' => Config::all(),
        ]);
    }

    /**
     * @param UpdateConfigRequest $request
     * @return RedirectResponse
     */
    public function settingsUpdate(UpdateConfigRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            foreach ($request->validated() as $code => $value) {
                Config::where('code', $code)->update(['value' => $value]);
            }
            DB::commit();
            return back()->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            DB::rollBack();
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function removeAttachment(Request $request): RedirectResponse
    {
        try {
            $attachment = Attachment::find($request->id);
            $oldPicture = $attachment->path_url;
            if (str_contains($oldPicture, '/storage/attachments/')) {
                $url = parse_url($oldPicture, PHP_URL_PATH);
                Storage::delete(str_replace('/storage', 'public', $url));
            }
            $attachment->delete();
            return back()->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}