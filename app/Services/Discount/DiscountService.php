<?php

namespace App\Services\Discount;

class DiscountService implements DiscountServiceInterface
{
    public function getInternetPackageDiscount(): int
    {
        return config('discounts.internet_package', 0);
    }
}
