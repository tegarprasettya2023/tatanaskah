<?php

namespace App\Http\Controllers\PersonalLetter;

use App\Http\Controllers\Controller;
use App\Models\PersonalLetterKuasa;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class SuratKuasaController extends Controller
{
    public function index(Request $request)
    {
        $query = PersonalLetterKuasa::with('user')->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor', 'like', "%{$search}%")
                  ->orWhere('nama_pemberi', 'like', "%{$search}%")
                  ->orWhere('nama_penerima', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('letter_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('letter_date', '<=', $request->date_to);
        }

        $data = $query->paginate(10)->withQueryString();

        $totalCount = PersonalLetterKuasa::count();
        $monthlyCount = PersonalLetterKuasa::whereMonth('created_at', date('m'))->count();
        $weeklyCount = PersonalLetterKuasa::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count();
        $todayCount = PersonalLetterKuasa::whereDate('created_at', today())->count();

        $title = 'Surat Kuasa';
        $icon = 'bx-user-check';
        $createRoute = route('transaction.personal.suratkuasa.create');
        $previewRoute = 'transaction.personal.suratkuasa.preview';
        $downloadRoute = 'transaction.personal.suratkuasa.download';
        $editRoute = 'transaction.personal.suratkuasa.edit';
        $deleteRoute = 'transaction.personal.suratkuasa.destroy';

        return view('pages.transaction.personal.template-index', compact(
            'data', 'title', 'icon', 'totalCount', 'monthlyCount', 
            'weeklyCount', 'todayCount', 'createRoute', 'previewRoute', 
            'downloadRoute', 'editRoute', 'deleteRoute'
        ));
    }

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

        $validated['user_id'] = auth()->id();
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

        if ($letter->generated_file) {
            Storage::delete('public/personal_letters/' . $letter->generated_file);
            $letter->update(['generated_file' => null]);
        }

        return redirect()->route('transaction.personal.suratkuasa.show', $letter->id)
            ->with('success', 'Surat kuasa berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $letter = PersonalLetterKuasa::findOrFail($id);
        
        if ($letter->generated_file) {
            Storage::delete('public/personal_letters/' . $letter->generated_file);
        }
        
        $letter->delete();

        return redirect()->route('transaction.personal.suratkuasa.index')
            ->with('success', 'Surat kuasa berhasil dihapus!');
    }

    public function preview($id)
    {
        $letter = PersonalLetterKuasa::findOrFail($id);

        $pdf = Pdf::loadView('pages.pdf.personal.surat_kuasa', compact('letter'))
                  ->setPaper('A4', 'portrait')
                  ->setOptions([
                      'isHtml5ParserEnabled' => true,
                      'isPhpEnabled' => true,
                      'defaultFont' => 'DejaVu Sans',
                  ]);

        return $pdf->stream('Preview_Surat_Kuasa.pdf');
    }

    public function download($id)
    {
        $letter = PersonalLetterKuasa::findOrFail($id);

        $pdf = Pdf::loadView('pages.pdf.personal.surat_kuasa', compact('letter'))
                  ->setPaper('A4', 'portrait')
                  ->setOptions([
                      'isHtml5ParserEnabled' => true,
                      'isPhpEnabled' => true,
                      'defaultFont' => 'DejaVu Sans',
                  ]);

        $filename = 'Surat_Kuasa_' .
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