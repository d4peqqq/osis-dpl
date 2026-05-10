<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\StrukturController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KegiatanController as AdminKegiatanController;
use App\Http\Controllers\Admin\GaleriController as AdminGaleriController;
use App\Http\Controllers\Admin\StrukturController as AdminStrukturController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\KartuAnggotaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Frontend Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/kegiatan', [KegiatanController::class, 'index'])->name('kegiatan.index');
Route::get('/kegiatan/{id}', [KegiatanController::class, 'show'])->name('kegiatan.show');
Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri.index');
Route::get('/struktur', [StrukturController::class, 'index'])->name('struktur.index');
Route::get('/anggota/{slug}', [AnggotaController::class, 'show'])->name('anggota.show');
Route::get('/kontak', [KontakController::class, 'index'])->name('kontak.index');

/*
|--------------------------------------------------------------------------
| Admin Auth Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    /*
    |--------------------------------------------------------------------------
    | Protected Admin Routes (require admin middleware)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Kegiatan CRUD
        Route::resource('kegiatan', AdminKegiatanController::class)->names([
            'index'   => 'kegiatan.index',
            'create'  => 'kegiatan.create',
            'store'   => 'kegiatan.store',
            'edit'    => 'kegiatan.edit',
            'update'  => 'kegiatan.update',
            'destroy' => 'kegiatan.destroy',
        ]);

        // Galeri
        Route::get('/galeri', [AdminGaleriController::class, 'index'])->name('galeri.index');
        Route::get('/galeri/create', [AdminGaleriController::class, 'create'])->name('galeri.create');
        Route::post('/galeri', [AdminGaleriController::class, 'store'])->name('galeri.store');
        Route::delete('/galeri/{galeri}', [AdminGaleriController::class, 'destroy'])->name('galeri.destroy');

        // Struktur CRUD
        Route::resource('struktur', AdminStrukturController::class)->names([
            'index'   => 'struktur.index',
            'create'  => 'struktur.create',
            'store'   => 'struktur.store',
            'edit'    => 'struktur.edit',
            'update'  => 'struktur.update',
            'destroy' => 'struktur.destroy',
        ]);

        // Kartu Anggota
        Route::get('/kartu-anggota', [KartuAnggotaController::class, 'index'])->name('kartu-anggota.index');
        Route::get('/kartu-anggota/{id}/preview', [KartuAnggotaController::class, 'preview'])->name('kartu-anggota.preview');
        Route::get('/kartu-anggota/{id}/pdf', [KartuAnggotaController::class, 'pdf'])->name('kartu-anggota.pdf');
        Route::get('/kartu-anggota/{id}/print', [KartuAnggotaController::class, 'print'])->name('kartu-anggota.print');

        // Pengaturan & Users (Strict Admin)
        Route::middleware(['superadmin'])->group(function () {
            // Pengaturan
            Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
            Route::put('/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');
            
            // User Management
            Route::resource('users', UserController::class)->names([
                'index'   => 'users.index',
                'create'  => 'users.create',
                'store'   => 'users.store',
                'edit'    => 'users.edit',
                'update'  => 'users.update',
                'destroy' => 'users.destroy',
            ]);
        });
    });
});
