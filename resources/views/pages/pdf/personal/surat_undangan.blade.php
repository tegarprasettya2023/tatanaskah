<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Undangan</title>
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
            width:100%; height:90px; text-align:center; z-index:1000;
        }
        .header img { width:100%; height:90px; object-fit:cover; display:block; }

        .footer {
            position: fixed; bottom:0; left:0; right:0;
            width:100%; height:60px; text-align:center; z-index:1000;
        }
        .footer img { width:90%; height:40px; object-fit:cover; display:block; }

        .content {
            margin-top:110px;   /* supaya tidak tabrakan header */
            margin-bottom:120px;/* supaya tidak tabrakan footer */
            margin-left:20mm;
            margin-right:20mm;
        }

        .title {
            text-align:center;
            font-weight:bold;
            font-size:14px;
            margin-bottom:25px; /* jarak judul ke bawah */
            text-transform:uppercase;
        }

        .kop-info table { width:100%; }
        .kop-info td { padding:3px 0; vertical-align:top; }
        .label { width:100px; }
        .colon { width:10px; }

        .penerima { margin:15px 0; }
        .isi-surat { margin:20px 0; text-align:justify; }

        .detail-acara table { width:100%; }
        .detail-acara td { padding:3px 0; vertical-align:top; }

        .signature-block {
            width:100%;
            margin-top:80px; /* tanda tangan agak ke bawah */
        }
        .signature-space { height:60px; }
        .signature-name { font-weight:bold; }

        .tembusan { margin-top:50px; }
        .tembusan strong { font-weight:bold; }
        .tembusan span { font-weight:normal; }

        .page-break { page-break-before:always; }

      .lampiran-header {
        margin-bottom:20px;
        text-align:right; /* rata kanan */
    }
    .lampiran-header .line {
        display:block;
    }
        .lampiran-title {
            text-align:center;
            font-weight:bold;
            margin-bottom:15px;
            font-size:14px;
        }
        .lampiran-table {
            width:100%;
            border-collapse:collapse;
            margin-top:15px;
        }
        .lampiran-table th, .lampiran-table td {
            border:1px solid #000;
            padding:6px;
        }
        .lampiran-table th { text-align:center; font-weight:bold; }
    </style>
</head>
<body>

{{-- HEADER --}}
<div class="header">
    @php
        $headerPath = '';
        $kopType = $letter->kop_type ?? 'klinik';
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
    <div class="title">SURAT UNDANGAN</div>

    {{-- Kop Info --}}
    <div class="kop-info">
        <table>
            <tr>
                <td class="label">Nomor</td><td class="colon">:</td>
                <td>{{ $letter->nomor ?? 'UND/nomor/bulan/tahun' }}</td>
               <td style="text-align:right;">
                    {{ $letter->tempat_ttd ?? 'Surabaya' }}, 
                    {{ $letter->tanggal_ttd ? \Carbon\Carbon::parse($letter->tanggal_ttd)->translatedFormat('d F Y') : '..................' }}
                </td>
            </tr>
            @if($letter->sifat)
            <tr><td class="label">Sifat</td><td class="colon">:</td><td colspan="2">{{ $letter->sifat }}</td></tr>
            @endif
            @if($letter->lampiran)
            <tr><td class="label">Lampiran</td><td class="colon">:</td><td colspan="2">{{ $letter->lampiran }}</td></tr>
            @endif
            <tr><td class="label">Perihal</td><td class="colon">:</td><td colspan="2">{{ $letter->perihal ?? '' }}</td></tr>
        </table>
    </div>

    {{-- Penerima --}}
    <div class="penerima">
        <div>Yth. {{ $letter->yth_nama ?? '..................' }}</div>
        <div>{{ $letter->yth_alamat ?? '......................................' }}</div>
    </div>

    {{-- Isi --}}
    <div class="isi-surat">
        &nbsp;&nbsp;&nbsp;{{ $letter->isi_pembuka ?? 'Sehubungan dengan ........................................' }}
    </div>

    <div class="detail-acara">
        <table>
            <tr>
            <td class="label">Hari, Tanggal</td>
            <td class="colon">:</td>
            <td>{{ $letter->hari_tanggal->translatedFormat('l, d F Y') }}</td>
            </tr>
            <tr><td class="label">Pukul</td><td class="colon">:</td><td>{{ $letter->pukul ?? '........................' }}</td></tr>
            <tr><td class="label">Tempat</td><td class="colon">:</td><td>{{ $letter->tempat_acara ?? '........................' }}</td></tr>
            <tr><td class="label">Acara</td><td class="colon">:</td><td>{{ $letter->acara ?? '........................' }}</td></tr>
        </table>
    </div>

    {{-- Penutup --}}
    <div class="isi-surat">
        &nbsp;&nbsp;&nbsp;{{ $letter->isi_penutup ?? 'Atas perhatian dan perkenan Bapak/Ibu/Saudara/i, kami mengucapkan terima kasih.' }}
    </div>

    {{-- Tanda Tangan --}}
    <div class="signature-block">
        <div style="text-align:right; margin-bottom:20px;">
            {{ $letter->jabatan_pembuat ?? 'Nama Jabatan' }},
        </div>
        <div class="signature-space"></div>
        <div style="text-align:right; font-weight:bold;">
            {{ $letter->nama_pembuat ?? 'Nama Lengkap' }}
        </div>
    </div>

    {{-- Tembusan --}}
    @if($letter->tembusan_1 || $letter->tembusan_2)
    <div class="tembusan">
      Tembusan:<br>
        <span>
            @if($letter->tembusan_1) 1. {{ $letter->tembusan_1 }}<br> @endif
            @if($letter->tembusan_2) 2. {{ $letter->tembusan_2 }} @endif
        </span>
    </div>
    @endif
</div>

{{-- Lampiran Halaman 2 --}}
@if(!empty($letter->daftar_undangan) && count($letter->daftar_undangan) > 0)
<div class="page-break"></div>
<div class="content">
   <div class="lampiran-header">
        <span class="line"><strong>Lampiran Surat Undangan</strong></span>
        <span class="line"><strong>Nomor :</strong> {{ $letter->nomor ?? '..................' }}</span>
        <span class="line"><strong>Tanggal :</strong> {{ $letter->tanggal_ttd ? \Carbon\Carbon::parse($letter->tanggal_ttd)->translatedFormat('d F Y') : '..................' }}</span>
    </div>

    <div class="lampiran-title">DAFTAR NAMA YANG DIUNDANG</div>
    <table class="lampiran-table">
        <thead>
            <tr>
                <th>No.</th><th>Nama</th><th>Jabatan</th><th>Unit Kerja</th>
            </tr>
        </thead>
        <tbody>
            @foreach($letter->daftar_undangan as $i => $row)
            <tr>
                <td style="text-align:center;">{{ $i+1 }}</td>
                <td>{{ $row['nama'] ?? '' }}</td>
                <td>{{ $row['jabatan'] ?? '' }}</td>
                <td>{{ $row['unit_kerja'] ?? '' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

</body>
</html>
