<?php

namespace App\Providers;

use App\Exceptions\ApiException;
use App\Services\Auth0\JWTService;
use App\Services\Auth0\JWTServiceInterface;
use App\Services\Countries\CountryService;
use App\Services\Countries\MockCountryService;
use App\Services\Countries\RestCountriesCountryService;
use Http\Adapter\Guzzle7\Client;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     * @throws ApiException
     */
    public function register()
    {
        $this->app->bind(JWTServiceInterface::class, JWTService::class);
        $this->app->singleton('httpClient', function () {
            return Client::createWithConfig([]);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(CountryService::class, RestCountriesCountryService::class);
    }
}
