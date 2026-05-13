<?php

namespace App\Repositories;

use App\Models\StrukturOrganisasi;
use Illuminate\Database\Eloquent\Collection;

/**
 * StrukturRepository
 *
 * ✅ SOLID - Single Responsibility Principle (SRP):
 * Hanya menangani semua operasi database StrukturOrganisasi.
 *
 * ✅ SOLID - Dependency Inversion Principle (DIP):
 * Controller tidak lagi menulis query Eloquent secara langsung.
 * Semua akses data melalui repository ini.
 */
class StrukturRepository
{
    /**
     * Ambil struktur yang aktif untuk halaman publik.
     */
    public function getActive(int $limit = 6): Collection
    {
        return StrukturOrganisasi::where('is_active', true)
            ->orderBy('order')
            ->take($limit)
            ->get();
    }

    /**
     * Ambil semua struktur untuk admin.
     */
    public function getAll(): Collection
    {
        return StrukturOrganisasi::orderBy('order')->get();
    }

    /**
     * Hitung total anggota struktur.
     */
    public function count(): int
    {
        return StrukturOrganisasi::count();
    }

    /**
     * Simpan anggota struktur baru.
     */
    public function create(array $data): StrukturOrganisasi
    {
        return StrukturOrganisasi::create($data);
    }

    /**
     * Update anggota struktur.
     */
    public function update(StrukturOrganisasi $struktur, array $data): bool
    {
        return $struktur->update($data);
    }

    /**
     * Hapus anggota struktur.
     */
    public function delete(StrukturOrganisasi $struktur): bool
    {
        return $struktur->delete();
    }
}