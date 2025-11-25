<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Notulen Rapat</title>
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
            margin-bottom: 25px;
        }

        .info-table {
            width: 100%;
            margin-bottom: 30px;
        }

        .info-table td {
            padding: 3px 0;
            vertical-align: top;
        }

        .info-table td.label {
            width: 150px;
            font-weight: normal;
        }

        .info-table td.colon {
            width: 20px;
        }

        .section-title {
            font-weight: bold;
            margin-top: 25px;
            margin-bottom: 10px;
        }

        .kegiatan-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0 30px 0;
        }

        .kegiatan-table th,
        .kegiatan-table td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
        }

        .kegiatan-table th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }

        .signature-wrapper {
            width: 100%;
            border-collapse: collapse;
            margin-top: 60px;
        }

        .signature-wrapper td {
            vertical-align: top;
            padding: 0 8px;
            box-sizing: border-box;
        }

        .sig-left {
            width: 50%;
            text-align: left;
        }

        .sig-right {
            width: 50%;
            text-align: right;
        }

        .sig-placeholder {
            display: block;
            height: 60px;
        }

        .sig-role {
            margin-bottom: 6px;
        }

        .sig-name {
            font-weight: normal;
            margin-top: 4px;
        }

        .sig-nik {
            margin-top: 4px;
            font-size: 11px;
        }

        .page-break {
            page-break-before: always;
        }

        .doc-title {
            text-align: center;
            font-weight: bold;
            font-size: 13px;
            margin-bottom: 40px;
        }

        .doc-grid {
            display: table;
            width: 100%;
            margin-top: 30px;
        }

        .doc-row {
            display: table-row;
        }

        .doc-cell {
            display: table-cell;
            width: 45%;
            padding: 15px;
            text-align: center;
            vertical-align: top;
        }

        .doc-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border: 1px solid #ccc;
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
    <div class="title">
        <strong>NOTULEN</strong> {{ strtoupper($letter->isi_notulen ?? '............') }}
    </div>

    <table class="info-table">
        <tr><td class="label">Rapat</td><td class="colon">:</td><td>{{ $letter->isi_notulen ?? '........................................' }}</td></tr>
        <tr><td class="label">Hari, tanggal</td><td class="colon">:</td><td>{{ $letter->tanggal_rapat ? $letter->tanggal_rapat->translatedFormat('l, d F Y') : '........................................' }}</td></tr>
        <tr><td class="label">Waktu</td><td class="colon">:</td><td>{{ $letter->waktu ?? '........................................' }}</td></tr>
        <tr><td class="label">Tempat</td><td class="colon">:</td><td>{{ $letter->tempat ?? '........................................' }}</td></tr>
        <tr><td class="label">Pimpinan Rapat</td><td class="colon">:</td><td>{{ $letter->pimpinan_rapat ?? '........................................' }}</td></tr>
        <tr><td class="label">Peserta Rapat</td><td class="colon">:</td><td>{{ $letter->peserta_rapat ?? '........................................' }}</td></tr>
    </table>

    <div class="section-title">KEGIATAN RAPAT :</div>

    <table class="kegiatan-table">
        <thead>
            <tr>
                <th width="5%">NO.</th>
                <th width="30%">PEMBICARA/URAIAN MATERI</th>
                <th width="25%">TANGGAPAN/PEMBERI<br>TANGGAPAN</th>
                <th width="20%">KEPUTUSAN<br>PIMPINAN</th>
                <th width="20%">KETERANGAN</th>
            </tr>
        </thead>
        <tbody>
            @php
                $kegiatanArray = is_array($letter->kegiatan_rapat) ? $letter->kegiatan_rapat : [];
            @endphp
            
            @if(!empty($kegiatanArray))
                @foreach($kegiatanArray as $i => $kegiatan)
                <tr>
                    <td style="text-align:center;">{{ $i + 1 }}.</td>
                    <td>{{ $kegiatan['pembicara'] ?? '' }}</td>
                    <td>{{ $kegiatan['tanggapan'] ?? '' }}</td>
                    <td>{{ $kegiatan['keputusan'] ?? '' }}</td>
                    <td>{{ $kegiatan['keterangan'] ?? '' }}</td>
                </tr>
                @endforeach
            @else
                <tr><td>1.</td><td></td><td></td><td></td><td></td></tr>
                <tr><td>2.</td><td></td><td></td><td></td><td></td></tr>
            @endif
        </tbody>
    </table>

    <table class="signature-wrapper" style="margin-top:60px;">
        <tr>
            <td class="sig-left" style="text-align:left; padding-top: 3%;">
                <div class="sig-role">{{ $letter->ttd_jabatan_1 ?? 'Jabatan 1' }}</div>
                <span class="sig-placeholder"></span>
                <div class="sig-name">{{ $letter->nama_ttd_jabatan_1 ?? '(Nama)' }}</div>
                <div class="sig-nik">{{ $letter->nik_ttd_jabatan_1 ? 'NIK. ' . $letter->nik_ttd_jabatan_1 : 'NIK Pegawai' }}</div>
            </td>
            <td class="sig-right" style="width:20%; text-align:left;">
                <div class="sig-role">{{ 'Surabaya' }}, {{ $letter->tanggal_ttd ? $letter->tanggal_ttd->translatedFormat('d F Y') : '..................' }}</div>
                <div class="sig-role">{{ $letter->ttd_jabatan_2 ?? 'Jabatan 2' }}</div>
                <span class="sig-placeholder"></span>
                <div class="sig-name">{{ $letter->nama_ttd_jabatan_2 ?? '(Nama)' }}</div>
                <div class="sig-nik">{{ $letter->nik_ttd_jabatan_2 ? 'NIK. ' . $letter->nik_ttd_jabatan_2 : 'NIK Pegawai' }}</div>
            </td>
        </tr>
    </table>

