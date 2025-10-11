<?php

namespace App\Http\Controllers\PersonalLetter;

use App\Models\PersonalLetterNotulen;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class SuratNotulenController extends BasePersonalLetterController
{
    public function create()
    {
        return view('pages.transaction.personal.templates.notulen.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kop_type' => 'required|in:klinik,lab,pt',
            'isi_notulen' => 'required|string|max:500',
            'tanggal_rapat' => 'required|date',
            'waktu' => 'required',
            'tempat' => 'required|string|max:255',
            'pimpinan_rapat' => 'required|string|max:255',
            'peserta_rapat' => 'required|string',
            'kegiatan_rapat' => 'required|array',
            'kegiatan_rapat.*.pembicara' => 'required|string',
            'kegiatan_rapat.*.materi' => 'required|string',
            'kegiatan_rapat.*.tanggapan' => 'nullable|string',
            'kegiatan_rapat.*.keputusan' => 'nullable|string',
            'kegiatan_rapat.*.keterangan' => 'nullable|string',
            'kepala_lab' => 'required|string|max:255',
            'nik_kepala_lab' => 'nullable|string|max:255',
            'notulis' => 'required|string|max:255',
            'nik_notulis' => 'nullable|string|max:255',
            'judul_dokumentasi' => 'nullable|string|max:500',
            'dokumentasi.*' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        // Handle upload dokumentasi
        if ($request->hasFile('dokumentasi')) {
            $uploaded = [];
            foreach ($request->file('dokumentasi') as $file) {
                $path = $file->store('notulen/dokumentasi', 'public');
                $uploaded[] = $path;
            }
            $validated['dokumentasi'] = $uploaded;
        }

        $letter = PersonalLetterNotulen::create($validated);

        return redirect()
            ->route('transaction.personal.notulen.show', $letter->id)
            ->with('success', 'Notulen berhasil dibuat!');
    }

    public function show($id)
    {
        $data = PersonalLetterNotulen::findOrFail($id);
        return view('pages.transaction.personal.templates.notulen.show', compact('data'));
    }

    public function edit($id)
    {
        $data = PersonalLetterNotulen::findOrFail($id);
        return view('pages.transaction.personal.templates.notulen.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $letter = PersonalLetterNotulen::findOrFail($id);

        $validated = $request->validate([
            'kop_type' => 'required|in:klinik,lab,pt',
            'isi_notulen' => 'required|string|max:500',
            'tanggal_rapat' => 'required|date',
            'waktu' => 'required',
            'tempat' => 'required|string|max:255',
            'pimpinan_rapat' => 'required|string|max:255',
            'peserta_rapat' => 'required|string',
            'kegiatan_rapat' => 'required|array',
            'kegiatan_rapat.*.pembicara' => 'required|string',
            'kegiatan_rapat.*.materi' => 'required|string',
            'kegiatan_rapat.*.tanggapan' => 'nullable|string',
            'kegiatan_rapat.*.keputusan' => 'nullable|string',
            'kegiatan_rapat.*.keterangan' => 'nullable|string',
            'kepala_lab' => 'required|string|max:255',
            'nik_kepala_lab' => 'nullable|string|max:255',
            'notulis' => 'required|string|max:255',
            'nik_notulis' => 'nullable|string|max:255',
            'judul_dokumentasi' => 'nullable|string|max:500',
            'dokumentasi.*' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'hapus_dokumentasi' => 'nullable|array',
        ]);

        // Handle hapus dokumentasi lama
        if ($request->filled('hapus_dokumentasi')) {
            $existingDocs = $letter->dokumentasi ?? [];
            foreach ($request->hapus_dokumentasi as $indexToDelete) {
                if (isset($existingDocs[$indexToDelete])) {
                    Storage::disk('public')->delete($existingDocs[$indexToDelete]);
                    unset($existingDocs[$indexToDelete]);
                }
            }
            $validated['dokumentasi'] = array_values($existingDocs);
        }

        // Handle upload dokumentasi baru
        if ($request->hasFile('dokumentasi')) {
            $existing = $validated['dokumentasi'] ?? $letter->dokumentasi ?? [];
            foreach ($request->file('dokumentasi') as $file) {
                $path = $file->store('notulen/dokumentasi', 'public');
                $existing[] = $path;
            }
            $validated['dokumentasi'] = $existing;
        }

        $letter->update($validated);

        // Hapus PDF lama
        if ($letter->generated_file) {
            Storage::delete('public/personal_letters/' . $letter->generated_file);
            $letter->update(['generated_file' => null]);
        }

        return redirect()
            ->route('transaction.personal.notulen.show', $letter->id)
            ->with('success', 'Notulen berhasil diupdate!');
    }

    public function destroy($id)
    {
        $letter = PersonalLetterNotulen::findOrFail($id);

        // Hapus dokumentasi
        if ($letter->dokumentasi) {
            foreach ($letter->dokumentasi as $doc) {
                Storage::disk('public')->delete($doc);
            }
        }

        // Hapus PDF
        if ($letter->generated_file) {
            Storage::delete('public/personal_letters/' . $letter->generated_file);
        }

        $letter->delete();

        return redirect()
            ->route('transaction.personal.index')
            ->with('success', 'Notulen berhasil dihapus!');
    }

    public function preview($id)
    {
        $letter = PersonalLetterNotulen::findOrFail($id);

        $pdf = Pdf::loadView('pages.pdf.personal.notulen', compact('letter'))
                  ->setPaper('A4', 'portrait')
                  ->setOptions([
                      'isHtml5ParserEnabled' => true,
                      'isPhpEnabled' => true,
                      'defaultFont' => 'DejaVu Sans',
                  ]);

        return $pdf->stream('Preview_Notulen.pdf');
    }

    public function download($id)
    {
        $letter = PersonalLetterNotulen::findOrFail($id);

        $pdf = Pdf::loadView('pages.pdf.personal.notulen', compact('letter'))
                  ->setPaper('A4', 'portrait')
                  ->setOptions([
                      'isHtml5ParserEnabled' => true,
                      'isPhpEnabled' => true,
                      'defaultFont' => 'DejaVu Sans',
                  ]);

        $filename = 'Notulen_' . 
                   $letter->tanggal_rapat->format('Y_m_d') . '.pdf';

        if (!$letter->generated_file) {
            $pdfContent = $pdf->output();
            Storage::put('public/personal_letters/' . $filename, $pdfContent);
            $letter->update(['generated_file' => $filename]);
        }

        return $pdf->download($filename);
    }
}