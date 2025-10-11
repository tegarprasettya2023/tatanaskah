<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Perintah</title>
    <style>
        @page { margin: 0; }
        body {
            font-family: 'CenturyGothic', sans-serif;
            font-size: 12px;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        /* Header */
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

        /* Konten */
        .content { margin-top: 120px; margin-bottom: 120px; margin-left: 20mm; margin-right: 20mm; }

        .title { text-align: center; font-weight: bold; font-size: 14px; margin-bottom: 3px; text-transform: uppercase; }
        .subtitle { text-align: center; margin-bottom: 15px; }
        .section-title { text-align: center; font-weight: bold; margin: 20px 0 10px 0; }

        .table-meta { width: 100%; margin-bottom: 15px; border-collapse: collapse; }
        .table-meta td { vertical-align: top; padding: 2px 4px; }

        /* Signature sekarang float right (sama seperti Surat Dinas) */
        .signature {
            float: right;
            text-align: center;
            width: 220px;
            margin-top: 10px;
        }
        .signature-space { height: 60px; }
        .signature-name { font-weight: bold; }

        /* Tembusan: clear both supaya berada di bawah area tanda tangan,
           dan tembusan-list diindent sejajar dengan kolom isi (90px + 10px = 100px) */
        .tembusan {
            clear: both;
            margin-top: 20px;
        }
        .tembusan .label-cell { width: 90px; display: inline-block; vertical-align: top; }
        .tembusan .colon-cell { width: 10px; display: inline-block; vertical-align: top; }
        .tembusan-list {
            margin-left: 100px; /* sejajar dengan kolom isi */
            margin-top: 4px;
        }
.tembusan-flex {
    position: fixed;
    bottom: 50px; /* posisi di atas footer (footer tinggi 60px + margin 10px) */
    left: 20mm;   /* sama dengan margin kiri content */
    right: 20mm;  /* sama dengan margin kanan content */
    display: flex;
    align-items: flex-start;
    font-size: 12px;
    line-height: 1.6;
    background: white; /* agar tidak transparan */
    padding: 5px 0;
    z-index: 3000;
}

.tembusan-flex > div:nth-child(1) {
    width: 90px;
    /* font-weight: bold; */
}

.tembusan-flex > div:nth-child(2) {
    padding-left: 6px;
}

        /* Lampiran */
        .page-break { page-break-before: always; }
        .lampiran-header { text-align: right; margin-bottom: 15px; }
        .lampiran-title { text-align: center; font-weight: bold; margin-bottom: 15px; text-transform: uppercase; }
        .lampiran-table { width: 100%; border-collapse: collapse; }
        .lampiran-table th, .lampiran-table td { border: 1px solid #000; padding: 6px; text-align: left; }
        .lampiran-table th { text-align: center; }
        .lampiran-table thead th {
    font-weight: normal !important;
}

    </style>
</head>
<body>

{{-- HEADER --}}
<div class="header">
    @php
        $headerPath = public_path('kop/header_lab.png');
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
        $footerPath = public_path('footer/footer_lab.png');
        if(file_exists($footerPath)) {
            $imageData = base64_encode(file_get_contents($footerPath));
            $mimeType = mime_content_type($footerPath);
            echo '<img src="data:' . $mimeType . ';base64,' . $imageData . '" alt="Footer">';
        }
    @endphp
</div>

{{-- ================= HALAMAN UTAMA ================= --}}
<div class="content">
    <div class="title">SURAT PERINTAH/TUGAS</div>
<div class="subtitle"><b>NOMOR: {{ $letter->nomor ?? 'ST/..../bulan/tahun' }}</b></div>


    <table class="table-meta">
        <tr>
            <td style="width: 90px;">Menimbang</td>
            <td style="width: 10px;">:</td>
            <td>
                1. {{ $letter->menimbang_1 ?? '...........................................' }} <br>
                2. {{ $letter->menimbang_2 ?? '...........................................' }}
            </td>
        </tr>
        <tr>
            <td>Dasar</td>
            <td>:</td>
            <td>
                a. {{ $letter->dasar_a ?? '...........................................' }} <br>
                b. {{ $letter->dasar_b ?? '...........................................' }}
            </td>
        </tr>
    </table>

    <div class="section-title">Memberi Perintah:</div>

    <table class="table-meta">
        <tr>
            <td style="width: 90px;">Kepada</td>
            <td style="width: 10px;">:</td>
            <td>
                <table>
                    <tr><td style="width:100px;">Nama</td><td style="width:10px;">:</td><td>{{ $letter->nama_penerima ?? '' }}</td></tr>
                    <tr><td>NIKepegawaian</td><td>:</td><td>{{ $letter->nik_penerima ?? '' }}</td></tr>
                    <tr><td>Jabatan</td><td>:</td><td>{{ $letter->jabatan_penerima ?? '' }}</td></tr>
                </table>
                @if(!empty($letter->nama_nama_terlampir)) Atau nama-nama terlampir. @endif
            </td>
        </tr>
        <tr>
            <td>Untuk</td>
            <td>:</td>
            <td>
                1. {{ $letter->untuk_1 ?? '' }} <br>
                2. {{ $letter->untuk_2 ?? '' }}
            </td>
        </tr>
        <!-- NOTE: tidak menaruh Tembusan di sini lagi -->
    </table>

{{-- Tanda Tangan --}}
<div class="signature">
    <div>{{ $letter->tempat ?? 'Surabaya' }}, {{ $letter->formatted_letter_date ?? '................' }}</div>
    <div>{{ $letter->jabatan_pembuat ?? 'Nama Jabatan' }},</div>
    <div class="signature-space"></div>
    <div class="signature-name">{{ $letter->nama_pembuat ?? 'Nama Pejabat' }}</div>
    <div>{{ $letter->nik_pembuat ?? 'NIK Pegawai' }}</div>
</div>

<div class="tembusan-flex">
    <div>Tembusan:</div>
    <div>
        1. {{ $letter->tembusan_1 ?? '...........................................' }}<br>
        2. {{ $letter->tembusan_2 ?? '...........................................' }}
    </div>
</div>



</div> <!-- akhir .content -->

{{-- ================= HALAMAN LAMPIRAN ================= --}}
<div class="page-break"></div>
<div class="content">
    <!-- Header Lampiran -->
    <div class="lampiran-header">
        <table style="width:100%; border-collapse:collapse;">
            <tr>
                <!-- kolom kiri kosong -->
                <td style="vertical-align: top;"></td>

                <!-- kolom kanan: semua sejajar kanan -->
                <td style="text-align: right; vertical-align: top; white-space: nowrap; padding-right: 5px;">
                    <div style="font-weight: bold;">Lampiran Surat Tugas</div>
                    <div>Nomor : {{ $letter->nomor ?? '.....................' }}</div>
                    <div>Tanggal : {{ $letter->formatted_letter_date ?? '.....................' }}</div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Judul Lampiran -->
    <div class="lampiran-title">DAFTAR NAMA YANG DIBERIKAN TUGAS</div>

    <!-- Tabel Lampiran -->
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
            @if(!empty($letter->lampiran) && count($letter->lampiran) > 0)
                @foreach($letter->lampiran as $i => $row)
                    <tr>
                        <td style="text-align: center;">{{ $i+1 }}</td>
                        <td>{{ $row['nama'] ?? '' }}</td>
                        <td>{{ $row['nik'] ?? '' }}</td>
                        <td>{{ $row['jabatan'] ?? '' }}</td>
                        <td>{{ $row['keterangan'] ?? '' }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" style="text-align: center;">(Belum ada data lampiran)</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
</body>
</html>
