<?php

namespace App\Http\Controllers\PersonalLetter;

use App\Http\Controllers\Controller;
use App\Models\PersonalLetterSpo;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SuratSpoController extends Controller
{
public function index(Request $request)
{
    $query = PersonalLetterSpo::with('user')->orderBy('created_at', 'desc');

    if ($request->filled('search')) {
        $query->search($request->search);
    }

    if ($request->filled('date_from')) {
        $query->whereDate('tanggal_terbit', '>=', $request->date_from);
    }
    if ($request->filled('date_to')) {
        $query->whereDate('tanggal_terbit', '<=', $request->date_to);
    }

    $data = $query->paginate(10)->withQueryString();

    $totalCount = PersonalLetterSpo::count();
    $monthlyCount = PersonalLetterSpo::whereMonth('created_at', date('m'))->count();
    $weeklyCount = PersonalLetterSpo::whereBetween('created_at', [
        Carbon::now()->startOfWeek(),
        Carbon::now()->endOfWeek()
    ])->count();
    $todayCount = PersonalLetterSpo::whereDate('created_at', today())->count();

    $title = 'SPO';
    $icon = 'bx-file-blank';
    $createRoute = route('transaction.personal.spo.create');
    $previewRoute = 'transaction.personal.spo.preview';
    $downloadRoute = 'transaction.personal.spo.download';
    $editRoute = 'transaction.personal.spo.edit';
    $deleteRoute = 'transaction.personal.spo.destroy';

    return view('pages.transaction.personal.template-index', compact(
        'data', 'title', 'icon', 'totalCount', 'monthlyCount', 
        'weeklyCount', 'todayCount', 'createRoute', 'previewRoute', 
        'downloadRoute', 'editRoute', 'deleteRoute'
    ));
}
    public function create()
    {
        return view('pages.transaction.personal.templates.spo.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'logo_kiri' => 'required|in:klinik,lab,pt',
            'logo_kanan' => 'required|in:klinik,lab,pt',
            'kop_type' => 'required|in:klinik,lab,pt',
            'judul_spo' => 'required|string',
            'no_dokumen' => 'required|string',
            'tanggal_terbit' => 'required|date',
            'bagan_alir_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $data = $request->except('bagan_alir_image');
        
        // Handle image upload
        if ($request->hasFile('bagan_alir_image')) {
            $file = $request->file('bagan_alir_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/spo'), $filename);
            $data['bagan_alir_image'] = 'uploads/spo/' . $filename;
        }

        // Set nomor dan letter_date untuk index display
        $data['nomor'] = $request->no_dokumen;
        $data['letter_date'] = $request->tanggal_terbit;

        $spo = PersonalLetterSpo::create($data);

        // Generate PDF
        $this->generatePdf($spo);

        return redirect()->route('transaction.personal.index')
            ->with('success', 'SPO berhasil dibuat!');
    }

    public function show($id)
    {
        $data = PersonalLetterSpo::findOrFail($id);
        return view('pages.transaction.personal.templates.spo.show', compact('data'));
    }

    public function edit($id)
    {
        $data = PersonalLetterSpo::findOrFail($id);
        return view('pages.transaction.personal.templates.spo.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $spo = PersonalLetterSpo::findOrFail($id);

        $validated = $request->validate([
            'logo_kiri' => 'required|in:klinik,lab,pt',
            'logo_kanan' => 'required|in:klinik,lab,pt',
            'kop_type' => 'required|in:klinik,lab,pt',
            'judul_spo' => 'required|string',
            'no_dokumen' => 'required|string',
            'tanggal_terbit' => 'required|date',
            'bagan_alir_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $data = $request->except('bagan_alir_image');
        
        // Handle new image upload
        if ($request->hasFile('bagan_alir_image')) {
            // Delete old image
            if ($spo->bagan_alir_image && file_exists(public_path($spo->bagan_alir_image))) {
                unlink(public_path($spo->bagan_alir_image));
            }
            
            $file = $request->file('bagan_alir_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/spo'), $filename);
            $data['bagan_alir_image'] = 'uploads/spo/' . $filename;
        }

        // Update nomor dan letter_date
        $data['nomor'] = $request->no_dokumen;
        $data['letter_date'] = $request->tanggal_terbit;

        $spo->update($data);

        // Regenerate PDF
        $this->generatePdf($spo);

        return redirect()->route('transaction.personal.index')
            ->with('success', 'SPO berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $spo = PersonalLetterSpo::findOrFail($id);
        
        // Delete image file
        if ($spo->bagan_alir_image && file_exists(public_path($spo->bagan_alir_image))) {
            unlink(public_path($spo->bagan_alir_image));
        }
        
        // Delete PDF file
        if ($spo->generated_file && file_exists(public_path($spo->generated_file))) {
            unlink(public_path($spo->generated_file));
        }
        
        $spo->delete();

        return redirect()->route('transaction.personal.index')
            ->with('success', 'SPO berhasil dihapus!');
    }

    public function preview($id)
    {
        $spo = PersonalLetterSpo::findOrFail($id);
        $pdf = $this->createPdf($spo);

        // Bersihkan nama file dari karakter ilegal
        $safeFilename = Str::slug($spo->no_dokumen, '-');

        return $pdf->stream('SPO_' . $safeFilename . '.pdf');
    }

    public function download($id)
    {
        $spo = PersonalLetterSpo::findOrFail($id);
        $pdf = $this->createPdf($spo);

        // Bersihkan nama file dari karakter ilegal
        $safeFilename = Str::slug($spo->no_dokumen, '-');

        return $pdf->download('SPO_' . $safeFilename . '.pdf');
    }

    private function generatePdf($spo)
    {
        $pdf = $this->createPdf($spo);

        // Pastikan nama file aman
        $safeFilename = Str::slug($spo->no_dokumen, '-');
        $filename = 'spo_' . $safeFilename . '_' . time() . '_' . $spo->id . '.pdf';
        $path = 'uploads/pdf/' . $filename;

        if (!file_exists(public_path('uploads/pdf'))) {
            mkdir(public_path('uploads/pdf'), 0777, true);
        }

        $pdf->save(public_path($path));

        $spo->update(['generated_file' => $path]);
    }

    private function createPdf($spo)
    {
        $pdf = Pdf::loadView('pages.pdf.personal.spo', compact('spo'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf;
    }
}
