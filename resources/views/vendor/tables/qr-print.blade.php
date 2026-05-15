<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Table QR') }} · {{ $restaurant->name }} · {{ $restaurant_table->label }}</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: system-ui, -apple-system, sans-serif; margin: 0; color: #111; background: #f4f4f5; }
        .no-print { padding: 1rem; text-align: center; }
        .no-print a, .no-print button { margin: 0 0.5rem; }
        .sheet {
            width: 210mm;
            min-height: 297mm;
            margin: 1rem auto;
            padding: 18mm 16mm;
            background: #fff;
            box-shadow: 0 4px 24px rgba(0,0,0,.08);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .sheet h1 { margin: 0 0 0.35rem; font-size: 1.75rem; font-weight: 700; }
        .sheet .sub { margin: 0 0 1.25rem; font-size: 1.1rem; color: #374151; }
        .sheet .code { margin: 0.25rem 0 0; font-size: 0.95rem; color: #6b7280; }
        .qr-wrap { padding: 12px; background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; }
        .qr-wrap img { display: block; width: 56mm; height: 56mm; object-fit: contain; }
        .hint { margin-top: 1.25rem; font-size: 0.8rem; color: #6b7280; max-width: 160mm; line-height: 1.45; }
        .url { margin-top: 0.75rem; font-size: 0.7rem; word-break: break-all; color: #9ca3af; font-family: ui-monospace, monospace; }
        .token { margin-top: 1rem; font-size: 0.65rem; word-break: break-all; color: #9ca3af; font-family: ui-monospace, monospace; }
        @media print {
            body { background: #fff; }
            .no-print { display: none !important; }
            .sheet { margin: 0; box-shadow: none; min-height: 297mm; page-break-after: always; }
            @page { size: A4 portrait; margin: 0; }
        }
    </style>
</head>
<body>
    <div class="no-print">
        <a href="{{ route('vendor.tables.index') }}">{{ __('Back to tables') }}</a>
        <button type="button" onclick="window.print()">{{ __('Print') }}</button>
    </div>

    <div class="sheet">
        <h1>{{ $restaurant->name }}</h1>
        <p class="sub">{{ __('Scan to open menu for this table') }}</p>
        <p class="sub" style="margin-bottom:0.5rem;"><strong>{{ __('Table') }}:</strong> {{ $restaurant_table->label }}</p>
        @if ($restaurant_table->table_code)
            <p class="code">{{ __('Code') }}: {{ $restaurant_table->table_code }}</p>
        @endif
        <div class="qr-wrap">
            <img src="{{ $qrPngDataUri }}" width="212" height="212" alt="{{ __('QR code') }}">
        </div>
        <p class="hint">{{ __('This code opens your menu and remembers this table for checkout.') }}</p>
        <p class="url">{{ $tableEntryUrl }}</p>
        <p class="token">{{ __('Fallback token') }}: {{ $restaurant_table->qr_token }}</p>
    </div>
</body>
</html>
