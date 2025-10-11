<?php

namespace App\Http\Controllers;

use App\Enums\LetterType;
use App\Http\Requests\StoreLetterRequest;
use App\Http\Requests\UpdateLetterRequest;
use App\Models\Attachment;
use App\Models\Classification;
use App\Models\Config;
use App\Models\Letter;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class IncomingLetterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        return view('pages.transaction.incoming.index', [
            'data' => Letter::incoming()->render($request->search),
            'search' => $request->search,
        ]);
    }

    /**
     * Display a listing of the incoming letter agenda.
     *
     * @param Request $request
     * @return View
     */
    public function agenda(Request $request): View
    {
        $letters = Letter::incoming()->agenda($request->since, $request->until, $request->filter)->render($request->search);

        return view('pages.transaction.incoming.agenda', [
            'data' => $letters,
            'search' => $request->search,
            'since' => $request->since,
            'until' => $request->until,
            'filter' => $request->filter,
            'query' => $request->getQueryString(),
            'totalDisetujui' => $letters->where('validation', 'Disetujui')->count(), 
        ]);
    }


    /**
     * @param Request $request
     * @return View
     */
    public function print(Request $request): View
    {
        $agenda = __('menu.agenda.menu');
        $letter = __('menu.agenda.incoming_letter');
        $title = App::getLocale() == 'id' ? "$agenda $letter" : "$letter $agenda";
        return view('pages.transaction.incoming.print', [
            'data' => Letter::incoming()->agenda($request->since, $request->until, $request->filter)->get(),
            'search' => $request->search,
            'since' => $request->since,
            'until' => $request->until,
            'filter' => $request->filter,
            'config' => Config::pluck('value', 'code')->toArray(),
            'title' => $title,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $year = now()->year;

        $letters = Letter::whereYear('created_at', $year)->get();

        $lastSequence = 0;

        foreach ($letters as $letter) {
            if (preg_match('/^(\d{4})\/437\.84\.31\/PTGM\/' . $year . '$/', $letter->reference_number, $matches)) {
                $sequence = (int) $matches[1];

                if ($sequence > $lastSequence) {
                    $lastSequence = $sequence;
                }
            }
        }

        // Tambahkan 1 dari sequence terakhir
        $nextNumber = str_pad($lastSequence + 1, 4, '0', STR_PAD_LEFT);

        // Bangun format nomor surat
        $referenceNumber = "{$nextNumber}/437.84.31/PTGM/{$year}";

        return view('pages.transaction.incoming.create', [
            'classifications' => Classification::all(),
            'referenceNumber' => $referenceNumber,
        ]);
    }





    /**
     * Store a newly created resource in storage.
     *
     * @param StoreLetterRequest $request
     * @return RedirectResponse
     */
    public function store(StoreLetterRequest $request): RedirectResponse
    {
        try {
            $user = auth()->user();

            if ($request->type != LetterType::INCOMING->type()) {
                throw new \Exception(__('menu.transaction.incoming_letter'));
            }

            $newLetter = $request->validated();
            $newLetter['user_id'] = $user->id;
            $newLetter['validation'] = 'Belum Disetujui';

            $letter = Letter::create($newLetter);

            if ($request->hasFile('attachments')) {
                foreach ($request->attachments as $attachment) {
                    $extension = $attachment->getClientOriginalExtension();
                    if (!in_array($extension, ['png', 'jpg', 'jpeg', 'pdf'])) continue;

                    $filename = time() . '-' . $attachment->getClientOriginalName();
                    $filename = str_replace(' ', '-', $filename);
                    $attachment->storeAs('public/attachments', $filename);

                    Attachment::create([
                        'filename' => $filename,
                        'extension' => $extension,
                        'user_id' => $user->id,
                        'letter_id' => $letter->id,
                    ]);
                }
            }

            return redirect()
                ->route('transaction.incoming.index')
                ->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }


    /**
     * Display the specified resource.
     *
     * @param Letter $incoming
     * @return View
     */
    public function show(Letter $incoming): View
    {
        return view('pages.transaction.incoming.show', [
            'data' => $incoming->load(['classification', 'user', 'attachments']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Letter $incoming
     * @return View
     */
    public function edit(Letter $incoming): View
    {
        return view('pages.transaction.incoming.edit', [
            'data' => $incoming,
            'classifications' => Classification::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateLetterRequest $request
     * @param Letter $incoming
     * @return RedirectResponse
     */
   public function update(UpdateLetterRequest $request, Letter $incoming): RedirectResponse
{
    try {
        $incoming->update($request->validated());
        if ($request->hasFile('attachments')) {
            foreach ($request->attachments as $attachment) {
                $extension = $attachment->getClientOriginalExtension();
                if (!in_array($extension, ['png', 'jpg', 'jpeg', 'pdf'])) continue;
                $filename = time() . '-' . $attachment->getClientOriginalName();
                $filename = str_replace(' ', '-', $filename);
                $attachment->storeAs('public/attachments', $filename);
                Attachment::create([
                    'filename' => $filename,
                    'extension' => $extension,
                    'user_id' => auth()->user()->id,
                    'letter_id' => $incoming->id,
                ]);
            }
        }
        return redirect()
            ->route('transaction.incoming.index')
            ->with('success', __('menu.general.success'));
    } catch (\Throwable $exception) {
        return back()->with('error', $exception->getMessage());
    }
}

    /**
     * Remove the specified resource from storage.
     *
     * @param Letter $incoming
     * @return RedirectResponse
     */
    public function destroy(Letter $incoming): RedirectResponse
    {
        try {
            $incoming->delete();
            return redirect()
                ->route('transaction.incoming.index')
                ->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}
