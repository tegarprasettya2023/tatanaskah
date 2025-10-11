<?php

namespace App\Http\Controllers\PersonalLetter;

use App\Models\PersonalLetterPerintah;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class SuratPerintahController extends BasePersonalLetterController
{
    public function create()
    {
        return view('pages.transaction.personal.templates.suratperintah.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'template_type' => 'required|string',
            'kop_type' => 'required|string',
            'nomor' => 'required|string|max:255',
            'letter_date' => 'required|date',
            'tempat' => 'required|string|max:255',
            'menimbang_1' => 'required|string',
            'menimbang_2' => 'required|string',
            'dasar_a' => 'required|string',
            'dasar_b' => 'required|string',
            'nama_penerima' => 'required|string|max:255',
            'nik_penerima' => 'required|string|max:255',
            'jabatan_penerima' => 'required|string|max:255',
            'nama_nama_terlampir' => 'nullable|string',
            'untuk_1' => 'required|string',
            'untuk_2' => 'required|string',
            'tembusan_1' => 'nullable|string',
            'tembusan_2' => 'nullable|string',
            'jabatan_pembuat' => 'required|string|max:255',
            'nama_pembuat' => 'required|string|max:255',
            'nik_pembuat' => 'required|string|max:255',
            'lampiran' => 'nullable|array',
        'lampiran.*.nama' => 'required_with:lampiran|string|max:255',
        'lampiran.*.nik' => 'required_with:lampiran|string|max:255',
        'lampiran.*.jabatan' => 'nullable|string|max:255',
        'lampiran.*.keterangan' => 'nullable|string|max:255',
        ]);

        $letter = PersonalLetterPerintah::create($validated);

        return redirect()->route('transaction.personal.surat_perintah.show', $letter->id)
            ->with('success', 'Surat perintah berhasil dibuat!');
    }

    public function show($id)
    {
        $data = PersonalLetterPerintah::findOrFail($id);
        return view('pages.transaction.personal.templates.suratperintah.show', compact('data'));
    }

    public function edit($id)
    {
        $data = PersonalLetterPerintah::findOrFail($id);
        return view('pages.transaction.personal.templates.suratperintah.edit', compact('data'));
    }

    public function update(Request $request, $id)
{
    $letter = PersonalLetterPerintah::findOrFail($id);

    $validated = $request->validate([
        'template_type' => 'required|string',
        'kop_type' => 'required|string',
        'nomor' => 'required|string|max:255',
        'letter_date' => 'required|date',
        'tempat' => 'required|string|max:255',
        'menimbang_1' => 'required|string',
        'menimbang_2' => 'required|string',
        'dasar_a' => 'required|string',
        'dasar_b' => 'required|string',
        'nama_penerima' => 'required|string|max:255',
        'nik_penerima' => 'required|string|max:255',
        'jabatan_penerima' => 'required|string|max:255',
        'nama_nama_terlampir' => 'nullable|string',
        'untuk_1' => 'required|string',
        'untuk_2' => 'required|string',
        'tembusan_1' => 'nullable|string',
        'tembusan_2' => 'nullable|string',
        'jabatan_pembuat' => 'required|string|max:255',
        'nama_pembuat' => 'required|string|max:255',
        'nik_pembuat' => 'required|string|max:255',
        'lampiran' => 'nullable|array',
        'lampiran.*.nama' => 'required_with:lampiran|string|max:255',
        'lampiran.*.nik' => 'required_with:lampiran|string|max:255',
        'lampiran.*.jabatan' => 'nullable|string|max:255',
        'lampiran.*.keterangan' => 'nullable|string|max:255',
    ]);

    $letter->update($validated);

    // reset file lama kalau ada
    if ($letter->generated_file) {
        Storage::delete('public/personal_letters/' . $letter->generated_file);
        $letter->update(['generated_file' => null]);
    }

    return redirect()->route('transaction.personal.surat_perintah.show', $letter->id)
        ->with('success', 'Surat perintah berhasil diperbarui!');
}


    public function destroy($id)
    {
        $letter = PersonalLetterPerintah::findOrFail($id);

        if ($letter->generated_file) {
            Storage::delete('public/personal_letters/' . $letter->generated_file);
        }

        $letter->delete();

        return redirect()->route('transaction.personal.index')
            ->with('success', 'Surat berhasil dihapus!');
    }

    public function preview($id)
    {
        $letter = PersonalLetterPerintah::findOrFail($id);

        $pdf = Pdf::loadView('pages.pdf.personal.surat_perintah', compact('letter'))
                  ->setPaper('A4', 'portrait')
                  ->setOptions([
                      'isHtml5ParserEnabled' => true,
                      'isPhpEnabled' => true,
                      'defaultFont' => 'DejaVu Sans',
                  ]);

        return $pdf->stream('Preview_Surat_Perintah.pdf');
    }

    public function download($id)
    {
        $letter = PersonalLetterPerintah::findOrFail($id);

        $pdf = Pdf::loadView('pages.pdf.personal.surat_perintah', compact('letter'))
                  ->setPaper('A4', 'portrait')
                  ->setOptions([
                      'isHtml5ParserEnabled' => true,
                      'isPhpEnabled' => true,
                      'defaultFont' => 'DejaVu Sans',
                  ]);

        $filename = 'Surat_Perintah_' . 
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