<?php

namespace App\Http\Controllers\PersonalLetter;

use App\Http\Controllers\Controller;
use App\Models\PersonalLetterKeputusan;
use Illuminate\Http\Request;
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
            'judul_2' => 'nullable|string|max:255',
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
            'lampiran' => 'nullable|array',
            'lampiran.*' => 'nullable|string',
        ]);

        // Sanitasi HTML untuk keamanan (opsional tapi direkomendasikan)
        if (isset($validated['lampiran'])) {
            $validated['lampiran'] = array_map(function($html) {
                return $this->sanitizeHtml($html);
            }, $validated['lampiran']);
        }

        // Filter tembusan yang kosong - PENTING: Cek setiap item
        if (isset($validated['tembusan']) && is_array($validated['tembusan'])) {
            $validated['tembusan'] = array_values(array_filter($validated['tembusan'], function($item) {
                // Pastikan bukan null, bukan false, dan setelah di-trim tidak kosong
                return $item !== null && $item !== false && trim((string)$item) !== '';
            }));
            // Jika hasil filter kosong, set ke null (bukan array kosong)
            if (empty($validated['tembusan'])) {
                $validated['tembusan'] = null;
            }
        } else {
            // Jika tidak ada tembusan sama sekali
            $validated['tembusan'] = null;
        }

        // Filter lampiran yang kosong
        if (isset($validated['lampiran']) && is_array($validated['lampiran'])) {
            $validated['lampiran'] = array_values(array_filter($validated['lampiran'], function($item) {
                if ($item === null || $item === false) return false;
                $stripped = strip_tags((string)$item);
                return trim($stripped) !== '';
            }));
            // Jika hasil filter kosong, set ke null
            if (empty($validated['lampiran'])) {
                $validated['lampiran'] = null;
            }
        } else {
            // Jika tidak ada lampiran sama sekali
            $validated['lampiran'] = null;
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
            'judul_2' => 'nullable|string|max:255',
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
            'lampiran' => 'nullable|array',
            'lampiran.*' => 'nullable|string',
        ]);

        // Sanitasi HTML untuk keamanan
        if (isset($validated['lampiran'])) {
            $validated['lampiran'] = array_map(function($html) {
                return $this->sanitizeHtml($html);
            }, $validated['lampiran']);
        }

        // Filter tembusan yang kosong
        if (isset($validated['tembusan'])) {
            $validated['tembusan'] = array_values(array_filter($validated['tembusan'], function($item) {
                return !empty(trim($item));
            }));
            // Jika semua tembusan kosong, set ke null
            if (empty($validated['tembusan'])) {
                $validated['tembusan'] = null;
            }
        }

        // Filter lampiran yang kosong
        if (isset($validated['lampiran'])) {
            $validated['lampiran'] = array_values(array_filter($validated['lampiran'], function($item) {
                $stripped = strip_tags($item);
                return !empty(trim($stripped));
            }));
            // Jika semua lampiran kosong, set ke null
            if (empty($validated['lampiran'])) {
                $validated['lampiran'] = null;
            }
        }

        $data->update($validated);

        return redirect()->route('transaction.personal.surat_keputusan.show', $data->id)
            ->with('success', 'Surat Keputusan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $data = PersonalLetterKeputusan::findOrFail($id);
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

        $safeNomor = str_replace(['/', '\\'], '_', $data->nomor);

        return $pdf->download('Surat_Keputusan_' . $safeNomor . '.pdf');
    }

    /**
     * Sanitasi HTML untuk mencegah XSS
     * Hanya izinkan tag-tag aman untuk formatting dokumen
     */
    private function sanitizeHtml($html)
    {
        if (empty($html)) {
            return $html;
        }

        // Tag yang diizinkan dari Quill editor
        $allowedTags = '<p><br><strong><em><u><s><h1><h2><h3><h4><h5><h6><ul><ol><li><a><blockquote>';
        
        // Strip tag yang tidak diizinkan
        $cleaned = strip_tags($html, $allowedTags);
        
        // Hapus atribut berbahaya dari tag <a>
        $cleaned = preg_replace('/<a[^>]*href=["\']javascript:[^"\']*["\'][^>]*>/i', '', $cleaned);
        $cleaned = preg_replace('/<a[^>]*onclick=[^>]*>/i', '<a>', $cleaned);
        
        // Izinkan hanya atribut class untuk alignment dari Quill
        $cleaned = preg_replace('/<([a-z]+)[^>]*class=["\']?(ql-align-[a-z]+)["\']?[^>]*>/i', '<$1 class="$2">', $cleaned);
        
        return $cleaned;
    }
}