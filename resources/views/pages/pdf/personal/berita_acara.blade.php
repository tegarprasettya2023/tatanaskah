<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Berita Acara</title>
    <style>
        @page { margin: 0; }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 10px;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .header { 
            position: fixed; 
            top: 0; 
            left: 0; 
            right: 0;
            width: 100%; 
            height: 90px; 
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
            margin-bottom: 100px;
            margin-left: 30px;
            margin-right: 30px;
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
            font-weight: bold;
            margin-bottom: 25px;
        }

        .paragraph {
            text-align: justify;
            margin: 15px 0;
        }

        .list-kegiatan {
            margin: 10px 0 10px 10px;
        }

        .list-kegiatan li {
            margin-bottom: 8px;
            text-align: justify;
        }

        .penutup {
            text-align: justify;
            margin: 20px 0;
        }

        .signature-wrapper {
            width: 100%;
            margin-top: 40px;
        }

        /* ---------- REVISI CSS UNTUK MENGSEJAJARKAN TTD ---------- */
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        /* pastikan tiap sel tepat separuh lebar konten */
        .signature-table td {
            vertical-align: top;
            padding: 5px;
            width: 50%;
            box-sizing: border-box;
        }

        /* agar aman override inline style pada td (jika ada) gunakan !important */
        .signature-table td.sig-left {
            text-align: left !important;
        }
        .signature-table td.sig-right {
            text-align: left !important;             width: 15%;

        }

        /* ruang tanda tangan dibuat agak lebih besar agar tanda tangan turun ke posisi yang sama */
        .sig-space {
            height: 60px; /* bisa sesuaikan lagi jika perlu */
        }

        .sig-name {
            font-weight: normal;
            margin-top: 4px;
        }

        .sig-nik {
            font-size: 10px;
        }
        /* --------------------------------------------------------- */

        .sig-left {
            /* fallback */
        }

        .sig-right {
            /* fallback */
        }

        .center-signature {
            text-align: center;
            margin-top: 50px;
        }

        .center-signature .sig-title {
            margin-bottom: 10px;
        }

        .center-signature .sig-space {
            height: 60px;
        }

        .center-signature .sig-name {
            font-weight: normal;
        }

        .center-signature .sig-position {
            margin-top: 3px;
        }

        .center-signature .sig-nik {
            margin-top: 3px;
            font-size: 10px;
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
    <div class="title">BERITA ACARA</div>
    <div class="nomor">NOMOR {{ $letter->nomor ?? '…/…. /…../…..' }}</div>

    <div class="paragraph">
        Pada hari ini, 
        <span>{{ $letter->tanggal_acara ? $letter->tanggal_acara->translatedFormat('l') : '…..' }}</span> 
        tanggal 
        <span>{{ $letter->tanggal_acara ? $letter->tanggal_acara->translatedFormat('d') : '….' }}</span>, 
        bulan 
        <span>{{ $letter->tanggal_acara ? $letter->tanggal_acara->translatedFormat('F') : '….' }}</span>, 
        tahun 
        <span>{{ $letter->tanggal_acara ? $letter->tanggal_acara->translatedFormat('Y') : '….' }}</span>, 
        kami masing-masing:
    </div>

    <div class="paragraph">
        1. <span>{{ $letter->nama_pihak_pertama ?? '…..(nama pejabat)' }}</span>({{ $letter->nip_pihak_pertama ?? 'NIP' }} dan {{ $letter->jabatan_pihak_pertama ?? 'jabatan' }}), selanjutnya disebut <span>PIHAK PERTAMA</span>
    </div>

    <div class="paragraph">
        dan
    </div>

    <div class="paragraph">
        2. <span>{{ $letter->pihak_kedua ?? '……(pihak lain)' }}</span>, selanjutnya disebut <span>PIHAK KEDUA</span>, telah melaksanakan <span>{{ $letter->telah_melaksanakan ?? '................................' }}</span>
    </div>

    @if(!empty($letter->kegiatan) && is_array($letter->kegiatan))
    <ol class="list-kegiatan">
        @foreach($letter->kegiatan as $kegiatan)
        <li>{{ $kegiatan }}</li>
        @endforeach
    </ol>
    @else
    <ol class="list-kegiatan">
        <li>……………………………………..….</li>
        <li>……………………………………..….</li>
        <li>dan seterusnya.</li>
    </ol>
    @endif

    <div class="penutup">
        Berita acara ini dibuat dengan sesungguhnya berdasarkan {{ $letter->dibuat_berdasarkan ?? '………………………….............................' }}
    </div>

    <!--
      Perubahan kecil pada inline style "Dibuat di ..." supaya start-nya
      berada pada posisi yang sama dengan awal kolom PIHAK PERTAMA (kolom kanan).
      Ini hanya menggeser posisi teks, bukan mengubah struktur tanda tangan.
    -->
    <div style="margin: 100px 0 10px 0; margin-left: 569px; text-align: left;">
        Dibuat di {{ $letter->tempat_ttd ?? '………….' }},
    </div>

    {{-- Tanda Tangan Pihak Pertama & Kedua --}} 
    <!-- (HTML tanda-tangan tetap persis seperti aslinya; cuma CSS di atas yang atur penjajaran) -->
    <table class="signature-table" style="margin-top: 10px;">
        <tr>
            <td class="sig-left" style="text-align: left;">
                <div>PIHAK KEDUA</div>
                <div class="sig-space"></div> {{-- lebih panjang agar turun ke bawah --}}
                <div class="sig-name">{{ $letter->pihak_kedua ?? 'Nama Lengkap' }}</div>
                <div class="sig-nik">{{ $letter->nik_pihak_kedua ? 'NIK. ' . $letter->nik_pihak_kedua : 'NIKepegawaian' }}</div>
            </td>
            <td class="sig-right" style="text-align: right;">
                <div>PIHAK PERTAMA</div>
                <div class="sig-space"></div> {{-- sama panjang agar sejajar --}}
                <div class="sig-name">{{ $letter->nama_pihak_pertama ?? 'Nama Lengkap' }}</div>
                <div class="sig-nik">{{ $letter->nip_pihak_pertama ? 'NIK. ' . $letter->nip_pihak_pertama : 'NIKepegawaian' }}</div>
            </td>
        </tr>
    </table>

    {{-- Mengetahui/Mengesahkan (fix di bawah dekat footer) --}}
    <div class="center-signature" style="position: absolute; bottom: 40px; left: 0; right: 0; text-align: center;">
        <div class="sig-title">Mengetahui/Mengesahkan</div>
        <div class="sig-position">{{ $letter->jabatan_mengetahui ?? 'Nama Jabatan' }}</div>
        <div style="height: 70px;"></div>
        <div class="sig-name">{{ $letter->nama_mengetahui ?? 'Nama Lengkap' }}</div>
        <div class="sig-nik">{{ $letter->nik_mengetahui ? 'NIK. ' . $letter->nik_mengetahui : 'NIKepegawaian' }}</div>
    </div>

</div>

</body>
</html>
