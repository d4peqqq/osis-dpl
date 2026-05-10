<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use App\Models\Pengaturan;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    public function index(Request $request)
    {
        $settings = Pengaturan::pluck('value', 'key');
        
        $query = Galeri::with('kegiatan');
        if ($request->has('gender') && in_array($request->gender, ['putra', 'putri'])) {
            $query->where('gender', $request->gender);
        }
        $galeri = $query->orderBy('order')->paginate(12);
        
        return view('galeri.index', compact('settings', 'galeri'));
    }
}
