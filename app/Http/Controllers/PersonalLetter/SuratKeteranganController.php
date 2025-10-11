<?php

namespace App\Http\Controllers\PersonalLetter;

use App\Models\PersonalLetterKeterangan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class SuratKeteranganController extends BasePersonalLetterController
{
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

        return redirect()->route('transaction.personal.index')
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