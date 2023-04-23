<?php

namespace App\Services\Http\Internet\Interfaces;

use App\Services\Http\Internet\Types\BuyPackageResponse;
use App\Services\Http\Internet\Types\Operator;

interface KaraneSyncInternetInterface
{
    public function buyPackage(string $phoneNumber, Operator $operator, string $code): BuyPackageResponse;
}
