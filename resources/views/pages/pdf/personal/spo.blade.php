<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SPO - {{ $spo->judul_spo }}</title>
<style>
    @page { 
        margin-top: 110px;
        margin-bottom: 70px;
        margin-left: 15mm;
        margin-right: 15mm;
    }

    body {
        font-family: 'Arial', sans-serif;
        font-size: 10px;
        line-height: 1.3;
        margin: 0;
        padding: 0;
    }

    /* Header dan Footer fixed untuk setiap halaman */
    .header { 
        position: fixed; 
        top: -110px; 
        left: -15mm; 
        right: -15mm;
        width: auto; 
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
        bottom: -70px; 
        left: 0; 
        right: 0;
        width: 100%; 
        height: 50px; 
        text-align: center;
        z-index: 1000;
    }
    .footer img { 
        width: 100%; 
        height: 40px; 
        object-fit: cover; 
        display: block; 
    }

    /* Content dengan margin untuk header/footer */
    .content {
        margin: 0;
    }

    /* Prevent awkward breaks */
    table {
        page-break-inside: auto;
    }

    tr {
        page-break-inside: avoid;
        page-break-after: auto;
    }

    .header-table, .ditetapkan-section {
        page-break-inside: avoid;
        page-break-after: avoid;
    }

    .approval-table {
        page-break-inside: avoid;
    }

    /* Global Table Normalization */
    table {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #000;
    }

    td, th {
        border: 1px solid #000;
        padding: 4px;
        vertical-align: top;
    }

    /* Header Table */
    .header-table td {
        padding: 5px;
        text-align: center;
        vertical-align: middle;
    }

    .logo-cell {
        width: 22%;
        text-align: center;
    }

    .logo-cell img {
        max-width: 100px;
        max-height: 70px;
    }

    .spo-label {
        width: 5%;
        text-align: center;
        font-size: 12px;
    }

    .title-cell {
        width: 48%;
        text-align: center;
        padding: 0;
    }

    .title-header {
        font-weight: bold;
        font-size: 12px;
        padding: 6px 0;
        border-bottom: 1px solid #000;
        margin: 0;
        width: 100%;
    }

    .info-table {
        border: none;
        font-size: 9px;
        width: 100%;
    }

    .info-table td {
        border: none;
        border-bottom: 1px solid #000;
        padding: 2px 15px;
    }

    .info-table .label-col {
        width: 30%;
        text-align: left;
    }

    .info-table .colon-col {
        width: 5%;
        text-align: center;
    }

    .info-table .data-col {
        width: 65%;
        text-align: left;
        padding-left: 10px
    }

    .info-table tr:last-child td {
        border-bottom: none;
    }

    /* Ditetapkan Section */
    .ditetapkan-section {
        margin-top: 20px;
    }

    .ditetapkan-inner {
        width: 45%;
        margin-left: auto;
        margin-right: -20px;
        text-align: center;
        padding: 10px 0;
    }

    /* Content Table */
    .content-table {
        margin-top: 10px;
    }

    .content-table .label-cell {
        width: 25%;
    }

    .bagan-alir-img {
        max-width: 100%;
        height: auto;
        display: block;
        margin: 5px auto;
    }

    /* Histori Table */
    .histori-table {
        font-size: 8px;
    }

    .histori-table th {
        background-color: #f0f0f0;
        font-weight: bold;
    }

    .rekaman-wrapper,
    .rekaman-wrapper td {
        border: 1px solid #000 !important;
        border-collapse: collapse;
    }

    .rekaman-row td {
        border: 1px solid #000;
        padding: 5px;
    }

    .histori-table th, 
    .histori-table td {
        border: 1px solid #000;
        border-collapse: collapse;
    }

    /* Approval Table */
    .approval-table {
        font-size: 10px;
        border: none;
        border-collapse: collapse;
    }

    .approval-table td {
        border: 0.5px solid #000000ff !important;
        text-align: center;
        border-top: none;
    }

    .approval-table .label-row {
        background-color: #e0e0e0;
    }
</style>

</head>
<body>

{{-- HEADER (Fixed - akan muncul di setiap halaman) --}}
<div class="header">
    @php
        $headerPath = '';
        $kopType = $spo->kop_type ?? 'lab';

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

