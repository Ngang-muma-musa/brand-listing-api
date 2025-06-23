<?php

namespace App\Providers;

use App\Contracts\BrandRepositoryInterface;
use App\Contracts\BrandServiceInterface;
use App\Contracts\CountryRepositoryInterface;
use App\Contracts\CountryServiceInterface;
use App\Contracts\UserServiceInterface; 
use App\Contracts\UserRepositoryInterface;
use App\Repositories\Eloquent\BrandRepository;
use App\Repositories\Eloquent\CountryRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Services\BrandService;
use App\Services\CountryService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Repository Bindings
        $this->app->bind(BrandRepositoryInterface::class, BrandRepository::class);
        $this->app->bind(CountryRepositoryInterface::class, CountryRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class); 

        // Service Bindings
        $this->app->bind(BrandServiceInterface::class, BrandService::class);
        $this->app->bind(CountryServiceInterface::class, CountryService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
