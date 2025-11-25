<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Panggilan</title>
    <style>
        @page { 
            margin: 120px 40px 100px 40px;
        }

        body {
            font-family: 'CenturyGothic', sans-serif;
            font-size: 10px;
            line-height: 1.6;
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
            z-index: 1000;
        }
        .header img { 
            width: 100%; 
            height: 100px; 
            object-fit: contain; 
            display: block; 
        }

        .footer {
            position: fixed; 
            bottom: -80px; 
            left: 0; 
            right: 0;
            width: 100%; 
            height: 40px; 
            text-align: center; 
            z-index: 1000;
        }
        .footer img { 
            width: 100%; 
            height: 40px; 
            object-fit: contain; 
            display: block; 
        }

        .content {
            position: relative;
            z-index: 1;
        }

        .title {
            text-align: center;
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 25px;
            text-transform: uppercase;
        }

        .header-table { 
            width: 100%; 
            margin-bottom: 25px; 
        }
        .header-table td { 
            padding: 3px 0; 
            vertical-align: top; 
        }
        .label { 
            width: 150px; 
        }
        .colon { 
            width: 15px; 
            text-align: center; 
        }

        .detail-section { 
            margin: 20px 0; 
            line-height: 1.8; 
        }
        .detail-section td { 
            padding: 3px 0; 
            vertical-align: top; 
        }

        .closing { 
            margin-top: 20px; 
            margin-bottom: 15px;
            text-align: justify;
        }
        
        .signature-block { 
            width: 100%; 
            margin-top: 80px; 
        }
        .signature-space { 
            height: 60px; 
        }
        .signature-name { 
            font-weight: bold; 
        }

        .tembusan { 
            margin-top: 50px; 
        }
        .tembusan strong { 
            font-weight: bold; 
        }
        .tembusan span { 
            font-weight: normal; 
        }
        
        /* Text Justify untuk isi pembuka */
        .text-justify {
            text-align: justify;
            text-justify: inter-word;
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
    <div class="title">SURAT PANGGILAN</div>

    <table class="header-table">
        <tr>
            <td class="label">Nomor</td><td class="colon">:</td>
            <td><strong>{{ $letter->nomor }}</strong></td>
            <td style="text-align:right;">Surabaya, {{ \Carbon\Carbon::parse($letter->letter_date)->translatedFormat('d F Y') }}</td>
        </tr>
        <tr><td class="label">Sifat</td><td class="colon">:</td><td colspan="2"><span class="dots">{{ $letter->sifat ?? '' }}</span></td></tr>
        <tr><td class="label">Lampiran</td><td class="colon">:</td><td colspan="2"><span class="dots">{{ $letter->lampiran ?? '' }}</span></td></tr>
        <tr><td class="label">Perihal</td><td class="colon">:</td><td colspan="2"><span class="dots">{{ $letter->perihal }}</span></td></tr>
        <tr><td class="label">Kepada</td><td class="colon">:</td><td colspan="2"><span class="dots">{{ $letter->kepada }}</span></td></tr>
    </table>

    {{-- Isi Pembuka dengan justify dan indentasi --}}
    <p class="text-justify" style="margin-bottom:15px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sehubungan dengan {{ $letter->isi_pembuka }}</p>

    <div class="detail-section">
        <table>
            <tr><td class="label">Pada hari, tanggal</td><td class="colon">:</td><td><span class="dots">{{ \Carbon\Carbon::parse($letter->hari_tanggal)->translatedFormat('l, d F Y') }}</span></td></tr>
            <tr><td class="label">Waktu</td><td class="colon">:</td><td><span class="dots">{{ $letter->waktu }}</span></td></tr>
            <tr><td class="label">Tempat</td><td class="colon">:</td><td><span class="dots">{{ $letter->tempat }}</span></td></tr>
            <tr><td class="label">Menghadap kepada</td><td class="colon">:</td><td><span class="dots">{{ $letter->menghadap }}</span></td></tr>
            <tr><td class="label">Alamat Pemanggil</td><td class="colon">:</td><td><span class="dots">{{ $letter->alamat_pemanggil }}</span></td></tr>
        </table>
    </div>

    {{-- Closing dengan justify dan indentasi --}}
    <p class="closing">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Atas perhatian dan perkenan Bapak/Ibu/Saudara/i, kami mengucapkan terima kasih.</p>

    {{-- Tanda Tangan --}}
    <div class="signature-block">
        <div style="text-align:right; margin-bottom:20px;">
            {{ $letter->jabatan }},
        </div>
        <div class="signature-space"></div>
        <div style="text-align:right;">
            <span style="font-weight:normal;">{{ $letter->nama_pejabat }}</span><br>
            NIK. {{ $letter->nik }}
        </div>
    </div>

    {{-- Tembusan - hanya tampil jika ada isi yang tidak kosong --}}
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
        <strong>Tembusan:</strong><br>
        <span>
            @foreach($tembusanFiltered as $index => $item)
                {{ $index + 1 }}. {{ $item }}<br>
            @endforeach
        </span>
    </div>
    @endif
</div>

</body>
</html>