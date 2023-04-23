<?php

namespace App\Services\Http\Internet\Interfaces;

use App\Services\Http\Internet\Types\BuyPackageResponse;

interface KaraneInternetInterface
{
    public function buyPackage(string $phoneNumber, string $code): BuyPackageResponse;
}
