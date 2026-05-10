<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\ImageUploadServiceInterface;
use App\Http\Controllers\Controller;
use App\Models\StrukturOrganisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StrukturController extends Controller
{
    /**
     * DIP: Controller bergantung pada abstraksi (interface),
     * bukan implementasi konkret ImageUploadService.
     */
    public function __construct(
        private ImageUploadServiceInterface $imageUploadService
    ) {}

    public function index()
    {
        $struktur = StrukturOrganisasi::orderBy('order')->paginate(10);
        return view('admin.struktur.index', compact('struktur'));
    }

    public function create()
    {
        return view('admin.struktur.create');
    }

    /**
     * SRP: Logika generasi slug dipindahkan ke method private ini.
     * Controller tidak bertanggung jawab atas detail algoritma slug.
     */
    private function generateSlug(string $name, int $excludeId = 0): string
    {
        $slug         = Str::slug($name);
        $originalSlug = $slug;
        $count        = 1;

        while (StrukturOrganisasi::where('slug', $slug)->where('id', '!=', $excludeId)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
    }

    /**
     * SRP + DIP: Logika upload gambar (termasuk base64 crop) didelegasikan
     * sepenuhnya ke ImageUploadService. Controller hanya menentukan folder tujuan.
     */
    private function handlePhotoUpload(Request $request): ?string
    {
        if ($request->filled('cropped_photo')) {
            return $this->imageUploadService->uploadFromBase64($request->cropped_photo, 'struktur');
        }

        return $this->imageUploadService->uploadFromRequest($request, 'photo', 'struktur');
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

        $photoPath = $this->handlePhotoUpload($request);
        if ($photoPath) {
            $validated['photo'] = $photoPath;
        }

        $validated['slug']      = $this->generateSlug($validated['name']);
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

        // SRP: logika upload terpusat di handlePhotoUpload() — tidak duplikat.
        $photoPath = $this->handlePhotoUpload($request);
        if ($photoPath) {
            $validated['photo'] = $photoPath;
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
