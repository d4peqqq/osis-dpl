<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * StoreKegiatanRequest
 *
 * ✅ SOLID - Single Responsibility Principle (SRP):
 * Class ini HANYA bertanggung jawab pada VALIDASI data
 * ketika membuat kegiatan baru.
 *
 * Sebelumnya, validasi hardcoded di dalam method store()
 * controller, bercampur dengan logic upload dan slug.
 * Sekarang dipisah ke file dedicated ini.
 *
 * Dampak nyata:
 * - Controller jadi lebih bersih dan pendek
 * - Validasi bisa di-test secara terpisah
 * - Mudah ditemukan jika ingin mengubah aturan validasi
 */
class StoreKegiatanRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Hanya admin yang boleh (sudah dijaga middleware di routes)
        return true;
    }

    public function rules(): array
    {
        return [
            'title'        => 'required|string|max:255',
            'body'         => 'required|string',
            'date'         => 'required|date',
            'gender'       => 'required|in:putra,putri',
            'photo'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'is_published' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul kegiatan wajib diisi.',
            'body.required'  => 'Isi kegiatan wajib diisi.',
            'date.required'  => 'Tanggal kegiatan wajib diisi.',
            'gender.required'=> 'Jenis kelompok wajib dipilih.',
            'gender.in'      => 'Jenis kelompok harus putra atau putri.',
            'photo.image'    => 'File harus berupa gambar.',
            'photo.max'      => 'Ukuran foto maksimal 10MB.',
        ];
    }
}