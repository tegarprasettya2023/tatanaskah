@extends('layout.main')

@section('content')
    <x-breadcrumb :values="[__('menu.transaction.menu'), 'Surat Pribadi', 'Pilih Template']" />

    <div class="card mb-4">
        <div class="card-header">
            <h5>Pilih Template Surat</h5>
            <p class="text-muted mb-0">Pilih jenis surat yang ingin dibuat</p>
        </div>
    </div>

    <div class="row">
        <!-- Template Perjanjian Kerjasama -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 border-primary">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-people fs-1 text-primary"></i>
                    </div>
                    <h5 class="card-title">Surat Perjanjian Kerja Sama</h5>
                    <ul class="list-unstyled text-start small">
                        <li><i class="bi bi-check-circle text-success"></i> Header & Footer Otomatis</li>
                        <li><i class="bi bi-check-circle text-success"></i> Pasal Dinamis (bisa tambah/kurang)</li>
                        <li><i class="bi bi-check-circle text-success"></i> Tanda Tangan 2 Pihak</li>
                    </ul>
                    <a href="{{ route('transaction.personal.create', ['template' => 'perjanjian_kerjasama']) }}"
                       class="btn btn-primary">
                       <i class="bi bi-plus-circle"></i> Buat Surat
                    </a>
                </div>
            </div>
        </div>

        <!-- Template Surat Dinas -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 border-success">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-envelope-paper fs-1 text-success"></i>
                    </div>
                    <h5 class="card-title">Surat Dinas</h5>
                    <ul class="list-unstyled text-start small">
                        <li><i class="bi bi-check-circle text-success"></i> Header & Footer Otomatis</li>
                        <li><i class="bi bi-check-circle text-success"></i> Nomor, Sifat, Lampiran, Perihal</li>
                        <li><i class="bi bi-check-circle text-success"></i> Tembusan Dinamis</li>
                    </ul>
                    <a href="{{ route('transaction.personal.surat_dinas.create') }}"
                       class="btn btn-success">
                       <i class="bi bi-plus-circle"></i> Buat Surat
                    </a>
                </div>
            </div>
        </div>

        <!-- Template Surat Keterangan -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 border-warning">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-file-earmark-text fs-1 text-warning"></i>
                    </div>
                    <h5 class="card-title">Surat Keterangan</h5>
                    <ul class="list-unstyled text-start small">
                        <li><i class="bi bi-check-circle text-success"></i> Header & Footer Otomatis</li>
                        <li><i class="bi bi-check-circle text-success"></i> Yang Menerangkan & Diterangkan</li>
                        <li><i class="bi bi-check-circle text-success"></i> Format Standar</li>
                    </ul>
                    <a href="{{ route('transaction.personal.surat_keterangan.create') }}" class="btn btn-warning">
                       <i class="bi bi-plus-circle"></i> Buat Surat
                    </a>
                </div>
            </div>
        </div>

        <!-- Template Surat Perintah -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 border-danger">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-clipboard-check fs-1 text-danger"></i>
                    </div>
                    <h5 class="card-title">Surat Perintah</h5>
                    <ul class="list-unstyled text-start small">
                        <li><i class="bi bi-check-circle text-success"></i> Header & Footer Otomatis</li>
                        <li><i class="bi bi-check-circle text-success"></i> Menimbang & Dasar</li>
                        <li><i class="bi bi-check-circle text-success"></i> Tugas/Perjalanan Dinas</li>
                    </ul>
                    <a href="{{ route('transaction.personal.surat_perintah.create') }}" 
                       class="btn btn-danger">
                       <i class="bi bi-plus-circle"></i> Buat Surat
                    </a>
                </div>
            </div>
        </div>

        <!-- Template Surat Kuasa -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 border-danger">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-person-check fs-1 text-danger"></i>
                    </div>
                    <h5 class="card-title">Surat Kuasa</h5>
                    <ul class="list-unstyled text-start small">
                        <li><i class="bi bi-check-circle text-success"></i> Header & Footer Otomatis</li>
                        <li><i class="bi bi-check-circle text-success"></i> Format Kuasa 2 Pihak</li>
                        <li><i class="bi bi-check-circle text-success"></i> Tanda Tangan Pemberi & Penerima</li>
                    </ul>
                    <a href="{{ route('transaction.personal.suratkuasa.create') }}" 
                       class="btn btn-danger">
                       <i class="bi bi-plus-circle"></i> Buat Surat
                    </a>
                </div>
            </div>
        </div>

        <!-- Template Surat Undangan -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 border-info">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-calendar-event fs-1 text-info"></i>
                    </div>
                    <h5 class="card-title">Surat Undangan</h5>
                    <ul class="list-unstyled text-start small">
                        <li><i class="bi bi-check-circle text-success"></i> Header & Footer Otomatis</li>
                        <li><i class="bi bi-check-circle text-success"></i> Nomor, Sifat, Lampiran, Perihal</li>
                        <li><i class="bi bi-check-circle text-success"></i> Daftar Undangan Opsional</li>
                    </ul>
                    <a href="{{ route('transaction.personal.surat_undangan.create') }}" 
                       class="btn btn-info">
                       <i class="bi bi-plus-circle"></i> Buat Surat
                    </a>
                </div>
            </div>
        </div>

        <!-- Template Surat Panggilan -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 border-secondary">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-telephone-forward fs-1 text-secondary"></i>
                    </div>
                    <h5 class="card-title">Surat Panggilan</h5>
                    <ul class="list-unstyled text-start small">
                        <li><i class="bi bi-check-circle text-success"></i> Header & Footer Otomatis</li>
                        <li><i class="bi bi-check-circle text-success"></i> Nomor Otomatis (001/bln/thn)</li>
                        <li><i class="bi bi-check-circle text-success"></i> Pilih Hari, Tanggal & Jam</li>
                    </ul>
                    <a href="{{ route('transaction.personal.surat_panggilan.create') }}" 
                    class="btn btn-secondary">
                    <i class="bi bi-plus-circle"></i> Buat Surat
                    </a>
                </div>
            </div>
        </div>
        <!-- Template Internal Memo -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 border-dark">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-journal-text fs-1 text-dark"></i>
                    </div>
                    <h5 class="card-title">Internal Memo</h5>
                    <ul class="list-unstyled text-start small">
                        <li><i class="bi bi-check-circle text-success"></i> Header & Footer Otomatis</li>
                        <li><i class="bi bi-check-circle text-success"></i> Format Memo Internal Perusahaan</li>
                        <li><i class="bi bi-check-circle text-success"></i> Isi & Penutup Standar</li>
                    </ul>
                    <a href="{{ route('transaction.personal.memo.create') }}" 
                    class="btn btn-dark">
                    <i class="bi bi-plus-circle"></i> Buat Surat
                    </a>
                </div>
            </div>
        </div>
        <!-- Template Pengumuman -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 border-primary">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-megaphone fs-1 text-primary"></i>
                    </div>
                    <h5 class="card-title">Surat Pengumuman</h5>
                    <ul class="list-unstyled text-start small">
                        <li><i class="bi bi-check-circle text-success"></i> Header & Footer Otomatis</li>
                        <li><i class="bi bi-check-circle text-success"></i> Nomor Otomatis (UM/001/bln/thn)</li>
                        <li><i class="bi bi-check-circle text-success"></i> Space TTD & Stempel Otomatis</li>
                    </ul>
                    <a href="{{ route('transaction.personal.pengumuman.create') }}" 
                       class="btn btn-primary">
                       <i class="bi bi-plus-circle"></i> Buat Surat
                    </a>
                </div>
            </div>
        </div>
        <!-- Template Notulen -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 border-success">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-journal-text fs-1 text-success"></i>
                    </div>
                    <h5 class="card-title">Notulen Rapat</h5>
                    <ul class="list-unstyled text-start small">
                        <li><i class="bi bi-check-circle text-success"></i> Header & Footer Otomatis</li>
                        <li><i class="bi bi-check-circle text-success"></i> Tabel Kegiatan Rapat Dinamis</li>
                        <li><i class="bi bi-check-circle text-success"></i> Dokumentasi dengan Upload Gambar</li>
                    </ul>
                    <a href="{{ route('transaction.personal.notulen.create') }}" 
                       class="btn btn-success">
                       <i class="bi bi-plus-circle"></i> Buat Surat
                    </a>
                </div>
            </div>
        </div>
        <!-- Template Berita Acara  -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 border-warning">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-file-earmark-ruled fs-1 text-warning"></i>
                    </div>
                    <h5 class="card-title">Berita Acara</h5>
                    <ul class="list-unstyled text-start small">
                        <li><i class="bi bi-check-circle text-success"></i> Header & Footer Otomatis</li>
                        <li><i class="bi bi-check-circle text-success"></i> 2 Pihak (Pejabat & Pihak Lain)</li>
                        <li><i class="bi bi-check-circle text-success"></i> Daftar Kegiatan Dinamis</li>
                    </ul>
                    <a href="{{ route('transaction.personal.beritaacara.create') }}" 
                       class="btn btn-warning">
                       <i class="bi bi-plus-circle"></i> Buat Surat
                    </a>
                </div>
            </div>
        </div>
