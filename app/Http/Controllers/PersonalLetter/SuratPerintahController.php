<?php

namespace App\Http\Controllers\PersonalLetter;

use App\Http\Controllers\Controller;
use App\Models\PersonalLetterPerintah;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class SuratPerintahController extends Controller
{
    public function index(Request $request)
    {
        $query = PersonalLetterPerintah::with('user')->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor', 'like', "%{$search}%")
                  ->orWhere('nama_penerima', 'like', "%{$search}%")
                  ->orWhere('nama_pembuat', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('letter_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('letter_date', '<=', $request->date_to);
        }

        $data = $query->paginate(10)->withQueryString();

        $totalCount = PersonalLetterPerintah::count();
        $monthlyCount = PersonalLetterPerintah::whereMonth('created_at', date('m'))->count();
        $weeklyCount = PersonalLetterPerintah::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count();
        $todayCount = PersonalLetterPerintah::whereDate('created_at', today())->count();

        $title = 'Surat Perintah';
        $icon = 'bx-list-check';
        $createRoute = route('transaction.personal.surat_perintah.create');
        $previewRoute = 'transaction.personal.surat_perintah.preview';
        $downloadRoute = 'transaction.personal.surat_perintah.download';
        $editRoute = 'transaction.personal.surat_perintah.edit';
        $deleteRoute = 'transaction.personal.surat_perintah.destroy';

        return view('pages.transaction.personal.template-index', compact(
            'data', 'title', 'icon', 'totalCount', 'monthlyCount', 
            'weeklyCount', 'todayCount', 'createRoute', 'previewRoute', 
            'downloadRoute', 'editRoute', 'deleteRoute'
        ));
    }

    public function create()
    {
        return view('pages.transaction.personal.templates.suratperintah.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'template_type' => 'required|string',
            'kop_type' => 'required|string',
            'nomor' => 'required|string|max:255',
            'letter_date' => 'required|date',
            'tempat' => 'required|string|max:255',
            
            // Menimbang - array dinamis
            'menimbang' => 'required|array|min:1',
            'menimbang.*' => 'required|string',
            
            // Dasar - array dinamis
            'dasar' => 'required|array|min:1',
            'dasar.*' => 'required|string',
            
            // Penerima - opsional
            'nama_penerima' => 'nullable|string|max:255',
            'nik_penerima' => 'nullable|string|max:255',
            'jabatan_penerima' => 'nullable|string|max:255',
            'nama_nama_terlampir' => 'nullable|string',
            
            // Untuk - array dinamis
            'untuk' => 'required|array|min:1',
            'untuk.*' => 'required|string',
            
            // Tembusan - array dinamis, opsional
            'tembusan' => 'nullable|array',
            'tembusan.*' => 'nullable|string',
            
            // Pembuat
            'jabatan_pembuat' => 'required|string|max:255',
            'nama_pembuat' => 'required|string|max:255',
            'nik_pembuat' => 'required|string|max:255',
            
            // Lampiran - opsional
            'lampiran' => 'nullable|array',
            'lampiran.*.nama' => 'required_with:lampiran|string|max:255',
            'lampiran.*.nik' => 'required_with:lampiran|string|max:255',
            'lampiran.*.jabatan' => 'nullable|string|max:255',
            'lampiran.*.keterangan' => 'nullable|string|max:255',
        ]);

        // Filter tembusan yang kosong
        if (!empty($validated['tembusan'])) {
            $validated['tembusan'] = array_values(array_filter($validated['tembusan'], function($item) {
                return !empty(trim($item));
            }));
            if (empty($validated['tembusan'])) {
                $validated['tembusan'] = null;
            }
        }

        $validated['user_id'] = auth()->id();
        $letter = PersonalLetterPerintah::create($validated);

        return redirect()->route('transaction.personal.surat_perintah.show', $letter->id)
            ->with('success', 'Surat perintah berhasil dibuat!');
    }

    public function show($id)
    {
        $data = PersonalLetterPerintah::findOrFail($id);
        return view('pages.transaction.personal.templates.suratperintah.show', compact('data'));
    }

    public function edit($id)
    {
        $data = PersonalLetterPerintah::findOrFail($id);
        return view('pages.transaction.personal.templates.suratperintah.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $letter = PersonalLetterPerintah::findOrFail($id);

        $validated = $request->validate([
            'template_type' => 'required|string',
            'kop_type' => 'required|string',
            'nomor' => 'required|string|max:255',
            'letter_date' => 'required|date',
            'tempat' => 'required|string|max:255',
            
            'menimbang' => 'required|array|min:1',
            'menimbang.*' => 'required|string',
            
            'dasar' => 'required|array|min:1',
            'dasar.*' => 'required|string',
            
            'nama_penerima' => 'nullable|string|max:255',
            'nik_penerima' => 'nullable|string|max:255',
            'jabatan_penerima' => 'nullable|string|max:255',
            'nama_nama_terlampir' => 'nullable|string',
            
            'untuk' => 'required|array|min:1',
            'untuk.*' => 'required|string',
            
            'tembusan' => 'nullable|array',
            'tembusan.*' => 'nullable|string',
            
            'jabatan_pembuat' => 'required|string|max:255',
            'nama_pembuat' => 'required|string|max:255',
            'nik_pembuat' => 'required|string|max:255',
            
            'lampiran' => 'nullable|array',
            'lampiran.*.nama' => 'required_with:lampiran|string|max:255',
            'lampiran.*.nik' => 'required_with:lampiran|string|max:255',
            'lampiran.*.jabatan' => 'nullable|string|max:255',
            'lampiran.*.keterangan' => 'nullable|string|max:255',
        ]);

        // Filter tembusan yang kosong
        if (!empty($validated['tembusan'])) {
            $validated['tembusan'] = array_values(array_filter($validated['tembusan'], function($item) {
                return !empty(trim($item));
            }));
            if (empty($validated['tembusan'])) {
                $validated['tembusan'] = null;
            }
        }

        $letter->update($validated);

        if ($letter->generated_file) {
            Storage::delete('public/personal_letters/' . $letter->generated_file);
            $letter->update(['generated_file' => null]);
        }

        return redirect()->route('transaction.personal.surat_perintah.show', $letter->id)
            ->with('success', 'Surat perintah berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $letter = PersonalLetterPerintah::findOrFail($id);

        if ($letter->generated_file) {
            Storage::delete('public/personal_letters/' . $letter->generated_file);
        }

        $letter->delete();

        return redirect()->route('transaction.personal.surat_perintah.index')
            ->with('success', 'Surat berhasil dihapus!');
    }

    public function preview($id)
    {
        $letter = PersonalLetterPerintah::findOrFail($id);

        $pdf = Pdf::loadView('pages.pdf.personal.surat_perintah', compact('letter'))
                  ->setPaper('A4', 'portrait')
                  ->setOptions([
                      'isHtml5ParserEnabled' => true,
                      'isPhpEnabled' => true,
                      'defaultFont' => 'DejaVu Sans',
                  ]);

        return $pdf->stream('Preview_Surat_Perintah.pdf');
    }

    public function download($id)
    {
        $letter = PersonalLetterPerintah::findOrFail($id);

        $pdf = Pdf::loadView('pages.pdf.personal.surat_perintah', compact('letter'))
                  ->setPaper('A4', 'portrait')
                  ->setOptions([
                      'isHtml5ParserEnabled' => true,
                      'isPhpEnabled' => true,
                      'defaultFont' => 'DejaVu Sans',
                  ]);

        $filename = 'Surat_Perintah_' . 
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