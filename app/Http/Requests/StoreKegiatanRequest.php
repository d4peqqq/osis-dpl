<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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