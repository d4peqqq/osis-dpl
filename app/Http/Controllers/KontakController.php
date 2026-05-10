<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;

class KontakController extends Controller
{
    public function index()
    {
        $settings = Pengaturan::pluck('value', 'key');
        return view('kontak.index', compact('settings'));
    }
}
