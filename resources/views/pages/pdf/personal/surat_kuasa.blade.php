<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Kuasa</title>
    <style>
        @page { margin: 0; }

        body {
            font-family: 'CenturyGothic', sans-serif;
            font-size: 12px;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        .header { 
            position: fixed; top:0; left:0; right:0;
            width:100%; height:80px; text-align:center; z-index:1000;
        }
        .header img { width:100%; height:90px; object-fit:cover; display:block; }

        .footer {
            position: fixed; bottom:0; left:0; right:0;
            width:100%; height:60px; text-align:center; z-index:1000;
        }
        .footer img { width:90%; height:40px; object-fit:cover; display:block; }

        .content {
            margin-top:110px;
            margin-bottom:120px;
            margin-left:20mm;
            margin-right:20mm;
        }

        .title {
            text-align:center;
            font-weight:bold;
            font-size:14px;
            margin-bottom:5px;
            text-transform:uppercase;
        }
        .nomor {
            text-align:center;
            margin-bottom:30px;
        }

        .section { margin:20px 0; }
        .section table { width:100%; border-collapse:collapse; margin-left:5mm; }
        .section td { padding:3px 0; vertical-align:top; }
        .label { width:90px; }
        .colon { width:15px; }

        .isi { margin:20px 0; text-align:justify; }

        /* Blok tanda tangan */
        .signature-block {
            width:100%;
            margin-top:60px;
        }
        .signature-left { float:left; text-align:center; width:40%; }
        .signature-right { float:right; text-align:center; width:40%; }
        .signature-space { height:60px; }
    </style>
</head>
<body>

{{-- HEADER --}}
<div class="header">
    @php
        $headerPath = '';
        $kopType = $letter->kop_type ?? 'klinik';

        if($kopType === 'klinik') {
            $headerPath = public_path('kop/header_klinik.png');
        } elseif($kopType === 'lab') {
            $headerPath = public_path('kop/header_lab.png');
        } elseif($kopType === 'pt') {
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
        } elseif($kopType === 'pt') {
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
    <div class="title">SURAT KUASA</div>
    <div class="nomor"><strong>NOMOR: {{ $letter->nomor ?? 'KUASA/..../bulan/tahun' }}</strong></div>

    <div class="section">
        <p>Yang bertanda tangan di bawah ini,</p>
        <table>
            <tr><td class="label">Nama</td><td class="colon">:</td><td>{{ $letter->nama_pemberi ?? '' }}</td></tr>
            <tr><td class="label">NIP</td><td class="colon">:</td><td>{{ $letter->nip_pemberi ?? '' }}</td></tr>
            <tr><td class="label">Jabatan</td><td class="colon">:</td><td>{{ $letter->jabatan_pemberi ?? '' }}</td></tr>
            <tr><td class="label">Alamat</td><td class="colon">:</td><td>{{ $letter->alamat_pemberi ?? '' }}</td></tr>
        </table>
    </div>

    <div class="section">
        <p>memberi kuasa kepada :</p>
        <table>
            <tr><td class="label">Nama</td><td class="colon">:</td><td>{{ $letter->nama_penerima ?? '' }}</td></tr>
            <tr><td class="label">NIP</td><td class="colon">:</td><td>{{ $letter->nip_penerima ?? '' }}</td></tr>
            <tr><td class="label">Jabatan</td><td class="colon">:</td><td>{{ $letter->jabatan_penerima ?? '' }}</td></tr>
            <tr><td class="label">Alamat</td><td class="colon">:</td><td>{{ $letter->alamat_penerima ?? '' }}</td></tr>
        </table>
    </div>

    <div class="section">
        <p>Untuk</p>
        <div class="isi">{!! nl2br(e($letter->isi ?? '..................................................................')) !!}</div>
        <p>Surat kuasa ini dibuat untuk dipergunakan sebagaimana mestinya.</p>
    </div>

      {{-- Tempat, tanggal + tanda tangan --}}
<div class="signature-block" 
     style="position:absolute; bottom:100px; left:0; right:0; width:100%; padding:0 20mm;">

    <div style="text-align:right; margin-bottom:20px; padding-right:150px;">
        {{ $letter->tempat ?? 'Surabaya' }}, 
        {{ $letter->letter_date ? \Carbon\Carbon::parse($letter->letter_date)->translatedFormat('d F Y') : '..................' }}
    </div>

    <table style="width:100%; text-align:center; table-layout: fixed;">
        <colgroup>
            <col style="width:50%; padding-left:20mm;">
            <col style="width:50%; padding-right:150px;">
        </colgroup>
        <tr>
            <td style="text-align:left;">
                Penerima Kuasa
            </td>
            <td style="text-align:right; padding-right:213px;">
                Pemberi Kuasa<br>
            </td>
        </tr>
        <tr>
            <td style="height:60px;"></td>
            <td style="height:60px;"></td>
        </tr>
        <tr>
            <td style="text-align:left;">{{ $letter->nama_penerima ?? 'Nama Lengkap' }}</td>
            <td style="text-align:right; padding-right:250px;">{{ $letter->nama_pemberi ?? 'Nama Lengkap' }}</td>
        </tr>
    </table>
</div>

</div>
</body>
</html>
