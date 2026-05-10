<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
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
