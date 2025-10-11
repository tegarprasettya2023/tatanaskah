<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Surat Pengumuman</title>
<style>
    @page {
        margin: 0;
        padding: 0;
    }

    body { 
        font-family: 'CenturyGothic', sans-serif; 
        font-size: 12px; 
        line-height: 1.6; 
        margin: 0;
        padding: 0;
    }

      /* HEADER FIX DI SETIAP HALAMAN */
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

    /* KONTEN */
    .content {
        margin: 0 40px;
        padding-top: 100px; /* biar tidak ketutup header */
        padding-bottom: 80px;
    }

    .title {
        text-align: center;
        font-weight: bold;
        font-size: 16px;
        margin-top: 10px;
        margin-bottom: 0;
    }

    .nomor {
        text-align: center;
        margin: -1px 0 15px 0;
        font-weight: bold;
    }

    .tentang-label {
        text-align: center;
        font-weight: bold;
        text-transform: uppercase;
        margin-top: 30px;
    }

    .tentang {
        text-align: center;
        margin-top: 5px;
        margin-bottom: 45px; /* jarak lebih jauh dari isi pembuka */
    }

    .isi {
        text-align: justify;
        margin: 0 10px 40px 10px; /* beri ruang kiri-kanan */
    }

    /* tanda tangan kanan bawah */
    .signature {
        position: absolute;
        bottom: 90px;
        right: -30px; /* geser lebih kanan */
        text-align: left;
        width: 320px;
    }

    .signature td {
        vertical-align: top;
        padding: 3px 0;
    }
</style>
</head>
<body>

{{-- HEADER --}}
<div class="header">
@php
    $kopType = $letter->kop_type ?? 'klinik';
    $headerPath = '';
    if($kopType === 'klinik') $headerPath = public_path('kop/header_klinik.png');
    elseif($kopType === 'lab') $headerPath = public_path('kop/header_lab.png');
    elseif($kopType === 'pt') $headerPath = public_path('kop/header_pt.png');

    if(file_exists($headerPath)) {
        $imageData = base64_encode(file_get_contents($headerPath));
        $mimeType = mime_content_type($headerPath);
        echo '<img src="data:' . $mimeType . ';base64,' . $imageData . '" alt="Header">';
    } else {
        echo '<div style="padding: 20px; background: #f8d7da; border: 2px solid #f5c2c7; text-align: center;">';
        echo '<strong style="color: #842029;">HEADER ' . strtoupper($kopType) . ' TIDAK DITEMUKAN</strong>';
        echo '</div>';
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
    } else {
        echo '<div style="padding: 10px; background: #f8d7da; border: 2px solid #f5c2c7; text-align: center; font-size: 10px;">';
        echo '<strong style="color: #842029;">FOOTER ' . strtoupper($kopType) . ' TIDAK DITEMUKAN</strong>';
        echo '</div>';
    }
@endphp
</div>

{{-- KONTEN --}}
<div class="content">
    <div class="title">PENGUMUMAN</div>
    <div class="nomor">NOMOR: {{ $letter->nomor ?? 'UM/nomor/bulan/tahun' }}</div>
    <div class="tentang-label">TENTANG</div>
    <div class="tentang">{{ strtoupper($letter->tentang ?? '......................................................') }}</div>

    <div class="isi">
        &nbsp;&nbsp;&nbsp;&nbsp;{!! nl2br(e($letter->isi_pembuka ?? '.............................................................................')) !!}
        <br><br>
        &nbsp;&nbsp;&nbsp;&nbsp;{!! nl2br(e($letter->isi_penutup ?? '')) !!}
    </div>

    {{-- tanda tangan kanan bawah --}}
    <div class="signature">
        <table>
            <tr><td>Dikeluarkan di {{ $letter->tempat_ttd ?? '..................' }}</td></tr>
            <tr><td>pada tanggal {{ \Carbon\Carbon::parse($letter->tanggal_ttd ?? now())->translatedFormat('d F Y') }}</td></tr>
            <tr><td style="height:10px;"></td></tr>
            <tr><td>{{ $letter->jabatan_pembuat ?? 'Nama Jabatan' }},</td></tr>
            <tr><td style="height:60px;"></td></tr>
            <tr><td>{{ $letter->nama_pembuat ?? 'Nama Lengkap' }}</td></tr>
            <tr><td>NIK Pegawai: {{ $letter->nik_pegawai ?? '..................' }}</td></tr>
        </table>
    </div>
</div>
</body>
</html>
