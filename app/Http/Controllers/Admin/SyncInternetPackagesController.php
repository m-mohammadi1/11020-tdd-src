<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\InternetPackage\Interfaces\GetInternetInterface;
use App\Services\InternetPackage\InternetPackageServiceProviderInterface;

class SyncInternetPackagesController extends Controller
{
    public function __construct(
        private GetInternetInterface $internetPackageService
    )
    {
    }

    public function run()
    {
        $this->internetPackageService->syncInternetPackagesInSystem();

    }

}
