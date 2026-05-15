<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Menu QR') }} · {{ $restaurant->name }}</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: system-ui, -apple-system, sans-serif; margin: 0; color: #111; background: #f4f4f5; }
        .no-print { padding: 1rem; text-align: center; }
        .sheet {
            width: 210mm;
            min-height: 297mm;
            margin: 1rem auto;
            padding: 22mm 18mm;
            background: #fff;
            box-shadow: 0 4px 24px rgba(0,0,0,.08);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .sheet h1 { margin: 0 0 0.5rem; font-size: 2rem; font-weight: 700; }
        .sheet p.lead { margin: 0 0 1.5rem; font-size: 1.05rem; color: #4b5563; max-width: 150mm; }
        .qr-wrap { padding: 14px; background: #fff; border: 1px solid #e5e7eb; border-radius: 14px; }
        .qr-wrap img { display: block; width: 62mm; height: 62mm; object-fit: contain; }
        .url { margin-top: 1.25rem; font-size: 0.75rem; word-break: break-all; color: #6b7280; font-family: ui-monospace, monospace; max-width: 170mm; }
        @media print {
            body { background: #fff; }
            .no-print { display: none !important; }
            .sheet { margin: 0; box-shadow: none; min-height: 297mm; }
            @page { size: A4 portrait; margin: 0; }
        }
    </style>
</head>
<body>
    <div class="no-print">
        <a href="{{ route('vendor.restaurants.edit', $restaurant) }}">{{ __('Back to settings') }}</a>
        <button type="button" onclick="window.print()">{{ __('Print') }}</button>
    </div>

    <div class="sheet">
        <h1>{{ $restaurant->name }}</h1>
        <p class="lead">{{ __('Scan for the full digital menu') }}</p>
        <div class="qr-wrap">
            <img src="{{ $qrPngDataUri }}" width="236" height="236" alt="{{ __('QR code') }}">
        </div>
        <p class="url">{{ $menuUrl }}</p>
    </div>
</body>
</html>
