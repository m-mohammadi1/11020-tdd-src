<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\InternetPackage\InternetPackageServiceInterface;
use App\Services\InternetPackage\InternetPackageServiceProviderInterface;
use Illuminate\Http\Request;

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
