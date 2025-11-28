<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // ✅ Add this line

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ✅ Fix MySQL index key length issues for utf8mb4
        Schema::defaultStringLength(191);

        // ✅ Enable Bootstrap 5 pagination theme (for GrowCRM UI)
        Paginator::useBootstrapFive();
    }
}
