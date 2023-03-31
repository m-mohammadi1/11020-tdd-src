<?php

namespace Tests\Feature;

use App\Models\InternetPackage;
use App\Services\Http\InternetPackage\Interfaces\KareneInternetPackageServiceInterface;
use App\Services\InternetPackage\InternetPackageServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InternetPackageTest extends TestCase
{
    use RefreshDatabase;


    public function test_can_sync_services_with_provider()
    {
        $response = $this->get('admin/internet-package/sync');


        $response->assertStatus(200);

        $count = InternetPackage::query()->count();

        $this->assertTrue($count > 0);

        $itemsStoreInDatabase = resolve(KareneInternetPackageServiceInterface::class)->getPackages();

        $this->assertDatabaseCount(InternetPackage::class, $itemsStoreInDatabase->count());
        $this->assertDatabaseHas(InternetPackage::class, [
            'code' => $itemsStoreInDatabase->first()->apiIdentifier
        ]);
    }
}
