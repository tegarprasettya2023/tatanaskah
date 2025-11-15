<?php

namespace App\Http\Controllers\PersonalLetter;

use App\Http\Controllers\Controller;
use App\Models\PersonalLetterKeterangan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class SuratKeteranganController extends Controller
{
    public function index(Request $request)
    {
        $query = PersonalLetterKeterangan::with('user')->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor', 'like', "%{$search}%")
                  ->orWhere('nama_yang_diterangkan', 'like', "%{$search}%")
                  ->orWhere('nama_yang_menerangkan', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('letter_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('letter_date', '<=', $request->date_to);
        }

        $data = $query->paginate(10)->withQueryString();

        $totalCount = PersonalLetterKeterangan::count();
        $monthlyCount = PersonalLetterKeterangan::whereMonth('created_at', date('m'))->count();
        $weeklyCount = PersonalLetterKeterangan::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count();
        $todayCount = PersonalLetterKeterangan::whereDate('created_at', today())->count();

        $title = 'Surat Keterangan';
        $icon = 'bx-file-blank';
        $createRoute = route('transaction.personal.surat_keterangan.create');
        $previewRoute = 'transaction.personal.surat_keterangan.preview';
        $downloadRoute = 'transaction.personal.surat_keterangan.download';
        $editRoute = 'transaction.personal.surat_keterangan.edit';
        $deleteRoute = 'transaction.personal.surat_keterangan.destroy';

        return view('pages.transaction.personal.template-index', compact(
            'data', 'title', 'icon', 'totalCount', 'monthlyCount', 
            'weeklyCount', 'todayCount', 'createRoute', 'previewRoute', 
            'downloadRoute', 'editRoute', 'deleteRoute'
        ));
    }

    public function create()
    {
        return view('pages.transaction.personal.templates.suratketerangan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'template_type' => 'required|string',
            'kop_type' => 'required|string',
            'nomor' => 'required|string|max:255',
            'letter_date' => 'required|date',
            'tempat' => 'required|string|max:255',
            'nama_yang_menerangkan' => 'required|string|max:255',
            'nik_yang_menerangkan' => 'required|string|max:255',
            'jabatan_yang_menerangkan' => 'required|string|max:255',
            'nama_yang_diterangkan' => 'required|string|max:255',
            'nip_yang_diterangkan' => 'required|string|max:255',
            'jabatan_yang_diterangkan' => 'required|string|max:255',
            'isi_keterangan' => 'required|string',
            'jabatan_pembuat' => 'required|string|max:255',
            'nama_pembuat' => 'required|string|max:255',
            'nik_pembuat' => 'required|string|max:255',
        ]);

        $validated['user_id'] = auth()->id();
        $letter = PersonalLetterKeterangan::create($validated);

        return redirect()->route('transaction.personal.surat_keterangan.show', $letter->id)
            ->with('success', 'Surat keterangan berhasil dibuat!');
    }

    public function show($id)
    {
        $data = PersonalLetterKeterangan::findOrFail($id);
        return view('pages.transaction.personal.templates.suratketerangan.show', compact('data'));
    }

    public function edit($id)
    {
        $data = PersonalLetterKeterangan::findOrFail($id);
        return view('pages.transaction.personal.templates.suratketerangan.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $letter = PersonalLetterKeterangan::findOrFail($id);

        $validated = $request->validate([
            'template_type' => 'required|string',
            'kop_type' => 'required|string',
            'nomor' => 'required|string|max:255',
            'letter_date' => 'required|date',
            'tempat' => 'required|string|max:255',
            'nama_yang_menerangkan' => 'required|string|max:255',
            'nik_yang_menerangkan' => 'required|string|max:255',
            'jabatan_yang_menerangkan' => 'required|string|max:255',
            'nama_yang_diterangkan' => 'required|string|max:255',
            'nip_yang_diterangkan' => 'required|string|max:255',
            'jabatan_yang_diterangkan' => 'required|string|max:255',
            'isi_keterangan' => 'required|string',
            'jabatan_pembuat' => 'required|string|max:255',
            'nama_pembuat' => 'required|string|max:255',
            'nik_pembuat' => 'required|string|max:255',
        ]);

        $letter->update($validated);

        if ($letter->generated_file) {
            Storage::delete('public/personal_letters/' . $letter->generated_file);
            $letter->update(['generated_file' => null]);
        }

        return redirect()->route('transaction.personal.surat_keterangan.show', $letter->id)
            ->with('success', 'Surat keterangan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $letter = PersonalLetterKeterangan::findOrFail($id);

        if ($letter->generated_file) {
            Storage::delete('public/personal_letters/' . $letter->generated_file);
        }

        $letter->delete();

        return redirect()->route('transaction.personal.surat_keterangan.index')
            ->with('success', 'Surat berhasil dihapus!');
    }

    public function preview($id)
    {
        $letter = PersonalLetterKeterangan::findOrFail($id);

        $pdf = Pdf::loadView('pages.pdf.personal.surat_keterangan', compact('letter'))
                  ->setPaper('A4', 'portrait')
                  ->setOptions([
                      'isHtml5ParserEnabled' => true,
                      'isPhpEnabled' => true,
                      'defaultFont' => 'DejaVu Sans',
                  ]);

        return $pdf->stream('Preview_Surat_Keterangan.pdf');
    }

    public function download($id)
    {
        $letter = PersonalLetterKeterangan::findOrFail($id);

        $pdf = Pdf::loadView('pages.pdf.personal.surat_keterangan', compact('letter'))
                  ->setPaper('A4', 'portrait')
                  ->setOptions([
                      'isHtml5ParserEnabled' => true,
                      'isPhpEnabled' => true,
                      'defaultFont' => 'DejaVu Sans',
                  ]);

        $filename = 'Surat_Keterangan_' . 
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