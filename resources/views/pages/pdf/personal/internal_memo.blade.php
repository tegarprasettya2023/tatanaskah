<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Internal Memo</title>
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
            position: relative;
            min-height: calc(100vh - 230px);
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
            margin-bottom:50px;   /* jarak jauh ke tanggal */
            font-weight:bold;
        }

        .tanggal {
            text-align:right;
            margin-bottom:50px;   /* jarak jauh ke Yth. */
        }

        .penerima { margin-bottom:15px; }
        .penerima table { width:100%; }
        .penerima td { padding:2px 0; vertical-align:top; }
        .penerima .label { width:40px; }
        .penerima .colon { width:10px; }

        .isi-memo {
            text-align:justify;
            margin:20px 0;
            text-indent:30px;
        }

        .signature-block {
            width:100%;
            margin-top:80px;
        }
        .signature-space { height:60px; }
        .signature-name { font-weight:bold; }

        .tembusan {
            bottom:100px;   /* melayang dekat footer */
            left:20mm;
            right:20mm;
        }
        .tembusan strong { font-weight:bold; }
        .tembusan span { font-weight:normal; }
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
    {{-- JUDUL --}}
    <div class="title">INTERNAL MEMO</div>
    <div class="nomor">NOMOR : {{ $letter->nomor ?? 'IM/nomor/bulan/tahun' }}</div>

    {{-- TANGGAL --}}
    <div class="tanggal">
        {{ $letter->tempat_ttd ?? 'Surabaya' }}, {{ $letter->formatted_letter_date ?? '.............................' }}
    </div>

    {{-- PENERIMA --}}
    <div class="penerima">
        <table>
            <tr><td class="label">Yth.</td><td class="colon">:</td><td>{{ $letter->yth_nama ?? '' }}</td></tr>
            <tr><td class="label">Hal</td><td class="colon">:</td><td>{{ $letter->hal ?? '' }}</td></tr>
        </table>
    </div>

    {{-- ISI MEMO --}}
    <div class="isi-memo">
        Sehubungan dengan {{ $letter->sehubungan_dengan ?? '................................................................................................' }}
    </div>
    <div class="isi-memo">
        {{ $letter->alinea_isi ?? '................................................................................................' }}
    </div>
    <div class="isi-memo">
        {{ $letter->isi_penutup ?? 'Atas perhatian dan perkenan Bapak/Ibu/Saudara/i, kami mengucapkan terima kasih.' }}
    </div>

    {{-- TANDA TANGAN --}}
    <div class="signature-block">
        <div style="text-align:right; margin-bottom:20px;">
            {{ $letter->jabatan_pembuat ?? 'Nama jabatan' }},
        </div>
        <div class="signature-space"></div>
        <div style="text-align:right;">
            <span class="signature-name">{{ $letter->nama_pembuat ?? 'Nama Lengkap' }}</span><br>
            NIK. {{ $letter->nik_pembuat ?? 'NIKepegawaian' }}
        </div>
    </div>

    {{-- TEMBUSAN (melayang, sejajar dengan blok Yth./Hal) --}}
    @if($letter->tembusan_1 || $letter->tembusan_2)
    <div class="tembusan">
        Tembusan:<br>
        <span>
            @if($letter->tembusan_1) 1. {{ $letter->tembusan_1 }}<br>@endif
            @if($letter->tembusan_2) 2. {{ $letter->tembusan_2 }} @endif
        </span>
    </div>
    @endif
</div>

</body>
</html>
