<?php

namespace Tests\Feature;

use App\Enums\OrderStatus;
use App\Models\InternetPackage;
use App\Models\User;
use App\Services\Http\InternetPackage\Interfaces\KareneInternetPackageServiceInterface;
use App\Services\InternetPackage\Exceptions\UserWalletAmountNotEnoughException;
use App\Services\InternetPackage\Interfaces\BuyInternetPackageServiceInterface;
use App\Services\InternetPackage\Interfaces\InternetPackageServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InternetPackageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        resolve(InternetPackageServiceInterface::class)
            ->syncInternetPackagesInSystem();
    }


    public function test_can_sync_services_with_provider()
    {
        $count = InternetPackage::query()->count();

        $this->assertTrue($count > 0);

        $itemsStoreInDatabase = resolve(KareneInternetPackageServiceInterface::class)->getPackages();

        $this->assertDatabaseCount(InternetPackage::class, $itemsStoreInDatabase->count());
        $this->assertDatabaseHas(InternetPackage::class, [
            'code' => $itemsStoreInDatabase->first()->apiIdentifier
        ]);
    }

    public function test_can_buy_packages_from_provider()
    {
        $packagge = InternetPackage::query()->first();

        $user = User::factory()
            ->createOne([
                'wallet_amount' => $packagge->price + 1
            ]);

        $result = resolve(BuyInternetPackageServiceInterface::class)
            ->buyPackageForUser($user, $packagge);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'package_id' => $packagge->id,
            'api_order_id' => $result->api_order_id,
            'status' => OrderStatus::SUCCESS
        ]);
    }

    public function test_user_cannot_buy_package_if_its_wallet_amount_is_not_enough()
    {
        $packagge = InternetPackage::query()->first();

        $user = User::factory()
            ->createOne([
                'wallet_amount' => $packagge->price - 1
            ]);

        $this->expectException(UserWalletAmountNotEnoughException::class);

        resolve(BuyInternetPackageServiceInterface::class)
            ->buyPackageForUser($user, $packagge);
    }

    public function test_user_wallet_amount_is_edited_correctly_after_successful_order()
    {
        $packagge = InternetPackage::query()->first();

        $userWalletAmount = 12_000 + $packagge->price;
        $user = User::factory()
            ->createOne([
                'wallet_amount' => $userWalletAmount
            ]);

        resolve(BuyInternetPackageServiceInterface::class)
            ->buyPackageForUser($user, $packagge);

        $user = $user->fresh();
        $this->assertEquals(12_000, $user->wallet_amount);
    }
}
