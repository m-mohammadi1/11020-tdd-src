<?php

namespace App\Services\InternetPackage\Functionality;

use App\Models\InternetPackage;
use App\Services\Http\Internet\Interfaces\KaraneBuyInternetInterface;
use App\Services\Http\Internet\Types\Operator;
use App\Services\InternetPackage\Interfaces\GetInternetInterface;


class GetInternet implements GetInternetInterface
{
    public function __construct(
        private KaraneBuyInternetInterface $internetPackageService
    )
    {
    }

    public function syncInternetPackagesInSystem()
    {
        $mciPackages = $this->internetPackageService->getPackages(Operator::MCI);
        $mtnPackages = $this->internetPackageService->getPackages(Operator::MTN);
        $rightelPackages = $this->internetPackageService->getPackages(Operator::RIGHTEL);

        $packages = $mciPackages->merge($mtnPackages)->merge($rightelPackages);

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
                    'operator' => $package->operator
                ]);
        }
    }
}
