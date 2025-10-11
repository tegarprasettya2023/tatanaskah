<?php

namespace App\Http\Controllers\PersonalLetter;

use App\Models\PersonalLetterBeritaAcara;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class SuratBeritaAcaraController extends BasePersonalLetterController
{
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
            ->route('transaction.personal.index')
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