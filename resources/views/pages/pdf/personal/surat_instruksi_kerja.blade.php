<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Instruksi Kerja</title>
    <style>
        @page { margin: 0; }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 10px;
            line-height: 1.3;
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
            margin: 0 auto;
        }

        .content-wrapper {
            margin-top: 100px;
            margin-bottom: 80px;
            margin-left: 15mm;
            margin-right: 15mm;
        }

        /* Header Table with Logo */
        .header-table {
            width: 100%;
            border: 2px solid #000;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .header-table td {
            padding: 5px;
            border: 2px solid #000;
            vertical-align: middle;
        }

        .logo-cell {
            width: 80px;
            text-align: center;
        }

        .logo-cell img {
            max-width: 100px;
            max-height: 60px;
        }

        .title-cell {
            text-align: center;
            font-weight: bold;
            font-size: 12px;
        }

        .info-cell {
            width: 200px;
            font-size: 9px;
        }

        .info-cell table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-cell table td {
            padding: 2px 4px;
            border: 1px solid #000;
        }

        /* Ditetapkan Section */
        .ditetapkan-section {
            width: 100%;
            border: 2px solid #000;
            border-collapse: collapse;
            margin-bottom: 10px;
            font-size: 9px;
        }

        .ditetapkan-section td {
            padding: 4px;
            border: 1px solid #000;
        }

        /* Content Table */
        .content-table {
            width: 100%;
            border: 2px solid #000;
            border-collapse: collapse;
            margin-bottom: 0;
        }

        .content-table td {
            padding: 5px;
            border: 1px solid #000;
            vertical-align: top;
        }

        .content-table .label-cell {
            width: 25%;
            font-weight: bold;
        }

        /* Rekaman Histori Table */
        .histori-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8px;
        }

        .histori-table th,
        .histori-table td {
            border: 1px solid #000;
            padding: 3px;
            text-align: center;
        }

        .histori-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        /* Persetujuan Table */
        .approval-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
        }

        .approval-table td {
            padding: 4px;
            border: 1px solid #000;
            text-align: center;
        }

        .approval-table .label-row {
            background-color: #e0e0e0;
            font-weight: bold;
        }
    </style>
</head>
<body>

{{-- HEADER --}}
<div class="header">
    @php
        $headerPath = '';
        $kopType = $letter->kop_type ?? 'lab';

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

