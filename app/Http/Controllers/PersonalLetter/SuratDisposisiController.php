<?php

namespace App\Http\Controllers\PersonalLetter;

use App\Http\Controllers\Controller;
use App\Models\PersonalLetterDisposisi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class SuratDisposisiController extends Controller
{
    public function index(Request $request)
    {
        $query = PersonalLetterDisposisi::with('user')->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_dokumen', 'like', "%{$search}%")
                  ->orWhere('perihal', 'like', "%{$search}%")
                  ->orWhere('bagian_pembuat', 'like', "%{$search}%")
                  ->orWhere('kepada', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('tanggal_pembuatan', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('tanggal_pembuatan', '<=', $request->date_to);
        }

        $data = $query->paginate(10)->withQueryString();

        $totalCount = PersonalLetterDisposisi::count();
        $monthlyCount = PersonalLetterDisposisi::whereMonth('created_at', date('m'))->count();
        $weeklyCount = PersonalLetterDisposisi::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count();
        $todayCount = PersonalLetterDisposisi::whereDate('created_at', today())->count();

        $title = 'Formulir Disposisi';
        $icon = 'bx-transfer';
        $createRoute = route('transaction.personal.suratdisposisi.create');
        $previewRoute = 'transaction.personal.suratdisposisi.preview';
        $downloadRoute = 'transaction.personal.suratdisposisi.download';
        $editRoute = 'transaction.personal.suratdisposisi.edit';
        $deleteRoute = 'transaction.personal.suratdisposisi.destroy';

        return view('pages.transaction.personal.template-index', compact(
            'data', 'title', 'icon', 'totalCount', 'monthlyCount', 
            'weeklyCount', 'todayCount', 'createRoute', 'previewRoute', 
            'downloadRoute', 'editRoute', 'deleteRoute'
        ));
    }

    public function create()
    {
        return view('pages.transaction.personal.templates.suratdisposisi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kop_type' => 'required|in:klinik,lab,pt',
            'logo_type' => 'required|in:klinik,lab,pt',
            'nomor' => 'nullable|string',
            'no_revisi' => 'nullable|string',
            'halaman_dari' => 'nullable|integer',
            'bagian_pembuat' => 'nullable|string',
            'nomor_tanggal' => 'nullable|string',
            'perihal' => 'nullable|string',
            'kepada' => 'nullable|string',
            'ringkasan_isi' => 'nullable|string',
            'instruksi_1' => 'nullable|string',
            'tanggal_pembuatan' => 'nullable|date',
            'no_agenda' => 'nullable|string',
            'signature' => 'nullable|string',
            'diteruskan_kepada' => 'nullable|array',
            'tanggal_diserahkan' => 'nullable|date',
            'tanggal_kembali' => 'nullable|date',
            'instruksi_2' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();
        $letter = PersonalLetterDisposisi::create($validated);

        return redirect()->route('transaction.personal.suratdisposisi.show', $letter->id)
            ->with('success', 'Formulir Disposisi berhasil dibuat!');
    }

    public function show($id)
    {
        $data = PersonalLetterDisposisi::findOrFail($id);
        return view('pages.transaction.personal.templates.suratdisposisi.show', compact('data'));
    }

    public function edit($id)
    {
        $data = PersonalLetterDisposisi::findOrFail($id);
        return view('pages.transaction.personal.templates.suratdisposisi.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $letter = PersonalLetterDisposisi::findOrFail($id);

        $validated = $request->validate([
            'kop_type' => 'required|in:klinik,lab,pt',
            'logo_type' => 'required|in:klinik,lab,pt',
            'nomor' => 'nullable|string',
            'no_revisi' => 'nullable|string',
            'halaman_dari' => 'nullable|integer',
            'bagian_pembuat' => 'nullable|string',
            'nomor_tanggal' => 'nullable|string',
            'perihal' => 'nullable|string',
            'kepada' => 'nullable|string',
            'ringkasan_isi' => 'nullable|string',
            'instruksi_1' => 'nullable|string',
            'tanggal_pembuatan' => 'nullable|date',
            'no_agenda' => 'nullable|string',
            'signature' => 'nullable|string',
            'diteruskan_kepada' => 'nullable|array',
            'tanggal_diserahkan' => 'nullable|date',
            'tanggal_kembali' => 'nullable|date',
            'instruksi_2' => 'nullable|string',
        ]);

        $letter->update($validated);

        if ($letter->generated_file) {
            Storage::delete('public/personal_letters/' . $letter->generated_file);
            $letter->update(['generated_file' => null]);
        }

        return redirect()->route('transaction.personal.suratdisposisi.show', $letter->id)
            ->with('success', 'Formulir Disposisi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $letter = PersonalLetterDisposisi::findOrFail($id);
        
        if ($letter->generated_file) {
            Storage::delete('public/personal_letters/' . $letter->generated_file);
        }

        $letter->delete();

        return redirect()->route('transaction.personal.suratdisposisi.index')
            ->with('success', 'Formulir Disposisi berhasil dihapus!');
    }

    public function preview($id)
    {
        $letter = PersonalLetterDisposisi::findOrFail($id);

        $pdf = Pdf::loadView('pages.pdf.personal.surat_disposisi', compact('letter'))
                  ->setPaper('A4', 'portrait')
                  ->setOptions([
                      'isHtml5ParserEnabled' => true,
                      'isPhpEnabled' => true,
                      'defaultFont' => 'DejaVu Sans',
                  ]);

        return $pdf->stream('Preview_Formulir_Disposisi.pdf');
    }

    public function download($id)
    {
        $letter = PersonalLetterDisposisi::findOrFail($id);

        $pdf = Pdf::loadView('pages.pdf.personal.surat_disposisi', compact('letter'))
                  ->setPaper('A4', 'portrait')
                  ->setOptions([
                      'isHtml5ParserEnabled' => true,
                      'isPhpEnabled' => true,
                      'defaultFont' => 'DejaVu Sans',
                  ]);

        $filename = 'Formulir_Disposisi_' .
                    str_replace(['/', ' ', '\\'], ['_', '_', '_'], $letter->nomor?? 'Draft') .
                    '_' . now()->format('Y_m_d') . '.pdf';

        if (!$letter->generated_file) {
            $pdfContent = $pdf->output();
            Storage::put('public/personal_letters/' . $filename, $pdfContent);
            $letter->update(['generated_file' => $filename]);
        }

        return $pdf->download($filename);
    }
}