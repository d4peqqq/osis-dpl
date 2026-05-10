<?php

namespace App\Contracts;

use Illuminate\Http\Request;

/**
 * Contract untuk layanan upload gambar.
 * Memenuhi prinsip ISP dan DIP — controller bergantung pada abstraksi ini,
 * bukan pada implementasi konkret.
 */
interface ImageUploadServiceInterface
{
    /**
     * Upload file gambar dari request dan simpan ke disk publik.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $field    Nama field input file
     * @param  string  $folder   Folder tujuan di storage/public
     * @return string|null       Path relatif file yang tersimpan, atau null jika tidak ada file
     */
    public function uploadFromRequest(Request $request, string $field, string $folder): ?string;

    /**
     * Upload gambar dari string base64 dan simpan ke disk publik.
     *
     * @param  string  $base64String  Data gambar dalam format base64
     * @param  string  $folder        Folder tujuan di storage/public
     * @return string|null            Path relatif file yang tersimpan, atau null jika gagal
     */
    public function uploadFromBase64(string $base64String, string $folder): ?string;
}
