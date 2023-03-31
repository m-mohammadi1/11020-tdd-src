<?php

namespace App\Providers;

use App\Services\Http\InternetPackage\Functionality\FakeKaraneBuyService;
use App\Services\Http\InternetPackage\Functionality\FakeKaraneInternetPackageService;
use App\Services\Http\InternetPackage\Interfaces\KaraneInternetPackageBuyServiceInterface;
use App\Services\Http\InternetPackage\Interfaces\KareneInternetPackageServiceInterface;
use App\Services\InternetPackage\Functionality\BuyInternetPackageService;
use App\Services\InternetPackage\Functionality\InternetPackageService;
use App\Services\InternetPackage\Interfaces\BuyInternetPackageServiceInterface;
use App\Services\InternetPackage\Interfaces\InternetPackageServiceInterface;
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
        $this->app->bind(KaraneInternetPackageBuyServiceInterface::class, FakeKaraneBuyService::class);
        $this->app->bind(BuyInternetPackageServiceInterface::class, BuyInternetPackageService::class);
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
