<?php

namespace App\Providers;

use App\Services\Http\InternetPackage\Functionality\FakeKaraneInternetPackageService;
use App\Services\Http\InternetPackage\Functionality\KaraneInternetPackageServiceProvider;
use App\Services\Http\InternetPackage\Interfaces\KareneInternetPackageServiceInterface;
use App\Services\InternetPackage\InternetPackageService;
use App\Services\InternetPackage\InternetPackageServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(InternetPackageServiceInterface::class, InternetPackageService::class);
        $this->app->bind(KareneInternetPackageServiceInterface::class, FakeKaraneInternetPackageService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
