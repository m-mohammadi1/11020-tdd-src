<?php

namespace App\Services\Http\Internet\Types;

class BuyPackageResponse
{
    public function __construct(
        public readonly bool $wasSuccessful,
        public readonly string $orderId
    )
    {
    }

}
