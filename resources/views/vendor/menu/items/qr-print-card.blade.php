<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Product QR') }} · {{ $menuItem->name }}</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: system-ui, -apple-system, sans-serif; margin: 0; color: #111; background: #e4e4e7; }
        .no-print { padding: 1rem; text-align: center; }
        .page {
            width: 210mm;
            min-height: 297mm;
            margin: 1rem auto;
            padding: 12mm;
            background: #fff;
            box-shadow: 0 4px 24px rgba(0,0,0,.08);
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10mm;
            align-content: start;
            justify-items: center;
        }
        .card {
            width: 85mm;
            min-height: 54mm;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 5mm 4mm;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            page-break-inside: avoid;
        }
        .card .brand { font-size: 0.65rem; color: #6b7280; text-transform: uppercase; letter-spacing: 0.06em; margin: 0; }
        .card h2 { margin: 0.15rem 0 0.35rem; font-size: 0.85rem; font-weight: 700; line-height: 1.25; max-height: 2.5em; overflow: hidden; }
        .card .price { margin: 0 0 0.35rem; font-size: 0.8rem; font-weight: 600; }
        .card .qr { margin-top: auto; }
        .card .qr img { width: 26mm; height: 26mm; display: block; }
        @media print {
            body { background: #fff; }
            .no-print { display: none !important; }
            .page { margin: 0; box-shadow: none; min-height: 297mm; }
            @page { size: A4 portrait; margin: 0; }
        }
    </style>
</head>
<body>
    <div class="no-print">
        <a href="{{ route('vendor.menu.items.index') }}">{{ __('Menu items') }}</a>
        <button type="button" onclick="window.print()">{{ __('Print') }}</button>
    </div>

    <div class="page">
        @foreach ([1, 2, 3, 4, 5, 6] as $_)
            <div class="card">
                <p class="brand">{{ $restaurant->name }}</p>
                <h2>{{ $menuItem->name }}</h2>
                <p class="price">{{ $restaurant->currency }} {{ number_format((float) $menuItem->price, 2) }}</p>
                <div class="qr">
                    <img src="{{ $qrPngDataUri }}" alt="{{ __('QR') }}">
                </div>
            </div>
        @endforeach
    </div>
</body>
</html>
