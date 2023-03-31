<?php

namespace App\Services\InternetPackage;

use App\Models\InternetPackage;
use App\Services\Http\InternetPackage\Interfaces\KareneInternetPackageServiceInterface;

class InternetPackageService implements InternetPackageServiceInterface
{
    public function __construct(
        private KareneInternetPackageServiceInterface $internetPackageService
    )
    {
    }

    public function syncInternetPackagesInSystem()
    {
        $packages = $this->internetPackageService->getPackages();

        /** @var \App\Services\Http\InternetPackage\Types\InternetPackage $package */
        foreach ($packages as $package) {
            InternetPackage::query()
                ->create([
                    'title' => $package->title,
                    'code' => $package->apiIdentifier,
                    'price' => $package->price,
                    'duration' => $package->duration,
                    'traffic' => $package->traffic
                ]);
        }
    }
}
