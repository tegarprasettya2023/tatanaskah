<?php

namespace App\Http\Controllers\PersonalLetter;

use App\Http\Controllers\Controller;
use App\Models\PersonalLetterDinas;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class SuratDinasController extends Controller
{
    public function index(Request $request)
    {
        // Query dasar - hanya ambil surat dinas
        $query = PersonalLetterDinas::with('user')->orderBy('created_at', 'desc');

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor', 'like', "%{$search}%")
                  ->orWhere('perihal', 'like', "%{$search}%")
                  ->orWhere('kepada', 'like', "%{$search}%");
            });
        }

        // Filter tanggal
        if ($request->filled('date_from')) {
            $query->whereDate('letter_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('letter_date', '<=', $request->date_to);
        }

        // Pagination
        $data = $query->paginate(10)->withQueryString();

        // Statistik
        $totalCount = PersonalLetterDinas::count();
        $monthlyCount = PersonalLetterDinas::whereMonth('created_at', date('m'))->count();
        $weeklyCount = PersonalLetterDinas::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count();
        $todayCount = PersonalLetterDinas::whereDate('created_at', today())->count();

        // Data untuk view
        $title = 'Surat Dinas';
        $icon = 'bx-envelope';
        $createRoute = route('transaction.personal.surat_dinas.create');
        $previewRoute = 'transaction.personal.surat_dinas.preview';
        $downloadRoute = 'transaction.personal.surat_dinas.download';
        $editRoute = 'transaction.personal.surat_dinas.edit';
        $deleteRoute = 'transaction.personal.surat_dinas.destroy';

        return view('pages.transaction.personal.template-index', compact(
            'data',
            'title',
            'icon',
            'totalCount',
            'monthlyCount',
            'weeklyCount',
            'todayCount',
            'createRoute',
            'previewRoute',
            'downloadRoute',
            'editRoute',
            'deleteRoute'
        ));
    }

    public function create()
    {
        $title = 'Buat Surat Dinas';
        return view('pages.transaction.personal.templates.suratdinas.create', compact('title'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'template_type' => 'required|string',
            'kop_type' => 'required|string',
            'nomor' => 'required|string|max:255',
            'letter_date' => 'required|date',
            'tempat' => 'required|string|max:255',
            'sifat' => 'nullable|string|max:255',
            'lampiran' => 'nullable|string|max:255',
            'perihal' => 'required|string|max:255',
            'kepada' => 'required|string|max:255',
            'kepada_tempat' => 'required|string|max:255',
            'sehubungan_dengan' => 'required|string',
            'isi_surat' => 'nullable|string',
            'nama1' => 'required|string|max:255',
            'jabatan1' => 'required|string|max:255',
            'nip' => 'nullable|string|max:255',
            'tembusan' => 'nullable|array',
            'tembusan.*' => 'nullable|string',
            'pihak' => 'nullable|array',
            'pihak.*.nama' => 'nullable|string|max:255',
        ]);

        if (!empty($validated['tembusan'])) {
            $validated['tembusan_data'] = array_filter($validated['tembusan'], fn($item) => !empty(trim($item)));
            $validated['tembusan_data'] = array_values($validated['tembusan_data']);
        }
        unset($validated['tembusan']);

        if (!empty($validated['pihak'])) {
            foreach ($validated['pihak'] as $index => $p) {
                $validated['pihak' . ($index + 1)] = $p['nama'] ?? '';
                $validated['institusi' . ($index + 1)] = $p['institusi'] ?? '';
                $validated['jabatan' . ($index + 1)] = $p['jabatan'] ?? '';
                $validated['nama' . ($index + 1)] = $p['nama'] ?? '';
            }
        }

        for ($i = 1; $i <= 2; $i++) {
            if (!isset($validated['pihak' . $i])) $validated['pihak' . $i] = '';
            if (!isset($validated['institusi' . $i])) $validated['institusi' . $i] = '';
            if (!isset($validated['jabatan' . $i])) $validated['jabatan' . $i] = '';
            if (!isset($validated['nama' . $i])) $validated['nama' . $i] = '';
        }

        unset($validated['pihak']);
        $validated['user_id'] = auth()->id();

        $letter = PersonalLetterDinas::create($validated);

        return redirect()->route('transaction.personal.surat_dinas.show', $letter->id)
            ->with('success', 'Surat dinas berhasil dibuat!');
    }

    public function show($id)
    {
        $letter = PersonalLetterDinas::findOrFail($id);
        return view('pages.transaction.personal.templates.suratdinas.show', compact('letter'));
    }

    public function edit($id)
    {
        $data = PersonalLetterDinas::findOrFail($id);
        return view('pages.transaction.personal.templates.suratdinas.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $letter = PersonalLetterDinas::findOrFail($id);

        $validated = $request->validate([
            'template_type' => 'required|string',
            'kop_type' => 'required|string',
            'nomor' => 'required|string|max:255',
            'letter_date' => 'required|date',
            'tempat' => 'required|string|max:255',
            'sifat' => 'nullable|string|max:255',
            'lampiran' => 'nullable|string|max:255',
            'perihal' => 'required|string|max:255',
            'kepada' => 'required|string|max:255',
            'kepada_tempat' => 'required|string|max:255',
            'sehubungan_dengan' => 'required|string',
            'isi_surat' => 'nullable|string',
            'nama1' => 'required|string|max:255',
            'jabatan1' => 'required|string|max:255',
            'nip' => 'nullable|string|max:255',
            'tembusan' => 'nullable|array',
            'tembusan.*' => 'nullable|string',
            'pihak' => 'nullable|array',
            'pihak.*.nama' => 'nullable|string|max:255',
        ]);

        if (!empty($validated['tembusan'])) {
            $validated['tembusan_data'] = array_filter($validated['tembusan'], fn($item) => !empty(trim($item)));
            $validated['tembusan_data'] = array_values($validated['tembusan_data']);
        }
        unset($validated['tembusan']);

        if (!empty($validated['pihak'])) {
            foreach ($validated['pihak'] as $index => $p) {
                $validated['pihak' . ($index + 1)] = $p['nama'] ?? '';
                $validated['institusi' . ($index + 1)] = $p['institusi'] ?? '';
                $validated['jabatan' . ($index + 1)] = $p['jabatan'] ?? '';
                $validated['nama' . ($index + 1)] = $p['nama'] ?? '';
            }
        }

        for ($i = 1; $i <= 2; $i++) {
            if (!isset($validated['pihak' . $i])) $validated['pihak' . $i] = '';
            if (!isset($validated['institusi' . $i])) $validated['institusi' . $i] = '';
            if (!isset($validated['jabatan' . $i])) $validated['jabatan' . $i] = '';
            if (!isset($validated['nama' . $i])) $validated['nama' . $i] = '';
            if (!isset($validated['tentang'])) $validated['tentang'] = '';
        }

        unset($validated['pihak']);

        $letter->update($validated);

        if ($letter->generated_file) {
            Storage::delete('public/personal_letters/' . $letter->generated_file);
            $letter->update(['generated_file' => null]);
        }

        return redirect()->route('transaction.personal.surat_dinas.show', $letter->id)
            ->with('success', 'Surat dinas berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $letter = PersonalLetterDinas::findOrFail($id);

        if ($letter->generated_file) {
            Storage::delete('public/personal_letters/' . $letter->generated_file);
        }

        $letter->delete();

        return redirect()->route('transaction.personal.surat_dinas.index')
            ->with('success', 'Surat berhasil dihapus!');
    }

    public function preview($id)
    {
        $letter = PersonalLetterDinas::findOrFail($id);

        $pdf = Pdf::loadView('pages.pdf.personal.surat_dinas', compact('letter'))
                  ->setPaper('A4', 'portrait')
                  ->setOptions([
                      'isHtml5ParserEnabled' => true,
                      'isPhpEnabled' => true,
                      'defaultFont' => 'DejaVu Sans',
                  ]);

        return $pdf->stream('Preview_Surat_Dinas.pdf');
    }

    public function download($id)
    {
        $letter = PersonalLetterDinas::findOrFail($id);

        $pdf = Pdf::loadView('pages.pdf.personal.surat_dinas', compact('letter'))
                  ->setPaper('A4', 'portrait')
                  ->setOptions([
                      'isHtml5ParserEnabled' => true,
                      'isPhpEnabled' => true,
                      'defaultFont' => 'DejaVu Sans',
                  ]);

        $filename = 'Surat_Dinas_' . 
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