{{-- FOOTER (Fixed - akan muncul di setiap halaman) --}}
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
{{-- HEADER TABLE WITH LOGOS --}}
<table class="header-table">
    <tr>
        <!-- Logo kiri -->
        <td class="logo-cell">
            @php
                $logoKiriPath = '';
                $logoKiri = $spo->logo_kiri ?? 'pt';
                if($logoKiri === 'klinik') {
                    $logoKiriPath = public_path('logo/logo_klinik.png');
                } elseif($logoKiri === 'lab') {
                    $logoKiriPath = public_path('logo/logo_lab.png');
                } elseif($logoKiri === 'pt') {
                    $logoKiriPath = public_path('logo/logo_pt.png');
                }

                if(file_exists($logoKiriPath)) {
                    $imageData = base64_encode(file_get_contents($logoKiriPath));
                    $mimeType = mime_content_type($logoKiriPath);
                    echo '<img src="data:' . $mimeType . ';base64,' . $imageData . '" alt="Logo Kiri">';
                }
            @endphp
        </td>

        <!-- Kolom SPO -->
        <td class="spo-label">SPO</td>

        <!-- Kolom tengah utama (judul dan data dokumen) -->
        <td class="title-cell">
            <!-- Judul -->
            <div class="title-header">
                {{ strtoupper($spo->judul_spo ?? 'JUDUL SPO') }}
            </div>

            <!-- Tabel info dokumen dengan wrapper -->
          <div class="info-wrapper">
    <table class="info-table">
        <tr>
            <td class="label-col">No. Dokumen</td>
            <td class="colon-col">:</td>
            <td class="data-col">{{ $spo->no_dokumen ?? '' }}</td>
        </tr>
        <tr>
            <td class="label-col">No. Revisi</td>
            <td class="colon-col">:</td>
            <td class="data-col">{{ $spo->no_revisi ?? '00' }}</td>
        </tr>
        <tr>
            <td class="label-col">Tanggal Terbit</td>
            <td class="colon-col">:</td>
            <td class="data-col">{{ $spo->tanggal_terbit ? $spo->tanggal_terbit->format('d/m/Y') : '. ./. ./. .' }}</td>
        </tr>
        <tr>
            <td class="label-col">Halaman</td>
            <td class="colon-col">:</td>
            <td class="data-col">{{ $spo->halaman ?? '1/1' }}</td>
        </tr>
    </table>
</div>
        </td>

        <!-- Logo kanan -->
        <td class="logo-cell">
            @php
                $logoKananPath = '';
                $logoKanan = $spo->logo_kanan ?? 'lab';
                if($logoKanan === 'klinik') {
                    $logoKananPath = public_path('logo/logo_klinik.png');
                } elseif($logoKanan === 'lab') {
                    $logoKananPath = public_path('logo/logo_lab.png');
                } elseif($logoKanan === 'pt') {
                    $logoKananPath = public_path('logo/logo_pt.png');
                }

                if(file_exists($logoKananPath)) {
                    $imageData = base64_encode(file_get_contents($logoKananPath));
                    $mimeType = mime_content_type($logoKananPath);
                    echo '<img src="data:' . $mimeType . ';base64,' . $imageData . '" alt="Logo Kanan">';
                }
            @endphp
        </td>
    </tr>
</table>

    {{-- DITETAPKAN OLEH --}}
    @if($spo->jabatan_menetapkan || $spo->nama_menetapkan || $spo->nip_menetapkan)
<table class="ditetapkan-section">
    <tr>
        <td>
            <div class="ditetapkan-inner">
                Ditetapkan Oleh<br>
                {{ $spo->jabatan_menetapkan ?? 'Kepala Laboratorium Utama Trisensa' }}<br><br><br>
                <span>{{ $spo->nama_menetapkan ?? 'Dr. dr. Herni Suprapti, M. Kes' }}</span><br>
                {{ $spo->nip_menetapkan ?? '208111505' }}
            </div>
        </td>
    </tr>
