<?php

namespace App\Providers;

use App\Models\Service;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        // Automatically force HTTPS when served through ngrok or HTTPS reverse proxies
        if ((isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') || 
            (isset($_SERVER['HTTP_HOST']) && str_contains($_SERVER['HTTP_HOST'], 'ngrok'))) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Share active hierarchical services and site settings with public views
        View::composer(['layouts.app', 'partials.header', 'partials.footer'], function ($view) {
            if (Schema::hasTable('services')) {
                $navServices = Service::parents()
                    ->active()
                    ->ordered()
                    ->with(['children' => function ($q) {
                        $q->active()->ordered();
                    }])
                    ->get();
                $view->with('navServices', $navServices);
            }
        });
    }
}
