<?php

namespace Tests\Feature;

use App\Models\InternetPackage;
use App\Services\Http\InternetPackage\Interfaces\KareneInternetPackageServiceInterface;
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
        $count = InternetPackage::query()->count();

        $this->assertTrue($count > 0);

        $itemsStoreInDatabase = resolve(KareneInternetPackageServiceInterface::class)->getPackages();

        $this->assertDatabaseCount(InternetPackage::class, $itemsStoreInDatabase->count());
        $this->assertDatabaseHas(InternetPackage::class, [
            'code' => $itemsStoreInDatabase->first()->apiIdentifier
        ]);
    }
}
