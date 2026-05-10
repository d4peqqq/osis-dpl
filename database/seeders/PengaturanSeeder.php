<?php

namespace Database\Seeders;

use App\Models\Pengaturan;
use Illuminate\Database\Seeder;

class PengaturanSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'nama_sekolah'  => 'SMA Insan Cendekia Al Kausar',
            'nama_osis'     => 'OSIS SMA Insan Cendekia Al Kausar',
            'alamat'        => '5QR6+WVG, Jl. Habib, Babakanjaya, Kec. Parungkuda, Kabupaten Sukabumi, Jawa Barat 43358',
            'telepon'       => '+62 821-1814-3180',
            'email'         => 'osis@alkausar.sch.id',
            'visi'          => 'Menjadi organisasi siswa yang inovatif, berprestasi, dan berkarakter.',
            'misi'          => "1. Mengembangkan potensi siswa secara optimal.\n2. Menciptakan lingkungan sekolah yang kondusif.\n3. Menjalin kerjasama yang harmonis antar warga sekolah.",
            'kata_sambutan' => 'Selamat datang di website resmi OSIS kami. Kami berkomitmen untuk terus berinovasi dan berkarya demi kemajuan sekolah dan siswa-siswi tercinta.',
            'sambutan_ketua' => 'Assalamualaikum Wr. Wb. Dengan penuh rasa syukur, kami hadir untuk memberikan yang terbaik bagi seluruh warga sekolah. Mari bersatu dan bergerak maju bersama OSIS!',
            'nama_ketua'    => 'Budi Santoso',
            'jabatan_ketua' => 'Ketua OSIS',
            'logo'          => '',
            'foto_ketua'    => '',
            'maps_embed'    => '',
            'instagram'     => 'https://instagram.com/osis_sma',
            'tiktok'        => '',
            'facebook'      => '',
            'twitter'       => '',
        ];

        foreach ($defaults as $key => $value) {
            Pengaturan::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
