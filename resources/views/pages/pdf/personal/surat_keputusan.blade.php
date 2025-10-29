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
            font-family: 'Century Gothic', sans-serif;
            font-size: 10px;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }

        .header {
            position: fixed;
            top: -120px;
            left: -30;
            right: 30;
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
            font-size: 12px;
            margin-bottom: 5px;
        }

        .nomor {
            text-align: center;
            font-weight: bold;
            font-size: 10px;
            margin-bottom: 5px;
        }

        .tentang {
            text-align: center;
            font-size: 12px;
            margin-bottom: -10px;
        }

        .data-tentang {
            text-align: center;
            font-weight: bold;
            font-size: 12px;
            margin-bottom: -20px;
            margin-top: 20px;
        }

        .section-title {
            font-size: 10px;
            margin-top: 15px;
            margin-bottom: 8px;
        }

        .section-content {
            font-size: 10px;
            margin-bottom: 15px;
            text-align: justify;
        }

        .list-item {
            margin-bottom: 8px;
            text-align: justify;
        }

        .memutuskan {
            text-align: center;
            font-size: 10px;
            margin: 20px 0;
        }

        .menetapkan-title {
            font-size: 10px;
            margin-bottom: 10px;
        }

        .keputusan-item {
            margin-bottom: 12px;
            font-size: 10px;
        }

        .keputusan-label {
            margin-bottom: 3px;
        }

        .keputusan-isi {
            margin-left: 40px;
            text-align: justify;
        }

        .signature-wrapper {
            width: 100%;
            margin-top: 40px;
        }

        .signature-right {
            text-align: left;
            font-size: 10px;
        }

        .sig-role {
            margin-bottom: 6px;
        }

        .sig-placeholder {
            display: block;
            height: 50px;
        }

        .sig-name {
            font-weight: bold;
            margin-top: 4px;
        }

        .sig-nik {
            margin-top: 4px;
            font-size: 10px;
        }

        .tembusan-section {
            margin-top: 40px;
            font-size: 10px;
        }

        .tembusan-title {
            margin-bottom: 8px;
        }

        .tembusan-list {
            margin-left: 0;
            padding-left: 20px;
        }

        .tembusan-list li {
            margin-bottom: 3px;
        }

        .page-break {
            page-break-before: always;
        }

        .lampiran-title {
            text-align: center;
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 20px;
        }

        .lampiran-content {
            font-size: 10px;
            text-align: justify;
            white-space: pre-line;
            line-height: 1.6;
        }
    </style>
</head>
<body>

