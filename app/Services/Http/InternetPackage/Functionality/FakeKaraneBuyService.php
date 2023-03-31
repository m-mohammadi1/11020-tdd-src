<?php

namespace App\Services\Http\InternetPackage\Functionality;

use App\Services\Http\InternetPackage\Interfaces\KaraneInternetPackageBuyServiceInterface;
use App\Services\Http\InternetPackage\Types\BuyPackageResponse;

class FakeKaraneBuyService implements KaraneInternetPackageBuyServiceInterface
{
    public function buyPackage(string $phoneNumber, string $code): BuyPackageResponse
    {
        // request to get an orderId
        $orderId = random_int(99_999_999, 999_999_999);

        // request to get response
        $response = [
            'status' => 200,
            'orderId' => $orderId
        ];

        return new BuyPackageResponse($response['status'] === 200, $response['orderId']);
    }

}
