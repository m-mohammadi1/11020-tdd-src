<?php

namespace App\Services\Http\Internet\Interfaces;

use App\Services\Http\Internet\Types\InternetPackage;
use App\Services\Http\Internet\Types\InternetPackageCollection;

interface KareneInternetInterface
{
    /**
     * @return InternetPackageCollection<InternetPackage>
     */
    public function getPackages(): InternetPackageCollection;
}
