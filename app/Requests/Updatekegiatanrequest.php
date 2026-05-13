<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * UpdateKegiatanRequest
 *
 * ✅ SOLID - Single Responsibility Principle (SRP):
 * Hanya menangani validasi untuk UPDATE kegiatan.
 *
 * ✅ SOLID - Open-Closed Principle (OCP):
 * Sebelumnya, rules store() dan update() ditulis DUPLIKAT
 * di dalam satu controller. Jika ada perubahan validasi,
 * harus edit 2 tempat sekaligus — rawan lupa.
 *
 * Sekarang masing-masing punya file sendiri.
 * Jika update punya aturan berbeda (misal photo tidak wajib
 * saat update tapi wajib saat store), tinggal bedakan di sini
 * tanpa menyentuh StoreKegiatanRequest.
 */
class UpdateKegiatanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'        => 'required|string|max:255',
            'body'         => 'required|string',
            'date'         => 'required|date',
            'gender'       => 'required|in:putra,putri',
            // Saat update, foto boleh tidak diisi (pakai foto lama)
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