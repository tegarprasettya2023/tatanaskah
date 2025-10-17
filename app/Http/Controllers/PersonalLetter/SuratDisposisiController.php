<?php

namespace App\Http\Controllers\PersonalLetter;

use App\Http\Controllers\Controller;
use App\Models\PersonalLetterDisposisi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class SuratDisposisiController extends Controller
{
    public function create()
    {
        // Pilihan logo otomatis, mirip seperti kop
        $logoOptions = [
            'logo_klinik.png' => 'Logo Klinik',
            'logo_lab.png' => 'Logo Laboratorium',
            'logo_pt.png' => 'Logo PT',
        ];

        return view('pages.transaction.personal.templates.suratdisposisi.create', compact('logoOptions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kop_type' => 'required|in:klinik,lab,pt',
            'logo' => 'required|in:logo_klinik.png,logo_lab.png,logo_pt.png',
            'nomor_ld' => 'required|string|max:255',
            'tanggal_dokumen' => 'required|date',
            'no_revisi' => 'required|string|max:255',
            'tanggal_pembuatan' => 'required|date',
            'perihal' => 'required|string',
            'paraf' => 'nullable|string',
            'diteruskan_kepada' => 'required|array',
            'diteruskan_kepada.*' => 'required|string',
            'tanggal_diserahkan' => 'nullable|date',
            'tanggal_kembali' => 'nullable|date',
            'catatan_1' => 'nullable|string',
            'catatan_2' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();

        $letter = PersonalLetterDisposisi::create($validated);

        return redirect()
            ->route('transaction.personal.disposisi.show', $letter->id)
            ->with('success', 'Formulir Disposisi berhasil dibuat!');
    }

    public function show($id)
    {
        $data = PersonalLetterDisposisi::where('user_id', auth()->id())->findOrFail($id);
        return view('pages.transaction.personal.templates.suratdisposisi.show', compact('data'));
    }

    public function edit($id)
    {
        $data = PersonalLetterDisposisi::where('user_id', auth()->id())->findOrFail($id);

        $logoOptions = [
            'logo_klinik.png' => 'Logo Klinik',
            'logo_lab.png' => 'Logo Laboratorium',
            'logo_pt.png' => 'Logo PT',
        ];

        return view('pages.transaction.personal.templates.suratdisposisi.edit', compact('data', 'logoOptions'));
    }

    public function update(Request $request, $id)
    {
        $letter = PersonalLetterDisposisi::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'kop_type' => 'required|in:klinik,lab,pt',
            'logo' => 'required|in:logo_klinik.png,logo_lab.png,logo_pt.png',
            'nomor_ld' => 'required|string|max:255',
            'tanggal_dokumen' => 'required|date',
            'no_revisi' => 'required|string|max:255',
            'tanggal_pembuatan' => 'required|date',
            'perihal' => 'required|string',
            'paraf' => 'nullable|string',
            'diteruskan_kepada' => 'required|array',
            'diteruskan_kepada.*' => 'required|string',
            'tanggal_diserahkan' => 'nullable|date',
            'tanggal_kembali' => 'nullable|date',
            'catatan_1' => 'nullable|string',
            'catatan_2' => 'nullable|string',
        ]);

        $letter->update($validated);

        if ($letter->generated_file) {
            Storage::delete('public/personal_letters/' . $letter->generated_file);
            $letter->update(['generated_file' => null]);
        }

        return redirect()
            ->route('transaction.personal.disposisi.show', $letter->id)
            ->with('success', 'Formulir Disposisi berhasil diupdate!');
    }

    public function destroy($id)
    {
        $letter = PersonalLetterDisposisi::where('user_id', auth()->id())->findOrFail($id);

        if ($letter->generated_file) {
            Storage::delete('public/personal_letters/' . $letter->generated_file);
        }

        $letter->delete();

        return redirect()
            ->route('transaction.personal.index')
            ->with('success', 'Formulir Disposisi berhasil dihapus!');
    }

    public function preview($id)
    {
        $letter = PersonalLetterDisposisi::where('user_id', auth()->id())->findOrFail($id);

        $pdf = Pdf::loadView('pages.pdf.personal.surat_disposisi', compact('letter'))
                  ->setPaper('A4', 'portrait')
                  ->setOptions([
                      'isHtml5ParserEnabled' => true,
                      'isPhpEnabled' => true,
                      'defaultFont' => 'DejaVu Sans',
                  ]);

        return $pdf->stream('Preview_Surat_Disposisi.pdf');
    }

    public function download($id)
    {
        $letter = PersonalLetterDisposisi::where('user_id', auth()->id())->findOrFail($id);

$pdf = Pdf::loadView('pages.pdf.personal.surat_disposisi', compact('letter'))
          ->setPaper('A4', 'portrait')
          ->setOptions([
              'isHtml5ParserEnabled' => true,
              'isPhpEnabled' => true,
              'isRemoteEnabled' => true,
          ]);

        $filename = 'Surat_Disposisi_' .
                   str_replace(['/', ' '], ['_', '_'], $letter->nomor_ld) .
                   '_' . now()->format('Y_m_d') . '.pdf';

        if (!$letter->generated_file) {
            $pdfContent = $pdf->output();
            Storage::put('public/personal_letters/' . $filename, $pdfContent);
            $letter->update(['generated_file' => $filename]);
        }

        return $pdf->download($filename);
    }
}