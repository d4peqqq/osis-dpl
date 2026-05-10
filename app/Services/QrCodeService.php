<?php

namespace App\Services;

use App\Contracts\QrCodeServiceInterface;
use chillerlan\QRCode\QRCode;

/**
 * Layanan generasi QR code.
 * Memenuhi prinsip SRP — tanggung jawab tunggal: membuat QR code.
 * Memenuhi prinsip DIP — controller bergantung pada QrCodeServiceInterface,
 * sehingga library QR code bisa diganti tanpa menyentuh controller.
 */
class QrCodeService implements QrCodeServiceInterface
{
    /**
     * Generate QR code dari URL dan kembalikan sebagai data URI.
     *
     * @param  string  $url  URL yang akan di-encode
     * @return string        Data URI siap pakai di atribut src="..."
     */
    public function generate(string $url): string
    {
        return (new QRCode())->render($url);
    }
}