{{-- HEADER --}}
<div class="header">
    @php
        $headerPath = '';
        $kopType = $data->kop_type ?? 'lab';
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
    <div class="title" style="text-align:center; font-weight:bold;">
        {{ strtoupper($data->judul) }}
    </div>

    <div class="nomor">
        <strong>NOMOR: {{ $data->nomor ?? 'SK/nomor/bulan/tahun' }}</strong>
    </div>

    <div class="tentang">
        <strong>TENTANG</strong>
    </div>

    <div class="data-tentang">
        {{ strtoupper($data->tentang ?? '...') }}
    </div>

    {{-- Menimbang --}}
    @if(!empty($data->menimbang) && count($data->menimbang) > 0)
    <div class="section-title">Menimbang :</div>
    <div class="section-content">
        <table style="width: 100%; border: none;">
            @foreach($data->menimbang as $i => $item)
            <tr>
                <td style="width: 30px; vertical-align: top; border: none;">{{ chr(97 + $i) }}.</td>
                <td style="vertical-align: top; text-align: justify; border: none;">{{ $item }}</td>
            </tr>
            @endforeach
        </table>
    </div>
    @endif

    {{-- Mengingat --}}
    @if(!empty($data->mengingat) && count($data->mengingat) > 0)
    <div class="section-title">Mengingat :</div>
    <div class="section-content">
        <table style="width: 100%; border: none;">
            @foreach($data->mengingat as $i => $item)
            <tr>
                <td style="width: 30px; vertical-align: top; border: none;">{{ chr(97 + $i) }}.</td>
                <td style="vertical-align: top; text-align: justify; border: none;">{{ $item }}</td>
            </tr>
            @endforeach
        </table>
    </div>
    @endif

    <div class="memutuskan">
        <strong>MEMUTUSKAN:</strong>
    </div>

    <div class="menetapkan-title">
        Menetapkan : <strong>{{ strtoupper($data->menetapkan ?? '...') }}</strong>
    </div>

    {{-- Isi Keputusan --}}
    @if(!empty($data->isi_keputusan) && count($data->isi_keputusan) > 0)
    @foreach($data->isi_keputusan as $keputusan)
    <div class="keputusan-item">
        <div class="keputusan-label"><strong>{{ $keputusan['label'] ?? '' }} :</strong></div>
        <div class="keputusan-isi">{{ $keputusan['isi'] ?? '' }}</div>
    </div>
    @endforeach
    @endif

    <div class="keputusan-item">
        <div class="keputusan-label"><strong>{{ !empty($data->isi_keputusan) ? (count($data->isi_keputusan) == 1 ? 'Kedua' : (count($data->isi_keputusan) == 2 ? 'Ketiga' : 'Terakhir')) : 'Kedua' }} :</strong></div>
    </div>

    {{-- Signature --}}
    <table class="signature-wrapper">
        <tr>
            <td style="width: 50%;"></td>
            <td style="width: 50%;">
                <div class="signature-right">
                    <div class="sig-role">Ditetapkan di: {{ $data->tempat_penetapan ?? 'Surabaya' }}</div>
                    <div class="sig-role">pada tanggal: {{ $data->tanggal_penetapan ? $data->tanggal_penetapan->translatedFormat('d F Y') : '..................' }}</div>
                    <div class="sig-role">{{ $data->jabatan_pejabat ?? 'Nama jabatan,' }}</div>
                    <span class="sig-placeholder"></span>
                    <div class="sig-name">{{ $data->nama_pejabat ?? 'Nama Lengkap' }}</div>
                    @if($data->nik_pejabat)
                    <div class="sig-nik">NIKepegawaian: {{ $data->nik_pejabat }}</div>
                    @else
                    <div class="sig-nik">NIKepegawaian</div>
                    @endif
                </div>
            </td>
        </tr>
    </table>

    {{-- Tembusan --}}
    @if(!empty($data->tembusan) && count($data->tembusan) > 0)
    <div class="tembusan-section">
        <div class="tembusan-title"><strong>Tembusan</strong></div>
        <ol class="tembusan-list">
            @foreach($data->tembusan as $item)
            <li>{{ $item }}</li>
            @endforeach
        </ol>
    </div>
    @endif
</div>

{{-- LAMPIRAN (Halaman 2) --}}
@if(!empty($data->lampiran))
<div class="page-break"></div>
<div class="content">
    <div class="lampiran-title">
        Lampiran<br>
        Keputusan Kepala Laboratorium<br>
        Laboratorium Medis Khusus Patologi Klinik Utama Trisensa<br>
        Nomor: {{ $data->nomor ?? 'SK/nomor/bulan/tahun' }}<br>
        Tanggal: {{ $data->tanggal_penetapan ? $data->tanggal_penetapan->translatedFormat('d F Y') : '..................' }}
    </div>

    <div class="lampiran-content">
        {{ $data->lampiran }}
    </div>

    {{-- Signature untuk Lampiran --}}
    <table class="signature-wrapper" style="margin-top: 60px;">
        <tr>
            <td style="width: 50%;"></td>
            <td style="width: 50%;">
                <div class="signature-right">
                    <div class="sig-role">{{ $data->jabatan_pejabat ?? 'Nama jabatan,' }}</div>
                    <span class="sig-placeholder"></span>
                    <div class="sig-role">Tanda Tangan dan Stempel</div>
                    <div class="sig-name">{{ $data->nama_pejabat ?? 'Nama Lengkap' }}</div>
                    @if($data->nik_pejabat)
                    <div class="sig-nik">NIKepegawaian: {{ $data->nik_pejabat }}</div>
                    @else
                    <div class="sig-nik">NIKepegawaian</div>
                    @endif
                </div>
            </td>
        </tr>
    </table>
</div>
@endif

</body>
</html>
