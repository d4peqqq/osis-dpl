<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\ImageUploadServiceInterface;
use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    /**
     * OCP: Daftar key pengaturan teks dipusatkan di konstanta ini.
     * Tambah field baru cukup di sini — tidak perlu ubah logika update().
     */
    private const TEXT_KEYS = [
        'nama_sekolah', 'nama_osis', 'alamat', 'telepon', 'email',
        'visi_putra', 'visi_putri', 'misi_putra', 'misi_putri',
        'kata_sambutan', 'sambutan_ketua', 'nama_ketua', 'jabatan_ketua',
        'instagram', 'facebook', 'twitter', 'tiktok', 'maps_embed',
    ];

    /**
     * DIP: Controller bergantung pada abstraksi (interface),
     * bukan implementasi konkret ImageUploadService.
     */
    public function __construct(
        private ImageUploadServiceInterface $imageUploadService
    ) {}

    public function index()
    {
        $settings = Pengaturan::pluck('value', 'key');
        return view('admin.pengaturan.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
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

        // SRP + DIP: logika upload didelegasikan ke ImageUploadService.
        $logo      = $this->imageUploadService->uploadFromRequest($request, 'logo', 'settings');
        $fotoKetua = $this->imageUploadService->uploadFromRequest($request, 'foto_ketua', 'settings');

        if ($logo) {
            Pengaturan::set('logo', $logo);
        }

        if ($fotoKetua) {
            Pengaturan::set('foto_ketua', $fotoKetua);
        }

        // OCP: menggunakan TEXT_KEYS — satu loop saja, tanpa duplikasi.
        // Tambah field baru cukup tambahkan ke konstanta TEXT_KEYS di atas.
        foreach (self::TEXT_KEYS as $key) {
            Pengaturan::set($key, $request->input($key) ?? '');
        }

        return redirect()->route('admin.pengaturan.index')->with('success', 'Pengaturan berhasil disimpan.');
    }
}
