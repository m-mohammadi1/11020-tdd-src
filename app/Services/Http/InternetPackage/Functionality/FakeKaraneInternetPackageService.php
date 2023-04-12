<?php

namespace App\Services\Http\InternetPackage\Functionality;


use App\Services\Http\InternetPackage\Exceptions\KaraneProviderFailedException;
use App\Services\Http\InternetPackage\Interfaces\KareneInternetPackageServiceInterface;
use App\Services\Http\InternetPackage\Types\DurationType;
use App\Services\Http\InternetPackage\Types\InternetPackage;
use App\Services\Http\InternetPackage\Types\InternetPackageCollection;
use App\Services\Http\InternetPackage\Types\TrafficType;

class FakeKaraneInternetPackageService implements KareneInternetPackageServiceInterface
{

    public function getPackages(): InternetPackageCollection
    {
        try {
            $jsonFromFile = file_get_contents(__DIR__.'/FakeResources/packages.json');

            $packages = json_decode($jsonFromFile, true)['data'];

            $items = [];
            foreach ($packages as $package) {
                // filter anarestan packages
                if ($package['type'] === "0") {
                    continue;
                }

                if (!isset($package['traffic']) || !isset($package['duration'])) {
                    continue;
                }

                $durationType = $package['duration']['category']['sub_type'];
                if (!DurationType::acceptsDurationType($durationType)) {
                    continue;
                }
                $durationType = new DurationType($durationType);

                $trafficType = $package['traffic']['category']['sub_type'];
                if (!TrafficType::acceptsDurationType($trafficType)) {
                    continue;
                }
                $trafficType = new TrafficType($trafficType);

                $item = new InternetPackage(
                    $package['type'],
                    $package['description'],
                    $package['cost'],
                    $package['duration']['category']['value'],
                    $durationType,
                    $package['traffic']['category']['value'],
                    $trafficType
                );

                $items[] = $item;
            }

            $finalCollection = new InternetPackageCollection($items);
        } catch (\Exception $exception) {
            KaraneProviderFailedException::throwBecauseGettingPackagesFailed();
        }

        return $finalCollection;
    }
}
