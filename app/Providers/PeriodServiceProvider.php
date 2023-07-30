<?php

namespace App\Providers;

use App\Services\PeriodService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class PeriodServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(PeriodService::class, function (Application $app) {
            return new PeriodService(config('period'));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
