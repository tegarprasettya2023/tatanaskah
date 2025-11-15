<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Perintah/Tugas</title>
    <style>
        @page { margin: 0; }
        body {
            font-family: 'Century Gothic', sans-serif ;
            font-size: 10px;
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
            margin-top: 120px; 
            margin-bottom: 120px; 
            margin-left: 20mm; 
            margin-right: 20mm; 
        }

        .title { 
            text-align: center; 
            font-weight: bold; 
            font-size: 12px; 
            margin-bottom: 3px; 
            text-transform: uppercase; 
        }
        
        .subtitle { 
            text-align: center; 
            margin-bottom: 15px; 
        }
        
        .section-title { 
            text-align: center; 
            font-weight: bold; 
            margin: 20px 0 10px 0; 
        }

        .table-meta { 
            width: 100%; 
            margin-bottom: 15px; 
            border-collapse: collapse; 
        }
        
        .table-meta td { 
            vertical-align: top; 
            padding: 2px 4px; 
        }

        .signature {
            float: right;
            text-align: center;
            width: 220px;
            margin-top: 10px;
        }
        
        .signature-space { 
            height: 60px; 
        }
        
        .signature-name { 
            font-weight: bold; 
        }

        .tembusan-flex {
            position: fixed;
            bottom: 50px;
            left: 20mm;
            right: 20mm;
            display: flex;
            align-items: flex-start;
            font-size: 12px;
            line-height: 1.6;
            background: white;
            padding: 5px 0;
            z-index: 3000;
        }

        .tembusan-flex > div:nth-child(1) {
            width: 90px;
        }

        .tembusan-flex > div:nth-child(2) {
            padding-left: 6px;
        }

        .page-break { 
            page-break-before: always; 
        }
        
        .lampiran-header { 
            text-align: right; 
            margin-bottom: 15px; 
        }
        
        .lampiran-title { 
            text-align: center; 
            font-weight: bold; 
            margin-bottom: 15px; 
            text-transform: uppercase; 
        }
        
        .lampiran-table { 
            width: 100%; 
            border-collapse: collapse; 
        }
        
        .lampiran-table th, 
        .lampiran-table td { 
            border: 1px solid #000; 
            padding: 6px; 
            text-align: left; 
        }
        
        .lampiran-table th { 
            text-align: center; 
            font-weight: normal !important;
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

{{-- HALAMAN UTAMA --}}
<div class="content">
    <div class="title">SURAT PERINTAH/TUGAS</div>
    <div class="subtitle"><b>NOMOR: {{ $letter->nomor ?? 'ST/..../bulan/tahun' }}</b></div>

    <table class="table-meta">
        {{-- Menimbang --}}
        @if(!empty($letter->menimbang) && count($letter->menimbang) > 0)
        <tr>
            <td style="width: 90px;">Menimbang</td>
            <td style="width: 10px;">:</td>
            <td>
                @foreach($letter->menimbang as $i => $item)
                    {{ $i + 1 }}. {{ $item }}<br>
                @endforeach
            </td>
        </tr>
        @endif

        {{-- Dasar --}}
        @if(!empty($letter->dasar) && count($letter->dasar) > 0)
        <tr>
            <td>Dasar</td>
            <td>:</td>
            <td>
                @php 
                    $dasarLabels = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
                @endphp
                @foreach($letter->dasar as $i => $item)
                    {{ $dasarLabels[$i] ?? ($i + 1) }}. {{ $item }}<br>
                @endforeach
            </td>
        </tr>
        @endif
    </table>

    <div class="section-title">Memberi Perintah:</div>

    <table class="table-meta">
        {{-- Kepada (Opsional) --}}
        @if(!empty($letter->nama_penerima) || !empty($letter->nik_penerima) || !empty($letter->jabatan_penerima))
        <tr>
            <td style="width: 90px;">Kepada</td>
            <td style="width: 10px;">:</td>
            <td>
                <table>
                    @if(!empty($letter->nama_penerima))
                    <tr>
                        <td style="width:100px;">Nama</td>
                        <td style="width:10px;">:</td>
                        <td>{{ $letter->nama_penerima }}</td>
                    </tr>
                    @endif
                    
                    @if(!empty($letter->nik_penerima))
                    <tr>
                        <td>NIK</td>
                        <td>:</td>
                        <td>{{ $letter->nik_penerima }}</td>
                    </tr>
                    @endif
                    
                    @if(!empty($letter->jabatan_penerima))
                    <tr>
                        <td>Jabatan</td>
                        <td>:</td>
                        <td>{{ $letter->jabatan_penerima }}</td>
                    </tr>
                    @endif
                </table>
                @if(!empty($letter->nama_nama_terlampir)) 
                    Atau nama-nama terlampir.
                @endif
            </td>
        </tr>
        @endif

        {{-- Untuk --}}
        @if(!empty($letter->untuk) && count($letter->untuk) > 0)
        <tr>
            <td>Untuk</td>
            <td>:</td>
            <td>
                @foreach($letter->untuk as $i => $item)
                    {{ $i + 1 }}. {{ $item }}<br>
                @endforeach
            </td>
        </tr>
        @endif
    </table>

    {{-- Tanda Tangan --}}
    <div class="signature">
        <div>{{ $letter->tempat ?? 'Surabaya' }}, {{ $letter->formatted_letter_date ?? '................' }}</div>
        <div>{{ $letter->jabatan_pembuat ?? 'Nama Jabatan' }},</div>
        <div class="signature-space"></div>
        <div class="signature-name">{{ $letter->nama_pembuat ?? 'Nama Pejabat' }}</div>
        <div>{{ $letter->nik_pembuat ?? 'NIK Pegawai' }}</div>
    </div>

    {{-- Tembusan (Opsional) --}}
    @if(!empty($letter->tembusan) && count($letter->tembusan) > 0)
    <div class="tembusan-flex">
        <div>Tembusan:</div>
        <div>
            @foreach($letter->tembusan as $i => $item)
                {{ $i + 1 }}. {{ $item }}<br>
            @endforeach
        </div>
    </div>
    @endif
</div>

{{-- HALAMAN LAMPIRAN (Opsional) --}}
@if(!empty($letter->lampiran) && count($letter->lampiran) > 0)
    @php
        // Check if there's any non-empty lampiran data
        $hasLampiranData = false;
        foreach($letter->lampiran as $row) {
            if (!empty($row['nama']) || !empty($row['nik']) || !empty($row['jabatan']) || !empty($row['keterangan'])) {
                $hasLampiranData = true;
                break;
            }
        }
    @endphp
    
    @if($hasLampiranData)
    <div class="page-break"></div>
    <div class="content">
        <div class="lampiran-header">
            <table style="width:100%; border-collapse:collapse;">
                <tr>
                    <td style="vertical-align: top;"></td>
                    <td style="text-align: right; vertical-align: top; white-space: nowrap; padding-right: 5px;">
                        <div style="font-weight: bold;">Lampiran Surat Tugas</div>
                        <div>Nomor : {{ $letter->nomor ?? '.....................' }}</div>
                        <div>Tanggal : {{ $letter->formatted_letter_date ?? '.....................' }}</div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="lampiran-title">DAFTAR NAMA YANG DIBERIKAN TUGAS</div>

        <table class="lampiran-table">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 25%;">Nama</th>
                    <th style="width: 20%;">NIK</th>
                    <th style="width: 20%;">Jabatan</th>
                    <th style="width: 30%;">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($letter->lampiran as $i => $row)
                    @if(!empty($row['nama']) || !empty($row['nik']) || !empty($row['jabatan']) || !empty($row['keterangan']))
                    <tr>
                        <td style="text-align: center;">{{ $i+1 }}</td>
                        <td>{{ $row['nama'] ?? '' }}</td>
                        <td>{{ $row['nik'] ?? '' }}</td>
                        <td>{{ $row['jabatan'] ?? '' }}</td>
                        <td>{{ $row['keterangan'] ?? '' }}</td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
@endif

</body>
</html>