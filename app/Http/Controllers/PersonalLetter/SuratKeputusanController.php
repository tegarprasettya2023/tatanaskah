<?php

namespace App\Http\Controllers\PersonalLetter;

use App\Http\Controllers\Controller;
use App\Models\PersonalLetterKeputusan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class SuratKeputusanController extends Controller
{
    public function create()
    {
        return view('pages.transaction.personal.templates.suratkeputusan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kop_type' => 'required|in:klinik,lab,pt',
            'judul_setelah_sk' => 'nullable|string',
            'nomor_sk' => 'required|string',
            'tanggal_sk' => 'required|date',
            'tentang' => 'required|string',
            'jabatan_pembuat' => 'nullable|string',
            'menimbang' => 'nullable|array',
            'menimbang.*' => 'nullable|string',
            'mengingat' => 'nullable|array',
            'mengingat.*' => 'nullable|string',
            'menetapkan' => 'nullable|string',
            'keputusan' => 'nullable|array',
            'keputusan.*' => 'nullable|string',
            'ditetapkan_di' => 'nullable|string',
            'tanggal_ditetapkan' => 'required|date',
            'nama_jabatan' => 'nullable|string',
            'nama_lengkap' => 'required|string',
            'nik_kepegawaian' => 'nullable|string',
            'keputusan_dari' => 'nullable|string',
            'lampiran_tentang' => 'nullable|string',
            'tembusan' => 'nullable|array',
            'tembusan.*' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();

        $letter = PersonalLetterKeputusan::create($validated);

        $this->generatePDF($letter);

        return redirect()
            ->route('transaction.personal.suratkeputusan.show', $letter->id)
            ->with('success', 'Surat Keputusan berhasil dibuat!');
    }

    public function show($id)
    {
        $data = PersonalLetterKeputusan::where('user_id', auth()->id())->findOrFail($id);
        return view('pages.transaction.personal.templates.suratkeputusan.show', compact('data'));
    }

    public function edit($id)
    {
        $data = PersonalLetterKeputusan::where('user_id', auth()->id())->findOrFail($id);
        return view('pages.transaction.personal.templates.suratkeputusan.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $letter = PersonalLetterKeputusan::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'kop_type' => 'required|in:klinik,lab,pt',
            'judul_setelah_sk' => 'nullable|string',
            'nomor_sk' => 'required|string',
            'tanggal_sk' => 'required|date',
            'tentang' => 'required|string',
            'jabatan_pembuat' => 'nullable|string',
            'menimbang' => 'nullable|array',
            'menimbang.*' => 'nullable|string',
            'mengingat' => 'nullable|array',
            'mengingat.*' => 'nullable|string',
            'menetapkan' => 'nullable|string',
            'keputusan' => 'nullable|array',
            'keputusan.*' => 'nullable|string',
            'ditetapkan_di' => 'nullable|string',
            'tanggal_ditetapkan' => 'required|date',
            'nama_jabatan' => 'nullable|string',
            'nama_lengkap' => 'required|string',
            'nik_kepegawaian' => 'nullable|string',
            'keputusan_dari' => 'nullable|string',
            'lampiran_tentang' => 'nullable|string',
            'tembusan' => 'nullable|array',
            'tembusan.*' => 'nullable|string',
        ]);

        $letter->update($validated);

        if ($letter->generated_file && Storage::exists($letter->generated_file)) {
            Storage::delete($letter->generated_file);
        }

        $this->generatePDF($letter);

        return redirect()
            ->route('transaction.personal.suratkeputusan.show', $letter->id)
            ->with('success', 'Surat Keputusan berhasil diupdate!');
    }

    public function destroy($id)
    {
        $letter = PersonalLetterKeputusan::where('user_id', auth()->id())->findOrFail($id);

        if ($letter->generated_file && Storage::exists($letter->generated_file)) {
            Storage::delete($letter->generated_file);
        }

        $letter->delete();

        return redirect()
            ->route('transaction.personal.index')
            ->with('success', 'Surat Keputusan berhasil dihapus!');
    }

    public function preview($id)
    {
        $letter = PersonalLetterKeputusan::where('user_id', auth()->id())->findOrFail($id);

        $pdf = Pdf::loadView('pages.pdf.personal.surat_keputusan', compact('letter'))
            ->setPaper('A4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => true,
                'defaultFont' => 'DejaVu Sans',
            ]);

        return $pdf->stream('Preview_Surat_Keputusan.pdf');
    }

    public function download($id)
    {
        $letter = PersonalLetterKeputusan::where('user_id', auth()->id())->findOrFail($id);

        $pdf = Pdf::loadView('pages.personal.surat_keputusan.pdf', compact('letter'))
            ->setPaper('A4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => true,
                'isRemoteEnabled' => true,
            ]);

        $filename = 'Surat_Keputusan_' .
            str_replace(['/', ' '], ['_', '_'], $letter->nomor_sk) .
            '_' . now()->format('Y_m_d') . '.pdf';

        return $pdf->download($filename);
    }

    private function generatePDF($letter)
    {
        $pdf = Pdf::loadView('pages.pdf.personal.surat_keputusan', compact('letter'))
            ->setPaper('A4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => true,
            ]);

        $filename = 'suratkeputusan/sk_' . $letter->id . '_' . time() . '.pdf';
        Storage::put('public/' . $filename, $pdf->output());

        $letter->update(['generated_file' => 'public/' . $filename]);
    }
}
