<?php

namespace App\Http\Controllers\PersonalLetter;

use App\Http\Controllers\Controller;
use App\Models\PersonalLetterNotulen;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class SuratNotulenController extends Controller
{
    public function index(Request $request)
    {
        $query = PersonalLetterNotulen::with('user')->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('isi_notulen', 'like', "%{$search}%")
                  ->orWhere('pimpinan_rapat', 'like', "%{$search}%")
                  ->orWhere('tempat', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('tanggal_rapat', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('tanggal_rapat', '<=', $request->date_to);
        }

        $data = $query->paginate(10)->withQueryString();

        $totalCount = PersonalLetterNotulen::count();
        $monthlyCount = PersonalLetterNotulen::whereMonth('created_at', date('m'))->count();
        $weeklyCount = PersonalLetterNotulen::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count();
        $todayCount = PersonalLetterNotulen::whereDate('created_at', today())->count();

        $title = 'Notulen';
        $icon = 'bx-notepad';
        $createRoute = route('transaction.personal.notulen.create');
        $previewRoute = 'transaction.personal.notulen.preview';
        $downloadRoute = 'transaction.personal.notulen.download';
        $editRoute = 'transaction.personal.notulen.edit';
        $deleteRoute = 'transaction.personal.notulen.destroy';

        return view('pages.transaction.personal.template-index', compact(
            'data', 'title', 'icon', 'totalCount', 'monthlyCount', 
            'weeklyCount', 'todayCount', 'createRoute', 'previewRoute', 
            'downloadRoute', 'editRoute', 'deleteRoute'
        ));
    }

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

        // Handle upload dokumentasi - PERBAIKAN: pastikan array
        $dokumentasiPaths = [];
        if ($request->hasFile('dokumentasi')) {
            foreach ($request->file('dokumentasi') as $file) {
                $path = $file->store('notulen/dokumentasi', 'public');
                $dokumentasiPaths[] = $path;
            }
        }
        
        // Simpan sebagai array (akan otomatis di-cast ke JSON oleh model)
        $validated['dokumentasi'] = $dokumentasiPaths;
        $validated['user_id'] = auth()->id();
        
        $letter = PersonalLetterNotulen::create($validated);

        return redirect()
            ->route('transaction.personal.notulen.show', $letter->id)
            ->with('success', 'Notulen berhasil dibuat!');
    }

    public function show($id)
    {
        $data = PersonalLetterNotulen::findOrFail($id);
        
        // Debug: Log data untuk checking
        \Log::info('Notulen Show Data:', [
            'id' => $data->id,
            'dokumentasi_type' => gettype($data->dokumentasi),
            'dokumentasi_value' => $data->dokumentasi,
            'dokumentasi_count' => is_array($data->dokumentasi) ? count($data->dokumentasi) : 0
        ]);
        
        return view('pages.transaction.personal.templates.notulen.show', compact('data'));
    }

    public function edit($id)
    {
        $data = PersonalLetterNotulen::findOrFail($id);
        
        // Debug: Log data untuk checking
        \Log::info('Notulen Edit Data:', [
            'id' => $data->id,
            'dokumentasi_type' => gettype($data->dokumentasi),
            'dokumentasi_value' => $data->dokumentasi,
        ]);
        
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

        // PERBAIKAN: Ambil dokumentasi yang ada sebagai array
        $existingDocs = is_array($letter->dokumentasi) ? $letter->dokumentasi : [];

        // Handle hapus dokumentasi lama
        if ($request->filled('hapus_dokumentasi')) {
            foreach ($request->hapus_dokumentasi as $indexToDelete) {
                if (isset($existingDocs[$indexToDelete])) {
                    // Hapus file dari storage
                    Storage::disk('public')->delete($existingDocs[$indexToDelete]);
                    unset($existingDocs[$indexToDelete]);
                }
            }
            // Re-index array
            $existingDocs = array_values($existingDocs);
        }

        // Handle upload dokumentasi baru
        if ($request->hasFile('dokumentasi')) {
            foreach ($request->file('dokumentasi') as $file) {
                $path = $file->store('notulen/dokumentasi', 'public');
                $existingDocs[] = $path;
            }
        }

        // Update dokumentasi dengan array yang sudah diproses
        $validated['dokumentasi'] = $existingDocs;

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
        if (is_array($letter->dokumentasi)) {
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
            ->route('transaction.personal.notulen.index')
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
                   $letter->tanggal_rapat->format('Y_m_d') . '_' . 
                   now()->format('His') . '.pdf';

        if (!$letter->generated_file) {
            $pdfContent = $pdf->output();
            Storage::put('public/personal_letters/' . $filename, $pdfContent);
            $letter->update(['generated_file' => $filename]);
        }

        return $pdf->download($filename);
    }
}