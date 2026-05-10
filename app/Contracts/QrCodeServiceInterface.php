<?php

namespace App\Contracts;

/**
 * Contract untuk layanan generasi QR code.
 * Memenuhi prinsip ISP dan DIP — controller bergantung pada abstraksi ini,
 * sehingga library QR code dapat diganti tanpa menyentuh controller.
 */
interface QrCodeServiceInterface
{
    /**
     * Generate QR code dari sebuah URL dan kembalikan sebagai data URI (base64).
     *
     * @param  string  $url  URL yang akan di-encode dalam QR code
     * @return string        Data URI gambar QR code (siap dipakai di <img src="...">)
     */
    public function generate(string $url): string;
}
