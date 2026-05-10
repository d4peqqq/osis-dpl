<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StrukturOrganisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StrukturController extends Controller
{
    public function index()
    {
        $struktur = StrukturOrganisasi::orderBy('order')->paginate(10);
        return view('admin.struktur.index', compact('struktur'));
    }

    public function create()
    {
        return view('admin.struktur.create');
    }

    private function generateSlug($name, $id = 0)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;
        while (StrukturOrganisasi::where('slug', $slug)->where('id', '!=', $id)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }
        return $slug;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'position'    => 'required|string|max:255',
            'gender'      => 'required|in:putra,putri',
            'photo'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'description' => 'nullable|string',
            'order'       => 'nullable|integer',
            'is_active'   => 'nullable',
        ]);

        if ($request->filled('cropped_photo')) {
            $image_parts = explode(";base64,", $request->cropped_photo);
            if (count($image_parts) >= 2) {
                $image_base64 = base64_decode($image_parts[1]);
                $file_name = 'struktur/' . uniqid() . '.png';
                Storage::disk('public')->put($file_name, $image_base64);
                $validated['photo'] = $file_name;
            }
        } elseif ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('struktur', 'public');
        }

        $validated['slug'] = $this->generateSlug($validated['name']);
        $validated['is_active'] = (bool) $request->input('is_active', 1);

        StrukturOrganisasi::create($validated);

        return redirect()->route('admin.struktur.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function edit(StrukturOrganisasi $struktur)
    {
        return view('admin.struktur.edit', compact('struktur'));
    }

    public function update(Request $request, StrukturOrganisasi $struktur)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'position'    => 'required|string|max:255',
            'gender'      => 'required|in:putra,putri',
            'photo'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'description' => 'nullable|string',
            'order'       => 'nullable|integer',
            'is_active'   => 'nullable',
        ]);

        if ($request->filled('cropped_photo')) {
            $image_parts = explode(";base64,", $request->cropped_photo);
            if (count($image_parts) >= 2) {
                $image_base64 = base64_decode($image_parts[1]);
                $file_name = 'struktur/' . uniqid() . '.png';
                Storage::disk('public')->put($file_name, $image_base64);
                $validated['photo'] = $file_name;
            }
        } elseif ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('struktur', 'public');
        } else {
            unset($validated['photo']);
        }

        if ($request->name !== $struktur->name) {
            $validated['slug'] = $this->generateSlug($validated['name'], $struktur->id);
        }

        $validated['is_active'] = (bool) $request->input('is_active', $struktur->is_active);
        $struktur->update($validated);

        return redirect()->route('admin.struktur.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(StrukturOrganisasi $struktur)
    {
        $struktur->delete();
        return redirect()->route('admin.struktur.index')->with('success', 'Anggota berhasil dihapus.');
    }
}