<!-- Template Formulir Disposisi -->
<div class="col-md-6 col-lg-4 mb-4">
    <div class="card h-100 border-dark">
        <div class="card-body text-center">
            <div class="mb-3">
                <i class="bi bi-file-earmark-ruled fs-1 text-dark"></i>
            </div>
            <h5 class="card-title">Formulir Disposisi</h5>
            <ul class="list-unstyled text-start small">
                <li><i class="bi bi-check-circle text-success"></i> Header & Footer Otomatis</li>
                <li><i class="bi bi-check-circle text-success"></i> Logo Customizable (Klinik/Lab/PT)</li>
                <li><i class="bi bi-check-circle text-success"></i> 2 Kolom (Pembuat & Disposisi)</li>
                <li><i class="bi bi-check-circle text-success"></i> Diteruskan Kepada Dinamis</li>
            </ul>
            <a href="{{ route('transaction.personal.suratdisposisi.create') }}" 
               class="btn btn-dark">
               <i class="bi bi-plus-circle"></i> Buat Surat
            </a>
        </div>
    </div>
</div>

        <!-- Template Surat Keputusan -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 border-info">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-file-earmark-check fs-1 text-info"></i>
                    </div>
                    <h5 class="card-title">Surat Keputusan</h5>
                    <ul class="list-unstyled text-start small">
                        <li><i class="bi bi-check-circle text-success"></i> Header & Footer Otomatis</li>
                        <li><i class="bi bi-check-circle text-success"></i> Menimbang & Mengingat Dinamis</li>
                        <li><i class="bi bi-check-circle text-success"></i> Isi Keputusan Fleksibel</li>
                        <li><i class="bi bi-check-circle text-success"></i> Lampiran Opsional</li>
                    </ul>
                    <a href="{{ route('transaction.personal.surat_keputusan.create') }}" 
                    class="btn btn-info">
                    <i class="bi bi-plus-circle"></i> Buat Surat
                    </a>
                </div>
            </div>
        </div>

