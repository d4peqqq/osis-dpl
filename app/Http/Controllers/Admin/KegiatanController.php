<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreKegiatanRequest;
use App\Http\Requests\UpdateKegiatanRequest;
use App\Models\Kegiatan;
use App\Repositories\KegiatanRepository;
use App\Services\KegiatanService;

class KegiatanController extends Controller
{
    public function __construct(
        private KegiatanService    $service,
        private KegiatanRepository $repository,
    ) {}

    /**
     * Tampilkan daftar kegiatan dengan pagination.
     */
    public function index()
    {
        $kegiatan = $this->repository->getAllPaginated(perPage: 10);
        return view('admin.kegiatan.index', compact('kegiatan'));
    }

    public function create()
    {
        return view('admin.kegiatan.create');
    }

    public function store(StoreKegiatanRequest $request)
    {
        // $request->validated() sudah bersih dan aman
        $this->service->create(
            data:  $request->validated(),
            photo: $request->file('photo'),
        );

        return redirect()
            ->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit kegiatan.
     */
    public function edit(Kegiatan $kegiatan)
    {
        return view('admin.kegiatan.edit', compact('kegiatan'));
    }

    public function update(UpdateKegiatanRequest $request, Kegiatan $kegiatan)
    {
        $this->service->update(
            kegiatan: $kegiatan,
            data:     $request->validated(),
            photo:    $request->file('photo'),
        );

        return redirect()
            ->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil diperbarui.');
    }

    /**
     * Hapus kegiatan.
     *
     * Service menangani hapus foto + hapus data.
     * Controller hanya meneruskan perintah.
     */
    public function destroy(Kegiatan $kegiatan)
    {
        $this->service->delete($kegiatan);

        return redirect()
            ->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil dihapus.');
    }
}