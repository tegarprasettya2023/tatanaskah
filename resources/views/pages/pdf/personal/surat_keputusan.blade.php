<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keputusan</title>
    <style>
        @page {
            margin: 120px 40px 100px 40px;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        .header {
            position: fixed;
            top: -120px;
            left: -40px;
            right: 30px;
            width: 113%;
            height: 100px;
            text-align: center;
        }

        .header img {
            width: 100%;
            height: 100px;
            object-fit: contain;
        }

        .footer {
            position: fixed;
            bottom: -80px;
            left: 0;
            right: 0;
            width: 100%;
            height: 40px;
            text-align: center;
        }

        .footer img {
            width: 100%;
            height: 40px;
            object-fit: contain;
        }

        .content {
            margin: 0;
        }

        .title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .subtitle {
            text-align: center;
            margin-bottom: 3px;
        }

        .nomor {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .section-title {
            text-align: center;
            font-weight: bold;
            margin: 15px 0 10px 0;
        }

        .indent-text {
            text-align: justify;
            margin-left: 40px;
            margin-right: 40px;
            margin-bottom: 15px;
        }

        .list-item {
            margin-left: 60px;
            margin-right: 40px;
            text-align: justify;
            margin-bottom: 8px;
        }

        .memutuskan {
            text-align: center;
            font-weight: bold;
            margin: 20px 0;
        }

        .menetapkan-title {
            margin-left: 40px;
            margin-bottom: 5px;
        }

        .keputusan-item {
            margin-left: 40px;
            margin-right: 40px;
            text-align: justify;
            margin-bottom: 10px;
        }

        .penutup {
            margin-top: 30px;
            margin-left: 40px;
        }

        .signature {
            margin-top: 80px;
            margin-left: 40px;
        }

        .signature-name {
            font-weight: bold;
            margin-top: 5px;
        }

        .tembusan {
            margin-top: 40px;
            margin-left: 40px;
        }

        .tembusan-title {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .page-break {
            page-break-before: always;
        }

        /* Lampiran Page */
        .lampiran-header {
            text-align: right;
            margin-bottom: 20px;
        }

        .lampiran-content {
            margin: 20px 40px;
        }
    </style>
</head>
<body>

{{-- HEADER --}}
<div class="header">
    @php
        $headerPath = '';
        $kopType = $letter->kop_type ?? 'lab';
        if($kopType === 'klinik') $headerPath = public_path('kop/header_klinik.png');
        elseif($kopType === 'lab') $headerPath = public_path('kop/header_lab.png');
        elseif($kopType === 'pt') $headerPath = public_path('kop/header_pt.png');

        if(file_exists($headerPath)) {
            $imageData = base64_encode(file_get_contents($headerPath));
            $mimeType = mime_content_type($headerPath);
            echo '<img src="data:' . $mimeType . ';base64,' . $imageData . '" alt="Header">';
        }
    @endphp
</div>

{{-- FOOTER --}}
<div class="footer">
    @php
        $footerPath = '';
        if($kopType === 'klinik') $footerPath = public_path('footer/footer_klinik.png');
        elseif($kopType === 'lab') $footerPath = public_path('footer/footer_lab.png');
        elseif($kopType === 'pt') $footerPath = public_path('footer/footer_pt.png');

        if(file_exists($footerPath)) {
            $imageData = base64_encode(file_get_contents($footerPath));
            $mimeType = mime_content_type($footerPath);
            echo '<img src="data:' . $mimeType . ';base64,' . $imageData . '" alt="Footer">';
        }
    @endphp
</div>

{{-- CONTENT --}}
<div class="content">
    {{-- Title --}}
    <div class="subtitle">{{ strtoupper($letter->judul_setelah_sk ?? 'LABORATORIUM MEDIS KHUSUS PATOLOGI KLINIK UTAMA TRISENSA') }}</div>
    <div class="nomor">NOMOR: {{ $letter->generateNomorSK() }}</div>

    {{-- TENTANG --}}
    <div class="section-title">TENTANG</div>
    <div class="indent-text">{{ strtoupper($letter->tentang ?? '') }}</div>

    {{-- MENIMBANG --}}
    @if(!empty($letter->menimbang) && is_array($letter->menimbang))
    <div class="menetapkan-title"><strong>Menimbang:</strong></div>
    @foreach($letter->menimbang as $index => $item)
        @if(!empty($item))
        <div class="list-item">
            {{ chr(97 + $index) }}. bahwa {{ $item }}
        </div>
        @endif
    @endforeach
    @endif

    {{-- MENGINGAT --}}
    @if(!empty($letter->mengingat) && is_array($letter->mengingat))
    <div class="menetapkan-title" style="margin-top: 15px;"><strong>Mengingat:</strong></div>
    @foreach($letter->mengingat as $index => $item)
        @if(!empty($item))
        <div class="list-item">
            {{ chr(97 + $index) }}. Undang-undang {{ $item }}
        </div>
        @endif
    @endforeach
    @endif

    {{-- MEMUTUSKAN --}}
    <div class="memutuskan">MEMUTUSKAN:</div>

    {{-- MENETAPKAN --}}
    <div class="menetapkan-title"><strong>Menetapkan:</strong></div>
    <div class="list-item"> {{ strtoupper($letter->menetapkan ?? 'KEPUTUSAN KEPALA LABORATORIUM MEDIS KHUSUS PATOLOGI KLINIK UTAMA TRISENSA TENTANG') }}{{ strtoupper($letter->tentang ?? '') }}.</div>

    {{-- KEPUTUSAN (Kesatu, Kedua, dst) --}}
    @if(!empty($letter->keputusan) && is_array($letter->keputusan))
        @php
            $angkaTerbilang = ['', 'Kesatu', 'Kedua', 'Ketiga', 'Keempat', 'Kelima', 'Keenam', 'Ketujuh', 'Kedelapan', 'Kesembilan', 'Kesepuluh'];
        @endphp
        @foreach($letter->keputusan as $index => $item)
            @if(!empty($item))
            <div class="keputusan-item">
                <strong>{{ $angkaTerbilang[$index + 1] ?? ($index + 1) }}</strong>
                <span style="margin-left: 20px;">:</span> {{ $item }}
            </div>
            @endif
        @endforeach
    @endif

    {{-- PENUTUP --}}
    <div class="penutup">
        <!-- <div style="margin-bottom: 5px;">Ditetapkan di:</div>
        <div style="margin-bottom: 5px;">pada tanggal:</div> -->
        <div style="margin-bottom: 5px;">{{ $letter->ditetapkan_di ?? '........................................' }}</div>
        <div style="margin-bottom: 5px;">{{ $letter->tanggal_ditetapkan ? $letter->tanggal_ditetapkan->translatedFormat('d F Y') : '........................................' }}</div>
        <div style="margin-bottom: 5px;">{{ $letter->nama_jabatan ?? '' }}</div>
    </div>

    {{-- SIGNATURE --}}
    <div class="signature">
        <div style="height: 60px;"></div>
        <div class="signature-name">{{ $letter->nama_lengkap ?? '(Nama Lengkap)' }}</div>
        <div>{{ $letter->nik_kepegawaian ? 'NIKepegawaian: ' . $letter->nik_kepegawaian : '' }}</div>
    </div>

    {{-- TEMBUSAN --}}
    @if(!empty($letter->tembusan) && is_array($letter->tembusan))
    <div class="tembusan">
        <div class="tembusan-title">Tembusan</div>
        @foreach($letter->tembusan as $index => $item)
            @if(!empty($item))
            <div>{{ $index + 1 }}. {{ $item }}</div>
            @endif
        @endforeach
    </div>
    @endif
</div>

{{-- HALAMAN 2 - LAMPIRAN --}}
<div class="page-break"></div>
<div class="content">
    <div class="lampiran-header">
        <div>Lampiran</div>
        <div>{{ $letter->keputusan_dari ?? 'Keputusan Kepala Laboratorium Medis' }}</div>
        <div>{{ $letter->keputusan_dari ?? 'Khusus Patologi Klinik Utama Trisensa' }}</div>
        <div>Nomor: {{ $letter->generateNomorSK() }}</div>
        <div>Tentang: {{ $letter->lampiran_tentang ?? $letter->tentang ?? '........................................' }}</div>
        <div>Tanggal: {{ $letter->getFormattedTanggalSK() }}</div>
    </div>

    <div class="lampiran-content">
        {{-- Space untuk konten lampiran --}}
        <div style="height: 400px; border: 1px dashed #ccc; padding: 20px;">
            <em>Konten lampiran (jika ada)</em>
        </div>
    </div>

    {{-- SIGNATURE LAMPIRAN --}}
    <div class="penutup">
        <div style="margin-bottom: 5px;">Ditetapkan di:</div>
        <div style="margin-bottom: 5px;">pada tanggal:</div>
        <div style="margin-bottom: 5px;">{{ $letter->ditetapkan_di ?? '........................................' }}</div>
        <div style="margin-bottom: 5px;">{{ $letter->tanggal_ditetapkan ? $letter->tanggal_ditetapkan->translatedFormat('d F Y') : '........................................' }}</div>
        <div style="margin-bottom: 5px;">Nama jabatan,</div>
        <div style="margin-bottom: 5px;">{{ $letter->nama_jabatan ?? '' }}</div>
    </div>

    <div class="signature">
        <div style="height: 60px;"></div>
        <div style="margin-bottom: 5px;">Tanda Tangan dan Stempel</div>
        <div class="signature-name">{{ $letter->nama_lengkap ?? '(Nama Lengkap)' }}</div>
        <div>{{ $letter->nik_kepegawaian ? 'NIKepegawaian: ' . $letter->nik_kepegawaian : '' }}</div>
    </div>
</div>

</body>
</html>