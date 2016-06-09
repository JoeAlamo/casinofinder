<?php

namespace CasinoFinder\Providers;

use CasinoFinder\Services\CasinoService;
use CasinoFinder\Services\CasinoServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(CasinoServiceInterface::class, CasinoService::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
