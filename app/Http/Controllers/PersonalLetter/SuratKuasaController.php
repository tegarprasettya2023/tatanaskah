<?php

namespace App\Http\Controllers\PersonalLetter;

use App\Http\Controllers\Controller;
use App\Models\PersonalLetterKuasa;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class SuratKuasaController extends Controller
{
    public function create()
    {
        return view('pages.transaction.personal.templates.suratkuasa.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kop_type' => 'required|string',
            'nomor' => 'required|string|max:255',
            'letter_date' => 'required|date',
            'tempat' => 'required|string|max:255',
            'nama_pemberi' => 'required|string|max:255',
            'nip_pemberi' => 'nullable|string|max:255',
            'jabatan_pemberi' => 'required|string|max:255',
            'alamat_pemberi' => 'nullable|string',
            'nama_penerima' => 'required|string|max:255',
            'nip_penerima' => 'nullable|string|max:255',
            'jabatan_penerima' => 'required|string|max:255',
            'alamat_penerima' => 'nullable|string',
            'isi' => 'required|string',
        ]);

        $letter = PersonalLetterKuasa::create($validated);

        return redirect()->route('transaction.personal.suratkuasa.show', $letter->id)
            ->with('success', 'Surat kuasa berhasil dibuat!');
    }

    public function show($id)
    {
        $data = PersonalLetterKuasa::findOrFail($id);
        return view('pages.transaction.personal.templates.suratkuasa.show', compact('data'));
    }

    public function edit($id)
    {
        $data = PersonalLetterKuasa::findOrFail($id);
        return view('pages.transaction.personal.templates.suratkuasa.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $letter = PersonalLetterKuasa::findOrFail($id);

        $validated = $request->validate([
            'kop_type' => 'required|string',
            'nomor' => 'required|string|max:255',
            'letter_date' => 'required|date',
            'tempat' => 'required|string|max:255',
            'nama_pemberi' => 'required|string|max:255',
            'nip_pemberi' => 'nullable|string|max:255',
            'jabatan_pemberi' => 'required|string|max:255',
            'alamat_pemberi' => 'nullable|string',
            'nama_penerima' => 'required|string|max:255',
            'nip_penerima' => 'nullable|string|max:255',
            'jabatan_penerima' => 'required|string|max:255',
            'alamat_penerima' => 'nullable|string',
            'isi' => 'required|string',
        ]);

        $letter->update($validated);

        return redirect()->route('transaction.personal.suratkuasa.show', $letter->id)
            ->with('success', 'Surat kuasa berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $letter = PersonalLetterKuasa::findOrFail($id);
        $letter->delete();

        return redirect()->route('transaction.personal.index')
            ->with('success', 'Surat kuasa berhasil dihapus!');
    }

    public function preview($id)
    {
        $letter = PersonalLetterKuasa::findOrFail($id);

        $pdf = Pdf::loadView('pages.pdf.personal.surat_kuasa', compact('letter'))
                  ->setPaper('A4', 'portrait');

        return $pdf->stream('Preview_Surat_Kuasa.pdf');
    }

    public function download($id)
    {
        $letter = PersonalLetterKuasa::findOrFail($id);

        $pdf = Pdf::loadView('pages.pdf.personal.surat_kuasa', compact('letter'))
                  ->setPaper('A4', 'portrait');

        $filename = 'Surat_Kuasa_' .
                    str_replace(['/', ' '], ['_', '_'], $letter->nomor) .
                    '_' . now()->format('Y_m_d') . '.pdf';

        return $pdf->download($filename);
    }
}
