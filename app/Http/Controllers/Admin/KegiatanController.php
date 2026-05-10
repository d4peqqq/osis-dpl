<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\ImageUploadServiceInterface;
use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KegiatanController extends Controller
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
        $kegiatan = Kegiatan::orderBy('date', 'desc')->paginate(10);
        return view('admin.kegiatan.index', compact('kegiatan'));
    }

    public function create()
    {
        return view('admin.kegiatan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'body'         => 'required|string',
            'date'         => 'required|date',
            'gender'       => 'required|in:putra,putri',
            'photo'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'is_published' => 'nullable',
        ]);

        // SRP + DIP: logika upload foto didelegasikan ke ImageUploadService,
        // bukan ditulis inline di controller.
        $photoPath = $this->imageUploadService->uploadFromRequest($request, 'photo', 'kegiatan');
        if ($photoPath) {
            $validated['photo'] = $photoPath;
        }

        $validated['slug']         = Str::slug($validated['title']) . '-' . Str::random(5);
        $validated['is_published'] = $request->has('is_published');

        Kegiatan::create($validated);

        return redirect()->route('admin.kegiatan.index')->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    public function edit(Kegiatan $kegiatan)
    {
        return view('admin.kegiatan.edit', compact('kegiatan'));
    }

    public function update(Request $request, Kegiatan $kegiatan)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'body'         => 'required|string',
            'date'         => 'required|date',
            'gender'       => 'required|in:putra,putri',
            'photo'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'is_published' => 'nullable',
        ]);

        // SRP + DIP: menggunakan service yang sama seperti store() —
        // tidak ada duplikasi logika upload.
        $photoPath = $this->imageUploadService->uploadFromRequest($request, 'photo', 'kegiatan');
        if ($photoPath) {
            $validated['photo'] = $photoPath;
        } else {
            unset($validated['photo']);
        }

        $validated['is_published'] = $request->has('is_published');
        $kegiatan->update($validated);

        return redirect()->route('admin.kegiatan.index')->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy(Kegiatan $kegiatan)
    {
        $kegiatan->delete();
        return redirect()->route('admin.kegiatan.index')->with('success', 'Kegiatan berhasil dihapus.');
    }
}
