<?php

namespace App\Http\Controllers\PersonalLetter;

use App\Http\Controllers\Controller;
use App\Models\PersonalLetterKeputusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class SuratKeputusanController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Daftar Surat Keputusan';
        $keyword = $request->get('search');
        $data = PersonalLetterKeputusan::when($keyword, function ($query, $keyword) {
            return $query->search($keyword);
        })->latest()->paginate(10);

        return view('pages.transaction.personal.templates.surat_keputusan.index', compact('title', 'data'));
    }

    public function create()
    {
        $title = 'Tambah Surat Keputusan';
        return view('pages.transaction.personal.templates.surat_keputusan.create', compact('title'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kop_type' => 'required|string',
            'judul' => 'required|string|max:255',
            'nomor' => 'required|string|max:255',
            'tentang' => 'required|string|max:255',
            'menimbang' => 'required|array',
            'mengingat' => 'required|array',
            'menetapkan' => 'nullable|string',
            'isi_keputusan' => 'required|array',
            'tanggal_penetapan' => 'required|date',
            'tempat_penetapan' => 'required|string|max:255',
            'nama_pejabat' => 'required|string|max:255',
            'jabatan_pejabat' => 'required|string|max:255',
            'nik_pejabat' => 'nullable|string|max:255',
            'tembusan' => 'nullable|array',
            'lampiran' => 'nullable|string',
        ]);

        if ($request->hasFile('lampiran')) {
            $validated['lampiran'] = $request->file('lampiran')->store('lampiran_surat_keputusan', 'public');
        }

        $data = PersonalLetterKeputusan::create($validated);

        return redirect()->route('transaction.personal.surat_keputusan.show', $data->id)
            ->with('success', 'Surat Keputusan berhasil dibuat!');
    }

    public function show($id)
    {
        $title = 'Detail Surat Keputusan';
        $data = PersonalLetterKeputusan::findOrFail($id);

        return view('pages.transaction.personal.templates.surat_keputusan.show', compact('title', 'data'));
    }

    public function edit($id)
    {
        $title = 'Edit Surat Keputusan';
        $data = PersonalLetterKeputusan::findOrFail($id);

        return view('pages.transaction.personal.templates.surat_keputusan.edit', compact('title', 'data'));
    }

    public function update(Request $request, $id)
    {
        $data = PersonalLetterKeputusan::findOrFail($id);

        $validated = $request->validate([
            'kop_type' => 'required|string',
            'judul' => 'required|string|max:255',
            'nomor' => 'required|string|max:255',
            'tentang' => 'required|string|max:255',
            'menimbang' => 'required|array',
            'mengingat' => 'required|array',
            'menetapkan' => 'nullable|string',
            'isi_keputusan' => 'required|array',
            'tanggal_penetapan' => 'required|date',
            'tempat_penetapan' => 'required|string|max:255',
            'nama_pejabat' => 'required|string|max:255',
            'jabatan_pejabat' => 'required|string|max:255',
            'nik_pejabat' => 'nullable|string|max:255',
            'tembusan' => 'nullable|array',
            'lampiran' => 'nullable|string',
        ]);

        if ($request->hasFile('lampiran')) {
            if ($data->lampiran) {
                Storage::disk('public')->delete($data->lampiran);
            }
            $validated['lampiran'] = $request->file('lampiran')->store('lampiran_surat_keputusan', 'public');
        }

        $data->update($validated);

        return redirect()->route('transaction.personal.surat_keputusan.show', $data->id)
            ->with('success', 'Surat Keputusan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $data = PersonalLetterKeputusan::findOrFail($id);

        if ($data->lampiran) {
            Storage::disk('public')->delete($data->lampiran);
        }

        $data->delete();

        return redirect()->route('transaction.personal.index')
            ->with('success', 'Surat Keputusan berhasil dihapus!');
    }

    public function preview($id)
    {
        $data = PersonalLetterKeputusan::findOrFail($id);

        $pdf = Pdf::loadView('pages.pdf.personal.surat_keputusan', compact('data'))
            ->setPaper('a4', 'portrait');

        $safeNomor = str_replace(['/', '\\'], '_', $data->nomor);

        return $pdf->stream('Surat_Keputusan_' . $safeNomor . '.pdf');
    }

    public function download($id)
    {
        $data = PersonalLetterKeputusan::findOrFail($id);

        $pdf = Pdf::loadView('pages.pdf.personal.surat_keputusan', compact('data'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Surat_Keputusan_' . $data->nomor . '.pdf');
    }
}
