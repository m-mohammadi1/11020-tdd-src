<?php

namespace App\Services\Http\InternetPackage\Types;

use App\Services\Http\InternetPackage\Exceptions\InvalidPackageTypeException;
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
