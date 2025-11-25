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
            margin-bottom: -3px;
        }

        .title-2 {
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: -3px;
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
            margin-top: 10px;
        }

        .data-tentang {
            text-align: center;
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 10px;
            margin-top: 20px;
        }

        .rahmat-tuhan {
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 5px;
        }

        .judul-2-paten {
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .section-wrapper {
            display: table;
            width: 100%;
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .section-row {
            display: table-row;
        }

        .section-label {
            display: table-cell;
            width: 95px;
            vertical-align: top;
            padding-right: 5px;
        }

        .section-colon {
            display: table-cell;
            width: 10px;
            vertical-align: top;
        }

        .section-content {
            display: table-cell;
            vertical-align: top;
        }

        .list-item {
            display: table;
            width: 100%;
            margin-bottom: 8px;
        }

        .list-item-row {
            display: table-row;
        }

        .list-item-label {
            display: table-cell;
            width: 30px;
            vertical-align: top;
        }

        .list-item-content {
            display: table-cell;
            vertical-align: top;
            text-align: justify;
        }

        .memutuskan {
            text-align: center;
            font-size: 10px;
            margin: 20px 0;
        }

        .keputusan-item {
            display: table;
            width: 100%;
            margin-bottom: 12px;
            font-size: 10px;
        }

        .keputusan-row {
            display: table-row;
        }

        .keputusan-label {
            display: table-cell;
            width: 95px;
            vertical-align: top;
            padding-right: 5px;
        }

        .keputusan-colon {
            display: table-cell;
            width: 10px;
            vertical-align: top;
        }

        .keputusan-isi {
            display: table-cell;
            vertical-align: top;
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
            margin-bottom: 1px;
        }

        .sig-placeholder {
            display: block;
            height: 50px;
        }

        .sig-name {
            margin-top: 10px;
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
            text-align: left;
            font-size: 10px;
            margin-bottom: 20px;
            margin-left: 475px;
        }

        /* Styling untuk konten HTML dari Rich Text Editor */
        .lampiran-content {
            font-size: 10px;
            text-align: justify;
            line-height: 1.6;
            margin-left: 0;
            padding-left: 0;
            word-break: break-word;
        }

        .lampiran-content p {
            margin: 0 0 10px 0;
            text-align: justify;
        }

        .lampiran-content h1 {
            font-size: 16px;
            font-weight: bold;
            margin: 15px 0 10px 0;
        }

        .lampiran-content h2 {
            font-size: 14px;
            font-weight: bold;
            margin: 12px 0 8px 0;
        }

        .lampiran-content h3 {
            font-size: 12px;
            font-weight: bold;
            margin: 10px 0 6px 0;
        }

        .lampiran-content h4,
        .lampiran-content h5,
        .lampiran-content h6 {
            font-size: 11px;
            font-weight: bold;
            margin: 8px 0 5px 0;
        }

        .lampiran-content ul,
        .lampiran-content ol {
            margin: 10px 0;
            padding-left: 25px;
        }

        .lampiran-content li {
            margin-bottom: 5px;
        }

        .lampiran-content strong {
            font-weight: bold;
        }

        .lampiran-content em {
            font-style: italic;
        }

        .lampiran-content u {
            text-decoration: underline;
        }

        .lampiran-content s {
            text-decoration: line-through;
        }

        /* Alignment classes dari Quill */
        .lampiran-content .ql-align-center {
            text-align: center;
        }

        .lampiran-content .ql-align-right {
            text-align: right;
        }

        .lampiran-content .ql-align-justify {
            text-align: justify;
        }

        .lampiran-content a {
            color: #0066cc;
            text-decoration: underline;
        }

        .lampiran-content blockquote {
            border-left: 3px solid #ccc;
            padding-left: 15px;
            margin-left: 0;
            font-style: italic;
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

    {{-- JUDUL 2 (setelah judul) --}}
    @if(!empty($data->judul_2))
    <div class="title-2">
        {{ $data->judul_2 }}
    </div>
    @endif

    <div class="nomor">
        <strong>Nomor: {{ $data->nomor ?? 'SK/nomor/bulan/tahun' }}</strong>
    </div>

    <div class="tentang">
        <strong>TENTANG</strong>
    </div>

    <div class="data-tentang">
        {{ strtoupper($data->tentang ?? '...') }}
    </div>

    {{-- KALIMAT PATEN: DENGAN RAHMAT TUHAN YANG MAHA ESA --}}
    <div class="rahmat-tuhan">
        DENGAN RAHMAT TUHAN YANG MAHA ESA
    </div>

    {{-- JUDUL 2 LAGI (setelah kalimat paten) --}}
    @if(!empty($data->judul_2))
    <div class="judul-2-paten">
        {{ $data->judul_2 }},
    </div>
    @endif

    {{-- Menimbang --}}
    @if(!empty($data->menimbang) && count($data->menimbang) > 0)
    <div class="section-wrapper">
        <div class="section-row">
            <div class="section-label">Menimbang</div>
            <div class="section-colon">:</div>
            <div class="section-content">
                @foreach($data->menimbang as $i => $item)
                <div class="list-item">
                    <div class="list-item-row">
                        <div class="list-item-label">{{ chr(97 + $i) }}.</div>
                        <div class="list-item-content">{{ $item }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- Mengingat --}}
    @if(!empty($data->mengingat) && count($data->mengingat) > 0)
<div class="section-wrapper">
    <div class="section-row">
        <div class="section-label">Mengingat</div>
        <div class="section-colon">:</div>
        <div class="section-content">
            @foreach($data->mengingat as $i => $item)
            <div class="list-item">
                <div class="list-item-row">
                    <div class="list-item-label">{{ $i + 1 }}.</div>
                    <div class="list-item-content">{{ $item }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

    <div class="memutuskan">
        <span>MEMUTUSKAN:</span>
    </div>

    <div class="section-wrapper" style="margin-bottom: 10px;">
        <div class="section-row">
            <div class="section-label">Menetapkan</div>
            <div class="section-colon">:</div>
            <div class="section-content">{{ strtoupper($data->menetapkan ?? '...') }}</div>
        </div>
    </div>

    {{-- Isi Keputusan --}}
    @if(!empty($data->isi_keputusan) && count($data->isi_keputusan) > 0)
    @foreach($data->isi_keputusan as $keputusan)
    <div class="keputusan-item">
        <div class="keputusan-row">
            <div class="keputusan-label"><span>{{ strtoupper($keputusan['label'] ?? '') }}</span></div>
            <div class="keputusan-colon"><span>:</span></div>
            <div class="keputusan-isi">{{ $keputusan['isi'] ?? '' }}</div>
        </div>
    </div>
    @endforeach
    @endif

    {{-- Signature --}}
    <table class="signature-wrapper">
        <tr>
            <td style="width: 100%;"></td>
            <td style="width: 50%;">
                <div class="signature-right">
                    <div class="sig-role">Ditetapkan di: {{ $data->tempat_penetapan ?? 'Surabaya' }}</div>
                    <div class="sig-role">pada tanggal: {{ $data->tanggal_penetapan ? $data->tanggal_penetapan->translatedFormat('d F Y') : '..................' }}</div>
                    <div class="sig-role">{{ $data->jabatan_pejabat ?? 'Nama jabatan,' }}</div>
                    <span class="sig-placeholder"></span>
                    <div class="sig-name">{{ $data->nama_pejabat ?? 'Nama Lengkap' }}</div>
                    @if($data->nik_pejabat)
                    <div class="sig-nik">NIK. {{ $data->nik_pejabat }}</div>
                    @else
                    <div class="sig-nik">NIKepegawaian</div>
                    @endif
                </div>
            </td>
        </tr>
    </table>

    {{-- Tembusan - hanya tampil jika ada isi yang tidak kosong --}}
    @php
        $tembusanFiltered = [];
        if (!empty($data->tembusan) && is_array($data->tembusan)) {
            $tembusanFiltered = array_filter($data->tembusan, function($item) {
                return !empty(trim($item));
            });
        }
    @endphp
    
    @if(!empty($tembusanFiltered) && count($tembusanFiltered) > 0)
    <div class="tembusan-section">
        <div class="tembusan-title"><span>Tembusan</span></div>
        <ol class="tembusan-list">
            @foreach($tembusanFiltered as $item)
            <li>{{ $item }}</li>
            @endforeach
        </ol>
    </div>
    @endif
</div>

{{-- LAMPIRAN (Multiple - Halaman terpisah per lampiran dengan HTML support) --}}
@php
    $lampiranFiltered = !empty($data->lampiran) && is_array($data->lampiran) 
        ? array_filter($data->lampiran, function($item) {
            // Hapus HTML tags dan whitespace untuk cek apakah benar-benar kosong
            $stripped = strip_tags($item);
            return !empty(trim($stripped));
        }) 
        : [];
@endphp

@if(count($lampiranFiltered) > 0)
    @php $lampiranNumber = 1; @endphp
    @foreach($data->lampiran as $index => $lampiranItem)
        @php
            // Skip jika lampiran kosong
            $stripped = strip_tags($lampiranItem);
            if(empty(trim($stripped))) continue;
        @endphp
        
 <div class="page-break"></div>
<div class="content">
    <div class="lampiran-title">
        Lampiran {{ $lampiranNumber }}<br>
        {{ $data->judul ?? 'Keputusan Kepala Laboratorium' }}<br>
        {{ $data->judul_2 ?? 'Khusus Patologi Klinik Utama Trisensa' }}<br>
        Tentang: {{ $data->tentang ?? '-' }}<br>
        Nomor: {{ $data->nomor ?? 'SK/nomor/bulan/tahun' }}<br>
        Tanggal: {{ $data->tanggal_penetapan ? $data->tanggal_penetapan->translatedFormat('d F Y') : '..................' }}
    </div>
</div>

            {{-- Render HTML dari Rich Text Editor --}}
            <div class="lampiran-content">
                {!! $lampiranItem !!}
            </div>

            {{-- Signature untuk Lampiran --}}
            <table class="signature-wrapper" style="margin-top: 60px;">
                <tr>
                    <td style="width: 100%;"></td>
                    <td style="width: 50%;">
                        <div class="signature-right">
                            <div class="sig-role">Ditetapkan di: {{ $data->tempat_penetapan ?? 'Surabaya' }}</div>
                            <div class="sig-role">pada tanggal: {{ $data->tanggal_penetapan ? $data->tanggal_penetapan->translatedFormat('d F Y') : '..................' }}</div>
                            <div class="sig-role">{{ $data->jabatan_pejabat ?? 'Nama jabatan,' }}</div>
                            <span class="sig-placeholder"></span>
                            <div class="sig-name">{{ $data->nama_pejabat ?? 'Nama Lengkap' }}</div>
                            @if($data->nik_pejabat)
                            <div class="sig-nik">NIK. {{ $data->nik_pejabat }}</div>
                            @else
                            <div class="sig-nik">NIKepegawaian</div>
                            @endif
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        @php $lampiranNumber++; @endphp
    @endforeach
@endif

</body>
</html>