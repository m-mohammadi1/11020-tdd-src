<?php

namespace App\Services\InternetPackage\SubServices\Discount;

class DiscountService implements DiscountServiceInterface
{
    public function getInternetPackageDiscount(): int
    {
        return config('discounts.internet_package', 0);
    }
}
