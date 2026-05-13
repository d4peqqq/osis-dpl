<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\KegiatanRepository;
use App\Repositories\GaleriRepository;
use App\Repositories\StrukturRepository;

class DashboardController extends Controller
{
    public function __construct(
        private KegiatanRepository $kegiatanRepo,
        private GaleriRepository   $galeriRepo,
        private StrukturRepository $strukturRepo,
    ) {}

    public function index()
    {
        // Semua "tahu cara hitung" ada di repository, bukan di sini
        $stats = [
            'kegiatan' => $this->kegiatanRepo->count(),
            'galeri'   => $this->galeriRepo->count(),
            'anggota'  => $this->strukturRepo->count(),
        ];

        $latestKegiatan = $this->kegiatanRepo->getLatest(limit: 5);

        return view('admin.dashboard.index', compact('stats', 'latestKegiatan'));
    }
}