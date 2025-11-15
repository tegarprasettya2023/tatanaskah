<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan</title>
    <style>
        @page {
            margin: 0;
        }
        
        body { 
            font-family: 'Century Gothic' sans-serif;
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
            margin-bottom: 120px; /* lebih tinggi karena ada tanda tangan */
            margin-left: 20mm;
            margin-right: 20mm;
        }
        
        .title {
            text-align: center;
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 2px;
        }
        
        .nomor {
            text-align: center;
            font-size: 10px;
            margin-bottom: 10px;
        }
        
        .section {
            margin: 20px 0;
        }
        
        .section table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .section td {
            padding: 3px 0;
            vertical-align: top;
        }
        
        .label {
            width: 100px;
        }
        
        .colon {
            width: 20px;
        }
        
        .isi {
            text-align: justify;
            margin: 20px 0;
            line-height: 1.8;
        }
        
        /* Pakem tanda tangan selalu di bawah */
        .signature-block {
            position: absolute;
            bottom: 100px; /* atur sesuai tinggi footer */
            right: 60px;
            text-align: center;
        }
        
        .signature-name {
            font-weight: normal;
        }
        
        .signature-space {
            height: 60px; /* ruang tanda tangan */
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
    <div class="title">
        SURAT KETERANGAN
    </div>
    <div class="nomor">
        <strong>NOMOR: {{ $letter->nomor ?? 'KET/..../Bulan/Tahun' }}</strong>
    </div>

    {{-- Yang Bertanda Tangan --}}
    <div class="section">
        <p>Yang bertanda tangan di bawah ini,</p>
        <table>
            <tr>
                <td class="label">Nama</td>
                <td class="colon">:</td>
                <td>{{ $letter->nama_yang_menerangkan ?? '' }}</td>
            </tr>
            <tr>
                <td class="label">NIK</td>
                <td class="colon">:</td>
                <td>{{ $letter->nik_yang_menerangkan ?? '' }}</td>
            </tr>
            <tr>
                <td class="label">Jabatan</td>
                <td class="colon">:</td>
                <td>{{ $letter->jabatan_yang_menerangkan ?? '' }}</td>
            </tr>
        </table>
    </div>

    {{-- Dengan Ini Menerangkan --}}
    <div class="section">
        <p>dengan ini menerangkan bahwa :</p>
        <table>
            <tr>
                <td class="label">Nama</td>
                <td class="colon">:</td>
                <td>{{ $letter->nama_yang_diterangkan ?? '' }}</td>
            </tr>
            <tr>
                <td class="label">NIP</td>
                <td class="colon">:</td>
                <td>{{ $letter->nip_yang_diterangkan ?? '' }}</td>
            </tr>
            <tr>
                <td class="label">Jabatan</td>
                <td class="colon">:</td>
                <td>{{ $letter->jabatan_yang_diterangkan ?? '' }}</td>
            </tr>
        </table>
    </div>

    {{-- Isi Keterangan --}}
    <div class="isi">
        {!! nl2br(e($letter->isi_keterangan ?? '')) !!}
    </div>
</div>

{{-- Tanda Tangan (selalu di bawah) --}}
<div class="signature-block">
    <div>
        {{ $letter->tempat ?? 'Surabaya' }}, 
        {{ $letter->letter_date ? \Carbon\Carbon::parse($letter->letter_date)->translatedFormat('d F Y') : '..................' }}
    </div>
    <div>{{ $letter->jabatan_pembuat ?? 'Jabatan Pembuat Keterangan' }}</div>
    <div class="signature-space"></div>
    <div class="signature-name">{{ $letter->nama_pembuat ?? 'Nama Pejabat' }}</div>
    <div>NIK. {{ $letter->nik_pembuat ?? '.................' }}</div>
</div>

</body>
</html>

<style>
    .section table {
        width: 100%;
        border-collapse: collapse;
        margin-left: 5mm; /* majuin tabel supaya lebih rapat */
    }

    .label {
        width: 80px; /* lebih kecil biar teks lebih maju */
        padding-left: 5px; /* kasih padding dikit */
    }

    .colon {
        width: 15px;
    }

    .isi {
    text-align: justify;
    margin: 10px 0 0 0;
    line-height: 1.8;
    padding-left: 0;
    text-indent: 25px; /* hanya baris pertama yang maju */
}
</style>
