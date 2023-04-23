<?php

namespace App\Services\Http\Internet\Interfaces;

use App\Enums\Operator;
use App\Services\Http\Internet\Types\BuyPackageResponse;

interface KaraneSyncInternetInterface
{
    public function buyPackage(string $phoneNumber, Operator $operator, string $code): BuyPackageResponse;
}