</table>
    @endif

    {{-- CONTENT TABLE --}}
    <table class="content-table">
        @for($i = 1; $i <= 9; $i++)
            @if($i == 5)
                {{-- Bagan Alir dengan gambar --}}
                @if($spo->{'label_' . $i} || $spo->bagan_alir_image)
                <tr>
                    <td class="label-cell">{{ $i }}. {{ $spo->{'label_' . $i} ?? 'Bagan Alir' }}</td>
                    <td>
                        @if($spo->bagan_alir_image)
                            @php
                                $imagePath = public_path($spo->bagan_alir_image);
                                if (file_exists($imagePath)) {
                                    $imageData = base64_encode(file_get_contents($imagePath));
                                    $mimeType = mime_content_type($imagePath);
                                    echo '<img src="data:' . $mimeType . ';base64,' . $imageData . '" class="bagan-alir-img">';
                                }
                            @endphp
                        @endif
                    </td>
                </tr>
                @endif
            @else
                {{-- Content biasa (1-4, 6-9) --}}
                @if($spo->{'label_' . $i} || $spo->{'content_' . $i})
                <tr>
                    <td class="label-cell">{{ $i }}. {{ $spo->{'label_' . $i} ?? '' }}</td>
                    <td>{!! nl2br(e($spo->{'content_' . $i} ?? '')) !!}</td>
                </tr>
                @endif
            @endif
        @endfor

{{-- REKAMAN HISTORIS (No. 10) sebagai row terpisah --}}
<tr class="rekaman-row">
    <td style="width: 25%; vertical-align: top;">
        10. {{ $spo->label_10 ?? 'Rekaman Historis Perubahan' }}
    </td>
    <td style="padding: 10px;">
        <table class="histori-table" style="width: 100%; border-collapse: collapse; border: none;">
            <thead>
                <tr>
                    <th style="width: 10%;">No.</th>
                    <th style="width: 30%;">Yang Diubah</th>
                    <th style="width: 40%;">Isi Perubahan</th>
                    <th style="width: 20%;">Tanggal mulai diberlakukan</th>
                </tr>
            </thead>
            <tbody>
                @if($spo->rekaman_historis && count($spo->rekaman_historis) > 0)
                    @foreach($spo->rekaman_historis as $histori)
                        @if(isset($histori['no']) && $histori['no'])
                        <tr>
                            <td>{{ $histori['no'] ?? '' }}</td>
                            <td>{{ $histori['yang_diubah'] ?? '' }}</td>
                            <td>{{ $histori['isi_perubahan'] ?? '' }}</td>
                            <td>{{ $histori['tanggal_berlaku'] ?? '' }}</td>
                        </tr>
                        @endif
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" style="height: 30px;"></td>
                    </tr>
                @endif
            </tbody>
        </table>
    </td>
</tr>

        {{-- APPROVAL FOOTER di dalam tabel --}}
        <tr>
            <td colspan="2" style="padding: 0; border: none;">
                <table class="approval-table">
                    <tr class="label-row">
                        <td rowspan="2" style="width: 20%; vertical-align: middle;">Jabatan:</td>
                        <td style="width: 40%;">Dibuat oleh :</td>
                        <td style="width: 40%;">Direview oleh :</td>
                    </tr>
                    <tr>
                        <td>{{ $spo->dibuat_jabatan ?? '.....................' }}</td>
                        <td>{{ $spo->direview_jabatan ?? '.....................' }}</td>
                    </tr>
                    <tr>
                        <td style="text-align: center;">Tanda Tangan :</td>
                        <td style="height: 40px;"></td>
                        <td style="height: 40px;"></td>
                    </tr>
                    <tr>
                        <td style="text-align: center;">Tanggal :</td>
                        <td>
                            @if($spo->dibuat_tanggal)
                                <strong>{{ $spo->dibuat_tanggal->format('d/m/Y') }}</strong>
                            @else
                                <strong>Tanggal/Bulan/Tahun</strong>
                            @endif
                        </td>
                        <td>
                            @if($spo->direview_tanggal)
                                <strong>{{ $spo->direview_tanggal->format('d/m/Y') }}</strong>
                            @else
                                <strong>Tanggal/Bulan/Tahun</strong>
                            @endif
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>

</body>
</html>