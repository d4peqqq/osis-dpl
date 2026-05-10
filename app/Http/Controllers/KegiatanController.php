<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Pengaturan;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    public function index(Request $request)
    {
        $settings = Pengaturan::pluck('value', 'key');
        
        $query = Kegiatan::where('is_published', true);
        if ($request->has('gender') && in_array($request->gender, ['putra', 'putri'])) {
            $query->where('gender', $request->gender);
        }
        $kegiatan = $query->orderBy('date', 'desc')->paginate(9);
        
        return view('kegiatan.index', compact('settings', 'kegiatan'));
    }

    public function show($id)
    {
        $settings = Pengaturan::pluck('value', 'key');
        $item = Kegiatan::where('id', $id)->where('is_published', true)->firstOrFail();
        $related = Kegiatan::where('is_published', true)->where('id', '!=', $id)->orderBy('date', 'desc')->take(3)->get();
        return view('kegiatan.show', compact('settings', 'item', 'related'));
    }
}
