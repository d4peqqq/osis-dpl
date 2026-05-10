<?php

namespace App\Providers;

use App\Contracts\ImageUploadServiceInterface;
use App\Contracts\QrCodeServiceInterface;
use App\Services\ImageUploadService;
use App\Services\QrCodeService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Daftarkan binding interface ke implementasi konkret.
     * Memenuhi prinsip DIP — high-level modules (controllers) bergantung
     * pada abstraksi (interface), bukan implementasi langsung.
     */
    public function register(): void
    {
        $this->app->bind(ImageUploadServiceInterface::class, ImageUploadService::class);
        $this->app->bind(QrCodeServiceInterface::class, QrCodeService::class);
    }

    public function boot(): void
    {
        // Use Bootstrap-like minimal pagination (we render inline above)
        Paginator::defaultView('pagination::default');

        // Make Str available in Blade templates
        Blade::directive('str', function ($expression) {
            return "<?php use Illuminate\\Support\\Str; ?>";
        });
    }
}
