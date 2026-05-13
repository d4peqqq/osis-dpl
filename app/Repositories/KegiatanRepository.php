<?php

namespace App\Repositories;

use App\Models\Kegiatan;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * KegiatanRepository
 *
 * ✅ SOLID - Single Responsibility Principle (SRP):
 * Class ini HANYA bertanggung jawab untuk semua operasi
 * database yang berhubungan dengan model Kegiatan.
 * Tidak ada logic bisnis, tidak ada HTTP request handling.
 *
 * ✅ SOLID - Dependency Inversion Principle (DIP):
 * Controller tidak lagi bergantung pada Kegiatan model secara langsung.
 * Controller bergantung pada Repository (abstraksi),
 * bukan implementasi konkret Eloquent query.
 */
class KegiatanRepository
{
    /**
     * Ambil semua kegiatan dengan pagination untuk admin.
     */
    public function getAllPaginated(int $perPage = 10): LengthAwarePaginator
    {
        return Kegiatan::orderBy('date', 'desc')->paginate($perPage);
    }

    /**
     * Ambil kegiatan yang sudah dipublish untuk halaman publik.
     */
    public function getPublished(int $limit = 3): Collection
    {
        return Kegiatan::where('is_published', true)
            ->orderBy('date', 'desc')
            ->take($limit)
            ->get();
    }

    /**
     * Hitung total semua kegiatan.
     */
    public function count(): int
    {
        return Kegiatan::count();
    }

    /**
     * Ambil kegiatan terbaru berdasarkan created_at.
     */
    public function getLatest(int $limit = 5): Collection
    {
        return Kegiatan::orderBy('created_at', 'desc')->take($limit)->get();
    }

    /**
     * Simpan kegiatan baru ke database.
     */
    public function create(array $data): Kegiatan
    {
        return Kegiatan::create($data);
    }

    /**
     * Update kegiatan yang sudah ada.
     */
    public function update(Kegiatan $kegiatan, array $data): bool
    {
        return $kegiatan->update($data);
    }

    /**
     * Hapus kegiatan dari database.
     */
    public function delete(Kegiatan $kegiatan): bool
    {
        return $kegiatan->delete();
    }
}