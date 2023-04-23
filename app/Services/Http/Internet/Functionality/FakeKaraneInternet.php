<?php

namespace App\Services\Http\Internet\Functionality;


use App\Enums\Operator;
use App\Services\Http\Internet\Exceptions\KaraneProviderFailedException;
use App\Services\Http\Internet\Interfaces\KaraneBuyInternetInterface;
use App\Services\Http\Internet\Types\DurationType;
use App\Services\Http\Internet\Types\InternetPackage;
use App\Services\Http\Internet\Types\InternetPackageCollection;
use App\Services\Http\Internet\Types\TrafficType;

class FakeKaraneInternet implements KaraneBuyInternetInterface
{

    public function getPackages(Operator $operator): InternetPackageCollection
    {
        try {
            $jsonFromFile = file_get_contents(__DIR__."/FakeResources/{$operator->value}.json");

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
                    $trafficType,
                    $operator
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
