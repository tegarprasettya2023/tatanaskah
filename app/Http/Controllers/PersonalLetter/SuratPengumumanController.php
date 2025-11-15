<?php

namespace App\Http\Controllers\PersonalLetter;

use App\Http\Controllers\Controller;
use App\Models\PersonalLetterPengumuman;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class SuratPengumumanController extends Controller
{
    public function index(Request $request)
    {
        $query = PersonalLetterPengumuman::with('user')->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor', 'like', "%{$search}%")
                  ->orWhere('tentang', 'like', "%{$search}%")
                  ->orWhere('nama_pembuat', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('tanggal_surat', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('tanggal_surat', '<=', $request->date_to);
        }

        $data = $query->paginate(10)->withQueryString();

        $totalCount = PersonalLetterPengumuman::count();
        $monthlyCount = PersonalLetterPengumuman::whereMonth('created_at', date('m'))->count();
        $weeklyCount = PersonalLetterPengumuman::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count();
        $todayCount = PersonalLetterPengumuman::whereDate('created_at', today())->count();

        $title = 'Pengumuman';
        $icon = 'bx-bullhorn';
        $createRoute = route('transaction.personal.pengumuman.create');
        $previewRoute = 'transaction.personal.pengumuman.preview';
        $downloadRoute = 'transaction.personal.pengumuman.download';
        $editRoute = 'transaction.personal.pengumuman.edit';
        $deleteRoute = 'transaction.personal.pengumuman.destroy';

        return view('pages.transaction.personal.template-index', compact(
            'data', 'title', 'icon', 'totalCount', 'monthlyCount', 
            'weeklyCount', 'todayCount', 'createRoute', 'previewRoute', 
            'downloadRoute', 'editRoute', 'deleteRoute'
        ));
    }

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
        $validated['user_id'] = auth()->id();

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

    public function destroy($id)
    {
        $letter = PersonalLetterPengumuman::findOrFail($id);

        if ($letter->generated_file) {
            Storage::delete('public/personal_letters/' . $letter->generated_file);
        }

        $letter->delete();

        return redirect()->route('transaction.personal.pengumuman.index')
            ->with('success', 'Surat berhasil dihapus!');
    }

    public function preview($id)
    {
        $letter = PersonalLetterPengumuman::findOrFail($id);

        $pdf = Pdf::loadView('pages.pdf.personal.pengumuman', compact('letter'))
            ->setPaper('A4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => true,
                'defaultFont' => 'DejaVu Sans',
            ]);

        return $pdf->stream('Preview_Surat_Pengumuman.pdf');
    }

    public function download($id)
    {
        $letter = PersonalLetterPengumuman::findOrFail($id);

        $pdf = Pdf::loadView('pages.pdf.personal.pengumuman', compact('letter'))
            ->setPaper('A4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => true,
                'defaultFont' => 'DejaVu Sans',
            ]);

        $filename = 'Surat_Pengumuman_' . str_replace(['/', ' '], ['_', '_'], $letter->nomor) . '_' . now()->format('Y_m_d') . '.pdf';

        if (!$letter->generated_file) {
            $pdfContent = $pdf->output();
            Storage::put('public/personal_letters/' . $filename, $pdfContent);
            $letter->update(['generated_file' => $filename]);
        }

        return $pdf->download($filename);
    }
}