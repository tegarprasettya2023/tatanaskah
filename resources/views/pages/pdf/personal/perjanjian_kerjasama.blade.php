<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Surat Perjanjian Kerja Sama</title>
<style>

    @page {
        margin: 120px 40px 80px 40px; /* top right bottom left */
    }

    body { 
        font-family: 'Century Gothic', sans-serif;
        font-size: 12px; 
        line-height: 1.5; 
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
            bottom: -60px;
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

    /* CONTENT - Tidak perlu padding lagi karena sudah diatur di @page */
    .content {
        margin: 0;
    }

    .title {
        text-align: center;
        font-weight: bold;
        font-size: 12px;
        margin: 5px;
    }

    .nomor {
        text-align: center;
        margin: 5px;
        font-weight: bold;
        font-size: 10px;
    }

    .title-line {
        margin: 5px;
    }

    .pembuka {
        text-align: justify;
        margin: 15px 0;
        margin-top: 30px;
        page-break-inside: avoid;
    }

    /* PIHAK I & II */
    .pihak-wrapper {
        margin: 15px 30px;
        page-break-inside: avoid;
    }
    .pihak-table {
        border-collapse: collapse;
        width: 100%;
    }
    .pihak-table td.num {
        width: 15px;
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

    /* PASAL - dengan pagination control */
    .pasal {
        page-break-inside: avoid;
        margin: 5px 0;
        orphans: 3;
        widows: 3;
    }

    .pasal-title {
        text-align: center;
        margin: 5px 0 8px 0;
        page-break-after: avoid;
    }
    .pasal-subtitle {
        text-align: center;
        margin: 8px 0 12px 0;
        page-break-after: avoid;
    }
    .pasal-content {
        text-align: justify;
        margin: 10px 0;
        line-height: 1.6;
        orphans: 3;
        widows: 3;
    }

    /* SIGNATURES */
    .signatures {
        margin-top: 40px;
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
        margin-top: 10px;
    }
    .signature-position {
        margin-top: 5px;
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
        <span>{{ $letter->letter_date ? \Carbon\Carbon::parse($letter->letter_date)->translatedFormat('l') : 'Minggu' }}</span> 
        tanggal <span>{{ $letter->letter_date ? \Carbon\Carbon::parse($letter->letter_date)->translatedFormat('d') : '28' }}</span>, 
        bulan <span>{{ $letter->letter_date ? \Carbon\Carbon::parse($letter->letter_date)->translatedFormat('F') : 'September' }}</span>, 
        tahun <span>{{ $letter->letter_date ? \Carbon\Carbon::parse($letter->letter_date)->translatedFormat('Y') : '2025' }}</span>, 
        bertempat di <span>{{ $letter->tempat ?? '............' }}</span> yang bertanda tangan di bawah ini :
    </div>

    {{-- PIHAK I & II --}}
    <div class="pihak-wrapper">
        <table class="pihak-table">
            <tr>
                <td class="num">1.</td>
                <td class="nama"><span>{{ $letter->pihak1 ?? '....................' }}</span></td>
                <td class="colon">:</td>
                <td class="text">
                    {{ $letter->jabatan1 ?? '....................' }} selanjutnya disebut sebagai <span>Pihak I</span>
                </td>
            </tr>
            <tr>
                <td class="num">2.</td>
                <td class="nama"><span>{{ $letter->pihak2 ?? '....................' }}</span></td>
                <td class="colon">:</td>
                <td class="text">
                    {{ $letter->jabatan2 ?? '....................' }} selanjutnya disebut sebagai <span>Pihak II</span>
                </td>
            </tr>
        </table>
    </div>

    <div class="pembuka">
        bersepakat untuk melakukan kerja sama dalam bidang 
        <span>{{ $letter->tentang ?? '.....yang' }}</span> diatur dalam ketentuan sebagai berikut:
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
                    <div><span>Pihak I</span></div>
                    <div>{{ $letter->institusi1 ?? 'Institusi Pihak I' }}</div>
                    <div class="signature-space"></div>
                    <div class="signature-name">{{ $letter->nama1 ?? 'Nama' }}</div>
                    <div class="signature-position">{{ $letter->jabatan1 ?? 'Nama Jabatan' }}</div>
                </td>
                <td>
                    <div><span>Pihak II</span></div>
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