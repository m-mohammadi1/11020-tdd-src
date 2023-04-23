<?php

namespace App\Services\Http\Internet\Types;

use App\Services\Http\Internet\Exceptions\InvalidPackageTypeException;
use Illuminate\Support\Collection;

class InternetPackageCollection extends Collection
{
    public function __construct(array $items)
    {
        foreach ($items as $item) {
            if (!($item instanceof InternetPackage)) {
                InvalidPackageTypeException::throwBecauseInvalidType();
            }
        }

        parent::__construct($items);
    }
}
