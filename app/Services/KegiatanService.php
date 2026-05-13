<?php

namespace App\Services;

use App\Models\Kegiatan;
use App\Repositories\KegiatanRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * KegiatanService
 *
 * ✅ SOLID - Single Responsibility Principle (SRP):
 * Class ini HANYA bertanggung jawab pada LOGIC BISNIS kegiatan:
 * - Generate slug unik
 * - Upload & hapus foto
 * - Menyiapkan data sebelum disimpan ke database
 *
 * Controller tidak perlu tahu cara generate slug atau upload foto.
 * Repository tidak perlu tahu logic bisnis.
 * Masing-masing punya tanggung jawab sendiri.
 *
 * ✅ SOLID - Open-Closed Principle (OCP):
 * Jika cara upload foto berubah (misal ke S3, Cloudinary),
 * cukup ubah method uploadPhoto() di sini.
 * Controller dan Repository tidak perlu disentuh sama sekali.
 *
 * ✅ SOLID - Dependency Inversion Principle (DIP):
 * Service bergantung pada KegiatanRepository (abstraksi),
 * bukan langsung pada Kegiatan model.
 */
class KegiatanService
{
    public function __construct(
        private KegiatanRepository $repository
    ) {}

    /**
     * Buat kegiatan baru.
     * Menggabungkan: persiapan data + upload foto + simpan ke DB.
     */
    public function create(array $data, ?UploadedFile $photo = null): Kegiatan
    {
        $data['slug']         = $this->generateSlug($data['title']);
        $data['is_published'] = $data['is_published'] ?? false;

        if ($photo) {
            $data['photo'] = $this->uploadPhoto($photo);
        }

        return $this->repository->create($data);
    }

    /**
     * Update kegiatan yang sudah ada.
     * Menggabungkan: persiapan data + upload foto baru (jika ada) + update DB.
     */
    public function update(Kegiatan $kegiatan, array $data, ?UploadedFile $photo = null): bool
    {
        $data['is_published'] = $data['is_published'] ?? false;

        if ($photo) {
            // Hapus foto lama sebelum upload yang baru
            $this->deletePhoto($kegiatan->photo);
            $data['photo'] = $this->uploadPhoto($photo);
        }

        return $this->repository->update($kegiatan, $data);
    }

    /**
     * Hapus kegiatan beserta fotonya.
     */
    public function delete(Kegiatan $kegiatan): bool
    {
        $this->deletePhoto($kegiatan->photo);
        return $this->repository->delete($kegiatan);
    }

    /**
     * Generate slug unik dari judul.
     *
     * ✅ SRP: Logic slug terpusat di satu tempat.
     * Sebelumnya logic ini ada langsung di dalam store() controller.
     */
    private function generateSlug(string $title): string
    {
        return Str::slug($title) . '-' . Str::random(5);
    }

    /**
     * Upload foto ke storage dan kembalikan path-nya.
     *
     * ✅ OCP: Jika storage berubah ke S3, hanya method ini yang diubah.
     * Tidak ada controller yang perlu disentuh.
     */
    private function uploadPhoto(UploadedFile $photo): string
    {
        return $photo->store('kegiatan', 'public');
    }

    /**
     * Hapus foto dari storage jika ada.
     */
    private function deletePhoto(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}