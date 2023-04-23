<?php

namespace App\Services\Http\Internet\Functionality;

use App\Services\Http\Internet\Interfaces\KaraneInternetInterface;
use App\Services\Http\Internet\Types\BuyPackageResponse;

class FakeKaraneBuyService implements KaraneInternetInterface
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
