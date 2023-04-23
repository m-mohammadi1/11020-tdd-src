<?php

namespace App\Services\Http\Internet\Interfaces;

use App\Services\Http\Internet\Types\InternetPackage;
use App\Services\Http\Internet\Types\InternetPackageCollection;

interface KaraneBuyInternetInterface
{
    /**
     * @return InternetPackageCollection<InternetPackage>
     */
    public function getPackages(): InternetPackageCollection;
}
