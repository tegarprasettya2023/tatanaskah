<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Formulir Disposisi</title>
    <style>
        @page {
            margin: 120px 40px 100px 40px;
        }

        body {
            font-family: 'Century Gothic', sans-serif;
            font-size: 12px;
            line-height: 1.3;
            margin: 0;
            padding: 0;
        }

        .header {
            position: fixed;
            top: -120px;
            left: -30px;
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

        /* Header Info Table */
        .header-info {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .header-info td {
            border: 1px solid #000;
            padding: 8px;
            vertical-align: top;
        }

        .header-info .logo-cell {
            width: 25%;
            text-align: center;
            vertical-align: middle;
        }

        .header-info .logo-img {
            max-width: 80px;
            max-height: 60px;
        }

        .header-info .title-cell {
            width: 50%;
            text-align: center;
            vertical-align: middle;
        }

        .header-info .doc-info {
            width: 25%;
        }

        .doc-info-row {
            margin-bottom: 3px;
        }

        .doc-info-label {
            display: inline-block;
            width: 60px;
            font-size: 9px;
        }

        .doc-info-value {
            font-size: 9px;
        }

        /* Title */
        .title-text {
            font-weight: bold;
            font-size: 14px;
            margin: 0;
        }

        /* Nomor/Tanggal Membaca Section */
        .membaca-section {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .membaca-section td {
            border: 1px solid #000;
            padding: 8px;
        }

        .membaca-label {
            width: 30%;
            font-weight: bold;
            background-color: #f0f0f0;
        }

        /* Perihal & Paraf Table */
        .perihal-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .perihal-table td {
            border: 1px solid #000;
            padding: 15px 8px; /* Jarak atas bawah lebih luas */
            vertical-align: top;
        }

        .perihal-label {
            width: 15%;
            font-weight: bold;
            background-color: #f0f0f0;
        }

        .perihal-content {
            width: 70%;
        }

        .paraf-cell {
            width: 15%;
            text-align: center;
        }

        /* Diteruskan Kepada Table */
        .diteruskan-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .diteruskan-table th,
        .diteruskan-table td {
            border: 1px solid #000;
            padding: 8px;
            vertical-align: top;
        }

        .diteruskan-table th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }

        .diteruskan-no {
            width: 8%;
            text-align: center;
        }

        .diteruskan-nama {
            width: 45%;
        }

        .diteruskan-tgl {
            width: 23%;
            text-align: center;
        }

        /* Catatan Table */
        .catatan-table {
            width: 100%;
            border-collapse: collapse;
        }

        .catatan-table td {
            border: 1px solid #000;
            padding: 8px;
            vertical-align: top;
            height: 80px;
        }

        .catatan-header {
            font-weight: bold;
            background-color: #f0f0f0;
            text-align: center;
            padding: 5px;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    
{{-- HEADER --}}
<div class="header">
    @php
        $kopType = $letter->kop_type ?? 'lab';
        $headerPath = match($kopType) {
            'klinik' => public_path('kop/header_klinik.png'),
            'lab' => public_path('kop/header_lab.png'),
            'pt' => public_path('kop/header_pt.png'),
            default => null,
        };

        if ($headerPath && file_exists($headerPath)) {
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
    {{-- Header Info Table dengan Logo --}}
    <table class="header-info">
        <tr>
           <td class="logo-cell">
    @php
        $logoPath = match($kopType) {
            'klinik' => public_path('logo/logo_klinik.png'),
            'lab' => public_path('logo/logo_lab.png'),
            'pt' => public_path('logo/logo_pt.png'),
            default => null,
        };

        if ($logoPath && file_exists($logoPath)) {
            $imageData = base64_encode(file_get_contents($logoPath));
            $mimeType = mime_content_type($logoPath);
            echo '<img src="data:' . $mimeType . ';base64,' . $imageData . '" class="logo-img">';
        }
    @endphp
</td>
            <td class="title-cell">
                <p class="title-text">FORMULIR DISPOSISI</p>
            </td>
            <td class="doc-info">
                <div class="doc-info-row">
                    <span class="doc-info-label">No. Dokumen</span>: <span class="doc-info-value">{{ $letter->nomor_membaca ?? '-' }}</span>
                </div>
                <div class="doc-info-row">
                    <span class="doc-info-label">No. Revisi</span>: <span class="doc-info-value">{{ $letter->no_revisi ?? '00' }}</span>
                </div>
                <div class="doc-info-row">
                    <span class="doc-info-label">Tanggal</span>: <span class="doc-info-value">{{ $letter->tanggal_pembuatan ? $letter->tanggal_pembuatan->format('d/m/Y') : '-' }}</span>
                </div>
            </td>
        </tr>
    </table>

    {{-- Nomor/Tanggal Membaca --}}
    <table class="membaca-section">
        <tr>
            <td class="membaca-label">Nomor/Tanggal Membaca</td>
            <td>
                {{ $letter->nomor_membaca ?? '-' }} / 
                {{ $letter->tanggal_membaca ? $letter->tanggal_membaca->format('d/m/Y') : '-' }}
            </td>
        </tr>
    </table>

    {{-- Perihal & Paraf --}}
    <table class="perihal-table">
        <tr>
            <td class="perihal-label">Perihal</td>
            <td class="perihal-content">{{ $letter->perihal ?? '-' }}</td>
            <td class="paraf-cell">
                <div style="font-weight: bold; margin-bottom: 3px;">Paraf</div>
                <div style="margin-top: 30px;">{{ $letter->paraf ?? '' }}</div>
            </td>
        </tr>
    </table>

    {{-- Diteruskan Kepada --}}
    <table class="diteruskan-table">
        <thead>
            <tr>
                <th class="diteruskan-no">No.</th>
                <th class="diteruskan-nama">Diteruskan Kepada</th>
                <th class="diteruskan-tgl">Tanggal Diserahkan</th>
                <th class="diteruskan-tgl">Tanggal Kembali</th>
            </tr>
        </thead>
        <tbody>
            @if(!empty($letter->diteruskan_kepada) && is_array($letter->diteruskan_kepada))
                @foreach($letter->diteruskan_kepada as $i => $penerima)
                <tr>
                    <td class="diteruskan-no">{{ $i + 1 }}.</td>
                    <td class="diteruskan-nama">{{ $penerima }}</td>
                    <td class="diteruskan-tgl">{{ $letter->tanggal_diserahkan ? $letter->tanggal_diserahkan->format('d/m/Y') : '' }}</td>
                    <td class="diteruskan-tgl">{{ $letter->tanggal_kembali ? $letter->tanggal_kembali->format('d/m/Y') : '' }}</td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td class="diteruskan-no">1.</td>
                    <td class="diteruskan-nama"></td>
                    <td class="diteruskan-tgl"></td>
                    <td class="diteruskan-tgl"></td>
                </tr>
                <tr>
                    <td class="diteruskan-no">2.</td>
                    <td class="diteruskan-nama"></td>
                    <td class="diteruskan-tgl"></td>
                    <td class="diteruskan-tgl"></td>
                </tr>
            @endif
        </tbody>
    </table>

    {{-- Catatan (2 Kolom) --}}
    <table class="catatan-table">
        <tr>
            <td class="catatan-header" style="width: 50%;">Catatan</td>
            <td class="catatan-header" style="width: 50%;">Catatan</td>
        </tr>
        <tr>
            <td style="width: 50%;">{{ $letter->catatan_1 ?? '' }}</td>
            <td style="width: 50%;">{{ $letter->catatan_2 ?? '' }}</td>
        </tr>
    </table>
</div>

</body>
</html>