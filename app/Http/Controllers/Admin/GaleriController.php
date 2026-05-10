<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use App\Models\Kegiatan;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    public function index()
    {
        $galeri = Galeri::with('kegiatan')->orderBy('order')->paginate(12);
        return view('admin.galeri.index', compact('galeri'));
    }

    public function create()
    {
        $kegiatan = Kegiatan::orderBy('date', 'desc')->get();
        return view('admin.galeri.create', compact('kegiatan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'photo'       => 'required|image|mimes:jpg,jpeg,png,webp|max:10240',
            'kegiatan_id' => 'nullable|exists:kegiatan,id',
            'order'       => 'nullable|integer',
            'gender'      => 'required|in:putra,putri',
        ]);

        $validated['photo'] = $request->file('photo')->store('galeri', 'public');
        Galeri::create($validated);

        return redirect()->route('admin.galeri.index')->with('success', 'Foto berhasil ditambahkan.');
    }

    public function destroy(Galeri $galeri)
    {
        $galeri->delete();
        return redirect()->route('admin.galeri.index')->with('success', 'Foto berhasil dihapus.');
    }
}
