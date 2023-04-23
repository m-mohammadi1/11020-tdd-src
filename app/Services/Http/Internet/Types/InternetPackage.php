<?php

namespace App\Services\Http\Internet\Types;

class InternetPackage
{
    public function __construct(
        public readonly int $apiIdentifier,
        public readonly string $title,
        public readonly float $price,
        public readonly int $duration,
        public readonly DurationType $durationType,
        public readonly int $traffic,
        public readonly TrafficType $trafficType,
    )
    {

    }

}
