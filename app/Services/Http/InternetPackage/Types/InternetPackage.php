<?php

namespace App\Services\Http\InternetPackage\Types;

class InternetPackage
{
    public function __construct(
        public readonly int $apiIdentifier,
        public readonly string $title,
        public readonly float $price,
        public readonly int $duration,
        public readonly int $traffic,
    )
    {

    }

}
