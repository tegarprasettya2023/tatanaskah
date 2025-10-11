<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $letter->reference_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 11pt;
            line-height: 1.4;
            position: relative;
            min-height: 100vh;
        }
        .header {
            width: 100%;
            margin-bottom: 30px;
            text-align: center;
        }
        .header img {
            width: 90%;
            height: auto;
        }
        .letter-container {
            padding: 0 40px;
            /* Add padding at the bottom to ensure content doesn't overlap with signature */
            padding-bottom: 200px;
        }
        /* Letter info table styling */
        .letter-info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .letter-info-table td {
            padding: 2px 0;
            vertical-align: top;
        }
        .letter-info-table .label-col {
            width: 60px;
            font-weight: bold;
        }
        .letter-info-table .content-col {
            width: auto;
        }
        .letter-info-table .date-col {
            width: 150px;
            text-align: right;
        }
        .subject-label {
            font-weight: bold;
            display: inline-block;
            width: 60px;
        }
        .subject-value {
            display: inline-block;
            font-weight: normal;
        }
        .recipient {
            margin-bottom: 15px;
            margin-top: 15px; /* Add some space before recipient */
        }
        .greeting {
            margin-top: 60px;
        }
        .content-section {
            margin-top: 10px;
            margin-bottom: 25px;
            text-align: justify;
        }
        .content-section p {
            margin: 8px 0;
            text-align: justify;
        }
        /* Signature section positioned at the bottom right */
        .signature-section {
            position: absolute;
            bottom: 100px; /* Position above footer */
            right: 40px;
            width: 300px;
            text-align: center;
        }
        .signature-section .title {
            margin-bottom: 10px;
        }
        .signature-section .signature-img {
            margin-bottom: 10px;
            height: 80px; /* Set a fixed height for the signature image */
        }
        .signature-section .name {
            font-weight: bold;
            text-decoration: underline;
        }
        .footer {
            position: fixed;
            bottom: 0;
            right: 0;
            width: auto;
            z-index: 1000;
        }
        .footer img {
            height: auto;
            width: 100%;
            display: block;
        }
        @page {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('kopsuratmigas.png') }}" alt="Kop Surat">
    </div>

    <div class="letter-container">
        <!-- Letter Info Section - Table format -->
        <table class="letter-info-table">
            <tr>
                <td class="label-col">Nomor</td>
                <td class="content-col">: {{ $letter->reference_number }}</td>
                <td class="date-col">{{ \Carbon\Carbon::parse($letter->letter_date)->format('d F Y') }}</td>
            </tr>
            <tr>
                <td class="label-col">Tentang</td>
                <td class="content-col" colspan="2">: {{ $letter->description }}</td>
            </tr>
            <tr>
                <td class="label-col">Hal</td>
                <td class="content-col" colspan="2">: {{ $letter->classification->type ?? 'klasifikasi' }}</td>
            </tr>
        </table>

        <!-- Recipient -->
        <div class="recipient">
            Kepada Yth,<br>
            {{ $letter->to }}
        </div>

        <!-- Greeting -->
        <div class="greeting">
            Dengan hormat,
        </div>

        <!-- Letter Content -->
        <div class="content-section">
            {!! nl2br(e($letter->note)) !!}
        </div>
    </div>

    <!-- Signature Section -->
    <div class="signature-section">
        <div class="title">Hormat kami,</div>
        <div class="company">{{ $config['ORGANIZATION_NAME'] ?? 'PT. GRESIK MIGAS (PERSERODA)' }}</div>
        <!-- Add signature image -->
        <div class="signature-img">
            <img src="{{ public_path('signature.png') }}" alt="Tanda Tangan" style="max-width: 100%; max-height: 100%;">
        </div>
        <div class="name">{{ $config['ORGANIZATION_LEADER_NAME'] ?? 'Moh Prisdianto AS, S.T.' }}</div>
    </div>

    <div class="footer">
        <img src="{{ public_path('footersuratmigas.png') }}" alt="Footer Surat">
    </div>
</body>
</html>