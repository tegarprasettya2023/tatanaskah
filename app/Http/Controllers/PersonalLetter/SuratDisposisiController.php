<?php

namespace App\Http\Controllers\PersonalLetter;

use App\Http\Controllers\Controller;
use App\Models\PersonalLetterDisposisi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class SuratDisposisiController extends Controller
{
    public function index()
    {
        $data = PersonalLetterDisposisi::latest()->paginate(10);
        return view('pages.transaction.personal.templates.suratdisposisi.index', compact('data'));
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
            'nomor_dokumen' => 'nullable|string',
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
            'signature' => 'nullable|string', // Base64 image
            'diteruskan_kepada' => 'nullable|array',
            'tanggal_diserahkan' => 'nullable|date',
            'tanggal_kembali' => 'nullable|date',
            'instruksi_2' => 'nullable|string',
        ]);

        $letter = PersonalLetterDisposisi::create($validated);

        // Generate PDF
        $this->generatePDF($letter);

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
            'nomor_dokumen' => 'nullable|string',
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
            'signature' => 'nullable|string', // Base64 image
            'diteruskan_kepada' => 'nullable|array',
            'tanggal_diserahkan' => 'nullable|date',
            'tanggal_kembali' => 'nullable|date',
            'instruksi_2' => 'nullable|string',
        ]);

        $letter->update($validated);

        // Regenerate PDF
        $this->generatePDF($letter);

        return redirect()->route('transaction.personal.suratdisposisi.show', $letter->id)
            ->with('success', 'Formulir Disposisi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $letter = PersonalLetterDisposisi::findOrFail($id);
        
        // Hapus file PDF jika ada
        if ($letter->generated_file && file_exists(storage_path('app/public/' . $letter->generated_file))) {
            unlink(storage_path('app/public/' . $letter->generated_file));
        }

        $letter->delete();

        return redirect()->route('transaction.personal.index')
            ->with('success', 'Formulir Disposisi berhasil dihapus!');
    }

    public function preview($id)
    {
        $letter = PersonalLetterDisposisi::findOrFail($id);

        $pdf = Pdf::loadView('pages.pdf.personal.surat_disposisi', compact('letter'))
                  ->setPaper('A4', 'portrait');

        return $pdf->stream('Preview_Formulir_Disposisi.pdf');
    }

    public function download($id)
    {
        $letter = PersonalLetterDisposisi::findOrFail($id);

        $pdf = Pdf::loadView('pages.pdf.personal.surat_disposisi', compact('letter'))
                  ->setPaper('A4', 'portrait');

        $filename = 'Formulir_Disposisi_' .
                    str_replace(['/', ' ', '\\'], ['_', '_', '_'], $letter->nomor_dokumen ?? 'Draft') .
                    '_' . now()->format('Y_m_d') . '.pdf';

        return $pdf->download($filename);
    }

    private function generatePDF($letter)
    {
        $pdf = Pdf::loadView('pages.pdf.personal.surat_disposisi', compact('letter'))
                  ->setPaper('A4', 'portrait');
        
        $filename = 'disposisi_' . $letter->id . '_' . time() . '.pdf';
        $path = 'letters/disposisi/' . $filename;
        
        Storage::disk('public')->put($path, $pdf->output());
        
        $letter->update(['generated_file' => $path]);
    }
}