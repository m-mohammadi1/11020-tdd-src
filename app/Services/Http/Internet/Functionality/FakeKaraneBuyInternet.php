<?php

namespace App\Services\Http\Internet\Functionality;

use App\Enums\Operator;
use App\Services\Http\Internet\Interfaces\KaraneSyncInternetInterface;
use App\Services\Http\Internet\Types\BuyPackageResponse;

class FakeKaraneBuyInternet implements KaraneSyncInternetInterface
{
    public function buyPackage(string $phoneNumber, Operator $operator, string $code): BuyPackageResponse
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
