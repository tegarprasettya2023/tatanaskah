<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Formulir Disposisi</title>
    <style>
        @page { margin: 0; }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 9px;
            line-height: 1.3;
            margin: 0;
            padding: 0;
        }

        .header { 
            position: fixed; 
            top: 0; 
            left: 0; 
            right: 0;
            width: 100%; 
            height: 90px; 
            text-align: center;
            z-index: 1000;
        }
        .header img { 
            width: 100%; 
            height: 90px; 
            object-fit: cover; 
            display: block; 
        }

        .footer {
            position: fixed; 
            bottom: 0; 
            left: 0; 
            right: 0;
            width: 100%; 
            height: 60px; 
            text-align: center;
            z-index: 1000;
        }
        .footer img { 
            width: 100%; 
            height: 40px; 
            object-fit: cover; 
            display: block; 
        }

        .content {
            margin-top: 110px;
            margin-bottom: 70px;
            margin-left: 15mm;
            margin-right: 15mm;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            table-layout: fixed;
        }
        .header-table td {
            border: 1px solid #000;
            padding: 4px;
            vertical-align: middle;
            font-size: 8px;
        }
        .logo-cell {
            text-align: center;
            vertical-align: middle;
            padding: 8px;
        }
        .logo-cell img {
            max-width: 150px;
            max-height: 50px;
            display: block;
            margin: 0 auto;
        }
        .title-cell {
            text-align: center;
            font-weight: bold;
            font-size: 12px;
            padding: 10px 6px;
        }
        .doc-info {
            text-align: center;
            font-size: 7px;
            padding: 4px;
        }

        .content-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        .content-table td {
            border: 1px solid #000;
            padding: 6px 8px; 
            vertical-align: top;
        }

        .content-box, .instruction-box {
            page-break-inside: avoid;
        }

        .content-table table {
            border-collapse: collapse;
        }
        .content-table table td {
            border: none;
            padding: 0;
        }
    </style>
</head>
<body>

{{-- HEADER --}}
<div class="header">
    @php
        $headerPath = '';
        $kopType = $letter->kop_type ?? 'pt';

        if($kopType === 'klinik') {
            $headerPath = public_path('kop/header_klinik.png');
        } elseif($kopType === 'lab') {
            $headerPath = public_path('kop/header_lab.png');
        } else {
            $headerPath = public_path('kop/header_pt.png');
        }

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

        if($kopType === 'klinik') {
            $footerPath = public_path('footer/footer_klinik.png');
        } elseif($kopType === 'lab') {
            $footerPath = public_path('footer/footer_lab.png');
        } else {
            $footerPath = public_path('footer/footer_pt.png');
        }

        if(file_exists($footerPath)) {
            $imageData = base64_encode(file_get_contents($footerPath));
            $mimeType = mime_content_type($footerPath);
            echo '<img src="data:' . $mimeType . ';base64,' . $imageData . '" alt="Footer">';
        }
    @endphp
</div>

{{-- CONTENT --}}
<div class="content">

    {{-- HEADER TABLE --}}
    <table class="header-table">
        <col style="width:18%">
        <col style="width:27%">
        <col style="width:27%">
        <col style="width:28%">
        <tr>
            <td class="logo-cell" rowspan="2">
                @php
                    $logoPath = '';
                    $logoType = $letter->logo_type ?? 'pt';

                    if($logoType === 'klinik') {
                        $logoPath = public_path('logo/logo_klinik.png');
                    } elseif($logoType === 'lab') {
                        $logoPath = public_path('logo/logo_lab.png');
                    } else {
                        $logoPath = public_path('logo/logo_pt.png');
                    }

                    if(file_exists($logoPath)) {
                        $imageData = base64_encode(file_get_contents($logoPath));
                        $mimeType = mime_content_type($logoPath);
                        echo '<img src="data:' . $mimeType . ';base64,' . $imageData . '">';
                    } else {
                        echo '<div style="font-weight:bold;font-size:9px;">LOGO</div>';
                    }
                @endphp
            </td>
            <td class="title-cell" colspan="3">FORMULIR DISPOSISI</td>
        </tr>
        <tr>
            <td class="doc-info"><strong>No. Dokumen</strong><br>{{ $letter->nomor_dokumen ?? 'LD/001/X/2025' }}</td>
            <td class="doc-info"><strong>No. Revisi</strong><br>{{ $letter->no_revisi ?? '00' }}</td>
            <td class="doc-info"><strong>Halaman dari</strong><br>{{ $letter->halaman_dari ?? '1' }}</td>
        </tr>
    </table>

    {{-- CONTENT TABLE --}}
    <table class="content-table">
        <col style="width:18%">
        <col style="width:32%">
        <col style="width:18%">
        <col style="width:32%">

        <tr>
            <td><strong>Dari (Bagian pembuat)</strong></td>
            <td>{{ $letter->bagian_pembuat ?? '' }}</td>
            <td><strong>Tanggal (pembuatan)</strong></td>
            <td>{{ $letter->tanggal_pembuatan? \Carbon\Carbon::parse($letter->tanggal_pembuatan)->translatedFormat('d F Y') : '' }}</td>
        </tr>

        <tr>
            <td><strong>Nomor/Tanggal</strong></td>
            <td>{{ $letter->nomor_tanggal ?? '' }}</td>
            <td><strong>No. Agenda</strong></td>
            <td>{{ $letter->no_agenda ?? '' }}</td>
        </tr>

        <tr>
            <td><strong>Perihal</strong></td>
            <td>{{ $letter->perihal ?? '' }}</td>
            <td><strong>Paraf</strong></td>
            <td>{{ $letter->paraf ?? '' }}</td>
        </tr>

        {{-- BAGIAN DITERUSKAN KE --}}
 <tr>
    <td><strong>Kepada</strong></td>
    <td><strong>Diteruskan Kepada</strong></td>
    <td><strong>Tanggal Diserahkan</strong></td>
    <td><strong>Tanggal Kembali</strong></td>
</tr>
<tr>
    <td>{{ $letter->kepada ?? '' }}</td>
    <td>
        @if($letter->diteruskan_kepada && is_array($letter->diteruskan_kepada))
            @foreach($letter->diteruskan_kepada as $i => $item)
                {{ $i+1 }}. {{ $item }}<br>
            @endforeach
        @else
            1. ....<br>
            2. ....<br>
        @endif
    </td>
    <td style="text-align:center;">
        {{ $letter->tanggal_diserahkan 
            ? \Carbon\Carbon::parse($letter->tanggal_diserahkan)->translatedFormat('d F Y') 
            : '' }}
    </td>
    <td style="text-align:center;">
        {{ $letter->tanggal_kembali 
            ? \Carbon\Carbon::parse($letter->tanggal_kembali)->translatedFormat('d F Y') 
            : '' }}
    </td>
</tr>

<tr>
    <td><strong>Ringkasan Isi</strong></td>
    <td colspan="3">
        <div style="white-space:pre-line;">
            {{ $letter->ringkasan_isi ?? '' }}
        </div>
    </td>
</tr>

        <tr>
            <td colspan="2" class="instruction-box">
                <strong>Instruksi:</strong><br>
                <div style="margin-top:4px;white-space:pre-line;font-size:10px;">{{ $letter->instruksi_1 ?? '' }}</div>
            </td>
            <td colspan="2" class="instruction-box">
                <strong>Instruksi:</strong><br>
                <div style="margin-top:4px;white-space:pre-line;font-size:10px;">{{ $letter->instruksi_2 ?? '' }}</div>
            </td>
        </tr>
    </table>
</div>

</body>
</html>
