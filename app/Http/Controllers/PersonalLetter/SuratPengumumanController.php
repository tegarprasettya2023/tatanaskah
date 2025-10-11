<?php

namespace App\Http\Controllers\PersonalLetter;

use App\Models\PersonalLetterPengumuman;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class SuratPengumumanController extends BasePersonalLetterController
{
    public function create()
    {
        $title = 'Buat Surat Pengumuman';
        return view('pages.transaction.personal.templates.pengumuman.create', compact('title'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kop_type'        => 'required|string|in:klinik,lab,pt',
            'tanggal_surat'   => 'required|date',
            'tentang'         => 'required|string|max:255',
            'isi_pembuka'     => 'required|string',
            'isi_penutup'     => 'nullable|string',
            'tempat_ttd'      => 'required|string|max:255',
            'tanggal_ttd'     => 'required|date',
            'nama_pembuat'    => 'required|string|max:255',
            'jabatan_pembuat' => 'required|string|max:255',
            'nik_pegawai'     => 'nullable|string|max:50',
        ]);

        // Generate Nomor Otomatis
        $month = Carbon::parse($validated['tanggal_surat'])->format('m');
        $year = Carbon::parse($validated['tanggal_surat'])->format('Y');
        $lastNumber = PersonalLetterPengumuman::whereMonth('tanggal_surat', $month)
                        ->whereYear('tanggal_surat', $year)
                        ->count() + 1;
        $validated['nomor'] = 'UM/' . str_pad($lastNumber, 3, '0', STR_PAD_LEFT) . '/' . $month . '/' . $year;

        $letter = PersonalLetterPengumuman::create($validated);

        return redirect()->route('transaction.personal.pengumuman.show', $letter->id)
            ->with('success', 'Surat pengumuman berhasil dibuat!');
    }

    public function show($id)
    {
        $letter = PersonalLetterPengumuman::findOrFail($id);
        return view('pages.transaction.personal.templates.pengumuman.show', compact('letter'));
    }

    public function edit($id)
    {
        $data = PersonalLetterPengumuman::findOrFail($id);
        return view('pages.transaction.personal.templates.pengumuman.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $letter = PersonalLetterPengumuman::findOrFail($id);

        $validated = $request->validate([
            'kop_type'        => 'required|string|in:klinik,lab,pt',
            'tanggal_surat'   => 'required|date',
            'tentang'         => 'required|string|max:255',
            'isi_pembuka'     => 'required|string',
            'isi_penutup'     => 'nullable|string',
            'tempat_ttd'      => 'required|string|max:255',
            'tanggal_ttd'     => 'required|date',
            'nama_pembuat'    => 'required|string|max:255',
            'jabatan_pembuat' => 'required|string|max:255',
            'nik_pegawai'     => 'nullable|string|max:50',
        ]);

        $letter->update($validated);

        if ($letter->generated_file) {
            Storage::delete('public/personal_letters/' . $letter->generated_file);
            $letter->update(['generated_file' => null]);
        }

        return redirect()->route('transaction.personal.pengumuman.show', $letter->id)
            ->with('success', 'Surat pengumuman berhasil diperbarui!');
    }

    public function preview($id)
    {
        $letter = PersonalLetterPengumuman::findOrFail($id);

        $pdf = Pdf::loadView('pages.pdf.personal.pengumuman', compact('letter'))
            ->setPaper('A4', 'portrait')
            ->setOptions(['defaultFont' => 'DejaVu Sans']);

        return $pdf->stream('Preview_Surat_Pengumuman.pdf');
    }

    public function download($id)
    {
        $letter = PersonalLetterPengumuman::findOrFail($id);

        $pdf = Pdf::loadView('pages.pdf.personal.pengumuman', compact('letter'))
            ->setPaper('A4', 'portrait')
            ->setOptions(['defaultFont' => 'DejaVu Sans']);

        $filename = 'Surat_Pengumuman_' . str_replace('/', '_', $letter->nomor) . '.pdf';
        $pdfContent = $pdf->output();
        Storage::put('public/personal_letters/' . $filename, $pdfContent);

        $letter->update(['generated_file' => $filename]);
        return $pdf->download($filename);
    }
}
