<?php

namespace App\Providers;

use App\Services\DynamicPricingService;
use Illuminate\Support\ServiceProvider;

class DynamicPricingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(DynamicPricingService::class, function ($app) {
            return new DynamicPricingService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
