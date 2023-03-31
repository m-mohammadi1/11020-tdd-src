<?php

namespace App\Services\Http\InternetPackage\Interfaces;

use App\Services\Http\InternetPackage\Types\BuyPackageResponse;

interface KaraneInternetPackageBuyServiceInterface
{
    public function buyPackage(string $phoneNumber, string $code): BuyPackageResponse;
}
