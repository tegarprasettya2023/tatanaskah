<?php

namespace App\Http\Controllers\PersonalLetter;

use App\Http\Controllers\Controller;
use App\Models\PersonalLetterPanggilan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class SuratPanggilanController extends Controller
{
    public function index(Request $request)
    {
        $query = PersonalLetterPanggilan::with('user')->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor', 'like', "%{$search}%")
                  ->orWhere('kepada', 'like', "%{$search}%")
                  ->orWhere('perihal', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('letter_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('letter_date', '<=', $request->date_to);
        }

        $data = $query->paginate(10)->withQueryString();

        $totalCount = PersonalLetterPanggilan::count();
        $monthlyCount = PersonalLetterPanggilan::whereMonth('created_at', date('m'))->count();
        $weeklyCount = PersonalLetterPanggilan::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count();
        $todayCount = PersonalLetterPanggilan::whereDate('created_at', today())->count();

        $title = 'Surat Panggilan';
        $icon = 'bx-phone-call';
        $createRoute = route('transaction.personal.surat_panggilan.create');
        $previewRoute = 'transaction.personal.surat_panggilan.preview';
        $downloadRoute = 'transaction.personal.surat_panggilan.download';
        $editRoute = 'transaction.personal.surat_panggilan.edit';
        $deleteRoute = 'transaction.personal.surat_panggilan.destroy';

        return view('pages.transaction.personal.template-index', compact(
            'data', 'title', 'icon', 'totalCount', 'monthlyCount', 
            'weeklyCount', 'todayCount', 'createRoute', 'previewRoute', 
            'downloadRoute', 'editRoute', 'deleteRoute'
        ));
    }

    public function create()
    {
        return view('pages.transaction.personal.templates.suratpanggilan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'template_type' => 'nullable|string',
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
            'tembusan' => 'nullable|array',
            'tembusan.*' => 'nullable|string',
        ]);

        // Filter tembusan yang kosong
        if (isset($validated['tembusan']) && is_array($validated['tembusan'])) {
            $validated['tembusan'] = array_values(array_filter($validated['tembusan'], function($item) {
                return $item !== null && $item !== false && trim((string)$item) !== '';
            }));
            if (empty($validated['tembusan'])) {
                $validated['tembusan'] = null;
            }
        } else {
            $validated['tembusan'] = null;
        }

        // Generate nomor otomatis
        $month = Carbon::parse($validated['letter_date'])->format('m');
        $year  = Carbon::parse($validated['letter_date'])->format('Y');
        $lastNumber = PersonalLetterPanggilan::whereMonth('letter_date', $month)
            ->whereYear('letter_date', $year)
            ->count() + 1;

        $validated['nomor'] = 'P/' . str_pad($lastNumber, 3, '0', STR_PAD_LEFT) . '/' . $month . '/' . $year;
        $validated['template_type'] = $validated['template_type'] ?? 'surat_panggilan';
        $validated['user_id'] = auth()->id();

        $letter = PersonalLetterPanggilan::create($validated);

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
            'tembusan' => 'nullable|array',
            'tembusan.*' => 'nullable|string',
        ]);

        // Filter tembusan yang kosong
        if (isset($validated['tembusan']) && is_array($validated['tembusan'])) {
            $validated['tembusan'] = array_values(array_filter($validated['tembusan'], function($item) {
                return $item !== null && $item !== false && trim((string)$item) !== '';
            }));
            if (empty($validated['tembusan'])) {
                $validated['tembusan'] = null;
            }
        } else {
            $validated['tembusan'] = null;
        }

        $letter->update($validated);

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

        return redirect()->route('transaction.personal.surat_panggilan.index')
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