</div>

{{-- HALAMAN 2 - DOKUMENTASI --}}
@php
    $dokumentasiArray = is_array($letter->dokumentasi) ? $letter->dokumentasi : [];
@endphp

@if(!empty($dokumentasiArray) && count($dokumentasiArray) > 0)
<div class="page-break"></div>
<div class="content">
    <div class="doc-title">
        JUDUL DOKUMENTASI {{ strtoupper($letter->judul_dokumentasi ?? '............') }}
    </div>
    <div class="doc-grid">
        @foreach(array_chunk($dokumentasiArray, 2) as $chunk)
        <div class="doc-row">
            @foreach($chunk as $doc)
            <div class="doc-cell">
                @php
                    $imagePath = storage_path('app/public/' . $doc);
                    if(file_exists($imagePath)) {
                        $imageData = base64_encode(file_get_contents($imagePath));
                        $mimeType = mime_content_type($imagePath);
                        echo '<img src="data:' . $mimeType . ';base64,' . $imageData . '" class="doc-image">';
                    } else {
                        echo '<div style="width:100%; height:250px; border:2px dashed #ccc; display:flex; align-items:center; justify-content:center; color:#999;"><strong>GAMBAR</strong></div>';
                    }
                @endphp
            </div>
            @endforeach
            @if(count($chunk) == 1)
                <div class="doc-cell"></div>
            @endif
        </div>
        @endforeach
    </div>

    <table class="signature-wrapper" style="margin-top:60px;">
        <tr>
            <td class="sig-left" style="text-align:left; padding-top: 3%;">
                <div class="sig-role">{{ $letter->ttd_jabatan_1 ?? 'Jabatan 1' }}</div>
                <span class="sig-placeholder"></span>
                <div class="sig-name">{{ $letter->nama_ttd_jabatan_1 ?? '(Nama)' }}</div>
                <div class="sig-nik">{{ $letter->nik_ttd_jabatan_1 ? 'NIK. ' . $letter->nik_ttd_jabatan_1 : 'NIK Pegawai' }}</div>
            </td>
            <td class="sig-right" style="width:20%; text-align:left;">
                <div class="sig-role">{{ 'Surabaya' }}, {{ $letter->tanggal_ttd ? $letter->tanggal_ttd->translatedFormat('d F Y') : '..................' }}</div>
                <div class="sig-role">{{ $letter->ttd_jabatan_2 ?? 'Jabatan 2' }}</div>
                <span class="sig-placeholder"></span>
                <div class="sig-name">{{ $letter->nama_ttd_jabatan_2 ?? '(Nama)' }}</div>
                <div class="sig-nik">{{ $letter->nik_ttd_jabatan_2 ? 'NIK. ' . $letter->nik_ttd_jabatan_2 : 'NIK Pegawai' }}</div>
            </td>
        </tr>
    </table>
</div>
@endif

</body>
</html>