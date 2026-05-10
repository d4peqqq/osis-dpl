<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use App\Models\StrukturOrganisasi;

class StrukturController extends Controller
{
    public function index()
    {
        $settings = Pengaturan::pluck('value', 'key');
        $all = StrukturOrganisasi::where('is_active', true)->orderBy('order')->get();

        // Ketua & Wakil per gender (for separate hero sections)
        $ketuaPutra = $all->filter(fn($m) => str_contains(strtolower($m->position), 'ketua') && !str_contains(strtolower($m->position), 'wakil') && !str_contains(strtolower($m->position), 'bidang') && ($m->gender ?? 'putra') === 'putra')->first();
        $ketuaPutri = $all->filter(fn($m) => str_contains(strtolower($m->position), 'ketua') && !str_contains(strtolower($m->position), 'wakil') && !str_contains(strtolower($m->position), 'bidang') && ($m->gender ?? 'putra') === 'putri')->first();
        $wakilPutra = $all->filter(fn($m) => str_contains(strtolower($m->position), 'wakil') && ($m->gender ?? 'putra') === 'putra')->first();
        $wakilPutri = $all->filter(fn($m) => str_contains(strtolower($m->position), 'wakil') && ($m->gender ?? 'putra') === 'putri')->first();

        // Exclude ketua & wakil from member lists to avoid duplication, then split by gender
        $members = $all->reject(fn($m) => 
            ($ketuaPutra && $m->id === $ketuaPutra->id) || 
            ($ketuaPutri && $m->id === $ketuaPutri->id) || 
            ($wakilPutra && $m->id === $wakilPutra->id) ||
            ($wakilPutri && $m->id === $wakilPutri->id)
        );

        $anggotaPutra = $members->filter(fn($m) => ($m->gender ?? 'putra') === 'putra');
        $anggotaPutri = $members->filter(fn($m) => ($m->gender ?? 'putra') === 'putri');

        return view('struktur.index', compact(
            'settings', 'all',
            'anggotaPutra', 'anggotaPutri',
            'ketuaPutra', 'ketuaPutri', 'wakilPutra', 'wakilPutri'
        ));
    }
}
