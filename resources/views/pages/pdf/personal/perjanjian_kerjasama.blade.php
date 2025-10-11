<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Surat Perjanjian Kerja Sama</title>
<style>
    @page {
        margin: 0;
        padding: 0;
    }

    body { 
        font-family: 'CenturyGothic', sans-serif; 
        font-size: 12px; 
        line-height: 1.5; 
        margin: 0;
        padding: 0;
    }

    /* HEADER FIX DI SETIAP HALAMAN */
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

    /* FOOTER FIX DI SETIAP HALAMAN */
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
    margin: 0 40px; /* jarak samping biar teks nggak mepet */
    padding-top: 90px; /* biar konten mulai setelah header */
    padding-bottom: 80px; /* biar konten selesai sebelum footer */
}

    .title {
        text-align: center;
        font-weight: bold;
        font-size: 12px;
        margin: 15px 0;
    }

    .nomor {
        text-align: center;
        margin: 15px 0 15px 0;
        font-weight: bold;
        font-size: 12px;
    }

    .title-line {
        margin: 12px 0;
    }

    .pembuka {
        text-align: justify;
        margin: 15px 0;
        margin-top: 30px;
    }

{{-- ✅ PIHAK I & II FORMAT LURUS SEPERTI TEMPLATE --}}
<style>
    .pihak-wrapper {
        margin: 15px 30px;
    }
    .pihak-table {
        border-collapse: collapse;
        width: 100%;
    }
    .pihak-table td.num {
        width: 15px;
        vertical-align: top;
    }
    .pihak-table td.dot {
        width: 15px;
        text-align: center;
        vertical-align: top;
    }
    .pihak-table td.nama {
        width: 150px;
        vertical-align: top;
        text-align: left;
    }
    .pihak-table td.colon {
        width: 30px;
        vertical-align: top;
        text-align: center;
    }
    .pihak-table td.text {
        text-align: justify;
        vertical-align: top;
    }

    /* PASAL */
   .pasal {
    page-break-inside: avoid;
    margin: -30px 0;
}
.pasal::before {
    content: "";
    display: block;
    height: 10px; /* sama dengan margin-top konten / tinggi header */
}

    .pasal-title {
        text-align: center;
        font-weight: bold;
        margin: 55px 0 8px 0;
    }
    .pasal-subtitle {
        text-align: center;
        font-weight: bold;
        margin: 8px 0 12px 0;
    }
    .pasal-content {
        text-align: justify;
        margin: 10px 0;
        line-height: 1.6;
    }

    /* SIGNATURES */
    .signatures {
        margin-top: 30px;
        page-break-inside: avoid;
    }
    .signatures table {
        width: 100%;
        border-collapse: collapse;
    }
    .signatures td {
        width: 50%;
        text-align: center;
        vertical-align: top;
        padding: 15px 10px;
    }
    .signature-space {
        height: 60px;
        margin: 15px 0;
    }
    .signature-name {
        font-weight: bold;
        margin-top: 10px;
    }
    .signature-position {
        margin-top: 5px;
    }

    /* PAGE BREAK FIX HEADER */
    .page-break {
        page-break-before: always;
    }
</style>
</head>
<body>

{{-- HEADER - Fixed di setiap halaman --}}
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
        } else {
            echo '<div style="padding: 20px; background: #f8d7da; border: 2px solid #f5c2c7; text-align: center;">';
            echo '<strong style="color: #842029;">HEADER ' . strtoupper($kopType) . ' TIDAK DITEMUKAN</strong><br>';
            echo '<small style="color: #842029;">Path: ' . $headerPath . '</small>';
            echo '</div>';
        }
    @endphp
</div>

{{-- FOOTER - Fixed di setiap halaman --}}
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
        } else {
            echo '<div style="padding: 10px; background: #f8d7da; border: 2px solid #f5c2c7; text-align: center; font-size: 10px;">';
            echo '<strong style="color: #842029;">FOOTER ' . strtoupper($kopType) . ' TIDAK DITEMUKAN</strong>';
            echo '</div>';
        }
    @endphp
</div>

