@extends('layout.main')

@section('content')
    <x-breadcrumb :values="[__('menu.transaction.menu'), 'Surat Pribadi', 'Pilih Template']" />

    <div class="card mb-4">
        <div class="card-header">
            <h5>Pilih Template Surat</h5>
            <p class="text-muted mb-0">Pilih jenis surat yang ingin Anda buat</p>
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
            <div class="card h-100 border-danger">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-file-earmark-text fs-1 text-danger"></i>
                    </div>
                    <h5 class="card-title">Formulir Disposisi</h5>
                    <ul class="list-unstyled text-start small">
                        <li><i class="bi bi-check-circle text-success"></i> Header & Footer Otomatis</li>
                        <li><i class="bi bi-check-circle text-success"></i> Logo Custom (Klinik/Lab/PT)</li>
                        <li><i class="bi bi-check-circle text-success"></i> Nomor Dokumen LD Auto</li>
                        <li><i class="bi bi-check-circle text-success"></i> Diteruskan Kepada Dinamis</li>
                    </ul>
                    <a href="{{ route('transaction.personal.disposisi.create') }}" 
                       class="btn btn-danger">
                       <i class="bi bi-plus-circle"></i> Buat Formulir
                    </a>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <h6><i class="bi bi-info-circle text-primary"></i> Informasi</h6>
            <ul class="mb-0">
                <li>Semua template mendukung 3 jenis kop: Klinik, Laboratorium, dan PT</li>
                <li>PDF akan otomatis dihasilkan dengan header dan footer sesuai kop yang dipilih</li>
                <li>Template dapat di-preview dan di-download dalam format PDF</li>
                <li>Data surat dapat diedit kapan saja</li>
            </ul>
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
