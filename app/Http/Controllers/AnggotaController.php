<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use App\Models\StrukturOrganisasi;

class AnggotaController extends Controller
{
    public function show($slug)
    {
        $settings = Pengaturan::pluck('value', 'key');
        $anggota = StrukturOrganisasi::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('anggota.show', compact('settings', 'anggota'));
    }
}
