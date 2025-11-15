<?php

namespace App\Http\Controllers\PersonalLetter;

use App\Http\Controllers\Controller;
use App\Models\PersonalLetterMemo;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class SuratMemoController extends Controller
{
    public function index(Request $request)
    {
        $query = PersonalLetterMemo::with('user')->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor', 'like', "%{$search}%")
                  ->orWhere('hal', 'like', "%{$search}%")
                  ->orWhere('yth_nama', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('letter_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('letter_date', '<=', $request->date_to);
        }

        $data = $query->paginate(10)->withQueryString();

        $totalCount = PersonalLetterMemo::count();
        $monthlyCount = PersonalLetterMemo::whereMonth('created_at', date('m'))->count();
        $weeklyCount = PersonalLetterMemo::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count();
        $todayCount = PersonalLetterMemo::whereDate('created_at', today())->count();

        $title = 'Internal Memo';
        $icon = 'bx-message-square-dots';
        $createRoute = route('transaction.personal.memo.create');
        $previewRoute = 'transaction.personal.memo.preview';
        $downloadRoute = 'transaction.personal.memo.download';
        $editRoute = 'transaction.personal.memo.edit';
        $deleteRoute = 'transaction.personal.memo.destroy';

        return view('pages.transaction.personal.template-index', compact(
            'data', 'title', 'icon', 'totalCount', 'monthlyCount', 
            'weeklyCount', 'todayCount', 'createRoute', 'previewRoute', 
            'downloadRoute', 'editRoute', 'deleteRoute'
        ));
    }

    public function create()
    {
        return view('pages.transaction.personal.templates.memo.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'template_type' => 'required|string',
            'kop_type' => 'required|string',
            'letter_date' => 'required|date',
            'tempat_ttd' => 'required|string|max:255',
            'yth_nama' => 'required|string|max:255',
            'hal' => 'required|string|max:255',
            'sehubungan_dengan' => 'required|string',
            'alinea_isi' => 'required|string',
            'isi_penutup' => 'nullable|string',
            'jabatan_pembuat' => 'required|string|max:255',
            'nama_pembuat' => 'required|string|max:255',
            'nik_pembuat' => 'required|string|max:255',
            'tembusan_1' => 'nullable|string',
            'tembusan_2' => 'nullable|string',
        ]);

        // Generate nomor otomatis
        $nomorData = PersonalLetterMemo::generateNomor($validated['letter_date']);
        $validated['nomor'] = $nomorData['nomor'];
        $validated['nomor_urut'] = $nomorData['nomor_urut'];
        $validated['user_id'] = auth()->id();

        // Default isi penutup
        if (empty($validated['isi_penutup'])) {
            $validated['isi_penutup'] = 'Atas perhatian dan perkenan Bapak/Ibu/Saudara/I, kami mengucapkan terima kasih.';
        }

        $letter = PersonalLetterMemo::create($validated);

        return redirect()->route('transaction.personal.memo.show', $letter->id)
            ->with('success', 'Internal memo berhasil dibuat dengan nomor: ' . $letter->nomor);
    }

    public function show($id)
    {
        $data = PersonalLetterMemo::findOrFail($id);
        return view('pages.transaction.personal.templates.memo.show', compact('data'));
    }

    public function edit($id)
    {
        $data = PersonalLetterMemo::findOrFail($id);
        return view('pages.transaction.personal.templates.memo.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $letter = PersonalLetterMemo::findOrFail($id);

        $validated = $request->validate([
            'template_type' => 'required|string',
            'kop_type' => 'required|string',
            'letter_date' => 'required|date',
            'tempat_ttd' => 'required|string|max:255',
            'yth_nama' => 'required|string|max:255',
            'hal' => 'required|string|max:255',
            'sehubungan_dengan' => 'required|string',
            'alinea_isi' => 'required|string',
            'isi_penutup' => 'nullable|string',
            'jabatan_pembuat' => 'required|string|max:255',
            'nama_pembuat' => 'required|string|max:255',
            'nik_pembuat' => 'required|string|max:255',
            'tembusan_1' => 'nullable|string',
            'tembusan_2' => 'nullable|string',
        ]);

        // Regenerate nomor jika bulan/tahun berubah
        if ($letter->letter_date->format('Y-m') !== date('Y-m', strtotime($validated['letter_date']))) {
            $nomorData = PersonalLetterMemo::generateNomor($validated['letter_date']);
            $validated['nomor'] = $nomorData['nomor'];
            $validated['nomor_urut'] = $nomorData['nomor_urut'];
        }

        $letter->update($validated);

        if ($letter->generated_file) {
            Storage::delete('public/personal_letters/' . $letter->generated_file);
            $letter->update(['generated_file' => null]);
        }

        return redirect()->route('transaction.personal.memo.show', $letter->id)
            ->with('success', 'Internal memo berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $letter = PersonalLetterMemo::findOrFail($id);

        if ($letter->generated_file) {
            Storage::delete('public/personal_letters/' . $letter->generated_file);
        }

        $letter->delete();

        return redirect()->route('transaction.personal.memo.index')
            ->with('success', 'Surat berhasil dihapus!');
    }

    public function preview($id)
    {
        $letter = PersonalLetterMemo::findOrFail($id);

        $pdf = Pdf::loadView('pages.pdf.personal.internal_memo', compact('letter'))
                  ->setPaper('A4', 'portrait')
                  ->setOptions([
                      'isHtml5ParserEnabled' => true,
                      'isPhpEnabled' => true,
                      'defaultFont' => 'DejaVu Sans',
                  ]);

        return $pdf->stream('Preview_Internal_Memo.pdf');
    }

    public function download($id)
    {
        $letter = PersonalLetterMemo::findOrFail($id);

        $pdf = Pdf::loadView('pages.pdf.personal.internal_memo', compact('letter'))
                  ->setPaper('A4', 'portrait')
                  ->setOptions([
                      'isHtml5ParserEnabled' => true,
                      'isPhpEnabled' => true,
                      'defaultFont' => 'DejaVu Sans',
                  ]);

        $filename = 'Internal_Memo_' . 
                   str_replace(['/', ' '], ['_', '_'], $letter->nomor) . 
                   '_' . now()->format('Y_m_d') . '.pdf';

        if (!$letter->generated_file) {
            $pdfContent = $pdf->output();
            Storage::put('public/personal_letters/' . $filename, $pdfContent);
            $letter->update(['generated_file' => $filename]);
        }

        return $pdf->download($filename);
    }
}