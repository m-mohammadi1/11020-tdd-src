<?php

namespace App\Services\Http\InternetPackage\Functionality;


use App\Services\Http\InternetPackage\Exceptions\KaraneProviderFailedException;
use App\Services\Http\InternetPackage\Interfaces\KareneInternetPackageServiceInterface;
use App\Services\Http\InternetPackage\Types\InternetPackage;
use App\Services\Http\InternetPackage\Types\InternetPackageCollection;

class FakeKaraneInternetPackageService implements KareneInternetPackageServiceInterface
{

    public function getPackages(): InternetPackageCollection
    {
        try {
            $jsonFromFile = file_get_contents(__DIR__.'/FakeResources/packages.json');

            $packages = json_decode($jsonFromFile, true)['data'];

            $items = [];
            foreach ($packages as $package) {
                if (!isset($package['traffic'])) {
                    continue;
                }

                $item = new InternetPackage(
                    $package['type'],
                    $package['description'],
                    $package['cost'],
                    $package['duration']['category']['value'],
                    $package['traffic']['category']['value'],
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
