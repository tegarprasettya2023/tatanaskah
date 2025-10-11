<?php

namespace App\Http\Controllers;

use App\Enums\LetterType;
use App\Http\Requests\StoreLetterRequest;
use App\Http\Requests\UpdateLetterRequest;
use App\Models\Attachment;
use App\Models\Classification;
use App\Models\Config;
use App\Models\Letter;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class OutgoingLetterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        return view('pages.transaction.outgoing.index', [
            'data' => Letter::outgoing()->render($request->search),
            'search' => $request->search,
        ]);
    }

    /**
     * Display a listing of the outgoing letter agenda.
     *
     * @param Request $request
     * @return View
     */
    public function agenda(Request $request): View
    {
        return view('pages.transaction.outgoing.agenda', [
            'data' => Letter::outgoing()->agenda($request->since, $request->until, $request->filter)->render($request->search),
            'search' => $request->search,
            'since' => $request->since,
            'until' => $request->until,
            'filter' => $request->filter,
            'query' => $request->getQueryString(),
        ]);
    }

    /**
     * @param Request $request
     * @return View
     */
    public function print(Request $request): View
    {
        $agenda = __('menu.agenda.menu');
        $letter = __('menu.agenda.outgoing_letter');
        $title = App::getLocale() == 'id' ? "$agenda $letter" : "$letter $agenda";
        return view('pages.transaction.outgoing.print', [
            'data' => Letter::outgoing()->agenda($request->since, $request->until, $request->filter)->get(),
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

        $nextNumber = str_pad($lastSequence + 1, 4, '0', STR_PAD_LEFT);

        // Bangun format nomor surat
        $referenceNumber = "{$nextNumber}/437.84.31/PTGM/{$year}";

        return view('pages.transaction.outgoing.create', [
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

            if ($request->type != LetterType::OUTGOING->type()) throw new \Exception(__('menu.transaction.outgoing_letter'));
            $newLetter = $request->validated();
            $newLetter['user_id'] = $user->id;
            $newLetter['validation'] = 'Belum Disetujui';
            $letter = Letter::create($newLetter);

            // Upload file attachments
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

            // Generate PDF letter
            $this->generateLetterPDF($letter);

            return redirect()
                ->route('transaction.outgoing.index')
                ->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Generate PDF for the letter and save it as an attachment
     *
     * @param Letter $letter
     * @return void
     */
    protected function generateLetterPDF(Letter $letter): void
    {
        // Get organization config
        $config = Config::pluck('value', 'code')->toArray();

        // Generate PDF
        $pdf = Pdf::loadView('pages.pdf.outgoing-letter', [
            'letter' => $letter->load('attachments'),
            'config' => $config
        ]);

        // Generate filename for the PDF
        $filename = 'letter-' . $letter->reference_number . '.pdf';
        $filename = str_replace(['/', '\\', ' '], '-', $filename);

        // Save the PDF to storage
        Storage::put('public/attachments/' . $filename, $pdf->output());

        // Create attachment record in database
        Attachment::create([
            'filename' => $filename,
            'extension' => 'pdf',
            'user_id' => auth()->id(),
            'letter_id' => $letter->id,
            'is_generated' => true, // Mark as auto-generated
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Letter $outgoing
     * @return View
     */
    public function show(Letter $outgoing): View
    {
        return view('pages.transaction.outgoing.show', [
            'data' => $outgoing->load(['classification', 'user', 'attachments']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Letter $outgoing
     * @return View
     */
    public function edit(Letter $outgoing): View
    {
        return view('pages.transaction.outgoing.edit', [
            'data' => $outgoing,
            'classifications' => Classification::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateLetterRequest $request
     * @param Letter $outgoing
     * @return RedirectResponse
     */
    public function update(UpdateLetterRequest $request, Letter $outgoing): RedirectResponse
    {
        try {
            $outgoing->update($request->validated());

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
                        'letter_id' => $outgoing->id,
                    ]);
                }
            }

            // Delete previous auto-generated PDF
            $previousPdf = $outgoing->attachments()->where('is_generated', true)->first();
            if ($previousPdf) {
                Storage::delete('public/attachments/' . $previousPdf->filename);
                $previousPdf->delete();
            }

            // Generate new PDF
            $this->generateLetterPDF($outgoing);

            return redirect()
                ->route('transaction.outgoing.index')
                ->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Letter $outgoing
     * @return RedirectResponse
     */
    public function destroy(Letter $outgoing): RedirectResponse
    {
        try {
            // Delete all attachments from storage
            foreach ($outgoing->attachments as $attachment) {
                Storage::delete('public/attachments/' . $attachment->filename);
            }

            $outgoing->delete();
            return redirect()
                ->route('transaction.outgoing.index')
                ->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }


}