{{-- CONTENT --}}
<div class="content">
    {{-- JUDUL --}}
    <div class="title">
        <div style="font-weight: bold; font-size: 12px;">PERJANJIAN KERJASAMA</div>
        <div class="title-line">ANTARA</div>
        <div class="spacing">{{ $letter->pihak1 ?? '.............................' }}</div>
        <div class="title-line">DAN</div>
        <div class="spacing">{{ $letter->pihak2 ?? '.............................' }}</div>
        <div class="title-line">TENTANG</div>
        <div class="spacing">{{ $letter->tentang ?? '.............................' }}</div>
    </div>

    {{-- NOMOR --}}
    <div class="nomor">
        NOMOR: {{ $letter->nomor ?? '-' }}
    </div>

    {{-- PEMBUKA --}}
    <div class="pembuka">
        Pada hari ini, 
        <strong>{{ $letter->letter_date ? \Carbon\Carbon::parse($letter->letter_date)->translatedFormat('l') : 'Minggu' }}</strong> 
        tanggal <strong>{{ $letter->letter_date ? \Carbon\Carbon::parse($letter->letter_date)->translatedFormat('d') : '28' }}</strong>, 
        bulan <strong>{{ $letter->letter_date ? \Carbon\Carbon::parse($letter->letter_date)->translatedFormat('F') : 'September' }}</strong>, 
        tahun <strong>{{ $letter->letter_date ? \Carbon\Carbon::parse($letter->letter_date)->translatedFormat('Y') : '2025' }}</strong>, 
        bertempat di <strong>{{ $letter->tempat ?? '............' }}</strong> yang bertanda tangan di bawah ini :
    </div>

  
<div class="pihak-wrapper">
    <table class="pihak-table">
        <tr>
            <td class="num">1.</td>
            <td class="nama"><strong>{{ $letter->pihak1 ?? '....................' }}</strong></td>
            <td class="colon">:</td>
            <td class="text">
                {{ $letter->jabatan1 ?? '....................' }} selanjutnya disebut sebagai <strong>Pihak I</strong>
            </td>
        </tr>
        <tr>
            <td class="num">2.</td>
            <td class="nama"><strong>{{ $letter->pihak2 ?? '....................' }}</strong></td>
            <td class="colon">:</td>
            <td class="text">
                {{ $letter->jabatan2 ?? '....................' }} selanjutnya disebut sebagai <strong>Pihak II</strong>
            </td>
        </tr>
    </table>
</div>


    <div class="pembuka">
        bersepakat untuk melakukan kerja sama dalam bidang 
        <strong>{{ $letter->tentang ?? '.....yang' }}</strong> diatur dalam ketentuan sebagai berikut:
    </div>

    {{-- PASAL DINAMIS --}}
    @php
        $pasalData = $letter->pasal_data;
    @endphp

    @if(!empty($pasalData) && is_array($pasalData))
        @foreach($pasalData as $index => $pasal)
        <div class="pasal">
            <div class="pasal-title">Pasal {{ $index + 1 }}</div>
            
            @if(!empty($pasal['title']))
                <div class="pasal-subtitle">{{ strtoupper($pasal['title']) }}</div>
            @endif
            
            <div class="pasal-content">
                {!! nl2br(e($pasal['content'] ?? '')) !!}
            </div>
        </div>
        @endforeach
    @else
        <div class="pasal">
            <div class="pasal-title">Pasal 1</div>
            <div class="pasal-content">
                <em style="color: #999;">Tidak ada pasal yang tersimpan.</em>
            </div>
        </div>
    @endif

    {{-- TANDA TANGAN --}}
    <div class="signatures">
        <table>
            <tr>
                <td>
                    <div><strong>Pihak I</strong></div>
                    <div>{{ $letter->institusi1 ?? 'Institusi Pihak I' }}</div>
                    <div class="signature-space"></div>
                    <div class="signature-name">{{ $letter->nama1 ?? 'Nama' }}</div>
                    <div class="signature-position">{{ $letter->jabatan1 ?? 'Nama Jabatan' }}</div>
                </td>
                <td>
                    <div><strong>Pihak II</strong></div>
                    <div>{{ $letter->institusi2 ?? 'Institusi Pihak II' }}</div>
                    <div class="signature-space"></div>
                    <div class="signature-name">{{ $letter->nama2 ?? 'Nama' }}</div>
                    <div class="signature-position">{{ $letter->jabatan2 ?? 'Nama Jabatan' }}</div>
                </td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>
