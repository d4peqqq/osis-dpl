<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\Galeri;
use App\Models\StrukturOrganisasi;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'kegiatan' => Kegiatan::count(),
            'galeri'   => Galeri::count(),
            'anggota'  => StrukturOrganisasi::count(),
        ];
        $latestKegiatan = Kegiatan::orderBy('created_at', 'desc')->take(5)->get();
        return view('admin.dashboard.index', compact('stats', 'latestKegiatan'));
    }
}
