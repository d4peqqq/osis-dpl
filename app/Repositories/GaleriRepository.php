<?php

namespace App\Repositories;

use App\Models\Galeri;
use Illuminate\Database\Eloquent\Collection;

/**
 * GaleriRepository
 *
 * ✅ SOLID - Single Responsibility Principle (SRP):
 * Hanya menangani semua operasi database Galeri.
 *
 * ✅ SOLID - Dependency Inversion Principle (DIP):
 * Controller bergantung pada Repository ini,
 * bukan langsung pada Eloquent model Galeri.
 */
class GaleriRepository
{
    /**
     * Ambil galeri berurutan untuk ditampilkan publik.
     */
    public function getOrdered(int $limit = 6): Collection
    {
        return Galeri::orderBy('order')->take($limit)->get();
    }

    /**
     * Ambil semua galeri untuk halaman admin.
     */
    public function getAll(): Collection
    {
        return Galeri::orderBy('order')->get();
    }

    /**
     * Hitung total galeri.
     */
    public function count(): int
    {
        return Galeri::count();
    }

    /**
     * Simpan foto galeri baru.
     */
    public function create(array $data): Galeri
    {
        return Galeri::create($data);
    }

    /**
     * Hapus foto galeri.
     */
    public function delete(Galeri $galeri): bool
    {
        return $galeri->delete();
    }
}