<div class="content-wrapper">
    {{-- HEADER TABLE WITH LOGOS --}}
    <table class="header-table">
        <tr>
            <td class="logo-cell">
                @php
                    $logoKiriPath = '';
                    $logoKiri = $letter->logo_kiri ?? 'lab';

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
            <td class="title-cell">
                {{ strtoupper($letter->judul_ik ?? 'JUDUL IK') }}
            </td>
            <td class="logo-cell">
                @php
                    $logoKananPath = '';
                    $logoKanan = $letter->logo_kanan ?? 'lab';

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
            <td class="info-cell">
                <table>
                    <tr>
                        <td colspan="2">No. Dokumen :<br>{{ $letter->no_dokumen ?? '' }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">No. Revisi :<br>{{ $letter->no_revisi ?? '00' }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Terbit :<br>{{ $letter->tanggal_terbit ? \Carbon\Carbon::parse($letter->tanggal_terbit)->format('d/m/Y') : '' }}</td>
                        <td>Halaman :<br>{{ $letter->halaman ?? '1/1' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- DITETAPKAN OLEH --}}
    <table class="ditetapkan-section">
        <tr>
            <td style="width: 50%; text-align: center;">
                Ditetapkan Oleh<br>
                {{ $letter->jabatan_menetapkan ?? 'Kepala Laboratorium Utama Trisensa' }}<br><br>
                <strong>{{ $letter->nama_menetapkan ?? 'Dr. dr. Herni Suprapti, M. Kes' }}</strong><br>
                {{ $letter->nip_menetapkan ?? '208111505' }}
            </td>
            <td style="width: 50%;"></td>
        </tr>
    </table>

    {{-- CONTENT TABLE --}}
    <table class="content-table">
        <tr>
            <td class="label-cell">1. Pengertian</td>
            <td>{!! nl2br(e($letter->pengertian ?? '')) !!}</td>
        </tr>
        <tr>
            <td class="label-cell">2. Tujuan</td>
            <td>{!! nl2br(e($letter->tujuan ?? '')) !!}</td>
        </tr>
        <tr>
            <td class="label-cell">3. Kebijakan</td>
            <td>{!! nl2br(e($letter->kebijakan ?? '')) !!}</td>
        </tr>
        <tr>
            <td class="label-cell">4. Pelaksana</td>
            <td>{!! nl2br(e($letter->pelaksana ?? '')) !!}</td>
        </tr>
        <tr>
            <td class="label-cell">5. Prosedur Kerja/Langkah-langkah Kerja</td>
            <td>
                @if($letter->prosedur_kerja && count($letter->prosedur_kerja) > 0)
                    @foreach($letter->prosedur_kerja as $index => $prosedur)
                        @if($prosedur)
                            5.{{ $index + 1 }} {{ $prosedur }}<br>
                        @endif
                    @endforeach
                @endif
            </td>
        </tr>
        <tr>
            <td class="label-cell">6. Hal-Hal Yang Perlu Diperhatikan</td>
            <td>{!! nl2br(e($letter->hal_hal_perlu_diperhatikan ?? '')) !!}</td>
        </tr>
        <tr>
            <td class="label-cell">7. Unit terkait</td>
            <td>{!! nl2br(e($letter->unit_terkait ?? '')) !!}</td>
        </tr>
        <tr>
            <td class="label-cell">8. Dokumen terkait</td>
            <td>{!! nl2br(e($letter->dokumen_terkait ?? '')) !!}</td>
        </tr>
        <tr>
            <td class="label-cell">9. Referensi</td>
            <td>{!! nl2br(e($letter->referensi ?? '')) !!}</td>
        </tr>
        <tr>
            <td colspan="2" style="padding: 5px;">
                <strong>10. Rekaman Histori Perubahan</strong><br><br>
                <table class="histori-table">
                    <thead>
                        <tr>
                            <th style="width: 10%;">NO.</th>
                            <th style="width: 30%;">YANG DIUBAH</th>
                            <th style="width: 40%;">ISI PERUBAHAN</th>
                            <th style="width: 20%;">TANGGAL BERLAKU</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($letter->rekaman_histori && count($letter->rekaman_histori) > 0)
                            @foreach($letter->rekaman_histori as $histori)
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
        <tr>
            <td colspan="2" style="padding: 0;">
                <table class="approval-table">
                    <tr class="label-row">
                        <td style="width: 20%;">Jabatan</td>
                        <td style="width: 30%;">Dibuat oleh :</td>
                        <td style="width: 30%;">Direview oleh :</td>
                    </tr>
                    <tr>
                        <td style="text-align: left; padding-left: 10px;">:</td>
                        <td>{{ $letter->dibuat_jabatan ?? '.....................' }}</td>
                        <td>{{ $letter->direview_jabatan ?? '.....................' }}</td>
                    </tr>
                    <tr>
                        <td rowspan="2" style="text-align: left; padding-left: 10px;">Tanda Tangan :</td>
                        <td style="height: 40px;"></td>
                        <td style="height: 40px;"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="text-align: left; padding-left: 10px;">Tanggal :</td>
                        <td><strong>{{ $letter->dibuat_tanggal ? \Carbon\Carbon::parse($letter->dibuat_tanggal)->format('d/m/Y') : 'Tanggal/Bulan/Tahun' }}</strong></td>
                        <td><strong>{{ $letter->direview_tanggal ? \Carbon\Carbon::parse($letter->direview_tanggal)->format('d/m/Y') : 'Tanggal/Bulan/Tahun' }}</strong></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>

</body>
</html>