<?php

namespace App\Services\InternetPackage\Functionality;

use App\Models\InternetPackage;
use App\Models\User;
use App\Services\Http\InternetPackage\Interfaces\KareneInternetPackageServiceInterface;
use App\Services\InternetPackage\Interfaces\InternetPackageServiceInterface;
use App\Services\InternetPackage\Types\InternetPackageBuyResponse;

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
                    'duration_type' => $package->durationType->getTypeEnum(),
                    'traffic' => $package->traffic
                ]);
        }
    }
}
