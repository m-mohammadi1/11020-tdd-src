<?php

namespace Tests\Feature;

use App\Enums\OrderStatus;
use App\Models\InternetPackage;
use App\Models\User;
use App\Services\Http\InternetPackage\Interfaces\KareneInternetPackageServiceInterface;
use App\Services\InternetPackage\Interfaces\BuyInternetPackageServiceInterface;
use App\Services\InternetPackage\Interfaces\InternetPackageServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InternetPackageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

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
        $user = User::factory()
            ->createOne();

        $packagge = InternetPackage::query()->first();

        $result = resolve(BuyInternetPackageServiceInterface::class)
            ->buyPackageForUser($user, $packagge);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'package_id' => $packagge->id,
            'api_order_id' => $result->api_order_id,
            'status' => OrderStatus::SUCCESS
        ]);
    }
}
