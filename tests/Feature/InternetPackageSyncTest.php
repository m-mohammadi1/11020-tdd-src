<?php

namespace Tests\Feature;

use App\Services\Http\InternetPackage\Interfaces\KareneInternetPackageServiceInterface;
use App\Services\Http\InternetPackage\Types\DurationType;
use App\Services\Http\InternetPackage\Types\InternetPackage;
use App\Models\InternetPackage as InternetPackageModel;
use App\Services\Http\InternetPackage\Types\TrafficType;
use App\Services\InternetPackage\Interfaces\InternetPackageServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InternetPackageSyncTest extends TestCase
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
        $count = InternetPackageModel::query()->count();

        $this->assertTrue($count > 0);

        $itemsStoreInDatabase = resolve(KareneInternetPackageServiceInterface::class)->getPackages();

        $this->assertDatabaseCount(InternetPackageModel::class, $itemsStoreInDatabase->count());
        $this->assertDatabaseHas(InternetPackageModel::class, [
            'code' => $itemsStoreInDatabase->first()->apiIdentifier
        ]);
    }

    public function test_synced_packages_duration_type_is_correct()
    {
        $this->withoutExceptionHandling();

        // get a fake stub package
        // check duration type on InternetPackage objects
        $itemsStoreInDatabase = resolve(KareneInternetPackageServiceInterface::class)->getPackages();
        /** @var InternetPackage $firstItem */
        $firstItem = $itemsStoreInDatabase->random();
        $this->assertInstanceOf(DurationType::class, $firstItem->durationType);

        // get the package from database by code and check
        // it has the right values and types
        /** @var InternetPackageModel $package */
        /** @var InternetPackage $stubPackage */

        $package = InternetPackageModel::query()->inRandomOrder()->first();
        $stubPackage = $itemsStoreInDatabase->where('apiIdentifier', $package->code)->first();

        $this->assertEquals($package->duration, $stubPackage->duration);
        $this->assertEquals($package->duration_type, $stubPackage->durationType->getTypeEnum());
    }

    public function test_synced_packages_traffic_type_is_correct()
    {
        // get a fake stub package
        // check duration type on InternetPackage objects
        $itemsStoreInDatabase = resolve(KareneInternetPackageServiceInterface::class)->getPackages();
        /** @var InternetPackage $firstItem */
        $firstItem = $itemsStoreInDatabase->random();
        $this->assertInstanceOf(TrafficType::class, $firstItem->trafficType);

        // get the package from database by code and check
        // it has the right values and types
        /** @var InternetPackageModel $package */
        /** @var InternetPackage $stubPackage */

        $package = InternetPackageModel::query()->inRandomOrder()->first();
        $stubPackage = $itemsStoreInDatabase->where('apiIdentifier', $package->code)->first();

        $this->assertEquals($package->traffic, $stubPackage->traffic);
        $this->assertEquals($package->traffic_type, $stubPackage->trafficType->getTypeEnum());
    }
}
