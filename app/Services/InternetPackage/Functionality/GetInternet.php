<?php

namespace App\Services\InternetPackage\Functionality;

use App\Models\InternetPackage;
use App\Services\Http\Internet\Interfaces\KareneInternetInterface;
use App\Services\InternetPackage\Interfaces\GetInternetInterface;


class GetInternet implements GetInternetInterface
{
    public function __construct(
        private KareneInternetInterface $internetPackageService
    )
    {
    }

    public function syncInternetPackagesInSystem()
    {
        $packages = $this->internetPackageService->getPackages();

        /** @var \App\Services\Http\Internet\Types\InternetPackage $package */
        foreach ($packages as $package) {
            InternetPackage::query()
                ->create([
                    'title' => $package->title,
                    'code' => $package->apiIdentifier,
                    'price' => $package->price,
                    'duration' => $package->duration,
                    'duration_type' => $package->durationType->getTypeEnum(),
                    'traffic' => $package->traffic,
                    'traffic_type' => $package->trafficType->getTypeEnum(),
                ]);
        }
    }
}
