<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\InternetPackage\Interfaces\InternetPackageServiceInterface;
use App\Services\InternetPackage\InternetPackageServiceProviderInterface;

class SyncInternetPackagesController extends Controller
{
    public function __construct(
        private InternetPackageServiceInterface $internetPackageService
    )
    {
    }

    public function run()
    {
        $this->internetPackageService->syncInternetPackagesInSystem();

    }

}
