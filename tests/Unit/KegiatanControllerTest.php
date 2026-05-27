<?php

namespace Tests\Feature\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Kegiatan;
use App\Services\KegiatanService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class KegiatanControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        // SETUP — persiapan sebelum setiap test dijalankan
        parent::setUp();

        // SETUP — buat user admin palsu
        $this->admin = User::factory()->create(['role' => 'admin']);
    }

    public function test_destroy_memanggil_service_delete()
    {
        // SETUP — buat mock KegiatanService
        $mock = $this->createMock(KegiatanService::class);

        // SETUP — ekspektasi: method delete() harus dipanggil tepat 1 kali
        $mock->expects($this->once())
             ->method('delete');

        // SETUP — daftarkan mock ke Laravel container
        $this->app->instance(KegiatanService::class, $mock);

        // SETUP — buat data kegiatan palsu
        $kegiatan = Kegiatan::factory()->create();

        // EXERCISE — kirim HTTP DELETE request sebagai admin
        $response = $this->actingAs($this->admin)
                         ->delete(route('admin.kegiatan.destroy', $kegiatan));

        // VERIFY — pastikan redirect ke halaman index setelah hapus
        $response->assertRedirect(route('admin.kegiatan.index'));

        // TEARDOWN — otomatis oleh RefreshDatabase
    }

    public function test_store_memanggil_service_create()
    {
        // SETUP — buat mock KegiatanService
        $mock = $this->createMock(KegiatanService::class);

        // SETUP — ekspektasi: method create() harus dipanggil tepat 1 kali
        $mock->expects($this->once())
             ->method('create');

        // SETUP — daftarkan mock ke Laravel container
        $this->app->instance(KegiatanService::class, $mock);

        // SETUP — data palsu untuk dikirim ke form (Constructor)
        $data = [
            'title'        => 'Kegiatan OSIS 2025',
            'body'         => 'Deskripsi kegiatan.',
            'date'         => '2025-06-15',
            'gender'       => 'putra',
            'is_published' => true,
        ];

        // EXERCISE — kirim HTTP POST request sebagai admin
        $response = $this->actingAs($this->admin)
                         ->post(route('admin.kegiatan.store'), $data);

        // VERIFY — pastikan redirect ke halaman index setelah store
        $response->assertRedirect(route('admin.kegiatan.index'));

        // TEARDOWN — otomatis oleh RefreshDatabase
    }

    public function test_update_memanggil_service_update()
    {
        // SETUP — buat mock KegiatanService
        $mock = $this->createMock(KegiatanService::class);

        // SETUP — ekspektasi: method update() harus dipanggil tepat 1 kali
        $mock->expects($this->once())
             ->method('update');

        // SETUP — daftarkan mock ke Laravel container
        $this->app->instance(KegiatanService::class, $mock);

        // SETUP — buat data kegiatan palsu (Getters)
        $kegiatan = Kegiatan::factory()->create();

        // SETUP — data baru untuk update (Comparisons)
        $data = [
            'title'        => 'Judul Kegiatan Diupdate',
            'body'         => 'Isi kegiatan yang sudah diubah.',
            'date'         => '2025-08-20',
            'gender'       => 'putri',
            'is_published' => true,
        ];

        // EXERCISE — kirim HTTP PUT request sebagai admin
        $response = $this->actingAs($this->admin)
                         ->put(route('admin.kegiatan.update', $kegiatan), $data);

        // VERIFY — pastikan redirect ke halaman index setelah update
        $response->assertRedirect(route('admin.kegiatan.index'));

        // TEARDOWN — otomatis oleh RefreshDatabase
    }
}