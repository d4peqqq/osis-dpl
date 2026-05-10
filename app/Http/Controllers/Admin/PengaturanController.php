<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function index()
    {
        $settings = Pengaturan::pluck('value', 'key');
        return view('admin.pengaturan.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'nama_sekolah'   => 'required|string|max:255',
            'nama_osis'      => 'required|string|max:255',
            'alamat'         => 'nullable|string',
            'telepon'        => 'nullable|string|max:50',
            'email'          => 'nullable|email|max:255',
            'visi_putra'     => 'nullable|string',
            'visi_putri'     => 'nullable|string',
            'misi_putra'     => 'nullable|string',
            'misi_putri'     => 'nullable|string',
            'kata_sambutan'  => 'nullable|string',
            'sambutan_ketua' => 'nullable|string',
            'nama_ketua'     => 'nullable|string|max:255',
            'jabatan_ketua'  => 'nullable|string|max:255',
            'instagram'      => 'nullable|string|max:255',
            'facebook'       => 'nullable|string|max:255',
            'twitter'        => 'nullable|string|max:255',
            'tiktok'         => 'nullable|string|max:255',
            'maps_embed'     => 'nullable|string',
            'logo'           => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:10240',
            'foto_ketua'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('settings', 'public');
        }

        if ($request->hasFile('foto_ketua')) {
            $validated['foto_ketua'] = $request->file('foto_ketua')->store('settings', 'public');
        }

        foreach ($validated as $key => $value) {
            if (!in_array($key, ['logo', 'foto_ketua']) || $request->hasFile($key)) {
                Pengaturan::set($key, $value ?? '');
            }
        }

        // Save text fields even if not changed
        $keys = ['nama_sekolah','nama_osis','alamat','telepon','email','visi_putra','visi_putri','misi_putra','misi_putri','kata_sambutan','sambutan_ketua','nama_ketua','jabatan_ketua','instagram','facebook','twitter','tiktok','maps_embed'];
        foreach ($keys as $key) {
            Pengaturan::set($key, $request->input($key) ?? '');
        }

        return redirect()->route('admin.pengaturan.index')->with('success', 'Pengaturan berhasil disimpan.');
    }
}
