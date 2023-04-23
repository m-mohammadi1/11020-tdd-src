<?php

namespace App\Providers;

use App\Services\Http\Internet\Interfaces\KaraneInternetInterface;
use App\Services\Http\Internet\Interfaces\KareneInternetInterface;
use App\Services\Http\Internet\Functionality\FakeKaraneBuyService;
use App\Services\Http\Internet\Functionality\FakeKaraneInternet;
use App\Services\InternetPackage\Functionality\BuyInternet;
use App\Services\InternetPackage\Functionality\GetInternet;
use App\Services\InternetPackage\Interfaces\BuyInternetInterface;
use App\Services\InternetPackage\Interfaces\GetInternetInterface;
use App\Services\InternetPackage\SubServices\Discount\DiscountService;
use App\Services\InternetPackage\SubServices\Discount\DiscountServiceInterface;
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
        // http layer
        $this->app->bind(KaraneInternetInterface::class, FakeKaraneBuyService::class);
        $this->app->bind(KareneInternetInterface::class, FakeKaraneInternet::class);


        // core domain
        $this->app->bind(BuyInternetInterface::class, BuyInternet::class);
        $this->app->bind(GetInternetInterface::class, GetInternet::class);
        $this->app->bind(DiscountServiceInterface::class, DiscountService::class);
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
