<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Surat Keputusan</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .kop { text-align: center; margin-bottom: 20px; }
        .content { margin: 20px; }
        .footer { position: fixed; bottom: 10px; text-align: center; font-size: 10px; }
    </style>
</head>
<body>
    {{-- Header sesuai kop_type --}}
    <div class="kop">
        @if($letter->kop_type == 'klinik')
            <img src="{{ public_path('kop/klinik.png') }}" width="100%">
        @elseif($letter->kop_type == 'lab')
            <img src="{{ public_path('kop/lab.png') }}" width="100%">
        @elseif($letter->kop_type == 'pt')
            <img src="{{ public_path('kop/pt.png') }}" width="100%">
        @endif
    </div>

    <div class="content">
        <h3 style="text-align: center; text-decoration: underline;">
            SURAT KEPUTUSAN
        </h3>
        <p style="text-align: center;">
            NOMOR: {{ $letter->reference_number ?? 'SK/nomor/bulan/tahun' }}
        </p>

        <p><strong>Menimbang:</strong></p>
        <p>{!! nl2br(e($letter->note)) !!}</p>

        <p><strong>MEMUTUSKAN:</strong></p>
        <p>Kesatu: ...</p>
        <p>Kedua: ...</p>
        <p>Ketiga: ...</p>
    </div>

    <div class="footer">
        @if($letter->kop_type == 'klinik')
            <img src="{{ public_path('footer/klinik.png') }}" width="100%">
        @elseif($letter->kop_type == 'lab')
            <img src="{{ public_path('footer/lab.png') }}" width="100%">
        @elseif($letter->kop_type == 'pt')
            <img src="{{ public_path('footer/pt.png') }}" width="100%">
        @endif
    </div>
</body>
</html>
