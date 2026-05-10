<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Galeri;
use App\Models\Pengaturan;
use App\Models\StrukturOrganisasi;

class HomeController extends Controller
{
    public function index()
    {
        $settings = Pengaturan::pluck('value', 'key');
        $kegiatan = Kegiatan::where('is_published', true)->orderBy('date', 'desc')->take(3)->get();
        $galeri = Galeri::orderBy('order')->take(6)->get();
        $struktur = StrukturOrganisasi::where('is_active', true)->orderBy('order')->take(6)->get();

        return view('home.index', compact('settings', 'kegiatan', 'galeri', 'struktur'));
    }
}
