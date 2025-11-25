<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Internal Memo</title>
    <style>
        @page {
            margin: 120px 40px 100px 40px;
        }

        body {
            font-family: 'Century Gothic', sans-serif;
            font-size: 10px;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }

        .header {
            position: fixed;
            top: -120px;
            left: -40px;
            right: -40px;
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
            position: relative;
        }

        .title {
            text-align: center;
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .nomor {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
            font-size: 10px;
        }

        .tanggal {
            text-align: right;
            margin-bottom: 20px;
        }

        .penerima {
            margin-bottom: 20px;
        }

        .penerima table {
            width: 100%;
        }

        .penerima td {
            padding: 2px 0;
            vertical-align: top;
        }

        .penerima .label {
            width: 40px;
        }

        .penerima .colon {
            width: 10px;
        }

        .isi-memo {
            text-align: justify;
            margin: 15px 0;
            line-height: 1.6;
            text-indent: 50px; /* Indent otomatis untuk paragraf pertama */
        }

        .isi-memo p {
            margin: 5px ;
            text-align: justify;
            text-indent: 50px; /* Setiap paragraf menjorok */
        }

        /* Khusus untuk list, jangan indent */
        .isi-memo ul,
        .isi-memo ol {
            text-indent: 0;
        }

        .isi-memo li {
            text-indent: 0;
        }

        .isi-memo h1, .isi-memo h2, .isi-memo h3 {
            font-weight: bold;
            margin: 12px 0 8px 0;
        }

        .isi-memo h1 { font-size: 14px; }
        .isi-memo h2 { font-size: 12px; }
        .isi-memo h3 { font-size: 11px; }

        .isi-memo ul, .isi-memo ol {
            margin: 10px 0;
            padding-left: 25px;
        }

        .isi-memo li {
            margin-bottom: 5px;
        }

        .isi-memo strong { font-weight: bold; }
        .isi-memo em { font-style: italic; }
        .isi-memo u { text-decoration: underline; }
        .isi-memo s { text-decoration: line-through; }

        .isi-memo .ql-align-center { text-align: center; }
        .isi-memo .ql-align-right { text-align: right; }
        .isi-memo .ql-align-justify { text-align: justify; }

        /* Indent classes dari Quill */
        .isi-memo .ql-indent-1 { padding-left: 3em; }
        .isi-memo .ql-indent-2 { padding-left: 6em; }
        .isi-memo .ql-indent-3 { padding-left: 9em; }
        .isi-memo .ql-indent-4 { padding-left: 12em; }
        .isi-memo .ql-indent-5 { padding-left: 15em; }
        .isi-memo .ql-indent-6 { padding-left: 18em; }
        .isi-memo .ql-indent-7 { padding-left: 21em; }
        .isi-memo .ql-indent-8 { padding-left: 24em; }

        .signature-block {
            margin-top: 40px;
        }

        .signature-right {
            text-align: right;
        }

        .signature-space {
            height: 50px;
        }

        .signature-name {
            font-weight: normal;
        }

        .tembusan {
            margin-top: 40px;
            font-size: 10px;
        }

        .tembusan-title {
            font-weight: bold;
            margin-bottom: 8px;
        }

        .tembusan-list {
            margin-left: 0;
            padding-left: 20px;
        }

        .tembusan-list li {
            margin-bottom: 3px;
        }
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
            <tr>
                <td class="label">Yth.</td>
                <td class="colon">:</td>
                <td>{{ $letter->yth_nama ?? '' }}</td>
            </tr>
            <tr>
                <td class="label">Hal</td>
                <td class="colon">:</td>
                <td>{{ $letter->hal ?? '' }}</td>
            </tr>
        </table>
    </div>

    {{-- ISI MEMO --}}
    <div class="isi-memo">
        {!! $letter->sehubungan_dengan ?? '' !!}
    </div>

    <div class="isi-memo">
        {!! $letter->alinea_isi ?? '' !!}
    </div>

    @if(!empty($letter->isi_penutup))
    <div class="isi-memo">
        {!! $letter->isi_penutup !!}
    </div>
    @else
    <div class="isi-memo">
        Atas perhatian dan perkenan Bapak/Ibu/Saudara/i, kami mengucapkan terima kasih.
    </div>
    @endif

    {{-- TANDA TANGAN --}}
    <table class="signature-block" style="width: 100%;">
        <tr>
            <td style="width: 50%;"></td>
            <td style="width: 50%;">
                <div class="signature-right">
                    <div style="margin-bottom: 5px;">
                        {{ $letter->jabatan_pembuat ?? 'Nama jabatan' }},
                    </div>
                    <div class="signature-space"></div>
                    <div class="signature-name">
                        {{ $letter->nama_pembuat ?? 'Nama Lengkap' }}
                    </div>
                    @if($letter->nik_pembuat)
                    <div style="margin-top: 4px; font-size: 10px;">
                        NIK. {{ $letter->nik_pembuat }}
                    </div>
                    @endif
                </div>
            </td>
        </tr>
    </table>

    {{-- TEMBUSAN --}}
    @php
        $tembusanFiltered = [];
        if (!empty($letter->tembusan) && is_array($letter->tembusan)) {
            $tembusanFiltered = array_filter($letter->tembusan, function($item) {
                return !empty(trim($item));
            });
        }
    @endphp

    @if(!empty($tembusanFiltered) && count($tembusanFiltered) > 0)
    <div class="tembusan">
        <div class="tembusan-title">Tembusan:</div>
        <ol class="tembusan-list">
            @foreach($tembusanFiltered as $item)
            <li>{{ $item }}</li>
            @endforeach
        </ol>
    </div>
    @endif
</div>

</body>
</html>