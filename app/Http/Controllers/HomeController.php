<?php

namespace App\Http\Controllers;

use App\Repositories\KegiatanRepository;
use App\Repositories\GaleriRepository;
use App\Repositories\PengaturanRepository;
use App\Repositories\StrukturRepository;

class HomeController extends Controller
{
    public function __construct(
        private KegiatanRepository  $kegiatanRepo,
        private GaleriRepository    $galeriRepo,
        private PengaturanRepository $pengaturanRepo,
        private StrukturRepository  $strukturRepo,
    ) {}

    public function index()
    {
        // Controller hanya "bertanya" ke repository, tidak query sendiri
        $settings = $this->pengaturanRepo->getAllAsKeyValue();
        $kegiatan = $this->kegiatanRepo->getPublished(limit: 3);
        $galeri   = $this->galeriRepo->getOrdered(limit: 6);
        $struktur = $this->strukturRepo->getActive(limit: 6);

        return view('home.index', compact('settings', 'kegiatan', 'galeri', 'struktur'));
    }
}