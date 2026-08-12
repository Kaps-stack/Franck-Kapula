<?php

namespace App\Providers;

use App\Models\Interest;
use App\Models\Language;
use App\Models\Profile;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

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
        /*
        |--------------------------------------------------------------------------
        | Force HTTPS in production
        |--------------------------------------------------------------------------
        */

        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        /*
        |--------------------------------------------------------------------------
        | Global Inertia data
        |--------------------------------------------------------------------------
        |
        | Ces données sont automatiquement disponibles sur toutes
        | les pages Inertia, sans devoir les envoyer depuis chaque
        | controller.
        |
        */

        Inertia::share([
            'profile' => fn () => Profile::first(),

            'interests' => fn () => Interest::all(),

            'languages' => fn () => Language::all(),
        ]);
    }
}
