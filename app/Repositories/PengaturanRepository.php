<?php

namespace App\Repositories;

use App\Models\Pengaturan;
use Illuminate\Support\Collection;

/**
 * PengaturanRepository
 *
 * ✅ SOLID - Single Responsibility Principle (SRP):
 * Hanya menangani akses data Pengaturan/Settings.
 *
 * ✅ SOLID - Open-Closed Principle (OCP):
 * Jika cara menyimpan settings berubah (misal ke file .env
 * atau cache Redis), cukup ubah di sini tanpa menyentuh
 * controller atau service yang menggunakannya.
 */
class PengaturanRepository
{
    /**
     * Ambil semua settings sebagai key-value collection.
     */
    public function getAllAsKeyValue(): Collection
    {
        return Pengaturan::pluck('value', 'key');
    }

    /**
     * Ambil satu nilai setting berdasarkan key.
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $setting = Pengaturan::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Update atau buat setting baru.
     */
    public function set(string $key, mixed $value): Pengaturan
    {
        return Pengaturan::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }
}