<?php

namespace Tests\Unit;

use App\Models\InternetPackage;
use PHPUnit\Framework\TestCase;

class InternetPackageCalculateFinalDiscountedPriceCorrectTest extends TestCase
{
    public function test_internet_package_calculated_correctly()
    {
        /** @var InternetPackage $package */
        $package = InternetPackage::factory()
            ->makeOne([
                "price" => 20_000
            ]);

        $result = $package->getFinalPriceWithDiscount(10);

        $this->assertEquals(18_000, $result);
    }
}
