<?php

namespace App\Http\Controllers\PersonalLetter;

use App\Http\Controllers\Controller;
use App\Models\PersonalLetter;
use App\Models\PersonalLetterDinas;
use App\Models\PersonalLetterKeterangan;
use App\Models\PersonalLetterPerintah;
use App\Models\PersonalLetterKuasa;
use App\Models\PersonalLetterUndangan;
use App\Models\PersonalLetterPanggilan;
use App\Models\PersonalLetterMemo;
use App\Models\PersonalLetterPengumuman;
use App\Models\PersonalLetterNotulen;
use App\Models\PersonalLetterBeritaAcara;
use App\Models\PersonalLetterDisposisi;
use App\Models\PersonalLetterKeputusan;
use App\Models\PersonalLetterInstruksiKerja;
use App\Models\PersonalLetterSPO;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class BasePersonalLetterController extends Controller
{
    
    public function index(Request $request)
    {
        // Ambil semua surat perjanjian
        $perjanjian = PersonalLetter::query();
        if ($request->filled('search')) {
            $perjanjian->search($request->search);
        }
        $perjanjian = $perjanjian->get()->map(function ($item) {
            $item->jenis = 'perjanjian';
            $item->route_prefix = 'perjanjian';
            return $item;
        });

        // Ambil semua surat dinas
        $dinas = PersonalLetterDinas::query();
        if ($request->filled('search')) {
            $dinas->search($request->search);
        }
        $dinas = $dinas->get()->map(function ($item) {
            $item->jenis = 'surat_dinas';
            $item->route_prefix = 'surat_dinas';
            return $item;
        });

        // Ambil semua surat keterangan
        $keterangan = PersonalLetterKeterangan::query();
        if ($request->filled('search')) {
            $keterangan->search($request->search);
        }
        $keterangan = $keterangan->get()->map(function ($item) {
            $item->jenis = 'surat_keterangan';
            $item->route_prefix = 'surat_keterangan';
            return $item;
        });

        // Ambil semua surat perintah
        $perintah = PersonalLetterPerintah::query();
        if ($request->filled('search')) {
            $perintah->search($request->search);
        }
        $perintah = $perintah->get()->map(function ($item) {
            $item->jenis = 'surat_perintah';
            $item->route_prefix = 'surat_perintah';
            return $item;
        });

        // Ambil semua surat kuasa
        $kuasa = PersonalLetterKuasa::query();
        if ($request->filled('search')) {
            $kuasa->search($request->search);
        }
        $kuasa = $kuasa->get()->map(function ($item) {
            $item->jenis = 'surat_kuasa';
            $item->route_prefix = 'suratkuasa';
            return $item;
        });

        // Ambil semua surat undangan
        $undangan = PersonalLetterUndangan::query();
        if ($request->filled('search')) {
            $undangan->search($request->search);
        }
        $undangan = $undangan->get()->map(function ($item) {
            $item->jenis = 'surat_undangan';
            $item->route_prefix = 'surat_undangan';
            return $item;
        });
        // Ambil semua surat panggilan
        $panggilan = PersonalLetterPanggilan::query();
        if ($request->filled('search')) {
            $panggilan->search($request->search);
        }
        $panggilan = $panggilan->get()->map(function ($item) {
            $item->jenis = 'surat_panggilan';
            $item->route_prefix = 'surat_panggilan';
            return $item;
        });

        // ...Memo
        $memo = PersonalLetterMemo::query();
        if ($request->filled('search')) {
            $memo->search($request->search);
        }
        $memo = $memo->get()->map(function ($item) {
            $item->jenis = 'internal_memo';
            $item->route_prefix = 'memo';
            return $item;
        });
        // Pengumuman
        $pengumuman = PersonalLetterPengumuman::query();
        if ($request->filled('search')) {
            $pengumuman->search($request->search);
        }
        $pengumuman = $pengumuman->get()->map(function ($item) {
            $item->jenis = 'pengumuman';
            $item->route_prefix = 'pengumuman';
            return $item;
        });
        // / Ambil semua notulen
        $notulen = PersonalLetterNotulen::query();
        if ($request->filled('search')) {
            $notulen->search($request->search);
        }
        $notulen = $notulen->get()->map(function ($item) {
            $item->jenis = 'notulen';
            $item->route_prefix = 'notulen';
            return $item;
        
        });
        // Ambil semua berita acara
        $berita_acara = PersonalLetterBeritaAcara::query();
        if ($request->filled('search')) {
            $berita_acara->search($request->search);
        }
        $berita_acara = $berita_acara->get()->map(function ($item) {
            $item->jenis = 'berita_acara';
            $item->route_prefix = 'beritaacara';
            return $item;
        });
        
        // Ambil semua surat disposisi
        $disposisi = PersonalLetterDisposisi::query();
        if ($request->filled('search')) {
            $disposisi->search($request->search);
        }
        $disposisi = $disposisi->get()->map(function ($item) {
            $item->jenis = 'surat_disposisi';
            $item->route_prefix = 'suratdisposisi';
            return $item;
        });

        // Surat Keputusan
        $keputusan = PersonalLetterKeputusan::query();
        if ($request->filled('search')) {
            $keputusan->search($request->search);
        }
        $keputusan = $keputusan->get()->map(function ($item) {
            $item->jenis = 'surat_keputusan';
            $item->route_prefix = 'surat_keputusan';
            return $item;
        });

        // Ambil semua SPO
        $spo = PersonalLetterSpo::query();
        if ($request->filled('search')) {
            $spo->search($request->search);
        }
        $spo = $spo->get()->map(function ($item) {
            $item->jenis = 'spo';
            $item->route_prefix = 'spo';
            return $item;
        });

        // Gabungkan semua data
        $all = $perjanjian
            ->concat($dinas)
            ->concat($keterangan)
            ->concat($perintah)
            ->concat($kuasa)
            ->concat($undangan)
            ->concat($panggilan)
            ->concat($memo)
            ->concat($pengumuman)
            ->concat($notulen)
            ->concat($berita_acara)
            ->concat($disposisi)
            ->concat($keputusan)
            ->concat($spo)
            ->sortByDesc('created_at')
            ->values();

        // Pagination manual
        $page = request()->input('page', 1);
        $perPage = 10;
        $pagedData = $all->slice(($page - 1) * $perPage, $perPage)->values();

        $data = new LengthAwarePaginator(
            $pagedData,
            $all->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $totalTemplates = $all->count();

        return view('pages.transaction.personal.index', compact('data', 'totalTemplates'));
    }

    public function templates()
    {
        return view('pages.transaction.personal.templates');
    }
}