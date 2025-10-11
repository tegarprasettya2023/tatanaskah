<?php

namespace App\Http\Controllers\PersonalLetter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PersonalLetter;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PerjanjianKerjasamaController extends Controller
{
    public function index(Request $request)
    {
        $query = PersonalLetter::query();

        if ($request->filled('template_type')) {
            $query->where('template_type', $request->template_type);
        }

        if ($request->filled('kop_type')) {
            $query->where('kop_type', $request->kop_type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor', 'like', "%{$search}%")
                  ->orWhere('pihak1', 'like', "%{$search}%")
                  ->orWhere('pihak2', 'like', "%{$search}%")
                  ->orWhere('tentang', 'like', "%{$search}%");
            });
        }

        $data = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('pages.transaction.personal.index', compact('data'));
    }

        public function preview($id)
{
    $letter = PersonalLetter::findOrFail($id);

    $pdf = Pdf::loadView('pages.pdf.personal.perjanjian_kerjasama', compact('letter'))
              ->setPaper('A4', 'portrait')
              ->setOptions([
                  'isHtml5ParserEnabled' => true,
                  'isPhpEnabled' => true,
                  'defaultFont' => 'DejaVu Sans',
              ]);

    // Stream (preview) instead of download
    return $pdf->stream('Preview_Surat.pdf');
}
    public function create($template)
{
    if ($template === 'perjanjian_kerjasama') {
        return view('pages.transaction.personal.templates.perjanjian_kerjasama.create');
    }

    abort(404, 'Template tidak ditemukan');
}


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'template_type' => 'required|string',
            'kop_type' => 'required|string',
            'nomor' => 'required|string|max:255',
            'letter_date' => 'required|date',
            'tempat' => 'required|string|max:255',
            'pihak1' => 'required|string|max:255',
            'pihak2' => 'required|string|max:255',
            'tentang' => 'required|string',
            'institusi1' => 'required|string|max:255',
            'jabatan1' => 'required|string|max:255',
            'nama1' => 'required|string|max:255',
            'institusi2' => 'required|string|max:255',
            'jabatan2' => 'required|string|max:255',
            'nama2' => 'required|string|max:255',
            'pasal' => 'required|array|min:1',
            'pasal.*.title' => 'nullable|string',
            'pasal.*.content' => 'required|string',
        ]);

        $validatedData['pasal_data'] = $validatedData['pasal'];
        unset($validatedData['pasal']);

        $letter = PersonalLetter::create($validatedData);

        return redirect()->route('transaction.personal.perjanjian.show', $letter->id)
            ->with('success', 'Surat perjanjian kerja sama berhasil dibuat!');
    }

    public function show($id)
    {
        $data = PersonalLetter::findOrFail($id);
        return view('pages.transaction.personal.templates.perjanjian_kerjasama.show', compact('data'));
    }

    public function edit($id)
    {
        $data = PersonalLetter::findOrFail($id);
        return view('pages.transaction.personal.templates.perjanjian_kerjasama.edit', compact('data'));
    }


    public function update(Request $request, $id)
    {
        $letter = PersonalLetter::findOrFail($id);

        $validatedData = $request->validate([
            'template_type' => 'required|string',
            'kop_type' => 'required|string',
            'nomor' => 'required|string|max:255',
            'letter_date' => 'required|date',
            'tempat' => 'required|string|max:255',
            'pihak1' => 'required|string|max:255',
            'pihak2' => 'required|string|max:255',
            'tentang' => 'required|string',
            'institusi1' => 'required|string|max:255',
            'jabatan1' => 'required|string|max:255',
            'nama1' => 'required|string|max:255',
            'institusi2' => 'required|string|max:255',
            'jabatan2' => 'required|string|max:255',
            'nama2' => 'required|string|max:255',
            'pasal' => 'required|array|min:1',
            'pasal.*.title' => 'nullable|string',
            'pasal.*.content' => 'required|string',
        ]);

        $validatedData['pasal_data'] = $validatedData['pasal'];
        unset($validatedData['pasal']);

        $letter->update($validatedData);

        if ($letter->generated_file) {
            Storage::delete('personal_letters/' . $letter->generated_file);
            $letter->update(['generated_file' => null]);
        }

        return redirect()->route('transaction.personal.perjanjian.show', $letter->id)
            ->with('success', 'Surat perjanjian kerja sama berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $letter = PersonalLetter::findOrFail($id);

        if ($letter->generated_file) {
            Storage::delete('personal_letters/' . $letter->generated_file);
        }

        $letter->delete();

        return redirect()->route('transaction.personal.perjanjian.index')
            ->with('success', 'Surat berhasil dihapus!');
    }

    public function download($id)
    {
        $letter = PersonalLetter::findOrFail($id);

        $pdf = Pdf::loadView('pages.pdf.personal.perjanjian_kerjasama', compact('letter'))
                  ->setPaper('A4', 'portrait')
                  ->setOptions([
                      'isHtml5ParserEnabled' => true,
                      'isPhpEnabled' => true,
                      'defaultFont' => 'DejaVu Sans',
                      'margin_top' => 15,
                      'margin_right' => 15,
                      'margin_bottom' => 15,
                      'margin_left' => 15,
                  ]);

        $filename = 'Perjanjian_Kerja_Sama_' . 
                   str_replace(['/', ' '], ['_', '_'], $letter->nomor) . 
                   '_' . now()->format('Y_m_d') . '.pdf';

        if (!$letter->generated_file) {
            $pdfContent = $pdf->output();
            Storage::put('public/personal_letters/' . $filename, $pdfContent);
            $letter->update(['generated_file' => $filename]);
        }

        return $pdf->download($filename);
    }

    public function templates()
    {
        return view('pages.transaction.personal.templates');
    }
}
