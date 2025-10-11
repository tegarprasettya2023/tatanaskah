<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Dinas</title>
    <style>
        @page {
            margin: 0;
        }
        
        body { 
            font-family: 'DejaVu Sans', sans-serif; 
            font-size: 12px; 
            line-height: 1.6; 
            margin: 0;
            padding: 0;
        }
        
   .header { 
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
            height: 80px;
            text-align: center;
            z-index: 1000;
        }
        
        .header img {
            width: 100%;
            height: 90px;
            object-fit: cover;
            display: block;
        }
        
        /* Footer - Fixed di setiap halaman */
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
            width: 90%;
            height: 40px;
            object-fit: cover;
            display: block;
        }
        
        .content { 
            margin-top: 110px;
            margin-bottom: 80px;
            margin-left: 20mm;
            margin-right: 20mm;
        }
        
        .title {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 20px;
        }
        
        .metadata {
            margin-bottom: 20px;
        }
        
        .metadata table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .metadata td {
            padding: 3px 0;
            vertical-align: top;
        }
        
        .metadata .label {
            width: 100px;
        }
        
        .metadata .colon {
            width: 20px;
        }
        
        .kepada {
            margin: 20px 0;
        }
        
        .isi {
            text-align: justify;
            margin: 15px 0;
            line-height: 1.8;
        }
        
        .penutup {
            text-align: justify;
            margin: 20px 0;
        }
        
        .signature {
            margin-top: 40px;
            float: right;
            text-align: center;
            width: 200px;
        }
        
        .signature-space {
            height: 60px;
        }
        
        .signature-name {
            font-weight: bold;
        }
        
        .tembusan {
            clear: both;
            margin-top: 80px;
        }
        
        .tembusan-list {
            margin-left: 20px;
        }
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
    {{-- Judul --}}
    <!-- <div class="title">
        KOP SURAT
    </div> -->

    {{-- Metadata Surat --}}
    <div class="metadata">
        <table>
            <tr>
                <td class="label">Nomor</td>
                <td class="colon">:</td>
                <td>{{ $letter->nomor ?? 'SD/..../bulan/tahun' }}</td>
                <td style="text-align: right;">
                    {{ $letter->tempat ?? 'Surabaya' }}, 
                    {{ $letter->letter_date ? \Carbon\Carbon::parse($letter->letter_date)->translatedFormat('d F Y') : '..................' }}
                </td>
            </tr>
            <tr>
                <td class="label">Sifat</td>
                <td class="colon">:</td>
                <td>{{ $letter->sifat ?? '' }}</td>
                <td></td>
            </tr>
            <tr>
                <td class="label">Lampiran</td>
                <td class="colon">:</td>
                <td>{{ $letter->lampiran ?? '' }}</td>
                <td></td>
            </tr>
            <tr>
                <td class="label">Perihal</td>
                <td class="colon">:</td>
                <td>{{ $letter->perihal ?? '' }}</td>
                <td></td>
            </tr>
        </table>
    </div>

    {{-- Kepada --}}
    <div class="kepada">
        <div>Yth. {{ $letter->kepada ?? '..............................' }}</div>
        <div style="margin-top: 5px;">di</div>
        <div>{{ $letter->kepada_tempat ?? '..............................' }}</div>
    </div>

   {{-- Isi Surat dengan paragraf "Sehubungan dengan..." --}}
<div class="isi">
    <p style="text-indent: 30px; margin: 0;">
        Sehubungan dengan {{ $letter->sehubungan_dengan ?? '......................................................................................' }}
    </p>
</div>

<div class="isi" style="margin-top: 5px; text-align: justify; text-indent: 30px;">
    {!! nl2br(e($letter->isi_surat ?? '')) !!}
</div>

{{-- Penutup --}}
<div class="penutup" style="text-indent: 30px;">
    Atas perhatian dan perkenan Bapak/Ibu/Saudara/i, kami mengucapkan terima kasih.
</div>

{{-- Tanda Tangan --}}
<div class="signature">
    <div>{{ $letter->jabatan1 ?? 'Nama Jabatan' }},</div>
    <div class="signature-space"></div>
    <div class="signature-name">{{ $letter->nama1 ?? 'Nama Pejabat' }}</div>
    <div>{{ $letter->nip ?? 'NIKepegawaian' }}</div>
</div>

{{-- Tembusan --}}
@if(!empty($letter->tembusan_data))
<div class="tembusan">
    <div>Tembusan :</div>
    <div class="tembusan-list" style="margin-left: 0;">
        @foreach($letter->tembusan_data as $index => $tembusan)
        <div>{{ $index + 1 }}. {{ $tembusan }}</div>
        @endforeach
    </div>
</div>
@else
@endif

</div>

</body>
</html>