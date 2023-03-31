<?php

namespace App\Services\Http\InternetPackage\Interfaces;

use App\Services\Http\InternetPackage\Types\InternetPackage;
use App\Services\Http\InternetPackage\Types\InternetPackageCollection;

interface KareneInternetPackageServiceInterface
{
    /**
     * @return InternetPackageCollection<InternetPackage>
     */
    public function getPackages(): InternetPackageCollection;
}
