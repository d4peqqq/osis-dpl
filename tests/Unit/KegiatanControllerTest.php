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
        // SETUP 
        parent::setUp();

        // SETUP 
        $this->admin = User::factory()->create(['role' => 'admin']);
    }

    public function test_destroy_memanggil_service_delete()
    {
        // SETUP 
        $mock = $this->createMock(KegiatanService::class);

        // SETUP 
        $mock->expects($this->once())
             ->method('delete');

        // SETUP 
        $this->app->instance(KegiatanService::class, $mock);

        // SETUP 
        $kegiatan = Kegiatan::factory()->create();

        // EXERCISE 
        $response = $this->actingAs($this->admin)
                         ->delete(route('admin.kegiatan.destroy', $kegiatan));

        // VERIFY 
        $response->assertRedirect(route('admin.kegiatan.index'));

        // TEARDOWN 
    }

    public function test_store_memanggil_service_create()
    {
        // SETUP 
        $mock = $this->createMock(KegiatanService::class);

        // SETUP 
        $mock->expects($this->once())
             ->method('create');

        // SETUP 
        $this->app->instance(KegiatanService::class, $mock);

        // SETUP 
        $data = [
            'title'        => 'Kegiatan OSIS 2025',
            'body'         => 'Deskripsi kegiatan.',
            'date'         => '2025-06-15',
            'gender'       => 'putra',
            'is_published' => true,
        ];

        // EXERCISE 
        $response = $this->actingAs($this->admin)
                         ->post(route('admin.kegiatan.store'), $data);

        // VERIFY 
        $response->assertRedirect(route('admin.kegiatan.index'));

        // TEARDOWN 
    }

    public function test_update_memanggil_service_update()
    {
        // SETUP 
        $mock = $this->createMock(KegiatanService::class);

        // SETUP 
        $mock->expects($this->once())
             ->method('update');

        // SETUP 
        $this->app->instance(KegiatanService::class, $mock);

        // SETUP 
        $kegiatan = Kegiatan::factory()->create();

        // SETUP 
        $data = [
            'title'        => 'Judul Kegiatan Diupdate',
            'body'         => 'Isi kegiatan yang sudah diubah.',
            'date'         => '2025-08-20',
            'gender'       => 'putri',
            'is_published' => true,
        ];

        // EXERCISE 
        $response = $this->actingAs($this->admin)
                         ->put(route('admin.kegiatan.update', $kegiatan), $data);

        // VERIFY 
        $response->assertRedirect(route('admin.kegiatan.index'));

        // TEARDOWN
    }
}