<!-- Template SPO -->
<div class="col-md-6 col-lg-4 mb-4">
    <div class="card h-100 border-primary">
        <div class="card-body text-center">
            <div class="mb-3">
                <i class="bi bi-clipboard-check fs-1 text-primary"></i>
            </div>
            <h5 class="card-title">Standar Prosedur Operasional (SPO)</h5>
            <ul class="list-unstyled text-start small">
                <li><i class="bi bi-check-circle text-success"></i> Header & Footer Otomatis</li>
                <li><i class="bi bi-check-circle text-success"></i> 2 Logo (Kiri & Kanan)</li>
                <li><i class="bi bi-check-circle text-success"></i> 10 Section dengan Label Edit</li>
                <li><i class="bi bi-check-circle text-success"></i> Upload Bagan Alir</li>
                <li><i class="bi bi-check-circle text-success"></i> Rekaman Histori Perubahan</li>
            </ul>
            <a href="{{ route('transaction.personal.spo.create') }}" 
               class="btn btn-primary">
               <i class="bi bi-plus-circle"></i> Buat SPO
            </a>
        </div>
    </div>
</div>
    </div>
    </div>

@endsection

@push('style')
<style>
.card {
    transition: transform 0.2s, box-shadow 0.2s;
}
.card:hover:not(.border-secondary) {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}
</style>
@endpush
