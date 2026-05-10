<?php

namespace App\Services;

use App\Contracts\ImageUploadServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Layanan upload gambar.
 * Memenuhi prinsip SRP — tanggung jawab tunggal: menangani penyimpanan gambar.
 * Memenuhi prinsip DIP — controller bergantung pada interface, bukan class ini langsung.
 */
class ImageUploadService implements ImageUploadServiceInterface
{
    /**
     * Upload file gambar dari HTTP request ke storage publik.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $field   Nama field input file dalam request
     * @param  string  $folder  Folder tujuan di storage/public
     * @return string|null      Path relatif file yang tersimpan, atau null jika tidak ada file
     */
    public function uploadFromRequest(Request $request, string $field, string $folder): ?string
    {
        if ($request->hasFile($field)) {
            return $request->file($field)->store($folder, 'public');
        }

        return null;
    }

    /**
     * Upload gambar dari string base64 ke storage publik.
     * Digunakan saat gambar sudah di-crop di browser (format data URI base64).
     *
     * @param  string  $base64String  Data gambar dalam format "data:image/...;base64,..."
     * @param  string  $folder        Folder tujuan di storage/public
     * @return string|null            Path relatif file yang tersimpan, atau null jika format tidak valid
     */
    public function uploadFromBase64(string $base64String, string $folder): ?string
    {
        $parts = explode(';base64,', $base64String);

        if (count($parts) < 2) {
            return null;
        }

        $imageData = base64_decode($parts[1]);
        $filePath  = $folder . '/' . uniqid() . '.png';

        Storage::disk('public')->put($filePath, $imageData);

        return $filePath;
    }
}
