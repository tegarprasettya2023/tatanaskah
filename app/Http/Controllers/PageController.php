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
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $todayIncomingLetter = Letter::incoming()->today()->count();
        $todayOutgoingLetter = Letter::outgoing()->today()->count();
        $todayDispositionLetter = Disposition::today()->count();
        $todayLetterTransaction = $todayIncomingLetter + $todayOutgoingLetter + $todayDispositionLetter;

        // Surat yang Disetujui dan Belum Disetujui
        $todayApprovedLetters = Letter::where('validation', 'Disetujui')->today()->count();
        $todayPendingLetters = Letter::where('validation', 'Belum Disetujui')->today()->count();

        $yesterdayIncomingLetter = Letter::incoming()->yesterday()->count();
        $yesterdayOutgoingLetter = Letter::outgoing()->yesterday()->count();
        $yesterdayDispositionLetter = Disposition::yesterday()->count();
        $yesterdayLetterTransaction = $yesterdayIncomingLetter + $yesterdayOutgoingLetter + $yesterdayDispositionLetter;

        return view('pages.dashboard', [
            'greeting' => GeneralHelper::greeting(),
            'currentDate' => Carbon::now()->isoFormat('dddd, D MMMM YYYY'),
            'todayIncomingLetter' => $todayIncomingLetter,
            'todayOutgoingLetter' => $todayOutgoingLetter,
            'todayDispositionLetter' => $todayDispositionLetter,
            'todayLetterTransaction' => $todayLetterTransaction,
            'todayApprovedLetters' => $todayApprovedLetters,
            'todayPendingLetters' => $todayPendingLetters,
            'activeUser' => User::active()->count(),
            'percentageIncomingLetter' => GeneralHelper::calculateChangePercentage($yesterdayIncomingLetter, $todayIncomingLetter),
            'percentageOutgoingLetter' => GeneralHelper::calculateChangePercentage($yesterdayOutgoingLetter, $todayOutgoingLetter),
            'percentageDispositionLetter' => GeneralHelper::calculateChangePercentage($yesterdayDispositionLetter, $todayDispositionLetter),
            'percentageLetterTransaction' => GeneralHelper::calculateChangePercentage($yesterdayLetterTransaction, $todayLetterTransaction),
        ]);
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
     * @param UpdateUserRequest $request
     * @return RedirectResponse
     */
    public function profileUpdate(UpdateUserRequest $request): RedirectResponse
    {
        try {
            $newProfile = $request->validated();

            // Cek jika ada file foto profil yang diupload
            if ($request->hasFile('profile_picture')) {
                // Hapus foto lama jika ada
                $oldPicture = auth()->user()->profile_picture;
                if ($oldPicture && str_contains($oldPicture, '/storage/avatars/')) {
                    $url = parse_url($oldPicture, PHP_URL_PATH); // Dapatkan path relatif
                    Storage::delete(str_replace('/storage', 'public', $url)); // Hapus dari storage
                }

                // Upload foto baru
                $file = $request->file('profile_picture');
                $filename = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();

                // Simpan ke storage/app/public/avatars
                $file->storeAs('public/avatars', $filename);

                // Simpan URL agar bisa digunakan di view
                $newProfile['profile_picture'] = asset('storage/avatars/' . $filename);
            }

            // Update data user
            auth()->user()->update($newProfile);

            return back()->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function passwordUpdate(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'current_password' => ['required', 'current_password'],
                'new_password' => ['required', 'confirmed', 'min:8'], // minimal 8 karakter
            ]);

            $user = auth()->user();

            // Update password
            $user->update([
                'password' => Hash::make($request->new_password), // Enkripsi password baru
            ]);

            return back()->with('success', __('Password Berhasil dirubah'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
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
