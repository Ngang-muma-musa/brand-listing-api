<?php

namespace App\Providers;

use App\Contracts\BrandRepositoryInterface;
use App\Contracts\CountryRepositoryInterface;
use App\Repositories\Eloquent\BrandRepository;
use App\Repositories\Eloquent\CountryRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BrandRepositoryInterface::class, BrandRepository::class);
        $this->app->bind(CountryRepositoryInterface::class, CountryRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
