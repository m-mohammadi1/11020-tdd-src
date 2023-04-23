<?php

namespace Tests\Feature\Internet;

use App\Enums\Operator;
use App\Models\InternetPackage;
use App\Models\User;
use App\Services\InternetPackage\Interfaces\BuyInternetInterface;
use App\Services\InternetPackage\Interfaces\GetInternetInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InternetPackageDiscountAppliedTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        resolve(GetInternetInterface::class)
            ->syncInternetPackagesInSystem();
    }


    public function test_internet_package_discount_is_is_applied()
    {
        $discountPercentage = config('discounts.internet_package');

        $packagge = InternetPackage::query()->where('operator', Operator::MCI)->first();

        $userWalletAmount = 12_000 + $packagge->price;
        $user = User::factory()
            ->createOne([
                'wallet_amount' => $userWalletAmount
            ]);

        resolve(BuyInternetInterface::class)
            ->buyPackageForUser($user, Operator::MCI, $packagge);

        $discountedAmount = $packagge->price * ($discountPercentage / 100);

        $user = $user->fresh();
        $this->assertEquals(12_000 + $discountedAmount, $user->wallet_amount);
    }

}
