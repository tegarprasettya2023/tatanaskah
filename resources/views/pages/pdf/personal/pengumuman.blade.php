<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Surat Pengumuman</title>
<style>
    @page {
        margin: 120px 40px 100px 40px;
    }

    body { 
        font-family: 'Century Gothic', sans-serif; 
        font-size: 10px; 
        line-height: 1.6; 
        margin: 0;
        padding: 0;
    }

    /* HEADER FIX DI SETIAP HALAMAN */
    .header { 
        position: fixed;
        top: -120px;
        left: -30px;
        right: 30px;
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

    /* KONTEN */
    .content {
        margin: 0;
    }

    .title {
        text-align: center;
        font-weight: bold;
        font-size: 12px;
        margin-top: 10px;
        margin-bottom: 0;
    }

    .nomor {
        text-align: center;
        margin: -1px 0 15px 0;
        font-weight: bold;
        font-size: 10px;
    }

    .tentang-label {
        text-align: center;
        font-weight: bold;
        text-transform: uppercase;
        margin-top: 30px;
        margin-bottom: 5px;
    }

    .tentang {
        text-align: center;
        margin-top: 5px;
        margin-bottom: 45px;
    }

    .isi {
        text-align: justify;
        margin: 0 10px 40px 10px;
        line-height: 1.6;
    }

    /* Styling untuk konten HTML dari Rich Text Editor */
    .isi p {
        margin: 0 0 10px 0;
        text-align: justify;
        text-indent: 0; /* TIDAK ADA auto indent, harus pakai Tab manual */
    }

    .isi h1 {
        font-size: 16px;
        font-weight: bold;
        margin: 15px 0 10px 0;
    }

    .isi h2 {
        font-size: 14px;
        font-weight: bold;
        margin: 12px 0 8px 0;
    }

    .isi h3 {
        font-size: 12px;
        font-weight: bold;
        margin: 10px 0 6px 0;
    }

    .isi h4,
    .isi h5,
    .isi h6 {
        font-size: 11px;
        font-weight: bold;
        margin: 8px 0 5px 0;
    }

    .isi ul,
    .isi ol {
        margin: 10px 0;
        padding-left: 25px;
    }

    .isi li {
        margin-bottom: 5px;
    }

    .isi strong {
        font-weight: bold;
    }

    .isi em {
        font-style: italic;
    }

    .isi u {
        text-decoration: underline;
    }

    .isi s {
        text-decoration: line-through;
    }

    /* Alignment classes dari Quill */
    .isi .ql-align-center {
        text-align: center;
    }

    .isi .ql-align-right {
        text-align: right;
    }

    .isi .ql-align-justify {
        text-align: justify;
    }

    /* Indentasi dari Quill - gunakan margin-left */
    .isi .ql-indent-1 {
        margin-left: 3em !important;
        padding-left: 0;
    }

    .isi .ql-indent-2 {
        margin-left: 6em !important;
        padding-left: 0;
    }

    .isi .ql-indent-3 {
        margin-left: 9em !important;
        padding-left: 0;
    }

    .isi .ql-indent-4 {
        margin-left: 12em !important;
        padding-left: 0;
    }

    .isi .ql-indent-5 {
        margin-left: 15em !important;
        padding-left: 0;
    }

    .isi .ql-indent-6 {
        margin-left: 18em !important;
        padding-left: 0;
    }

    .isi .ql-indent-7 {
        margin-left: 21em !important;
        padding-left: 0;
    }

    .isi .ql-indent-8 {
        margin-left: 24em !important;
        padding-left: 0;
    }

    .isi a {
        color: #0066cc;
        text-decoration: underline;
    }

    .isi blockquote {
        border-left: 3px solid #ccc;
        padding-left: 15px;
        margin-left: 0;
        font-style: italic;
    }

    /* tanda tangan kanan bawah */
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
    <div class="nomor">NOMOR: {{ $letter->nomor ?? 'UM/001/XII/2024' }}</div>
    <div class="tentang-label">TENTANG</div>
    <div class="tentang">{{ strtoupper($letter->tentang ?? '......................................................') }}</div>

    {{-- Isi Pembuka (HTML dari Rich Text Editor) --}}
    <div class="isi">
        {!! $letter->isi_pembuka ?? '..............................................................................' !!}
    </div>

    {{-- Isi Penutup (HTML dari Rich Text Editor) --}}
    @if(!empty($letter->isi_penutup))
    <div class="isi" style="margin-top: 20px;">
        {!! $letter->isi_penutup !!}
    </div>
    @endif

    {{-- Tanda tangan --}}
    <table class="signature-wrapper">
        <tr>
            <td style="width: 50%;"></td>
            <td style="width: 50%;">
                <div class="signature-right">
                    <div class="sig-role">Dikeluarkan di {{ $letter->tempat_ttd ?? '..................' }}</div>
                    <div class="sig-role">pada tanggal {{ \Carbon\Carbon::parse($letter->tanggal_ttd ?? now())->translatedFormat('d F Y') }}</div>
                    <div class="sig-role">{{ $letter->jabatan_pembuat ?? 'Nama Jabatan' }},</div>
                    <span class="sig-placeholder"></span>
                    <div class="sig-name">{{ $letter->nama_pembuat ?? 'Nama Lengkap' }}</div>
                    @if($letter->nik_pegawai)
                    <div class="sig-nik">NIK Pegawai: {{ $letter->nik_pegawai }}</div>
                    @else
                    <div class="sig-nik">NIK Pegawai: ..................</div>
                    @endif
                </div>
            </td>
        </tr>
    </table>
</div>
</body>
</html>