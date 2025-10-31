<?php

namespace App\Http\Controllers\PersonalLetter;

use App\Http\Controllers\Controller;
use App\Models\PersonalLetterInstruksiKerja;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class SuratInstruksiKerjaController extends Controller
{
    public function index()
    {
        $data = PersonalLetterInstruksiKerja::latest()->paginate(10);
        return view('pages.transaction.personal.templates.suratinstruksikerja.index', compact('data'));
    }

    public function create()
    {
        return view('pages.transaction.personal.templates.suratinstruksikerja.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'logo_kiri' => 'required|in:klinik,lab,pt',
            'logo_kanan' => 'required|in:klinik,lab,pt',
            'kop_type' => 'required|in:klinik,lab,pt',
            'judul_ik' => 'required|string|max:255',
            'no_dokumen' => 'required|string|max:255',
            'no_revisi' => 'nullable|string|max:50',
            'tanggal_terbit' => 'required|date',
            'halaman' => 'nullable|string|max:50',
            'jabatan_menetapkan' => 'nullable|string|max:255',
            'nama_menetapkan' => 'nullable|string|max:255',
            'nip_menetapkan' => 'nullable|string|max:255',
            'pengertian' => 'nullable|string',
            'tujuan' => 'nullable|string',
            'kebijakan' => 'nullable|string',
            'pelaksana' => 'nullable|string',
            'prosedur_kerja' => 'nullable|array',
            'prosedur_kerja.*' => 'nullable|string',
            'hal_hal_perlu_diperhatikan' => 'nullable|string',
            'unit_terkait' => 'nullable|string',
            'dokumen_terkait' => 'nullable|string',
            'referensi' => 'nullable|string',
            'rekaman_histori' => 'nullable|array',
            'dibuat_jabatan' => 'nullable|string|max:255',
            'dibuat_nama' => 'nullable|string|max:255',
            'dibuat_tanggal' => 'nullable|date',
            'direview_jabatan' => 'nullable|string|max:255',
            'direview_nama' => 'nullable|string|max:255',
            'direview_tanggal' => 'nullable|date',
        ]);

        // Filter empty values
        if (isset($validated['prosedur_kerja'])) {
            $validated['prosedur_kerja'] = array_filter($validated['prosedur_kerja']);
        }

        $instruksiKerja = PersonalLetterInstruksiKerja::create($validated);

        // Generate PDF
        $this->generatePDF($instruksiKerja);

        return redirect()
            ->route('transaction.personal.suratinstruksikerja.show', $instruksiKerja->id)
            ->with('success', 'Instruksi Kerja berhasil dibuat!');
    }

    public function show($id)
    {
        $data = PersonalLetterInstruksiKerja::findOrFail($id);
        return view('pages.transaction.personal.templates.suratinstruksikerja.show', compact('data'));
    }

    public function edit($id)
    {
        $data = PersonalLetterInstruksiKerja::findOrFail($id);
        return view('pages.transaction.personal.templates.suratinstruksikerja.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $instruksiKerja = PersonalLetterInstruksiKerja::findOrFail($id);

        $validated = $request->validate([
            'logo_kiri' => 'required|in:klinik,lab,pt',
            'logo_kanan' => 'required|in:klinik,lab,pt',
            'kop_type' => 'required|in:klinik,lab,pt',
            'judul_ik' => 'required|string|max:255',
            'no_dokumen' => 'required|string|max:255',
            'no_revisi' => 'nullable|string|max:50',
            'tanggal_terbit' => 'required|date',
            'halaman' => 'nullable|string|max:50',
            'jabatan_menetapkan' => 'nullable|string|max:255',
            'nama_menetapkan' => 'nullable|string|max:255',
            'nip_menetapkan' => 'nullable|string|max:255',
            'pengertian' => 'nullable|string',
            'tujuan' => 'nullable|string',
            'kebijakan' => 'nullable|string',
            'pelaksana' => 'nullable|string',
            'prosedur_kerja' => 'nullable|array',
            'prosedur_kerja.*' => 'nullable|string',
            'hal_hal_perlu_diperhatikan' => 'nullable|string',
            'unit_terkait' => 'nullable|string',
            'dokumen_terkait' => 'nullable|string',
            'referensi' => 'nullable|string',
            'rekaman_histori' => 'nullable|array',
            'dibuat_jabatan' => 'nullable|string|max:255',
            'dibuat_nama' => 'nullable|string|max:255',
            'dibuat_tanggal' => 'nullable|date',
            'direview_jabatan' => 'nullable|string|max:255',
            'direview_nama' => 'nullable|string|max:255',
            'direview_tanggal' => 'nullable|date',
        ]);

        // Filter empty values
        if (isset($validated['prosedur_kerja'])) {
            $validated['prosedur_kerja'] = array_filter($validated['prosedur_kerja']);
        }

        $instruksiKerja->update($validated);

        // Regenerate PDF
        $this->generatePDF($instruksiKerja);

        return redirect()
            ->route('transaction.personal.suratinstruksikerja.show', $instruksiKerja->id)
            ->with('success', 'Instruksi Kerja berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $instruksiKerja = PersonalLetterInstruksiKerja::findOrFail($id);

        // Delete PDF file if exists
        if ($instruksiKerja->generated_file && Storage::disk('public')->exists($instruksiKerja->generated_file)) {
            Storage::disk('public')->delete($instruksiKerja->generated_file);
        }

        $instruksiKerja->delete();

        return redirect()
            ->route('transaction.personal.index')
            ->with('success', 'Instruksi Kerja berhasil dihapus!');
    }

    public function preview($id)
    {
        $letter = PersonalLetterInstruksiKerja::findOrFail($id);
        $pdf = Pdf::loadView('pages.pdf.personal.surat_instruksi_kerja', compact('letter'));
        $pdf->setPaper('A4', 'portrait');
        
        $safeFilename = 'IK_' . preg_replace('/[^A-Za-z0-9_\-]/', '_', $letter->no_dokumen) . '.pdf';
        
        return $pdf->stream($safeFilename);
    }

    public function download($id)
    {
        $letter = PersonalLetterInstruksiKerja::findOrFail($id);
        $pdf = Pdf::loadView('pages.pdf.personal.surat_instruksi_kerja', compact('letter'));
        $pdf->setPaper('A4', 'portrait');
        
        $safeFilename = 'IK_' . preg_replace('/[^A-Za-z0-9_\-]/', '_', $letter->no_dokumen) . '.pdf';
        
        return $pdf->download($safeFilename);
    }

    private function generatePDF($instruksiKerja)
    {
        $letter = $instruksiKerja;
        $pdf = Pdf::loadView('pages.pdf.personal.surat_instruksi_kerja', compact('letter'));
        $pdf->setPaper('A4', 'portrait');

        $safeDocNumber = preg_replace('/[^A-Za-z0-9_\-]/', '_', $instruksiKerja->no_dokumen);
        $filename = 'instruksi_kerja/IK_' . $safeDocNumber . '.pdf';
        
        Storage::disk('public')->put($filename, $pdf->output());

        $instruksiKerja->update(['generated_file' => $filename]);
    }
}