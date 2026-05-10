<?php

namespace Database\Seeders;

use App\Models\Kegiatan;
use App\Models\Galeri;
use App\Models\StrukturOrganisasi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // Demo kegiatan
        $kegiatan = [
            ['title' => 'Pentas Seni Tahunan', 'date' => '2024-11-15', 'body' => 'Pentas seni tahunan yang menampilkan bakat-bakat terbaik siswa dalam bidang seni dan budaya. Acara ini dihadiri oleh ratusan penonton dari berbagai kalangan.'],
            ['title' => 'Olimpiade Olahraga Sekolah', 'date' => '2024-10-20', 'body' => 'Olimpiade olahraga antar kelas yang penuh semangat dan sportivitas. Berbagai cabang olahraga dipertandingkan mulai dari sepakbola, basket, hingga badminton.'],
            ['title' => 'Seminar Kepemimpinan', 'date' => '2024-09-10', 'body' => 'Seminar kepemimpinan yang menghadirkan narasumber berpengalaman untuk membentuk jiwa kepemimpinan siswa OSIS.'],
        ];

        foreach ($kegiatan as $k) {
            Kegiatan::updateOrCreate(['slug' => Str::slug($k['title'])], [
                'title' => $k['title'],
                'body' => $k['body'],
                'date' => $k['date'],
                'is_published' => true,
            ]);
        }

        // Demo struktur
        $struktur = [
            ['name' => 'Budi Santoso', 'position' => 'Ketua OSIS', 'order' => 1, 'description' => 'Ketua OSIS yang bertanggung jawab memimpin seluruh program dan kegiatan organisasi.'],
            ['name' => 'Sari Dewi', 'position' => 'Wakil Ketua', 'order' => 2, 'description' => 'Wakil Ketua OSIS yang mendampingi ketua dalam menjalankan roda organisasi.'],
            ['name' => 'Ahmad Fauzi', 'position' => 'Sekretaris', 'order' => 3, 'description' => 'Bertanggung jawab atas administrasi dan dokumentasi kegiatan OSIS.'],
            ['name' => 'Rina Marlina', 'position' => 'Bendahara', 'order' => 4, 'description' => 'Mengelola keuangan dan anggaran organisasi secara transparan dan akuntabel.'],
            ['name' => 'Doni Prasetyo', 'position' => 'Ketua Bidang Pendidikan', 'order' => 5, 'description' => 'Memimpin dan mengkoordinasikan program di bidang pendidikan.'],
            ['name' => 'Fitri Handayani', 'position' => 'Anggota Bidang Pendidikan', 'order' => 6, 'description' => 'Membantu pelaksanaan program di bidang pendidikan.'],
            ['name' => 'Hendra Kusuma', 'position' => 'Ketua Bidang Olahraga', 'order' => 7, 'description' => 'Memimpin program dan kegiatan di bidang olahraga.'],
            ['name' => 'Indah Permata', 'position' => 'Ketua Bidang Seni', 'order' => 8, 'description' => 'Mengkoordinasikan kegiatan seni dan budaya di sekolah.'],
        ];

        foreach ($struktur as $s) {
            StrukturOrganisasi::updateOrCreate(['slug' => Str::slug($s['name']) . '-' . Str::random(4)], [
                'name' => $s['name'],
                'position' => $s['position'],
                'description' => $s['description'],
                'order' => $s['order'],
                'is_active' => true,
                'slug' => Str::slug($s['name']),
            ]);
        }
    }
}
