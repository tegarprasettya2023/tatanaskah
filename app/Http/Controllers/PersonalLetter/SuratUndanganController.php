<?php

namespace App\Http\Controllers\PersonalLetter;

use App\Models\PersonalLetterUndangan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class SuratUndanganController extends BasePersonalLetterController
{
    public function create()
    {
        return view('pages.transaction.personal.templates.suratundangan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'template_type' => 'required|string',
            'kop_type' => 'required|string',
            'nomor' => 'required|string|max:255',
            'sifat' => 'nullable|string|max:255',
            'lampiran' => 'nullable|string|max:255',
            'perihal' => 'required|string|max:255',
            'yth_nama' => 'required|string|max:255',
            'yth_alamat' => 'required|string',
            'isi_pembuka' => 'required|string',
            'hari_tanggal' => 'required|date',
            'pukul' => 'required|string|max:255',
            'tempat_acara' => 'required|string|max:255',   
            'acara' => 'required|string|max:255',
            'tempat_ttd' => 'required|string|max:255',    
            'tanggal_ttd' => 'required|date',   
            'jabatan_pembuat' => 'required|string|max:255',
            'nama_pembuat' => 'required|string|max:255',
            'tembusan_1' => 'nullable|string',
            'tembusan_2' => 'nullable|string',
            'daftar_undangan' => 'nullable|array',
            'daftar_undangan.*.nama' => 'required_with:daftar_undangan|string|max:255',
            'daftar_undangan.*.jabatan' => 'nullable|string|max:255',
            'daftar_undangan.*.unit_kerja' => 'nullable|string|max:255',
            
        ]);

        $letter = PersonalLetterUndangan::create($validated);

        return redirect()->route('transaction.personal.surat_undangan.show', $letter->id)
            ->with('success', 'Surat undangan berhasil dibuat!');
    }

    public function show($id)
    {
        $data = PersonalLetterUndangan::findOrFail($id);
        return view('pages.transaction.personal.templates.suratundangan.show', compact('data'));
    }

    public function edit($id)
    {
        $data = PersonalLetterUndangan::findOrFail($id);
        return view('pages.transaction.personal.templates.suratundangan.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $letter = PersonalLetterUndangan::findOrFail($id);

   $validated = $request->validate([
    'template_type' => 'required|string',
    'kop_type' => 'required|string',
    'nomor' => 'required|string|max:255',
    'sifat' => 'nullable|string|max:255',
    'lampiran' => 'nullable|string|max:255',
    'perihal' => 'required|string|max:255',
    'yth_nama' => 'required|string|max:255',
    'yth_alamat' => 'required|string',
    'isi_pembuka' => 'required|string',
    'hari_tanggal' => 'required|date',
    'pukul' => 'required',
    'tempat_acara' => 'required|string|max:255',
    'acara' => 'required|string|max:255',
    'tempat_ttd' => 'required|string|max:255',
    'tanggal_ttd' => 'required|date',   
    'jabatan_pembuat' => 'required|string|max:255',
    'nama_pembuat' => 'required|string|max:255',
    'tembusan_1' => 'nullable|string',
    'tembusan_2' => 'nullable|string',
    'daftar_undangan' => 'nullable|array',
    'daftar_undangan.*.nama' => 'required_with:daftar_undangan|string|max:255',
    'daftar_undangan.*.jabatan' => 'nullable|string|max:255',
    'daftar_undangan.*.unit_kerja' => 'nullable|string|max:255',
]);

        $letter->update($validated);

        if ($letter->generated_file) {
            Storage::delete('public/personal_letters/' . $letter->generated_file);
            $letter->update(['generated_file' => null]);
        }

        return redirect()->route('transaction.personal.surat_undangan.show', $letter->id)
            ->with('success', 'Surat undangan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $letter = PersonalLetterUndangan::findOrFail($id);

        if ($letter->generated_file) {
            Storage::delete('public/personal_letters/' . $letter->generated_file);
        }

        $letter->delete();

        return redirect()->route('transaction.personal.index')
            ->with('success', 'Surat berhasil dihapus!');
    }

    public function preview($id)
    {
        $letter = PersonalLetterUndangan::findOrFail($id);

        $pdf = Pdf::loadView('pages.pdf.personal.surat_undangan', compact('letter'))
                  ->setPaper('A4', 'portrait')
                  ->setOptions([
                      'isHtml5ParserEnabled' => true,
                      'isPhpEnabled' => true,
                      'defaultFont' => 'DejaVu Sans',
                  ]);

        return $pdf->stream('Preview_Surat_Undangan.pdf');
    }

    public function download($id)
    {
        $letter = PersonalLetterUndangan::findOrFail($id);

        $pdf = Pdf::loadView('pages.pdf.personal.surat_undangan', compact('letter'))
                  ->setPaper('A4', 'portrait')
                  ->setOptions([
                      'isHtml5ParserEnabled' => true,
                      'isPhpEnabled' => true,
                      'defaultFont' => 'DejaVu Sans',
                  ]);

        $filename = 'Surat_Undangan_' . 
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
