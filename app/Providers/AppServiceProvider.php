<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
        // Fix for MySQL "max key length is 767 bytes" error
        Schema::defaultStringLength(191);

        // Set locale from session if available
        $locale = session('locale', 'en');
        if (in_array($locale, ['en', 'kh'])) {
            app()->setLocale($locale);
        }
    }
}
