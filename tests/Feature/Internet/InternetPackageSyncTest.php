<?php

namespace Tests\Feature\Internet;

use App\Enums\Operator;
use App\Models\InternetPackage as InternetPackageModel;
use App\Services\Http\Internet\Interfaces\KaraneBuyInternetInterface;
use App\Services\Http\Internet\Types\DurationType;
use App\Services\Http\Internet\Types\InternetPackage;
use App\Services\Http\Internet\Types\TrafficType;
use App\Services\InternetPackage\Interfaces\GetInternetInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InternetPackageSyncTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        resolve(GetInternetInterface::class)
            ->syncInternetPackagesInSystem();
    }


    public function test_synced_packages_duration_type_is_correct()
    {
        $this->withoutExceptionHandling();

        // get a fake stub package
        // check duration type on InternetPackage objects
        $packages = resolve(KaraneBuyInternetInterface::class)->getPackages(Operator::MCI);
        /** @var InternetPackage $firstItem */
        $firstItem = $packages->random();
        $this->assertInstanceOf(DurationType::class, $firstItem->durationType);

        // get the package from database by code and check
        // it has the right values and types
        /** @var InternetPackageModel $package */
        /** @var InternetPackage $stubPackage */
        $package = InternetPackageModel::query()->where('operator', Operator::MCI)->inRandomOrder()->first();
        $stubPackage = $packages->where('apiIdentifier', $package->code)->first();

        $this->assertEquals($package->duration, $stubPackage->duration);
        $this->assertEquals($package->duration_type, $stubPackage->durationType->getTypeEnum());
    }

    public function test_synced_packages_traffic_type_is_correct()
    {
        // get a fake stub package
        // check duration type on InternetPackage objects
        $packages = resolve(KaraneBuyInternetInterface::class)->getPackages(Operator::MCI);
        /** @var InternetPackage $firstItem */
        $firstItem = $packages->random();
        $this->assertInstanceOf(TrafficType::class, $firstItem->trafficType);


        // get the package from database by code and check
        // it has the right values and types
        /** @var InternetPackageModel $package */
        /** @var InternetPackage $stubPackage */
        $package = InternetPackageModel::query()->where('operator', Operator::MCI)->inRandomOrder()->first();
        $stubPackage = $packages->where('apiIdentifier', $package->code)->first();

        $this->assertEquals($package->traffic, $stubPackage->traffic);
        $this->assertEquals($package->traffic_type, $stubPackage->trafficType->getTypeEnum());
    }

    public function test_can_sync_services_with_provider()
    {
        $count = InternetPackageModel::query()->count();

        $this->assertTrue($count > 0);

        $mciPackages = resolve(KaraneBuyInternetInterface::class)->getPackages(Operator::MCI);
        $mtnPackages = resolve(KaraneBuyInternetInterface::class)->getPackages(Operator::MTN);
        $rightelPackages = resolve(KaraneBuyInternetInterface::class)->getPackages(Operator::RIGHTEL);

        $allCount = $mciPackages->count() + $mtnPackages->count() + $rightelPackages->count();

        $this->assertDatabaseCount(InternetPackageModel::class, $allCount);
        $this->assertDatabaseHas(InternetPackageModel::class, [
            'code' => $mciPackages->first()->apiIdentifier
        ]);
    }

    public function test_can_sync_mtn_packages_with_provider()
    {
        $this->assertOperatorPackageCountMatchesWithDatabase(Operator::MTN);
    }


    public function test_can_sync_mci_packages_with_provider()
    {
        $this->assertOperatorPackageCountMatchesWithDatabase(Operator::MCI);
    }


    public function test_can_sync_rightel_packages_with_provider()
    {
        $this->assertOperatorPackageCountMatchesWithDatabase(Operator::RIGHTEL);
    }


    private function assertOperatorPackageCountMatchesWithDatabase(Operator $operator): void
    {
        $packages = resolve(KaraneBuyInternetInterface::class)->getPackages($operator);
        // check count with database
        $count = InternetPackageModel::query()
            ->where('operator', $operator)
            ->count();

        $this->assertEquals($packages->count(), $count);
    }
}
