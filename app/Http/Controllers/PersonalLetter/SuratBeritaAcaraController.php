<?php

namespace App\Http\Controllers\PersonalLetter;

use App\Http\Controllers\Controller;
use App\Models\PersonalLetterBeritaAcara;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class SuratBeritaAcaraController extends Controller
{
    public function index(Request $request)
    {
        $query = PersonalLetterBeritaAcara::with('user')->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor', 'like', "%{$search}%")
                  ->orWhere('nama_pihak_pertama', 'like', "%{$search}%")
                  ->orWhere('pihak_kedua', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('tanggal_acara', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('tanggal_acara', '<=', $request->date_to);
        }

        $data = $query->paginate(10)->withQueryString();

        $totalCount = PersonalLetterBeritaAcara::count();
        $monthlyCount = PersonalLetterBeritaAcara::whereMonth('created_at', date('m'))->count();
        $weeklyCount = PersonalLetterBeritaAcara::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count();
        $todayCount = PersonalLetterBeritaAcara::whereDate('created_at', today())->count();

        $title = 'Berita Acara';
        $icon = 'bx-file-find';
        $createRoute = route('transaction.personal.beritaacara.create');
        $previewRoute = 'transaction.personal.beritaacara.preview';
        $downloadRoute = 'transaction.personal.beritaacara.download';
        $editRoute = 'transaction.personal.beritaacara.edit';
        $deleteRoute = 'transaction.personal.beritaacara.destroy';

        return view('pages.transaction.personal.template-index', compact(
            'data', 'title', 'icon', 'totalCount', 'monthlyCount', 
            'weeklyCount', 'todayCount', 'createRoute', 'previewRoute', 
            'downloadRoute', 'editRoute', 'deleteRoute'
        ));
    }

    public function create()
    {
        return view('pages.transaction.personal.templates.beritaacara.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kop_type' => 'required|in:klinik,lab,pt',
            'nomor' => 'required|string|max:255',
            'tanggal_acara' => 'required|date',
            'nama_pihak_pertama' => 'required|string|max:255',
            'nip_pihak_pertama' => 'required|string|max:255',
            'jabatan_pihak_pertama' => 'required|string|max:255',
            'pihak_kedua' => 'required|string|max:255',
            'nik_pihak_kedua' => 'nullable|string|max:255',
            'telah_melaksanakan' => 'required|string',
            'kegiatan' => 'required|array',
            'kegiatan.*' => 'required|string',
            'dibuat_berdasarkan' => 'required|string',
            'tempat_ttd' => 'required|string|max:255',
            'tanggal_ttd' => 'required|date',
            'nama_mengetahui' => 'required|string|max:255',
            'jabatan_mengetahui' => 'required|string|max:255',
            'nik_mengetahui' => 'nullable|string|max:255',
        ]);

        $validated['user_id'] = auth()->id();
        $letter = PersonalLetterBeritaAcara::create($validated);

        return redirect()
            ->route('transaction.personal.beritaacara.show', $letter->id)
            ->with('success', 'Berita Acara berhasil dibuat!');
    }

    public function show($id)
    {
        $data = PersonalLetterBeritaAcara::findOrFail($id);
        return view('pages.transaction.personal.templates.beritaacara.show', compact('data'));
    }

    public function edit($id)
    {
        $data = PersonalLetterBeritaAcara::findOrFail($id);
        return view('pages.transaction.personal.templates.beritaacara.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $letter = PersonalLetterBeritaAcara::findOrFail($id);

        $validated = $request->validate([
            'kop_type' => 'required|in:klinik,lab,pt',
            'nomor' => 'required|string|max:255',
            'tanggal_acara' => 'required|date',
            'nama_pihak_pertama' => 'required|string|max:255',
            'nip_pihak_pertama' => 'required|string|max:255',
            'jabatan_pihak_pertama' => 'required|string|max:255',
            'pihak_kedua' => 'required|string|max:255',
            'nik_pihak_kedua' => 'nullable|string|max:255',
            'telah_melaksanakan' => 'required|string',
            'kegiatan' => 'required|array',
            'kegiatan.*' => 'required|string',
            'dibuat_berdasarkan' => 'required|string',
            'tempat_ttd' => 'required|string|max:255',
            'tanggal_ttd' => 'required|date',
            'nama_mengetahui' => 'required|string|max:255',
            'jabatan_mengetahui' => 'required|string|max:255',
            'nik_mengetahui' => 'nullable|string|max:255',
        ]);

        $letter->update($validated);

        if ($letter->generated_file) {
            Storage::delete('public/personal_letters/' . $letter->generated_file);
            $letter->update(['generated_file' => null]);
        }

        return redirect()
            ->route('transaction.personal.beritaacara.show', $letter->id)
            ->with('success', 'Berita Acara berhasil diupdate!');
    }

    public function destroy($id)
    {
        $letter = PersonalLetterBeritaAcara::findOrFail($id);

        if ($letter->generated_file) {
            Storage::delete('public/personal_letters/' . $letter->generated_file);
        }

        $letter->delete();

        return redirect()
            ->route('transaction.personal.beritaacara.index')
            ->with('success', 'Berita Acara berhasil dihapus!');
    }

    public function preview($id)
    {
        $letter = PersonalLetterBeritaAcara::findOrFail($id);

        $pdf = Pdf::loadView('pages.pdf.personal.berita_acara', compact('letter'))
                  ->setPaper('A4', 'portrait')
                  ->setOptions([
                      'isHtml5ParserEnabled' => true,
                      'isPhpEnabled' => true,
                      'defaultFont' => 'DejaVu Sans',
                  ]);

        return $pdf->stream('Preview_Berita_Acara.pdf');
    }

    public function download($id)
    {
        $letter = PersonalLetterBeritaAcara::findOrFail($id);

        $pdf = Pdf::loadView('pages.pdf.personal.berita_acara', compact('letter'))
                  ->setPaper('A4', 'portrait')
                  ->setOptions([
                      'isHtml5ParserEnabled' => true,
                      'isPhpEnabled' => true,
                      'defaultFont' => 'DejaVu Sans',
                  ]);

        $filename = 'Berita_Acara_' . 
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