<?php

namespace App\Http\Controllers\PersonalLetter;

use App\Models\PersonalLetterPanggilan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class SuratPanggilanController extends BasePersonalLetterController
{
    public function create()
    {
        // Tampilkan form create
        return view('pages.transaction.personal.templates.suratpanggilan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'template_type' => 'nullable|string',
            'kop_type' => 'required|string',
            'letter_date' => 'required|date',       // tanggal surat (header)
            'sifat' => 'nullable|string',
            'lampiran' => 'nullable|string',
            'perihal' => 'required|string',
            'kepada' => 'required|string',
            'isi_pembuka' => 'required|string',
            'hari_tanggal' => 'required|date',      // tanggal pemanggilan (untuk PDF => hari, tanggal)
            'waktu' => 'required|string',
            'tempat' => 'required|string',
            'menghadap' => 'required|string',
            'alamat_pemanggil' => 'required|string',
            'jabatan' => 'required|string',
            'nama_pejabat' => 'required|string',
            'nik' => 'required|string',
            'tembusan_1' => 'nullable|string',
            'tembusan_2' => 'nullable|string',
        ]);

        // generate nomor = P/001/BB/2025 (BB = month)
        $month = Carbon::parse($validated['letter_date'])->format('m');
        $year  = Carbon::parse($validated['letter_date'])->format('Y');

        $lastNumber = PersonalLetterPanggilan::whereMonth('letter_date', $month)
            ->whereYear('letter_date', $year)
            ->count() + 1;

        $validated['nomor'] = 'P/' . str_pad($lastNumber, 3, '0', STR_PAD_LEFT) . '/' . $month . '/' . $year;
        $validated['template_type'] = $validated['template_type'] ?? 'surat_panggilan';

        $letter = PersonalLetterPanggilan::create($validated);

        // generate PDF langsung dan simpan, lalu update generated_file
        $pdf = Pdf::loadView('pages.pdf.personal.surat_panggilan', ['letter' => $letter])
                  ->setPaper('A4', 'portrait')
                  ->setOptions([
                      'isHtml5ParserEnabled' => true,
                      'isPhpEnabled' => true,
                      'defaultFont' => 'DejaVu Sans',
                  ]);

        $filename = 'Surat_Panggilan_' . str_replace(['/', ' '], ['_', '_'], $letter->nomor) . '_' . now()->format('Y_m_d') . '.pdf';
        $pdfContent = $pdf->output();
        Storage::put('public/personal_letters/' . $filename, $pdfContent);

        $letter->update(['generated_file' => $filename]);

        return redirect()->route('transaction.personal.surat_panggilan.show', $letter->id)
            ->with('success', 'Surat panggilan berhasil dibuat!');
    }

    public function show($id)
    {
        $data = PersonalLetterPanggilan::findOrFail($id);
        return view('pages.transaction.personal.templates.suratpanggilan.show', compact('data'));
    }

    public function edit($id)
    {
        $data = PersonalLetterPanggilan::findOrFail($id);
        return view('pages.transaction.personal.templates.suratpanggilan.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $letter = PersonalLetterPanggilan::findOrFail($id);

        $validated = $request->validate([
            'kop_type' => 'required|string',
            'letter_date' => 'required|date',
            'sifat' => 'nullable|string',
            'lampiran' => 'nullable|string',
            'perihal' => 'required|string',
            'kepada' => 'required|string',
            'isi_pembuka' => 'required|string',
            'hari_tanggal' => 'required|date',
            'waktu' => 'required|string',
            'tempat' => 'required|string',
            'menghadap' => 'required|string',
            'alamat_pemanggil' => 'required|string',
            'jabatan' => 'required|string',
            'nama_pejabat' => 'required|string',
            'nik' => 'required|string',
            'tembusan_1' => 'nullable|string',
            'tembusan_2' => 'nullable|string',
        ]);

        $letter->update($validated);

        // jika sudah ada generated_file, hapus supaya nanti diregenerate jika perlu
        if ($letter->generated_file) {
            Storage::delete('public/personal_letters/' . $letter->generated_file);
            $letter->update(['generated_file' => null]);
        }

        return redirect()->route('transaction.personal.surat_panggilan.show', $letter->id)
            ->with('success', 'Surat panggilan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $letter = PersonalLetterPanggilan::findOrFail($id);
        if ($letter->generated_file) {
            Storage::delete('public/personal_letters/' . $letter->generated_file);
        }
        $letter->delete();

        return redirect()->route('transaction.personal.index')
            ->with('success', 'Surat panggilan berhasil dihapus!');
    }

    public function preview($id)
    {
        $letter = PersonalLetterPanggilan::findOrFail($id);
        $pdf = Pdf::loadView('pages.pdf.personal.surat_panggilan', ['letter' => $letter])
                  ->setPaper('A4', 'portrait')
                  ->setOptions([
                      'isHtml5ParserEnabled' => true,
                      'isPhpEnabled' => true,
                      'defaultFont' => 'DejaVu Sans',
                  ]);
        return $pdf->stream('Preview_Surat_Panggilan.pdf');
    }

    public function download($id)
    {
        $letter = PersonalLetterPanggilan::findOrFail($id);
        $pdf = Pdf::loadView('pages.pdf.personal.surat_panggilan', ['letter' => $letter])
                  ->setPaper('A4', 'portrait')
                  ->setOptions([
                      'isHtml5ParserEnabled' => true,
                      'isPhpEnabled' => true,
                      'defaultFont' => 'DejaVu Sans',
                  ]);

        $filename = 'Surat_Panggilan_' . str_replace(['/', ' '], ['_', '_'], $letter->nomor) . '_' . now()->format('Y_m_d') . '.pdf';

        if (!$letter->generated_file) {
            $pdfContent = $pdf->output();
            Storage::put('public/personal_letters/' . $filename, $pdfContent);
            $letter->update(['generated_file' => $filename]);
        }

        return $pdf->download($filename);
    }
}
