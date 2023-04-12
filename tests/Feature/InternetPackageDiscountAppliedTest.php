<?php

namespace Tests\Feature;

use App\Models\InternetPackage;
use App\Models\User;
use App\Services\InternetPackage\Interfaces\BuyInternetPackageServiceInterface;
use App\Services\InternetPackage\Interfaces\InternetPackageServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InternetPackageDiscountAppliedTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        resolve(InternetPackageServiceInterface::class)
            ->syncInternetPackagesInSystem();
    }


    public function test_internet_package_discount_is_is_applied()
    {
        $discountPercentage = config('discounts.internet_package');

        $packagge = InternetPackage::query()->first();

        $userWalletAmount = 12_000 + $packagge->price;
        $user = User::factory()
            ->createOne([
                'wallet_amount' => $userWalletAmount
            ]);

        resolve(BuyInternetPackageServiceInterface::class)
            ->buyPackageForUser($user, $packagge);

        $discountedAmount = $packagge->price * ($discountPercentage / 100);

        $user = $user->fresh();
        $this->assertEquals(12_000 + $discountedAmount, $user->wallet_amount);
    }

}
