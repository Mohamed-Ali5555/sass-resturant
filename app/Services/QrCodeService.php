<?php

namespace App\Services;

use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\SvgWriter;

class QrCodeService
{
    public function pngDataUri(string $payload, int $size = 360, int $margin = 8): string
    {
        $qrCode = new QrCode(
            data: $payload,
            size: $size,
            margin: $margin,
            errorCorrectionLevel: ErrorCorrectionLevel::Medium,
        );

        return (new PngWriter)->write($qrCode)->getDataUri();
    }

    public function inlineSvg(string $payload, int $size = 200, int $margin = 4): string
    {
        $qrCode = new QrCode(
            data: $payload,
            size: $size,
            margin: $margin,
            errorCorrectionLevel: ErrorCorrectionLevel::Medium,
        );

        return (new SvgWriter)->write($qrCode)->getString();
    }
}
