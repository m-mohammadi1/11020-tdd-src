<?php

namespace App\Services\Http\Internet\Interfaces;

use App\Services\Http\Internet\Types\InternetPackage;
use App\Services\Http\Internet\Types\InternetPackageCollection;
use App\Services\Http\Internet\Types\Operator;

interface KaraneBuyInternetInterface
{
    /**
     * @return InternetPackageCollection<InternetPackage>
     */
    public function getPackages(Operator $operator): InternetPackageCollection;
}
