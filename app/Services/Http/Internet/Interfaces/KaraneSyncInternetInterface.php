<?php

namespace App\Services\Http\Internet\Interfaces;

use App\Services\Http\Internet\Types\BuyPackageResponse;

interface KaraneSyncInternetInterface
{
    public function buyPackage(string $phoneNumber, string $code): BuyPackageResponse;
}
